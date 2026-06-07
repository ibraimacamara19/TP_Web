<?php
require_once 'config/conexao.php';

function obter_total($conn, $sql) {
    $resultado = mysqli_query($conn, $sql);
    $linha = mysqli_fetch_assoc($resultado);
    return $linha["total"];
}

$total_alunos = obter_total($conn, "SELECT COUNT(*) AS total FROM alunos");
$total_professores = obter_total($conn, "SELECT COUNT(*) AS total FROM professores");
$total_turmas = obter_total($conn, "SELECT COUNT(*) AS total FROM turmas WHERE estado = 'ativa'");
$total_pagamentos_pendentes = obter_total($conn, "SELECT COUNT(*) AS total FROM pagamentos WHERE estado = 'pendente'");

$resultado_valor = mysqli_query($conn, "SELECT COALESCE(SUM(valor), 0) AS total FROM pagamentos WHERE estado = 'pago'");
$linha_valor = mysqli_fetch_assoc($resultado_valor);
$total_recebido = $linha_valor["total"];

$resultado_media = mysqli_query($conn, "SELECT COALESCE(AVG(nota), 0) AS media FROM notas");
$linha_media = mysqli_fetch_assoc($resultado_media);
$media_notas = $linha_media["media"];

$tipo_relatorio = isset($_GET["tipo_relatorio"]) ? $_GET["tipo_relatorio"] : "resumo";

$titulo_resultado = "Resumo Geral";
$linhas = [];

if ($tipo_relatorio === "alunos") {
    $titulo_resultado = "Relatório de Alunos";
    $resultado = mysqli_query($conn, "SELECT * FROM alunos ORDER BY nome ASC");

    while ($aluno = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Aluno",
            "descricao" => $aluno["nome"] . " - " . $aluno["turma"],
            "valor" => $aluno["numero_estudante"],
            "estado" => "Registado"
        ];
    }
} elseif ($tipo_relatorio === "professores") {
    $titulo_resultado = "Relatório de Professores";
    $resultado = mysqli_query($conn, "SELECT * FROM professores ORDER BY nome ASC");

    while ($professor = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Professor",
            "descricao" => $professor["nome"] . " - " . $professor["especialidade"],
            "valor" => $professor["email"],
            "estado" => $professor["estado"]
        ];
    }
} elseif ($tipo_relatorio === "turmas") {
    $titulo_resultado = "Relatório de Turmas";
    $resultado = mysqli_query($conn, "SELECT * FROM turmas ORDER BY nome ASC");

    while ($turma = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Turma",
            "descricao" => $turma["nome"] . " - " . $turma["classe"],
            "valor" => $turma["ano_letivo"],
            "estado" => $turma["estado"]
        ];
    }
} elseif ($tipo_relatorio === "notas") {
    $titulo_resultado = "Relatório de Notas";
    $resultado = mysqli_query($conn, "SELECT * FROM notas ORDER BY criado_em DESC");

    while ($nota = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Nota",
            "descricao" => $nota["aluno"] . " - " . $nota["disciplina"],
            "valor" => $nota["nota"],
            "estado" => $nota["periodo"]
        ];
    }
} elseif ($tipo_relatorio === "pagamentos") {
    $titulo_resultado = "Relatório de Pagamentos";
    $resultado = mysqli_query($conn, "SELECT * FROM pagamentos ORDER BY data_pagamento DESC");

    while ($pagamento = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Pagamento",
            "descricao" => $pagamento["aluno"] . " - " . $pagamento["tipo_pagamento"],
            "valor" => number_format($pagamento["valor"], 2, ",", ".") . " FCFA",
            "estado" => $pagamento["estado"]
        ];
    }
} else {
    $linhas[] = [
        "categoria" => "Alunos",
        "descricao" => "Total de alunos registados",
        "valor" => $total_alunos,
        "estado" => "Atualizado"
    ];

    $linhas[] = [
        "categoria" => "Professores",
        "descricao" => "Total de professores registados",
        "valor" => $total_professores,
        "estado" => "Atualizado"
    ];

    $linhas[] = [
        "categoria" => "Turmas",
        "descricao" => "Turmas ativas",
        "valor" => $total_turmas,
        "estado" => "Ativo"
    ];

    $linhas[] = [
        "categoria" => "Pagamentos",
        "descricao" => "Pagamentos pendentes",
        "valor" => $total_pagamentos_pendentes,
        "estado" => "Pendente"
    ];

    $linhas[] = [
        "categoria" => "Receitas",
        "descricao" => "Total recebido em pagamentos pagos",
        "valor" => number_format($total_recebido, 2, ",", ".") . " FCFA",
        "estado" => "Pago"
    ];

    $linhas[] = [
        "categoria" => "Notas",
        "descricao" => "Média geral das notas",
        "valor" => number_format($media_notas, 2, ",", "."),
        "estado" => "Atualizado"
    ];
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Relatórios Administrativos</h2>
        <p>Consulte informações reais registadas na base de dados do sistema.</p>
    </section>

    <section class="resumo-relatorios">
        <article class="card-relatorio">
            <h3>Total de Alunos</h3>
            <p class="valor-destaque"><?php echo $total_alunos; ?></p>
        </article>

        <article class="card-relatorio">
            <h3>Total de Professores</h3>
            <p class="valor-destaque"><?php echo $total_professores; ?></p>
        </article>

        <article class="card-relatorio">
            <h3>Turmas Ativas</h3>
            <p class="valor-destaque"><?php echo $total_turmas; ?></p>
        </article>

        <article class="card-relatorio">
            <h3>Pagamentos Pendentes</h3>
            <p class="valor-destaque"><?php echo $total_pagamentos_pendentes; ?></p>
        </article>
    </section>

    <section class="formulario-container">
        <h3>Filtrar Relatório</h3>

        <form class="formulario" method="get" action="relatorios.php">
            <div class="campo">
                <label for="tipo_relatorio">Tipo de Relatório</label>
                <select id="tipo_relatorio" name="tipo_relatorio" required>
                    <option value="resumo" <?php if ($tipo_relatorio === "resumo") echo "selected"; ?>>Resumo Geral</option>
                    <option value="alunos" <?php if ($tipo_relatorio === "alunos") echo "selected"; ?>>Alunos</option>
                    <option value="professores" <?php if ($tipo_relatorio === "professores") echo "selected"; ?>>Professores</option>
                    <option value="turmas" <?php if ($tipo_relatorio === "turmas") echo "selected"; ?>>Turmas</option>
                    <option value="notas" <?php if ($tipo_relatorio === "notas") echo "selected"; ?>>Notas</option>
                    <option value="pagamentos" <?php if ($tipo_relatorio === "pagamentos") echo "selected"; ?>>Pagamentos</option>
                </select>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Gerar Relatório</button>
                <a href="relatorios.php" class="botao-secundario">Limpar</a>
            </div>
        </form>
    </section>
    <section class="acoes-relatorio">
    <button type="button" class="botao" onclick="window.print();">
        Imprimir Relatório
    </button>

    <button type="button" class="botao-secundario" onclick="window.print();">
        Gerar PDF
    </button>
</section>

    <section class="tabela-container">
        <h3><?php echo $titulo_resultado; ?></h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th>Quantidade / Valor</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($linhas) > 0) { ?>
                    <?php foreach ($linhas as $linha) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["categoria"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["descricao"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["valor"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["estado"]); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">Não existem dados para apresentar.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>