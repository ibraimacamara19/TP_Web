<?php
require_once 'config/conexao.php';

if (!isset($_GET["id"])) {
    header("Location: turmas.php");
    exit;
}

$id_turma = intval($_GET["id"]);
$mensagem = "";

$sql = "SELECT * FROM turmas WHERE id_turma = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_turma);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$turma = mysqli_fetch_assoc($resultado);

if (!$turma) {
    header("Location: turmas.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_turma"];
    $nivel_ensino = $_POST["nivel_ensino"];
    $classe = $_POST["classe"];
    $turno = $_POST["turno"];
    $sala = $_POST["sala"];
    $ano_letivo = $_POST["ano_letivo"];
    $estado = $_POST["estado_turma"];
    $observacao = $_POST["observacao_turma"];

    $sql_update = "UPDATE turmas SET 
        nome = ?,
        nivel_ensino = ?,
        classe = ?,
        turno = ?,
        sala = ?,
        ano_letivo = ?,
        estado = ?,
        observacao = ?
        WHERE id_turma = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "ssssssssi",
        $nome,
        $nivel_ensino,
        $classe,
        $turno,
        $sala,
        $ano_letivo,
        $estado,
        $observacao,
        $id_turma
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: turmas.php?msg=atualizado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar turma: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Turma</h2>
        <p>Atualize os dados da turma selecionada.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados da Turma</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_turma.php?id=<?php echo $id_turma; ?>">
            <div class="campo">
                <label for="nome_turma">Nome da Turma</label>
                <input type="text" id="nome_turma" name="nome_turma" required maxlength="50"
                       value="<?php echo htmlspecialchars($turma['nome']); ?>">
            </div>

            <div class="campo">
                <label for="nivel_ensino">Nível de Ensino</label>
                <select id="nivel_ensino" name="nivel_ensino" required>
                    <option value="">Selecione</option>
                    <option value="basico" <?php if ($turma['nivel_ensino'] === 'basico') echo 'selected'; ?>>Ensino Básico</option>
                    <option value="secundario" <?php if ($turma['nivel_ensino'] === 'secundario') echo 'selected'; ?>>Ensino Secundário</option>
                    <option value="tecnico" <?php if ($turma['nivel_ensino'] === 'tecnico') echo 'selected'; ?>>Ensino Técnico</option>
                </select>
            </div>

            <div class="campo">
                <label for="classe">Classe / Ano</label>
                <select id="classe" name="classe" required>
                    <option value="">Selecione</option>
                    <option value="7.º Ano" <?php if ($turma['classe'] === '7.º Ano') echo 'selected'; ?>>7.º Ano</option>
                    <option value="8.º Ano" <?php if ($turma['classe'] === '8.º Ano') echo 'selected'; ?>>8.º Ano</option>
                    <option value="9.º Ano" <?php if ($turma['classe'] === '9.º Ano') echo 'selected'; ?>>9.º Ano</option>
                    <option value="10.º Ano" <?php if ($turma['classe'] === '10.º Ano') echo 'selected'; ?>>10.º Ano</option>
                    <option value="11.º Ano" <?php if ($turma['classe'] === '11.º Ano') echo 'selected'; ?>>11.º Ano</option>
                    <option value="12.º Ano" <?php if ($turma['classe'] === '12.º Ano') echo 'selected'; ?>>12.º Ano</option>
                </select>
            </div>

            <div class="campo">
                <label for="turno">Turno</label>
                <select id="turno" name="turno" required>
                    <option value="">Selecione</option>
                    <option value="manha" <?php if ($turma['turno'] === 'manha') echo 'selected'; ?>>Manhã</option>
                    <option value="tarde" <?php if ($turma['turno'] === 'tarde') echo 'selected'; ?>>Tarde</option>
                    <option value="noite" <?php if ($turma['turno'] === 'noite') echo 'selected'; ?>>Noite</option>
                </select>
            </div>

            <div class="campo">
                <label for="sala">Sala</label>
                <input type="text" id="sala" name="sala" maxlength="30"
                       value="<?php echo htmlspecialchars($turma['sala']); ?>">
            </div>

            <div class="campo">
                <label for="ano_letivo">Ano Letivo</label>
                <input type="text" id="ano_letivo" name="ano_letivo" required maxlength="20"
                       value="<?php echo htmlspecialchars($turma['ano_letivo']); ?>">
            </div>

            <div class="campo">
                <label for="estado_turma">Estado</label>
                <select id="estado_turma" name="estado_turma" required>
                    <option value="">Selecione</option>
                    <option value="ativa" <?php if ($turma['estado'] === 'ativa') echo 'selected'; ?>>Ativa</option>
                    <option value="inativa" <?php if ($turma['estado'] === 'inativa') echo 'selected'; ?>>Inativa</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_turma">Observação</label>
                <textarea id="observacao_turma" name="observacao_turma" rows="4"><?php echo htmlspecialchars($turma['observacao']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Turma</button>
                <a href="turmas.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>