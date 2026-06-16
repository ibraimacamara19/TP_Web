<?php
require_once 'config/conexao.php';
require_once 'config/conexao.php';
$mensagem = "";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] === "eliminado") {
        $mensagem = "Nota eliminada com sucesso!";
    }

    if ($_GET["msg"] === "atualizado") {
        $mensagem = "Nota atualizada com sucesso!";
    }
}

if (isset($_GET["acao"]) && $_GET["acao"] === "eliminar" && isset($_GET["id"])) {
    $id_nota = intval($_GET["id"]);

    $sql_delete = "DELETE FROM notas WHERE id_nota = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_nota);

    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: notas.php?msg=eliminado");
        exit;
    } else {
        $mensagem = "Erro ao eliminar nota: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aluno = $_POST["aluno_nota"];
    $turma = $_POST["turma_nota"];
    $disciplina = $_POST["disciplina_nota"];
    $professor = $_POST["professor_nota"];
    $periodo = $_POST["periodo"];
    $nota = $_POST["nota"];
    $observacao = $_POST["observacao_nota"];

    $sql = "INSERT INTO notas 
        (aluno, turma, disciplina, professor, periodo, nota, observacao)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $aluno,
        $turma,
        $disciplina,
        $professor,
        $periodo,
        $nota,
        $observacao
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Nota registada com sucesso!";
    } else {
        $mensagem = "Erro ao registar nota: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM notas ORDER BY id_nota DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Notas</h2>
        <p>Lance, consulte e organize as notas dos alunos por turma, disciplina e período.</p>
    </section>
<section class="acoes-relatorio no-print">
    <a href="relatorio_notas_aluno.php" class="botao">
        Gerar Relatório Individual de Notas
    </a>
</section>
    <section class="formulario-container">
        <h3>Lançar Nova Nota</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="notas.php">
            <div class="campo">
                <label for="aluno_nota">Aluno</label>
                <input type="text" id="aluno_nota" name="aluno_nota" placeholder="Nome do aluno" required maxlength="120">
            </div>

            <div class="campo">
                <label for="turma_nota">Turma</label>
                <input type="text" id="turma_nota" name="turma_nota" placeholder="Ex: 10.º Ano A" required maxlength="50">
            </div>

            <div class="campo">
                <label for="disciplina_nota">Disciplina</label>
                <input type="text" id="disciplina_nota" name="disciplina_nota" placeholder="Ex: Matemática" required maxlength="100">
            </div>

            <div class="campo">
                <label for="professor_nota">Professor</label>
                <input type="text" id="professor_nota" name="professor_nota" placeholder="Nome do professor" required maxlength="120">
            </div>

            <div class="campo">
                <label for="periodo">Período</label>
                <select id="periodo" name="periodo" required>
                    <option value="">Selecione</option>
                    <option value="1_periodo">1.º Período</option>
                    <option value="2_periodo">2.º Período</option>
                    <option value="3_periodo">3.º Período</option>
                    <option value="final">Nota Final</option>
                </select>
            </div>

            <div class="campo">
                <label for="nota">Nota</label>
                <input type="number" id="nota" name="nota" placeholder="Ex: 15" min="0" max="20" step="0.1" required>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_nota">Observação</label>
                <textarea id="observacao_nota" name="observacao_nota" rows="4" placeholder="Observação sobre o desempenho do aluno"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Nota</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Notas</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Turma</th>
                    <th>Disciplina</th>
                    <th>Professor</th>
                    <th>Período</th>
                    <th>Nota</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($registo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registo["aluno"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["turma"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["disciplina"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["professor"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["periodo"]); ?></td>
                        <td><?php echo htmlspecialchars($registo["nota"]); ?></td>
                        <td>
                            <a class="acao editar" href="editar_nota.php?id=<?php echo $registo['id_nota']; ?>">
                                Editar
                            </a>

                            <a 
                                class="acao eliminar" 
                                href="notas.php?acao=eliminar&id=<?php echo $registo['id_nota']; ?>"
                                onclick="return confirm('Tem a certeza que deseja eliminar esta nota?');">
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