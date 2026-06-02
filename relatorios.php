<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Relatórios Administrativos</h2>
        <p>Consulte informações resumidas sobre alunos, professores, turmas, notas e pagamentos.</p>
    </section>

    <section class="resumo-relatorios">
        <article class="card-relatorio">
            <h3>Total de Alunos</h3>
            <p class="valor-destaque">120</p>
        </article>

        <article class="card-relatorio">
            <h3>Total de Professores</h3>
            <p class="valor-destaque">18</p>
        </article>

        <article class="card-relatorio">
            <h3>Turmas Ativas</h3>
            <p class="valor-destaque">12</p>
        </article>

        <article class="card-relatorio">
            <h3>Pagamentos Pendentes</h3>
            <p class="valor-destaque">25</p>
        </article>
    </section>

    <section class="formulario-container">
        <h3>Filtrar Relatório</h3>

        <form class="formulario formulario-relatorio" method="post" action="#">
            <div class="campo">
                <label for="tipo_relatorio">Tipo de Relatório</label>
                <select id="tipo_relatorio" name="tipo_relatorio" required>
                    <option value="">Selecione</option>
                    <option value="alunos">Alunos</option>
                    <option value="professores">Professores</option>
                    <option value="turmas">Turmas</option>
                    <option value="notas">Notas</option>
                    <option value="pagamentos">Pagamentos</option>
                </select>
            </div>

            <div class="campo">
                <label for="ano_letivo_relatorio">Ano Letivo</label>
                <input 
                    type="text" 
                    id="ano_letivo_relatorio" 
                    name="ano_letivo_relatorio" 
                    placeholder="Ex: 2025/2026"
                    maxlength="20">
            </div>

            <div class="campo">
                <label for="turma_relatorio">Turma</label>
                <select id="turma_relatorio" name="turma_relatorio">
                    <option value="">Todas as turmas</option>
                    <option value="10A">10.º Ano A</option>
                    <option value="11A">11.º Ano A</option>
                    <option value="12A">12.º Ano A</option>
                </select>
            </div>

            <div class="campo">
                <label for="estado_relatorio">Estado</label>
                <select id="estado_relatorio" name="estado_relatorio">
                    <option value="">Todos</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                    <option value="pago">Pago</option>
                    <option value="pendente">Pendente</option>
                    <option value="atrasado">Atrasado</option>
                </select>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Gerar Relatório</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>

            <p class="mensagem-formulario" id="mensagemRelatorio"></p>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Resultado do Relatório</h3>

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
                <tr>
                    <td>Alunos</td>
                    <td>Alunos registados no sistema</td>
                    <td>120</td>
                    <td><span class="estado ativo">Ativo</span></td>
                </tr>

                <tr>
                    <td>Professores</td>
                    <td>Professores registados</td>
                    <td>18</td>
                    <td><span class="estado ativo">Ativo</span></td>
                </tr>

                <tr>
                    <td>Pagamentos</td>
                    <td>Propinas pendentes</td>
                    <td>25</td>
                    <td><span class="estado pendente">Pendente</span></td>
                </tr>

                <tr>
                    <td>Notas</td>
                    <td>Média geral das notas</td>
                    <td>14.8</td>
                    <td><span class="estado ativo">Atualizado</span></td>
                </tr>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>