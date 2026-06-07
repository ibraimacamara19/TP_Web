<?php
require_once 'config/conexao.php';

if (!isset($_GET["id"])) {
    header("Location: pagamentos.php");
    exit;
}

$id_pagamento = intval($_GET["id"]);
$mensagem = "";

$sql = "SELECT * FROM pagamentos WHERE id_pagamento = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_pagamento);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$pagamento = mysqli_fetch_assoc($resultado);

if (!$pagamento) {
    header("Location: pagamentos.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aluno = $_POST["aluno_pagamento"];
    $tipo_pagamento = $_POST["tipo_pagamento"];
    $mes_referencia = $_POST["mes_referencia"];
    $valor = $_POST["valor_pagamento"];
    $data_pagamento = $_POST["data_pagamento"];
    $metodo_pagamento = $_POST["metodo_pagamento"];
    $estado = $_POST["estado_pagamento"];
    $observacao = $_POST["observacao_pagamento"];

    $sql_update = "UPDATE pagamentos SET 
        aluno = ?,
        tipo_pagamento = ?,
        mes_referencia = ?,
        valor = ?,
        data_pagamento = ?,
        metodo_pagamento = ?,
        estado = ?,
        observacao = ?
        WHERE id_pagamento = ?";

    $stmt_update = mysqli_prepare($conn, $sql_update);

    mysqli_stmt_bind_param(
        $stmt_update,
        "sssdssssi",
        $aluno,
        $tipo_pagamento,
        $mes_referencia,
        $valor,
        $data_pagamento,
        $metodo_pagamento,
        $estado,
        $observacao,
        $id_pagamento
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: pagamentos.php?msg=atualizado");
        exit;
    } else {
        $mensagem = "Erro ao atualizar pagamento: " . mysqli_error($conn);
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Editar Pagamento</h2>
        <p>Atualize os dados do pagamento selecionado.</p>
    </section>

    <section class="formulario-container">
        <h3>Dados do Pagamento</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="editar_pagamento.php?id=<?php echo $id_pagamento; ?>">
            <div class="campo">
                <label for="aluno_pagamento">Aluno</label>
                <input 
                    type="text" 
                    id="aluno_pagamento" 
                    name="aluno_pagamento" 
                    required 
                    maxlength="120"
                    value="<?php echo htmlspecialchars($pagamento['aluno']); ?>">
            </div>

            <div class="campo">
                <label for="tipo_pagamento">Tipo de Pagamento</label>
                <select id="tipo_pagamento" name="tipo_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="matricula" <?php if ($pagamento['tipo_pagamento'] === 'matricula') echo 'selected'; ?>>Matrícula</option>
                    <option value="propina" <?php if ($pagamento['tipo_pagamento'] === 'propina') echo 'selected'; ?>>Propina</option>
                    <option value="exame" <?php if ($pagamento['tipo_pagamento'] === 'exame') echo 'selected'; ?>>Exame</option>
                    <option value="outro" <?php if ($pagamento['tipo_pagamento'] === 'outro') echo 'selected'; ?>>Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="mes_referencia">Mês de Referência</label>
                <select id="mes_referencia" name="mes_referencia">
                    <option value="">Selecione</option>
                    <option value="janeiro" <?php if ($pagamento['mes_referencia'] === 'janeiro') echo 'selected'; ?>>Janeiro</option>
                    <option value="fevereiro" <?php if ($pagamento['mes_referencia'] === 'fevereiro') echo 'selected'; ?>>Fevereiro</option>
                    <option value="marco" <?php if ($pagamento['mes_referencia'] === 'marco') echo 'selected'; ?>>Março</option>
                    <option value="abril" <?php if ($pagamento['mes_referencia'] === 'abril') echo 'selected'; ?>>Abril</option>
                    <option value="maio" <?php if ($pagamento['mes_referencia'] === 'maio') echo 'selected'; ?>>Maio</option>
                    <option value="junho" <?php if ($pagamento['mes_referencia'] === 'junho') echo 'selected'; ?>>Junho</option>
                    <option value="julho" <?php if ($pagamento['mes_referencia'] === 'julho') echo 'selected'; ?>>Julho</option>
                    <option value="agosto" <?php if ($pagamento['mes_referencia'] === 'agosto') echo 'selected'; ?>>Agosto</option>
                    <option value="setembro" <?php if ($pagamento['mes_referencia'] === 'setembro') echo 'selected'; ?>>Setembro</option>
                    <option value="outubro" <?php if ($pagamento['mes_referencia'] === 'outubro') echo 'selected'; ?>>Outubro</option>
                    <option value="novembro" <?php if ($pagamento['mes_referencia'] === 'novembro') echo 'selected'; ?>>Novembro</option>
                    <option value="dezembro" <?php if ($pagamento['mes_referencia'] === 'dezembro') echo 'selected'; ?>>Dezembro</option>
                </select>
            </div>

            <div class="campo">
                <label for="valor_pagamento">Valor</label>
                <input 
                    type="number" 
                    id="valor_pagamento" 
                    name="valor_pagamento" 
                    min="0"
                    step="0.01"
                    required
                    value="<?php echo htmlspecialchars($pagamento['valor']); ?>">
            </div>

            <div class="campo">
                <label for="data_pagamento">Data do Pagamento</label>
                <input 
                    type="date" 
                    id="data_pagamento" 
                    name="data_pagamento"
                    required
                    value="<?php echo htmlspecialchars($pagamento['data_pagamento']); ?>">
            </div>

            <div class="campo">
                <label for="metodo_pagamento">Método de Pagamento</label>
                <select id="metodo_pagamento" name="metodo_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="dinheiro" <?php if ($pagamento['metodo_pagamento'] === 'dinheiro') echo 'selected'; ?>>Dinheiro</option>
                    <option value="transferencia" <?php if ($pagamento['metodo_pagamento'] === 'transferencia') echo 'selected'; ?>>Transferência</option>
                    <option value="outro" <?php if ($pagamento['metodo_pagamento'] === 'outro') echo 'selected'; ?>>Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="estado_pagamento">Estado</label>
                <select id="estado_pagamento" name="estado_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="pago" <?php if ($pagamento['estado'] === 'pago') echo 'selected'; ?>>Pago</option>
                    <option value="pendente" <?php if ($pagamento['estado'] === 'pendente') echo 'selected'; ?>>Pendente</option>
                    <option value="atrasado" <?php if ($pagamento['estado'] === 'atrasado') echo 'selected'; ?>>Atrasado</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_pagamento">Observação</label>
                <textarea id="observacao_pagamento" name="observacao_pagamento" rows="4"><?php echo htmlspecialchars($pagamento['observacao']); ?></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Atualizar Pagamento</button>
                <a href="pagamentos.php" class="botao-secundario">Cancelar</a>
            </div>
        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>