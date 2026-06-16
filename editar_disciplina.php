<?php
require_once 'config/conexao.php';
require_once 'config/conexao.php';
if (!isset($_GET["id"])) {
    header("Location: disciplinas.php");
    exit;
}

$id_disciplina = intval($_GET["id"]);
$mensagem = "";

$sql = "SELECT * FROM disciplinas WHERE id_disciplina = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_disciplina);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$disciplina = mysqli_fetch_assoc($resultado);

if (!$disciplina) {
    header("Location: disciplinas.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_disciplina"];
    $codigo = $_POST["codigo_disciplina"];
    $carga_horaria = $_POST["carga_horaria"];
    $nivel_ensino = $_POST["nivel_disciplina"];
    $professor_responsavel = $_POST["professor_responsavel"];
    $estado = $_POST["estado_disciplina"];
    $descricao = $_POST["descricao_disciplina"];

    $sql_update = "UPDATE disciplinas SET 
        codigo = ?,
        nome = ?,
        carga_horaria = ?,
        nivel_ensino = ?,
        professor_responsavel = ?,
        estado = ?,
        descricao = ?
        WHERE id_disciplina = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "ssissssi",
        $codigo,
        $nome,
        $carga_horaria,
        $nivel_ensino,
        $professor_responsavel,
        $estado,
        $descricao,
        $id_disciplina
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: disciplinas.php?msg=atualizado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar disciplina: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Disciplina</h2>
        <p>Atualize os dados da disciplina selecionada.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados da Disciplina</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_disciplina.php?id=<?php echo $id_disciplina; ?>">
            <div class="campo">
                <label for="nome_disciplina">Nome da Disciplina</label>
                <input type="text" id="nome_disciplina" name="nome_disciplina" required maxlength="100"
                       value="<?php echo htmlspecialchars($disciplina['nome']); ?>">
            </div>

            <div class="campo">
                <label for="codigo_disciplina">Código da Disciplina</label>
                <input type="text" id="codigo_disciplina" name="codigo_disciplina" required maxlength="20"
                       value="<?php echo htmlspecialchars($disciplina['codigo']); ?>">
            </div>

            <div class="campo">
                <label for="carga_horaria">Carga Horária</label>
                <input type="number" id="carga_horaria" name="carga_horaria" min="1" max="300" required
                       value="<?php echo htmlspecialchars($disciplina['carga_horaria']); ?>">
            </div>

            <div class="campo">
                <label for="nivel_disciplina">Nível de Ensino</label>
                <select id="nivel_disciplina" name="nivel_disciplina" required>
                    <option value="">Selecione</option>
                    <option value="basico" <?php if ($disciplina['nivel_ensino'] === 'basico') echo 'selected'; ?>>Ensino Básico</option>
                    <option value="secundario" <?php if ($disciplina['nivel_ensino'] === 'secundario') echo 'selected'; ?>>Ensino Secundário</option>
                    <option value="tecnico" <?php if ($disciplina['nivel_ensino'] === 'tecnico') echo 'selected'; ?>>Ensino Técnico</option>
                </select>
            </div>

            <div class="campo">
                <label for="professor_responsavel">Professor Responsável</label>
                <input type="text" id="professor_responsavel" name="professor_responsavel" maxlength="120"
                       value="<?php echo htmlspecialchars($disciplina['professor_responsavel']); ?>">
            </div>

            <div class="campo">
                <label for="estado_disciplina">Estado</label>
                <select id="estado_disciplina" name="estado_disciplina" required>
                    <option value="">Selecione</option>
                    <option value="ativa" <?php if ($disciplina['estado'] === 'ativa') echo 'selected'; ?>>Ativa</option>
                    <option value="inativa" <?php if ($disciplina['estado'] === 'inativa') echo 'selected'; ?>>Inativa</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="descricao_disciplina">Descrição</label>
                <textarea id="descricao_disciplina" name="descricao_disciplina" rows="4"><?php echo htmlspecialchars($disciplina['descricao']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Disciplina</button>
                <a href="disciplinas.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>