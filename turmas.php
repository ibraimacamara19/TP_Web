<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Turmas</h2>
        <p>Crie, consulte e organize as turmas da instituição por ano letivo, classe e turno.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Nova Turma</h3>

        <form class="formulario formulario-turma" method="post" action="#">
            <div class="campo">
                <label for="nome_turma">Nome da Turma</label>
                <input 
                    type="text" 
                    id="nome_turma" 
                    name="nome_turma" 
                    placeholder="Ex: 10.º Ano A"
                    required
                    maxlength="50">
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
                    <option value="7">7.º Ano</option>
                    <option value="8">8.º Ano</option>
                    <option value="9">9.º Ano</option>
                    <option value="10">10.º Ano</option>
                    <option value="11">11.º Ano</option>
                    <option value="12">12.º Ano</option>
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
                <input 
                    type="text" 
                    id="sala" 
                    name="sala" 
                    placeholder="Ex: Sala 12"
                    maxlength="30">
            </div>

            <div class="campo">
                <label for="ano_letivo">Ano Letivo</label>
                <input 
                    type="text" 
                    id="ano_letivo" 
                    name="ano_letivo" 
                    placeholder="Ex: 2025/2026"
                    required
                    maxlength="20">
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
                <textarea 
                    id="observacao_turma" 
                    name="observacao_turma" 
                    rows="4" 
                    placeholder="Informações adicionais sobre a turma"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Turma</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>

            <p class="mensagem-formulario" id="mensagemTurma"></p>
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
                <tr>
                    <td>10.º Ano A</td>
                    <td>Ensino Secundário</td>
                    <td>10.º Ano</td>
                    <td>Manhã</td>
                    <td>Sala 12</td>
                    <td>2025/2026</td>
                    <td>Ativa</td>
                    <td>
                        <button class="acao editar">Editar</button>
                        <button class="acao eliminar">Eliminar</button>
                    </td>
                </tr>

                <tr>
                    <td>11.º Ano A</td>
                    <td>Ensino Secundário</td>
                    <td>11.º Ano</td>
                    <td>Tarde</td>
                    <td>Sala 08</td>
                    <td>2025/2026</td>
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