<?php
require_once 'config/conexao.php';

$mensagem = "";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] === "eliminado") {
        $mensagem = "Professor eliminado com sucesso!";
    }

    if ($_GET["msg"] === "atualizado") {
        $mensagem = "Professor atualizado com sucesso!";
    }
}

if (isset($_GET["acao"]) && $_GET["acao"] === "eliminar" && isset($_GET["id"])) {
    $id_professor = intval($_GET["id"]);

    $sql_delete = "DELETE FROM professores WHERE id_professor = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);

    mysqli_stmt_bind_param($stmt_delete, "i", $id_professor);

    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: professores.php?msg=eliminado");
        exit;
    } else {
        $mensagem = "Erro ao eliminar professor: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_professor"];
    $email = $_POST["email_professor"];
    $contacto = $_POST["contacto_professor"];
    $especialidade = $_POST["especialidade"];
    $estado = $_POST["estado_professor"];
    $observacao = $_POST["observacao_professor"];

    $sql = "INSERT INTO professores 
        (nome, email, contacto, especialidade, estado, observacao)
        VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $nome,
        $email,
        $contacto,
        $especialidade,
        $estado,
        $observacao
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Professor registado com sucesso!";
    } else {
        $mensagem = "Erro ao registar professor: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM professores ORDER BY id_professor DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Professores</h2>
        <p>Registe, consulte e organize os professores da instituição.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Novo Professor</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="professores.php">
            <div class="campo">
                <label for="nome_professor">Nome Completo</label>
                <input 
                    type="text" 
                    id="nome_professor" 
                    name="nome_professor" 
                    placeholder="Digite o nome completo"
                    required
                    maxlength="120">
            </div>

            <div class="campo">
                <label for="email_professor">Email</label>
                <input 
                    type="email" 
                    id="email_professor" 
                    name="email_professor" 
                    placeholder="exemplo@email.com"
                    required>
            </div>

            <div class="campo">
                <label for="contacto_professor">Contacto</label>
                <input 
                    type="tel" 
                    id="contacto_professor" 
                    name="contacto_professor" 
                    placeholder="Ex: +245 966 000 000"
                    maxlength="30">
            </div>

            <div class="campo">
                <label for="especialidade">Especialidade</label>
                <input 
                    type="text" 
                    id="especialidade" 
                    name="especialidade" 
                    placeholder="Ex: Matemática, Português, Física"
                    required
                    maxlength="100">
            </div>

            <div class="campo">
                <label for="estado_professor">Estado</label>
                <select id="estado_professor" name="estado_professor" required>
                    <option value="">Selecione</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_professor">Observação</label>
                <textarea 
                    id="observacao_professor" 
                    name="observacao_professor" 
                    rows="4" 
                    placeholder="Informações adicionais sobre o professor"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Professor</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Professores</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Contacto</th>
                    <th>Especialidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($professor = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($professor["nome"]); ?></td>
                        <td><?php echo htmlspecialchars($professor["email"]); ?></td>
                        <td><?php echo htmlspecialchars($professor["contacto"]); ?></td>
                        <td><?php echo htmlspecialchars($professor["especialidade"]); ?></td>
                        <td><?php echo htmlspecialchars($professor["estado"]); ?></td>
                        <td>
                            <a class="acao editar" href="editar_professor.php?id=<?php echo $professor['id_professor']; ?>">
                                Editar
                            </a>

                            <a 
                                class="acao eliminar" 
                                href="professores.php?acao=eliminar&id=<?php echo $professor['id_professor']; ?>"
                                onclick="return confirm('Tem a certeza que deseja eliminar este professor?');">
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