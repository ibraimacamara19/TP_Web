<?php
require_once 'config/conexao.php';

if (!isset($_GET["id"])) {
    header("Location: notas.php");
    exit;
}

$id_nota = intval($_GET["id"]);
$mensagem = "";

$sql = "SELECT * FROM notas WHERE id_nota = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_nota);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$registo = mysqli_fetch_assoc($resultado);

if (!$registo) {
    header("Location: notas.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aluno = $_POST["aluno_nota"];
    $turma = $_POST["turma_nota"];
    $disciplina = $_POST["disciplina_nota"];
    $professor = $_POST["professor_nota"];
    $periodo = $_POST["periodo"];
    $nota = $_POST["nota"];
    $observacao = $_POST["observacao_nota"];

    $sql_update = "UPDATE notas SET 
        aluno = ?,
        turma = ?,
        disciplina = ?,
        professor = ?,
        periodo = ?,
        nota = ?,
        observacao = ?
        WHERE id_nota = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "sssssssi",
        $aluno,
        $turma,
        $disciplina,
        $professor,
        $periodo,
        $nota,
        $observacao,
        $id_nota
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: notas.php?msg=atualizado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar nota: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Nota</h2>
        <p>Atualize os dados da nota selecionada.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados da Nota</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_nota.php?id=<?php echo $id_nota; ?>">
            <div class="campo">
                <label for="aluno_nota">Aluno</label>
                <input type="text" id="aluno_nota" name="aluno_nota" required maxlength="120"
                       value="<?php echo htmlspecialchars($registo['aluno']); ?>">
            </div>

            <div class="campo">
                <label for="turma_nota">Turma</label>
                <input type="text" id="turma_nota" name="turma_nota" required maxlength="50"
                       value="<?php echo htmlspecialchars($registo['turma']); ?>">
            </div>

            <div class="campo">
                <label for="disciplina_nota">Disciplina</label>
                <input type="text" id="disciplina_nota" name="disciplina_nota" required maxlength="100"
                       value="<?php echo htmlspecialchars($registo['disciplina']); ?>">
            </div>

            <div class="campo">
                <label for="professor_nota">Professor</label>
                <input type="text" id="professor_nota" name="professor_nota" required maxlength="120"
                       value="<?php echo htmlspecialchars($registo['professor']); ?>">
            </div>

            <div class="campo">
                <label for="periodo">Período</label>
                <select id="periodo" name="periodo" required>
                    <option value="">Selecione</option>
                    <option value="1_periodo" <?php if ($registo['periodo'] === '1_periodo') echo 'selected'; ?>>1.º Período</option>
                    <option value="2_periodo" <?php if ($registo['periodo'] === '2_periodo') echo 'selected'; ?>>2.º Período</option>
                    <option value="3_periodo" <?php if ($registo['periodo'] === '3_periodo') echo 'selected'; ?>>3.º Período</option>
                    <option value="final" <?php if ($registo['periodo'] === 'final') echo 'selected'; ?>>Nota Final</option>
                </select>
            </div>

            <div class="campo">
                <label for="nota">Nota</label>
                <input type="number" id="nota" name="nota" min="0" max="20" step="0.1" required
                       value="<?php echo htmlspecialchars($registo['nota']); ?>">
            </div>

            <div class="campo campo-largo">
                <label for="observacao_nota">Observação</label>
                <textarea id="observacao_nota" name="observacao_nota" rows="4"><?php echo htmlspecialchars($registo['observacao']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Nota</button>
                <a href="notas.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>