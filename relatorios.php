<?php
require_once 'config/conexao.php';

date_default_timezone_set("Africa/Bissau");
$data_relatorio = date("d/m/Y H:i");

function obter_total($conn, $sql) {
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        return 0;
    }

    $linha = mysqli_fetch_assoc($resultado);
    return $linha["total"] ?? 0;
}

function formatar_periodo($periodo) {
    $periodos = [
        "1_periodo" => "1.º Período",
        "2_periodo" => "2.º Período",
        "3_periodo" => "3.º Período",
        "final" => "Nota Final"
    ];

    return $periodos[$periodo] ?? $periodo;
}

function formatar_estado($estado) {
    $estados = [
        "ativa" => "Ativa",
        "ativo" => "Ativo",
        "inativa" => "Inativa",
        "inativo" => "Inativo",
        "pago" => "Pago",
        "pendente" => "Pendente",
        "atrasado" => "Atrasado",
        "Registado" => "Registado",
        "Atualizado" => "Atualizado"
    ];

    return $estados[$estado] ?? $estado;
}

$total_alunos = obter_total($conn, "SELECT COUNT(*) AS total FROM alunos");
$total_professores = obter_total($conn, "SELECT COUNT(*) AS total FROM professores");
$total_turmas = obter_total($conn, "SELECT COUNT(*) AS total FROM turmas WHERE estado = 'ativa'");
$total_pagamentos_pendentes = obter_total($conn, "SELECT COUNT(*) AS total FROM pagamentos WHERE estado = 'pendente'");

$resultado_valor = mysqli_query($conn, "SELECT COALESCE(SUM(valor), 0) AS total FROM pagamentos WHERE estado = 'pago'");
$linha_valor = mysqli_fetch_assoc($resultado_valor);
$total_recebido = $linha_valor["total"] ?? 0;

$resultado_media = mysqli_query($conn, "SELECT COALESCE(AVG(nota), 0) AS media FROM notas");
$linha_media = mysqli_fetch_assoc($resultado_media);
$media_notas = $linha_media["media"] ?? 0;

$tipos_validos = ["resumo", "alunos", "professores", "turmas", "notas", "pagamentos"];
$tipo_relatorio = isset($_GET["tipo_relatorio"]) ? $_GET["tipo_relatorio"] : "resumo";

if (!in_array($tipo_relatorio, $tipos_validos)) {
    $tipo_relatorio = "resumo";
}

$nomes_relatorios = [
    "resumo" => "Resumo Geral",
    "alunos" => "Relatório de Alunos",
    "professores" => "Relatório de Professores",
    "turmas" => "Relatório de Turmas",
    "notas" => "Relatório de Notas",
    "pagamentos" => "Relatório de Pagamentos"
];

$titulo_resultado = $nomes_relatorios[$tipo_relatorio];
$linhas = [];

if ($tipo_relatorio === "alunos") {
    $resultado = mysqli_query($conn, "SELECT * FROM alunos ORDER BY nome ASC");

    while ($aluno = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Aluno",
            "descricao" => $aluno["nome"] . " | Turma: " . $aluno["turma"],
            "valor" => $aluno["numero_estudante"],
            "estado" => "Registado"
        ];
    }
} elseif ($tipo_relatorio === "professores") {
    $resultado = mysqli_query($conn, "SELECT * FROM professores ORDER BY nome ASC");

    while ($professor = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Professor",
            "descricao" => $professor["nome"] . " | Especialidade: " . $professor["especialidade"],
            "valor" => $professor["email"],
            "estado" => formatar_estado($professor["estado"])
        ];
    }
} elseif ($tipo_relatorio === "turmas") {
    $resultado = mysqli_query($conn, "SELECT * FROM turmas ORDER BY nome ASC");

    while ($turma = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Turma",
            "descricao" => $turma["nome"] . " | Classe: " . $turma["classe"] . " | Turno: " . $turma["turno"],
            "valor" => $turma["ano_letivo"],
            "estado" => formatar_estado($turma["estado"])
        ];
    }
} elseif ($tipo_relatorio === "notas") {
    $resultado = mysqli_query($conn, "SELECT * FROM notas ORDER BY criado_em DESC");

    while ($nota = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Nota",
            "descricao" => $nota["aluno"] . " | Disciplina: " . $nota["disciplina"] . " | Turma: " . $nota["turma"],
            "valor" => number_format($nota["nota"], 1, ",", "."),
            "estado" => formatar_periodo($nota["periodo"])
        ];
    }
} elseif ($tipo_relatorio === "pagamentos") {
    $resultado = mysqli_query($conn, "SELECT * FROM pagamentos ORDER BY data_pagamento DESC");

    while ($pagamento = mysqli_fetch_assoc($resultado)) {
        $linhas[] = [
            "categoria" => "Pagamento",
            "descricao" => $pagamento["aluno"] . " | Tipo: " . $pagamento["tipo_pagamento"] . " | Mês: " . $pagamento["mes_referencia"],
            "valor" => number_format($pagamento["valor"], 2, ",", ".") . " FCFA",
            "estado" => formatar_estado($pagamento["estado"])
        ];
    }
} else {
    $linhas[] = [
        "categoria" => "Alunos",
        "descricao" => "Total de alunos registados no sistema",
        "valor" => $total_alunos,
        "estado" => "Atualizado"
    ];

    $linhas[] = [
        "categoria" => "Professores",
        "descricao" => "Total de professores registados no sistema",
        "valor" => $total_professores,
        "estado" => "Atualizado"
    ];

    $linhas[] = [
        "categoria" => "Turmas",
        "descricao" => "Total de turmas ativas",
        "valor" => $total_turmas,
        "estado" => "Ativo"
    ];

    $linhas[] = [
        "categoria" => "Pagamentos",
        "descricao" => "Total de pagamentos pendentes",
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
        "descricao" => "Média geral das notas registadas",
        "valor" => number_format($media_notas, 2, ",", "."),
        "estado" => "Atualizado"
    ];
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina no-print">
        <h2>Relatórios Administrativos</h2>
        <p>Consulte informações reais registadas na base de dados do sistema.</p>
    </section>

    <section class="resumo-relatorios no-print">
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

    <section class="formulario-container no-print">
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

    <section class="acoes-relatorio no-print">
        <button type="button" class="botao" onclick="window.print();">
            Imprimir Relatório
        </button>

        <button type="button" class="botao-secundario" onclick="window.print();">
            Gerar PDF
        </button>
    </section>

    <section class="tabela-container relatorio-area">

        <?php include 'includes/cabecalho_documento.php'; ?>

        <div class="relatorio-topo">
            <div>
                <h3><?php echo htmlspecialchars($titulo_resultado); ?></h3>
                <p>Relatório gerado automaticamente pelo Sistema de Gestão Escolar GB.</p>
            </div>

            <div class="relatorio-meta">
                <p><strong>País:</strong> República da Guiné-Bissau</p>
                <p><strong>Data:</strong> <?php echo $data_relatorio; ?></p>
                <p><strong>Tipo:</strong> <?php echo htmlspecialchars($titulo_resultado); ?></p>
            </div>
        </div>

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