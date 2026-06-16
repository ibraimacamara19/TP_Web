<?php
require_once 'config/conexao.php';
require_once 'config/conexao.php';
$mensagem = "";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] === "eliminado") {
        $mensagem = "Turma eliminada com sucesso!";
    }

    if ($_GET["msg"] === "atualizado") {
        $mensagem = "Turma atualizada com sucesso!";
    }
}

if (isset($_GET["acao"]) && $_GET["acao"] === "eliminar" && isset($_GET["id"])) {
    $id_turma = intval($_GET["id"]);

    $sql_delete = "DELETE FROM turmas WHERE id_turma = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_turma);

    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: turmas.php?msg=eliminado");
        exit;
    } else {
        $mensagem = "Erro ao eliminar turma: " . mysqli_error($conn);
    }
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

    $sql = "INSERT INTO turmas 
        (nome, nivel_ensino, classe, turno, sala, ano_letivo, estado, observacao)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $nome,
        $nivel_ensino,
        $classe,
        $turno,
        $sala,
        $ano_letivo,
        $estado,
        $observacao
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Turma registada com sucesso!";
    } else {
        $mensagem = "Erro ao registar turma: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM turmas ORDER BY id_turma DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Turmas</h2>
        <p>Crie, consulte e organize as turmas da instituição por ano letivo, classe e turno.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Nova Turma</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="turmas.php">
            <div class="campo">
                <label for="nome_turma">Nome da Turma</label>
                <input type="text" id="nome_turma" name="nome_turma" placeholder="Ex: 10.º Ano A" required maxlength="50">
            </div>

            <div class="campo">
                <label for="nivel_ensino">Nível de Ensino</label>
                <select id="nivel_ensino" name="nivel_ensino" required>
                    <option value="">Selecione</option>
                    <option value="basico">Ensino Básico</option>
                    <option value="secundario">Ensino Secundário</option>
                    <option value="tecnico">Ensino Técnico</option>
                </select>
            </div>

            <div class="campo">
                <label for="classe">Classe / Ano</label>
                <select id="classe" name="classe" required>
                    <option value="">Selecione</option>
                    <option value="7.º Ano">7.º Ano</option>
                    <option value="8.º Ano">8.º Ano</option>
                    <option value="9.º Ano">9.º Ano</option>
                    <option value="10.º Ano">10.º Ano</option>
                    <option value="11.º Ano">11.º Ano</option>
                    <option value="12.º Ano">12.º Ano</option>
                </select>
            </div>

            <div class="campo">
                <label for="turno">Turno</label>
                <select id="turno" name="turno" required>
                    <option value="">Selecione</option>
                    <option value="manha">Manhã</option>
                    <option value="tarde">Tarde</option>
                    <option value="noite">Noite</option>
                </select>
            </div>

            <div class="campo">
                <label for="sala">Sala</label>
                <input type="text" id="sala" name="sala" placeholder="Ex: Sala 12" maxlength="30">
            </div>

            <div class="campo">
                <label for="ano_letivo">Ano Letivo</label>
                <input type="text" id="ano_letivo" name="ano_letivo" placeholder="Ex: 2025/2026" required maxlength="20">
            </div>

            <div class="campo">
                <label for="estado_turma">Estado</label>
                <select id="estado_turma" name="estado_turma" required>
                    <option value="">Selecione</option>
                    <option value="ativa">Ativa</option>
                    <option value="inativa">Inativa</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_turma">Observação</label>
                <textarea id="observacao_turma" name="observacao_turma" rows="4" placeholder="Informações adicionais sobre a turma"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Turma</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Turmas</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Nível</th>
                    <th>Classe</th>
                    <th>Turno</th>
                    <th>Sala</th>
                    <th>Ano Letivo</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($turma = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($turma["nome"]); ?></td>
                        <td><?php echo htmlspecialchars($turma["nivel_ensino"]); ?></td>
                        <td><?php echo htmlspecialchars($turma["classe"]); ?></td>
                        <td><?php echo htmlspecialchars($turma["turno"]); ?></td>
                        <td><?php echo htmlspecialchars($turma["sala"]); ?></td>
                        <td><?php echo htmlspecialchars($turma["ano_letivo"]); ?></td>
                        <td><?php echo htmlspecialchars($turma["estado"]); ?></td>
                        <td>
                            <a class="acao editar" href="editar_turma.php?id=<?php echo $turma['id_turma']; ?>">
                                Editar
                            </a>

                            <a 
                                class="acao eliminar" 
                                href="turmas.php?acao=eliminar&id=<?php echo $turma['id_turma']; ?>"
                                onclick="return confirm('Tem a certeza que deseja eliminar esta turma?');">
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