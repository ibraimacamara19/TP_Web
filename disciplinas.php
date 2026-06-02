<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Disciplinas</h2>
        <p>Registe, consulte e organize as disciplinas lecionadas na instituição.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Nova Disciplina</h3>

        <form class="formulario formulario-disciplina" method="post" action="#">
            <div class="campo">
                <label for="nome_disciplina">Nome da Disciplina</label>
                <input 
                    type="text" 
                    id="nome_disciplina" 
                    name="nome_disciplina" 
                    placeholder="Ex: Matemática"
                    required
                    maxlength="100">
            </div>

            <div class="campo">
                <label for="codigo_disciplina">Código da Disciplina</label>
                <input 
                    type="text" 
                    id="codigo_disciplina" 
                    name="codigo_disciplina" 
                    placeholder="Ex: MAT001"
                    required
                    maxlength="20">
            </div>

            <div class="campo">
                <label for="carga_horaria">Carga Horária</label>
                <input 
                    type="number" 
                    id="carga_horaria" 
                    name="carga_horaria" 
                    placeholder="Ex: 60"
                    min="1"
                    max="300"
                    required>
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
                <input 
                    type="text" 
                    id="professor_responsavel" 
                    name="professor_responsavel" 
                    placeholder="Nome do professor"
                    maxlength="120">
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
                <textarea 
                    id="descricao_disciplina" 
                    name="descricao_disciplina" 
                    rows="4" 
                    placeholder="Breve descrição da disciplina"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Disciplina</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>

            <p class="mensagem-formulario" id="mensagemDisciplina"></p>
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
                <tr>
                    <td>MAT001</td>
                    <td>Matemática</td>
                    <td>60h</td>
                    <td>Ensino Secundário</td>
                    <td>Carlos Mendes</td>
                    <td>Ativa</td>
                    <td>
                        <button class="acao editar">Editar</button>
                        <button class="acao eliminar">Eliminar</button>
                    </td>
                </tr>

                <tr>
                    <td>POR001</td>
                    <td>Português</td>
                    <td>60h</td>
                    <td>Ensino Secundário</td>
                    <td>Ana Gomes</td>
                    <td>Ativa</td>
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