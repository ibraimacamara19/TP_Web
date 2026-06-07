<?php
require_once 'config/conexao.php';

$mensagem_sistema = "";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] === "eliminado") {
        $mensagem_sistema = "Mensagem eliminada com sucesso!";
    }

    if ($_GET["msg"] === "atualizado") {
        $mensagem_sistema = "Mensagem atualizada com sucesso!";
    }
}

if (isset($_GET["acao"]) && $_GET["acao"] === "eliminar" && isset($_GET["id"])) {
    $id_mensagem = intval($_GET["id"]);

    $sql_delete = "DELETE FROM mensagens_contacto WHERE id_mensagem = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_mensagem);

    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: contacto.php?msg=eliminado");
        exit;
    } else {
        $mensagem_sistema = "Erro ao eliminar mensagem: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_contacto"];
    $email = $_POST["email_contacto"];
    $assunto = $_POST["assunto_contacto"];
    $mensagem = $_POST["mensagem_contacto"];

    $sql = "INSERT INTO mensagens_contacto 
        (nome, email, assunto, mensagem)
        VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $nome,
        $email,
        $assunto,
        $mensagem
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem_sistema = "Mensagem enviada com sucesso!";
    } else {
        $mensagem_sistema = "Erro ao enviar mensagem: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM mensagens_contacto ORDER BY id_mensagem DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Contacto</h2>
        <p>Entre em contacto com a administração do Sistema de Gestão Escolar GB.</p>
    </section>

    <section class="contacto-layout">

        <section class="formulario-container contacto-formulario">
            <h3>Enviar Mensagem</h3>

            <?php if (!empty($mensagem_sistema)) { ?>
                <p class="mensagem-formulario"><?php echo $mensagem_sistema; ?></p>
            <?php } ?>

            <form class="formulario" method="post" action="contacto.php">
                <div class="campo">
                    <label for="nome_contacto">Nome</label>
                    <input 
                        type="text" 
                        id="nome_contacto" 
                        name="nome_contacto" 
                        placeholder="Digite o seu nome"
                        required
                        maxlength="120">
                </div>

                <div class="campo">
                    <label for="email_contacto">Email</label>
                    <input 
                        type="email" 
                        id="email_contacto" 
                        name="email_contacto" 
                        placeholder="exemplo@email.com"
                        required>
                </div>

                <div class="campo campo-largo">
                    <label for="assunto_contacto">Assunto</label>
                    <input 
                        type="text" 
                        id="assunto_contacto" 
                        name="assunto_contacto" 
                        placeholder="Digite o assunto da mensagem"
                        required
                        maxlength="150">
                </div>

                <div class="campo campo-largo">
                    <label for="mensagem_contacto">Mensagem</label>
                    <textarea 
                        id="mensagem_contacto" 
                        name="mensagem_contacto" 
                        rows="6" 
                        placeholder="Escreva a sua mensagem"
                        required></textarea>
                </div>

                <div class="botoes-formulario">
                    <button type="submit" class="botao">Enviar Mensagem</button>
                    <button type="reset" class="botao-secundario">Limpar</button>
                </div>
            </form>
        </section>

        <aside class="info-contacto">
            <h3>Informações</h3>

            <div class="info-item">
                <strong>Instituição:</strong>
                <p>Sistema de Gestão Escolar GB</p>
            </div>

            <div class="info-item">
                <strong>Localização:</strong>
                <p>Bissau, Guiné-Bissau</p>
            </div>

            <div class="info-item">
                <strong>Email:</strong>
                <p>contacto@gestaoescolargb.com</p>
            </div>

            <div class="info-item">
                <strong>Telefone:</strong>
                <p>+245 955 000 000</p>
            </div>

            <div class="info-item">
                <strong>Horário:</strong>
                <p>Segunda a Sexta, das 08h às 17h</p>
            </div>
        </aside>

    </section>

    <section class="tabela-container">
        <h3>Mensagens Recebidas</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Assunto</th>
                    <th>Mensagem</th>
                    <th>Estado</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($registo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registo["nome"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["email"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["assunto"]); ?></td>
                        <td><?php echo htmlspecialchars(substr($registo["mensagem"], 0, 50)); ?>...</td>
                        <td><?php echo htmlspecialchars($registo["estado"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["criado_em"]); ?></td>
                        <td>
                            <a class="acao editar" href="editar_mensagem.php?id=<?php echo $registo['id_mensagem']; ?>">
                                Editar
                            </a>

                            <a 
                                class="acao eliminar" 
                                href="contacto.php?acao=eliminar&id=<?php echo $registo['id_mensagem']; ?>"
                                onclick="return confirm('Tem a certeza que deseja eliminar esta mensagem?');">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>