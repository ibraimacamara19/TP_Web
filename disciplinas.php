<?php
require_once 'config/conexao.php';

$mensagem = "";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] === "eliminado") {
        $mensagem = "Disciplina eliminada com sucesso!";
    }

    if ($_GET["msg"] === "atualizado") {
        $mensagem = "Disciplina atualizada com sucesso!";
    }
}

if (isset($_GET["acao"]) && $_GET["acao"] === "eliminar" && isset($_GET["id"])) {
    $id_disciplina = intval($_GET["id"]);

    $sql_delete = "DELETE FROM disciplinas WHERE id_disciplina = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_disciplina);

    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: disciplinas.php?msg=eliminado");
        exit;
    } else {
        $mensagem = "Erro ao eliminar disciplina: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_disciplina"];
    $codigo = $_POST["codigo_disciplina"];
    $carga_horaria = $_POST["carga_horaria"];
    $nivel_ensino = $_POST["nivel_disciplina"];
    $professor_responsavel = $_POST["professor_responsavel"];
    $estado = $_POST["estado_disciplina"];
    $descricao = $_POST["descricao_disciplina"];

    $sql = "INSERT INTO disciplinas 
        (codigo, nome, carga_horaria, nivel_ensino, professor_responsavel, estado, descricao)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssissss",
        $codigo,
        $nome,
        $carga_horaria,
        $nivel_ensino,
        $professor_responsavel,
        $estado,
        $descricao
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Disciplina registada com sucesso!";
    } else {
        $mensagem = "Erro ao registar disciplina: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM disciplinas ORDER BY id_disciplina DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Disciplinas</h2>
        <p>Registe, consulte e organize as disciplinas lecionadas na instituição.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Nova Disciplina</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="disciplinas.php">
            <div class="campo">
                <label for="nome_disciplina">Nome da Disciplina</label>
                <input type="text" id="nome_disciplina" name="nome_disciplina" placeholder="Ex: Matemática" required maxlength="100">
            </div>

            <div class="campo">
                <label for="codigo_disciplina">Código da Disciplina</label>
                <input type="text" id="codigo_disciplina" name="codigo_disciplina" placeholder="Ex: MAT001" required maxlength="20">
            </div>

            <div class="campo">
                <label for="carga_horaria">Carga Horária</label>
                <input type="number" id="carga_horaria" name="carga_horaria" placeholder="Ex: 60" min="1" max="300" required>
            </div>

            <div class="campo">
                <label for="nivel_disciplina">Nível de Ensino</label>
                <select id="nivel_disciplina" name="nivel_disciplina" required>
                    <option value="">Selecione</option>
                    <option value="basico">Ensino Básico</option>
                    <option value="secundario">Ensino Secundário</option>
                    <option value="tecnico">Ensino Técnico</option>
                </select>
            </div>

            <div class="campo">
                <label for="professor_responsavel">Professor Responsável</label>
                <input type="text" id="professor_responsavel" name="professor_responsavel" placeholder="Nome do professor" maxlength="120">
            </div>

            <div class="campo">
                <label for="estado_disciplina">Estado</label>
                <select id="estado_disciplina" name="estado_disciplina" required>
                    <option value="">Selecione</option>
                    <option value="ativa">Ativa</option>
                    <option value="inativa">Inativa</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="descricao_disciplina">Descrição</label>
                <textarea id="descricao_disciplina" name="descricao_disciplina" rows="4" placeholder="Breve descrição da disciplina"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Disciplina</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Disciplinas</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Disciplina</th>
                    <th>Carga Horária</th>
                    <th>Nível</th>
                    <th>Professor</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($disciplina = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($disciplina["codigo"]); ?></td>
                        <td><?php echo htmlspecialchars($disciplina["nome"]); ?></td>
                        <td><?php echo htmlspecialchars($disciplina["carga_horaria"]); ?>h</td>
                        <td><?php echo htmlspecialchars($disciplina["nivel_ensino"]); ?></td>
                        <td><?php echo htmlspecialchars($disciplina["professor_responsavel"]); ?></td>
                        <td><?php echo htmlspecialchars($disciplina["estado"]); ?></td>
                        <td>
                            <a class="acao editar" href="editar_disciplina.php?id=<?php echo $disciplina['id_disciplina']; ?>">
                                Editar
                            </a>

                            <a 
                                class="acao eliminar" 
                                href="disciplinas.php?acao=eliminar&id=<?php echo $disciplina['id_disciplina']; ?>"
                                onclick="return confirm('Tem a certeza que deseja eliminar esta disciplina?');">
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