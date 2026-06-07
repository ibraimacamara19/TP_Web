<?php
require_once 'config/conexao.php';

if (!isset($_GET["id"])) {
    header("Location: alunos.php");
    exit;
}

$id_aluno = intval($_GET["id"]);
$mensagem = "";

$sql = "SELECT * FROM alunos WHERE id_aluno = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_aluno);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$aluno = mysqli_fetch_assoc($resultado);

if (!$aluno) {
    header("Location: alunos.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero_estudante = $_POST["numero_estudante"];
    $nome = $_POST["nome"];
    $data_nascimento = $_POST["data_nascimento"];
    $genero = $_POST["genero"];
    $contacto = $_POST["contacto"];
    $email = $_POST["email"];
    $turma = $_POST["turma"];
    $morada = $_POST["morada"];
    $encarregado_nome = $_POST["encarregado_nome"];
    $encarregado_contacto = $_POST["encarregado_contacto"];
    $observacao = $_POST["observacao"];

    $sql_update = "UPDATE alunos SET 
        numero_estudante = ?,
        nome = ?,
        data_nascimento = ?,
        genero = ?,
        contacto = ?,
        email = ?,
        turma = ?,
        morada = ?,
        encarregado_nome = ?,
        encarregado_contacto = ?,
        observacao = ?
        WHERE id_aluno = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "sssssssssssi",
        $numero_estudante,
        $nome,
        $data_nascimento,
        $genero,
        $contacto,
        $email,
        $turma,
        $morada,
        $encarregado_nome,
        $encarregado_contacto,
        $observacao,
        $id_aluno
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: alunos.php?msg=atualizado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar aluno: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Aluno</h2>
        <p>Atualize os dados do aluno selecionado.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados do Aluno</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_aluno.php?id=<?php echo $id_aluno; ?>">
            <div class="campo">
                <label for="numero_estudante">Número de Estudante</label>
                <input type="text" id="numero_estudante" name="numero_estudante" required maxlength="30"
                       value="<?php echo htmlspecialchars($aluno['numero_estudante']); ?>">
            </div>

            <div class="campo">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required maxlength="120"
                       value="<?php echo htmlspecialchars($aluno['nome']); ?>">
            </div>

            <div class="campo">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required
                       value="<?php echo htmlspecialchars($aluno['data_nascimento']); ?>">
            </div>

            <div class="campo">
                <label for="genero">Género</label>
                <select id="genero" name="genero" required>
                    <option value="">Selecione</option>
                    <option value="masculino" <?php if ($aluno['genero'] === 'masculino') echo 'selected'; ?>>Masculino</option>
                    <option value="feminino" <?php if ($aluno['genero'] === 'feminino') echo 'selected'; ?>>Feminino</option>
                    <option value="outro" <?php if ($aluno['genero'] === 'outro') echo 'selected'; ?>>Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="contacto">Contacto</label>
                <input type="tel" id="contacto" name="contacto" maxlength="30"
                       value="<?php echo htmlspecialchars($aluno['contacto']); ?>">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($aluno['email']); ?>">
            </div>

            <div class="campo">
                <label for="turma">Turma</label>
                <select id="turma" name="turma" required>
                    <option value="">Selecione a turma</option>
                    <option value="7.º Ano A" <?php if ($aluno['turma'] === '7.º Ano A') echo 'selected'; ?>>7.º Ano A</option>
                    <option value="8.º Ano A" <?php if ($aluno['turma'] === '8.º Ano A') echo 'selected'; ?>>8.º Ano A</option>
                    <option value="9.º Ano A" <?php if ($aluno['turma'] === '9.º Ano A') echo 'selected'; ?>>9.º Ano A</option>
                    <option value="10.º Ano A" <?php if ($aluno['turma'] === '10.º Ano A') echo 'selected'; ?>>10.º Ano A</option>
                    <option value="11.º Ano A" <?php if ($aluno['turma'] === '11.º Ano A') echo 'selected'; ?>>11.º Ano A</option>
                    <option value="12.º Ano A" <?php if ($aluno['turma'] === '12.º Ano A') echo 'selected'; ?>>12.º Ano A</option>
                </select>
            </div>

            <div class="campo">
                <label for="morada">Morada</label>
                <input type="text" id="morada" name="morada" maxlength="200"
                       value="<?php echo htmlspecialchars($aluno['morada']); ?>">
            </div>

            <div class="campo">
                <label for="encarregado_nome">Nome do Encarregado</label>
                <input type="text" id="encarregado_nome" name="encarregado_nome" maxlength="120"
                       value="<?php echo htmlspecialchars($aluno['encarregado_nome']); ?>">
            </div>

            <div class="campo">
                <label for="encarregado_contacto">Contacto do Encarregado</label>
                <input type="tel" id="encarregado_contacto" name="encarregado_contacto" maxlength="30"
                       value="<?php echo htmlspecialchars($aluno['encarregado_contacto']); ?>">
            </div>

            <div class="campo campo-largo">
                <label for="observacao">Observação</label>
                <textarea id="observacao" name="observacao" rows="4"><?php echo htmlspecialchars($aluno['observacao']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Aluno</button>
                <a href="alunos.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>