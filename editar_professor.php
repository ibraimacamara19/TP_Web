<?php
require_once 'config/conexao.php';
require_once 'config/conexao.php';
if (!isset($_GET["id"])) {
    header("Location: professores.php");
    exit;
}

$id_professor = intval($_GET["id"]);
$mensagem = "";

$sql = "SELECT * FROM professores WHERE id_professor = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_professor);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$professor = mysqli_fetch_assoc($resultado);

if (!$professor) {
    header("Location: professores.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_professor"];
    $email = $_POST["email_professor"];
    $contacto = $_POST["contacto_professor"];
    $especialidade = $_POST["especialidade"];
    $estado = $_POST["estado_professor"];
    $observacao = $_POST["observacao_professor"];

    $sql_update = "UPDATE professores SET 
        nome = ?,
        email = ?,
        contacto = ?,
        especialidade = ?,
        estado = ?,
        observacao = ?
        WHERE id_professor = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "ssssssi",
        $nome,
        $email,
        $contacto,
        $especialidade,
        $estado,
        $observacao,
        $id_professor
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: professores.php?msg=atualizado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar professor: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Professor</h2>
        <p>Atualize os dados do professor selecionado.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados do Professor</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_professor.php?id=<?php echo $id_professor; ?>">
            <div class="campo">
                <label for="nome_professor">Nome Completo</label>
                <input 
                    type="text" 
                    id="nome_professor" 
                    name="nome_professor" 
                    required 
                    maxlength="120"
                    value="<?php echo htmlspecialchars($professor['nome']); ?>">
            </div>

            <div class="campo">
                <label for="email_professor">Email</label>
                <input 
                    type="email" 
                    id="email_professor" 
                    name="email_professor" 
                    required
                    value="<?php echo htmlspecialchars($professor['email']); ?>">
            </div>

            <div class="campo">
                <label for="contacto_professor">Contacto</label>
                <input 
                    type="tel" 
                    id="contacto_professor" 
                    name="contacto_professor" 
                    maxlength="30"
                    value="<?php echo htmlspecialchars($professor['contacto']); ?>">
            </div>

            <div class="campo">
                <label for="especialidade">Especialidade</label>
                <input 
                    type="text" 
                    id="especialidade" 
                    name="especialidade" 
                    required 
                    maxlength="100"
                    value="<?php echo htmlspecialchars($professor['especialidade']); ?>">
            </div>

            <div class="campo">
                <label for="estado_professor">Estado</label>
                <select id="estado_professor" name="estado_professor" required>
                    <option value="">Selecione</option>
                    <option value="ativo" <?php if ($professor['estado'] === 'ativo') echo 'selected'; ?>>Ativo</option>
                    <option value="inativo" <?php if ($professor['estado'] === 'inativo') echo 'selected'; ?>>Inativo</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_professor">Observação</label>
                <textarea 
                    id="observacao_professor" 
                    name="observacao_professor" 
                    rows="4"><?php echo htmlspecialchars($professor['observacao']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Professor</button>
                <a href="professores.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>