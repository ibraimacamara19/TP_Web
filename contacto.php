<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Contacto</h2>
        <p>Entre em contacto com a administração do Sistema de Gestão Escolar GB.</p>
    </section>

    <section class="contacto-layout">

        <section class="formulario-container contacto-formulario">
            <h3>Enviar Mensagem</h3>

            <form class="formulario formulario-contacto" method="post" action="#">
                <div class="campo">
                    <label for="nome_contacto">Nome</label>
                    <input 
                        type="text" 
                        id="nome_contacto" 
                        name="nome_contacto" 
                        placeholder="Digite o seu nome"
                        required
                        maxlength="120">
                </div>

                <div class="campo">
                    <label for="email_contacto">Email</label>
                    <input 
                        type="email" 
                        id="email_contacto" 
                        name="email_contacto" 
                        placeholder="exemplo@email.com"
                        required>
                </div>

                <div class="campo campo-largo">
                    <label for="assunto_contacto">Assunto</label>
                    <input 
                        type="text" 
                        id="assunto_contacto" 
                        name="assunto_contacto" 
                        placeholder="Digite o assunto da mensagem"
                        required
                        maxlength="150">
                </div>

                <div class="campo campo-largo">
                    <label for="mensagem_contacto">Mensagem</label>
                    <textarea 
                        id="mensagem_contacto" 
                        name="mensagem_contacto" 
                        rows="6" 
                        placeholder="Escreva a sua mensagem"
                        required></textarea>
                </div>

                <div class="botoes-formulario">
                    <button type="submit" class="botao">Enviar Mensagem</button>
                    <button type="reset" class="botao-secundario">Limpar</button>
                </div>

                <p class="mensagem-formulario" id="mensagemContacto"></p>
            </form>
        </section>

        <aside class="info-contacto">
            <h3>Informações</h3>

            <div class="info-item">
                <strong>Instituição:</strong>
                <p>Sistema de Gestão Escolar GB</p>
            </div>

            <div class="info-item">
                <strong>Localização:</strong>
                <p>Bissau, Guiné-Bissau</p>
            </div>

            <div class="info-item">
                <strong>Email:</strong>
                <p>contacto@gestaoescolargb.com</p>
            </div>

            <div class="info-item">
                <strong>Telefone:</strong>
                <p>+245 955 000 000</p>
            </div>

            <div class="info-item">
                <strong>Horário:</strong>
                <p>Segunda a Sexta, das 08h às 17h</p>
            </div>
        </aside>

    </section>

</main>

<?php include 'includes/footer.php'; ?>