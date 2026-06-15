<?php
require_once 'config/conexao.php';

date_default_timezone_set("Africa/Bissau");
$data_relatorio = date("d/m/Y H:i");

function formatar_periodo($periodo) {
    $periodos = [
        "1_periodo" => "1.º Período",
        "2_periodo" => "2.º Período",
        "3_periodo" => "3.º Período",
        "final" => "Nota Final"
    ];

    return $periodos[$periodo] ?? $periodo;
}

$aluno_selecionado = isset($_GET["aluno"]) ? trim($_GET["aluno"]) : "";

$alunos_resultado = mysqli_query($conn, "SELECT DISTINCT aluno FROM notas ORDER BY aluno ASC");

$notas = [];
$media = 0;
$total_notas = 0;
$soma_notas = 0;

if (!empty($aluno_selecionado)) {
    $sql = "SELECT * FROM notas WHERE aluno = ? ORDER BY disciplina ASC, periodo ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $aluno_selecionado);
    mysqli_stmt_execute($stmt);
    $resultado_notas = mysqli_stmt_get_result($stmt);

    while ($linha = mysqli_fetch_assoc($resultado_notas)) {
        $notas[] = $linha;
        $soma_notas += floatval($linha["nota"]);
        $total_notas++;
    }

    if ($total_notas > 0) {
        $media = $soma_notas / $total_notas;
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina no-print">
        <h2>Relatório Individual de Notas</h2>
        <p>Selecione um aluno para gerar o relatório individual das notas registadas.</p>
    </section>

    <section class="formulario-container no-print">
        <h3>Selecionar Aluno</h3>

        <form class="formulario" method="get" action="relatorio_notas_aluno.php">
            <div class="campo">
                <label for="aluno">Aluno</label>
                <select id="aluno" name="aluno" required>
                    <option value="">Selecione o aluno</option>

                    <?php while ($aluno = mysqli_fetch_assoc($alunos_resultado)) { ?>
                        <option 
                            value="<?php echo htmlspecialchars($aluno['aluno']); ?>"
                            <?php if ($aluno_selecionado === $aluno['aluno']) echo "selected"; ?>>
                            <?php echo htmlspecialchars($aluno['aluno']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Gerar Relatório</button>
                <a href="relatorio_notas_aluno.php" class="botao-secundario">Limpar</a>
            </div>
        </form>
    </section>

    <?php if (!empty($aluno_selecionado)) { ?>

        <section class="acoes-relatorio no-print">
    <button type="button" class="botao" onclick="imprimirRelatorioIndividual();">
        Imprimir Relatório
    </button>

    <button type="button" class="botao-secundario" onclick="imprimirRelatorioIndividual();">
        Gerar PDF
    </button>

    <a href="notas.php" class="botao-secundario">
        Voltar para Notas
    </a>
</section>

        <section class="tabela-container relatorio-area">

            <?php include 'includes/cabecalho_documento.php'; ?>

            <div class="relatorio-topo">
                <div>
                    <h3>Relatório Individual de Notas</h3>
                    <p>Relatório gerado automaticamente pelo Sistema de Gestão Escolar GB.</p>
                </div>

                <div class="relatorio-meta">
                    <p><strong>País:</strong> República da Guiné-Bissau</p>
                    <p><strong>Data:</strong> <?php echo $data_relatorio; ?></p>
                    <p><strong>Aluno:</strong> <?php echo htmlspecialchars($aluno_selecionado); ?></p>
                </div>
            </div>

            <?php if ($total_notas > 0) { ?>

                <section class="dados-aluno-relatorio">
                    <p><strong>Nome do Aluno:</strong> <?php echo htmlspecialchars($aluno_selecionado); ?></p>
                    <p><strong>Total de Notas:</strong> <?php echo $total_notas; ?></p>
                    <p><strong>Média Geral:</strong> <?php echo number_format($media, 2, ",", "."); ?></p>
                </section>

                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Turma</th>
                            <th>Professor</th>
                            <th>Período</th>
                            <th>Nota</th>
                            <th>Observação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($notas as $nota) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($nota["disciplina"]); ?></td>
                                <td><?php echo htmlspecialchars($nota["turma"]); ?></td>
                                <td><?php echo htmlspecialchars($nota["professor"]); ?></td>
                                <td><?php echo htmlspecialchars(formatar_periodo($nota["periodo"])); ?></td>
                                <td><?php echo htmlspecialchars(number_format($nota["nota"], 1, ",", ".")); ?></td>
                                <td><?php echo htmlspecialchars($nota["observacao"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <?php } else { ?>

                <p>Este aluno ainda não possui notas registadas.</p>

            <?php } ?>

        </section>

    <?php } ?>

</main>
<script>
function imprimirRelatorioIndividual() {
    const areaRelatorio = document.querySelector(".relatorio-area");

    if (!areaRelatorio) {
        alert("Área do relatório individual não encontrada.");
        return;
    }

    const conteudo = areaRelatorio.innerHTML;

    const janela = window.open("", "_blank", "width=1000,height=800");

    janela.document.write(`
        <!DOCTYPE html>
        <html lang="pt">
        <head>
            <meta charset="UTF-8">
            <title>Relatório Individual de Notas - Sistema de Gestão Escolar GB</title>

            <style>
                @page {
                    size: A4;
                    margin: 15mm;
                }

                * {
                    box-sizing: border-box;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                    background: white;
                    color: black;
                    margin: 0;
                    padding: 0;
                    font-size: 12px;
                }

                .cabecalho-documento {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 15px;
                    text-align: left;
                    border-bottom: 2px solid black;
                    margin-bottom: 18px;
                    padding-bottom: 12px;
                }

                .brasao-documento {
                    width: 65px;
                    max-width: 65px;
                    height: auto;
                }

                .cabecalho-documento h2 {
                    font-size: 18px;
                    margin: 0 0 4px 0;
                    color: black;
                    text-transform: uppercase;
                }

                .cabecalho-documento p {
                    margin: 2px 0;
                    color: black;
                    font-size: 12px;
                    font-weight: bold;
                }

                .relatorio-topo {
                    display: flex;
                    justify-content: space-between;
                    gap: 20px;
                    border-bottom: 1px solid #999;
                    margin-bottom: 18px;
                    padding-bottom: 10px;
                }

                .relatorio-topo h3 {
                    font-size: 18px;
                    color: black;
                    margin-bottom: 5px;
                }

                .relatorio-topo p,
                .relatorio-meta p {
                    color: black;
                    font-size: 12px;
                    margin: 3px 0;
                }

                .relatorio-meta {
                    border: 1px solid #999;
                    padding: 8px;
                    min-width: 220px;
                }

                .dados-aluno-relatorio {
                    border: 1px solid #999;
                    padding: 10px;
                    margin-bottom: 15px;
                    background: white;
                }

                .dados-aluno-relatorio p {
                    margin: 4px 0;
                    color: black;
                    font-size: 12px;
                }

                .tabela {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 11px;
                    margin-top: 10px;
                }

                .tabela th {
                    background: black;
                    color: white;
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }

                .tabela td {
                    background: white;
                    color: black;
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }

                .tabela tr {
                    page-break-inside: avoid;
                }
            </style>
        </head>

        <body>
            ${conteudo}
        </body>
        </html>
    `);

    janela.document.close();

    setTimeout(function () {
        janela.focus();
        janela.print();
    }, 500);
}
</script>
<?php include 'includes/footer.php'; ?>