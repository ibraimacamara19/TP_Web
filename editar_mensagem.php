<?php
require_once 'config/conexao.php';
require_once 'config/conexao.php';
if (!isset($_GET["id"])) {
    header("Location: contacto.php");
    exit;
}

$id_mensagem = intval($_GET["id"]);
$mensagem_sistema = "";

$sql = "SELECT * FROM mensagens_contacto WHERE id_mensagem = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_mensagem);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$registo = mysqli_fetch_assoc($resultado);

if (!$registo) {
    header("Location: contacto.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_contacto"];
    $email = $_POST["email_contacto"];
    $assunto = $_POST["assunto_contacto"];
    $mensagem = $_POST["mensagem_contacto"];
    $estado = $_POST["estado_mensagem"];

    $sql_update = "UPDATE mensagens_contacto SET 
        nome = ?,
        email = ?,
        assunto = ?,
        mensagem = ?,
        estado = ?
        WHERE id_mensagem = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "sssssi",
        $nome,
        $email,
        $assunto,
        $mensagem,
        $estado,
        $id_mensagem
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: contacto.php?msg=atualizado");
        exit;
    } else {
        $mensagem_sistema = "Erro ao atualizar mensagem: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Mensagem</h2>
        <p>Atualize os dados ou o estado da mensagem recebida.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados da Mensagem</h3>

        <?php if (!empty($mensagem_sistema)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem_sistema; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_mensagem.php?id=<?php echo $id_mensagem; ?>">
            <div class="campo">
                <label for="nome_contacto">Nome</label>
                <input 
                    type="text" 
                    id="nome_contacto" 
                    name="nome_contacto" 
                    required 
                    maxlength="120"
                    value="<?php echo htmlspecialchars($registo['nome']); ?>">
            </div>

            <div class="campo">
                <label for="email_contacto">Email</label>
                <input 
                    type="email" 
                    id="email_contacto" 
                    name="email_contacto" 
                    required
                    value="<?php echo htmlspecialchars($registo['email']); ?>">
            </div>

            <div class="campo campo-largo">
                <label for="assunto_contacto">Assunto</label>
                <input 
                    type="text" 
                    id="assunto_contacto" 
                    name="assunto_contacto" 
                    required 
                    maxlength="150"
                    value="<?php echo htmlspecialchars($registo['assunto']); ?>">
            </div>

            <div class="campo">
                <label for="estado_mensagem">Estado</label>
                <select id="estado_mensagem" name="estado_mensagem" required>
                    <option value="">Selecione</option>
                    <option value="nova" <?php if ($registo['estado'] === 'nova') echo 'selected'; ?>>Nova</option>
                    <option value="lida" <?php if ($registo['estado'] === 'lida') echo 'selected'; ?>>Lida</option>
                    <option value="respondida" <?php if ($registo['estado'] === 'respondida') echo 'selected'; ?>>Respondida</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="mensagem_contacto">Mensagem</label>
                <textarea 
                    id="mensagem_contacto" 
                    name="mensagem_contacto" 
                    rows="6"
                    required><?php echo htmlspecialchars($registo['mensagem']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Mensagem</button>
                <a href="contacto.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>