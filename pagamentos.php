<?php
require_once 'config/conexao.php';
require_once 'config/conexao.php';
$mensagem = "";

if (isset($_GET["msg"])) {
    if ($_GET["msg"] === "eliminado") {
        $mensagem = "Pagamento eliminado com sucesso!";
    }

    if ($_GET["msg"] === "atualizado") {
        $mensagem = "Pagamento atualizado com sucesso!";
    }
}

if (isset($_GET["acao"]) && $_GET["acao"] === "eliminar" && isset($_GET["id"])) {
    $id_pagamento = intval($_GET["id"]);

    $sql_delete = "DELETE FROM pagamentos WHERE id_pagamento = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_pagamento);

    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: pagamentos.php?msg=eliminado");
        exit;
    } else {
        $mensagem = "Erro ao eliminar pagamento: " . mysqli_error($conn);
    }
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

    $sql = "INSERT INTO pagamentos 
        (aluno, tipo_pagamento, mes_referencia, valor, data_pagamento, metodo_pagamento, estado, observacao)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssdssss",
        $aluno,
        $tipo_pagamento,
        $mes_referencia,
        $valor,
        $data_pagamento,
        $metodo_pagamento,
        $estado,
        $observacao
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Pagamento registado com sucesso!";
    } else {
        $mensagem = "Erro ao registar pagamento: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM pagamentos ORDER BY id_pagamento DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Pagamentos</h2>
        <p>Registe, consulte e controle os pagamentos escolares dos alunos.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Novo Pagamento</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="pagamentos.php">
            <div class="campo">
                <label for="aluno_pagamento">Aluno</label>
                <input 
                    type="text" 
                    id="aluno_pagamento" 
                    name="aluno_pagamento" 
                    placeholder="Nome do aluno"
                    required
                    maxlength="120">
            </div>

            <div class="campo">
                <label for="tipo_pagamento">Tipo de Pagamento</label>
                <select id="tipo_pagamento" name="tipo_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="matricula">Matrícula</option>
                    <option value="propina">Propina</option>
                    <option value="exame">Exame</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="mes_referencia">Mês de Referência</label>
                <select id="mes_referencia" name="mes_referencia">
                    <option value="">Selecione</option>
                    <option value="janeiro">Janeiro</option>
                    <option value="fevereiro">Fevereiro</option>
                    <option value="marco">Março</option>
                    <option value="abril">Abril</option>
                    <option value="maio">Maio</option>
                    <option value="junho">Junho</option>
                    <option value="julho">Julho</option>
                    <option value="agosto">Agosto</option>
                    <option value="setembro">Setembro</option>
                    <option value="outubro">Outubro</option>
                    <option value="novembro">Novembro</option>
                    <option value="dezembro">Dezembro</option>
                </select>
            </div>

            <div class="campo">
                <label for="valor_pagamento">Valor</label>
                <input 
                    type="number" 
                    id="valor_pagamento" 
                    name="valor_pagamento" 
                    placeholder="Ex: 15000"
                    min="0"
                    step="0.01"
                    required>
            </div>

            <div class="campo">
                <label for="data_pagamento">Data do Pagamento</label>
                <input 
                    type="date" 
                    id="data_pagamento" 
                    name="data_pagamento"
                    required>
            </div>

            <div class="campo">
                <label for="metodo_pagamento">Método de Pagamento</label>
                <select id="metodo_pagamento" name="metodo_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="dinheiro">Dinheiro</option>
                    <option value="transferencia">Transferência</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="estado_pagamento">Estado</label>
                <select id="estado_pagamento" name="estado_pagamento" required>
                    <option value="">Selecione</option>
                    <option value="pago">Pago</option>
                    <option value="pendente">Pendente</option>
                    <option value="atrasado">Atrasado</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_pagamento">Observação</label>
                <textarea 
                    id="observacao_pagamento" 
                    name="observacao_pagamento" 
                    rows="4" 
                    placeholder="Observações sobre o pagamento"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Pagamento</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Pagamentos</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Tipo</th>
                    <th>Mês</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Método</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($pagamento = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pagamento["aluno"]); ?></td>
                        <td><?php echo htmlspecialchars($pagamento["tipo_pagamento"]); ?></td>
                        <td><?php echo htmlspecialchars($pagamento["mes_referencia"]); ?></td>
                        <td><?php echo htmlspecialchars($pagamento["valor"]); ?> FCFA</td>
                        <td><?php echo htmlspecialchars($pagamento["data_pagamento"]); ?></td>
                        <td><?php echo htmlspecialchars($pagamento["metodo_pagamento"]); ?></td>
                        <td><?php echo htmlspecialchars($pagamento["estado"]); ?></td>
                        <td>
                            <a class="acao editar" href="editar_pagamento.php?id=<?php echo $pagamento['id_pagamento']; ?>">
                                Editar
                            </a>

                            <a 
                                class="acao eliminar" 
                                href="pagamentos.php?acao=eliminar&id=<?php echo $pagamento['id_pagamento']; ?>"
                                onclick="return confirm('Tem a certeza que deseja eliminar este pagamento?');">
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