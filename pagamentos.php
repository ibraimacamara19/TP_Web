<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Pagamentos</h2>
        <p>Registe, consulte e controle os pagamentos escolares dos alunos.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Novo Pagamento</h3>

        <form class="formulario formulario-pagamento" method="post" action="#">
            <div class="campo">
                <label for="aluno_pagamento">Aluno</label>
                <select id="aluno_pagamento" name="aluno_pagamento" required>
                    <option value="">Selecione o aluno</option>
                    <option value="1">Maria Gomes</option>
                    <option value="2">João Embaló</option>
                    <option value="3">Djamila Camara</option>
                </select>
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

            <p class="mensagem-formulario" id="mensagemPagamento"></p>
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
                <tr>
                    <td>Maria Gomes</td>
                    <td>Propina</td>
                    <td>Janeiro</td>
                    <td>15 000 FCFA</td>
                    <td>2026-01-10</td>
                    <td>Dinheiro</td>
                    <td>Pago</td>
                    <td>
                        <button class="acao editar">Editar</button>
                        <button class="acao eliminar">Eliminar</button>
                    </td>
                </tr>

                <tr>
                    <td>João Embaló</td>
                    <td>Matrícula</td>
                    <td>-</td>
                    <td>25 000 FCFA</td>
                    <td>2026-01-05</td>
                    <td>Transferência</td>
                    <td>Pago</td>
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