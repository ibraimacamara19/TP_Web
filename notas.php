<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Notas</h2>
        <p>Lance, consulte e organize as notas dos alunos por turma, disciplina e período.</p>
    </section>

    <section class="formulario-container">
        <h3>Lançar Nova Nota</h3>

        <form class="formulario formulario-nota" method="post" action="#">
            <div class="campo">
                <label for="aluno_nota">Aluno</label>
                <select id="aluno_nota" name="aluno_nota" required>
                    <option value="">Selecione o aluno</option>
                    <option value="1">Maria Gomes</option>
                    <option value="2">João Embaló</option>
                    <option value="3">Djamila Camara</option>
                </select>
            </div>

            <div class="campo">
                <label for="turma_nota">Turma</label>
                <select id="turma_nota" name="turma_nota" required>
                    <option value="">Selecione a turma</option>
                    <option value="10A">10.º Ano A</option>
                    <option value="11A">11.º Ano A</option>
                    <option value="12A">12.º Ano A</option>
                </select>
            </div>

            <div class="campo">
                <label for="disciplina_nota">Disciplina</label>
                <select id="disciplina_nota" name="disciplina_nota" required>
                    <option value="">Selecione a disciplina</option>
                    <option value="matematica">Matemática</option>
                    <option value="portugues">Português</option>
                    <option value="fisica">Física</option>
                    <option value="informatica">Informática</option>
                </select>
            </div>

            <div class="campo">
                <label for="professor_nota">Professor</label>
                <select id="professor_nota" name="professor_nota" required>
                    <option value="">Selecione o professor</option>
                    <option value="carlos">Carlos Mendes</option>
                    <option value="ana">Ana Gomes</option>
                    <option value="mario">Mário Lopes</option>
                </select>
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
                <input 
                    type="number" 
                    id="nota" 
                    name="nota" 
                    placeholder="Ex: 15"
                    min="0"
                    max="20"
                    step="0.1"
                    required>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_nota">Observação</label>
                <textarea 
                    id="observacao_nota" 
                    name="observacao_nota" 
                    rows="4" 
                    placeholder="Observação sobre o desempenho do aluno"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Nota</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>

            <p class="mensagem-formulario" id="mensagemNota"></p>
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
                <tr>
                    <td>Maria Gomes</td>
                    <td>10.º Ano A</td>
                    <td>Matemática</td>
                    <td>Carlos Mendes</td>
                    <td>1.º Período</td>
                    <td>15</td>
                    <td>
                        <button class="acao editar">Editar</button>
                        <button class="acao eliminar">Eliminar</button>
                    </td>
                </tr>

                <tr>
                    <td>João Embaló</td>
                    <td>11.º Ano A</td>
                    <td>Português</td>
                    <td>Ana Gomes</td>
                    <td>1.º Período</td>
                    <td>16.5</td>
                    <td>
                        <button class="acao editar">Editar</button>
                        <button class="acao eliminar">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>