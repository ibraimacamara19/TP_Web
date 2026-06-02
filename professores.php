<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Professores</h2>
        <p>Registe, consulte e organize os professores da instituição.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Novo Professor</h3>

        <form class="formulario formulario-professor" method="post" action="#">
            <div class="campo">
                <label for="nome_professor">Nome Completo</label>
                <input 
                    type="text" 
                    id="nome_professor" 
                    name="nome_professor" 
                    placeholder="Digite o nome completo"
                    required
                    maxlength="120">
            </div>

            <div class="campo">
                <label for="email_professor">Email</label>
                <input 
                    type="email" 
                    id="email_professor" 
                    name="email_professor" 
                    placeholder="exemplo@email.com"
                    required>
            </div>

            <div class="campo">
                <label for="contacto_professor">Contacto</label>
                <input 
                    type="tel" 
                    id="contacto_professor" 
                    name="contacto_professor" 
                    placeholder="Ex: +245 966 000 000"
                    maxlength="30">
            </div>

            <div class="campo">
                <label for="especialidade">Especialidade</label>
                <input 
                    type="text" 
                    id="especialidade" 
                    name="especialidade" 
                    placeholder="Ex: Matemática, Português, Física"
                    required
                    maxlength="100">
            </div>

            <div class="campo">
                <label for="estado_professor">Estado</label>
                <select id="estado_professor" name="estado_professor" required>
                    <option value="">Selecione</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>

            <div class="campo campo-largo">
                <label for="observacao_professor">Observação</label>
                <textarea 
                    id="observacao_professor" 
                    name="observacao_professor" 
                    rows="4" 
                    placeholder="Informações adicionais sobre o professor"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Professor</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>

            <p class="mensagem-formulario" id="mensagemProfessor"></p>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Professores</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Contacto</th>
                    <th>Especialidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Carlos Mendes</td>
                    <td>carlos@email.com</td>
                    <td>+245 966 111 111</td>
                    <td>Matemática</td>
                    <td>Ativo</td>
                    <td>
                        <button class="acao editar">Editar</button>
                        <button class="acao eliminar">Eliminar</button>
                    </td>
                </tr>

                <tr>
                    <td>Ana Gomes</td>
                    <td>ana@email.com</td>
                    <td>+245 955 222 222</td>
                    <td>Português</td>
                    <td>Ativo</td>
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