<?php
require_once 'config/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero_estudante = $_POST["numero_estudante"];
    $nome = $_POST["nome"];
    $data_nascimento = $_POST["data_nascimento"];
    $genero = $_POST["genero"];
    $contacto = $_POST["contacto"];
    $email = $_POST["email"];
    $turma = $_POST["turma"];
    $morada = $_POST["morada"];
    $encarregado_nome = $_POST["encarregado_nome"];
    $encarregado_contacto = $_POST["encarregado_contacto"];
    $observacao = $_POST["observacao"];

    $sql = "INSERT INTO alunos 
        (numero_estudante, nome, data_nascimento, genero, contacto, email, turma, morada, encarregado_nome, encarregado_contacto, observacao)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssss",
        $numero_estudante,
        $nome,
        $data_nascimento,
        $genero,
        $contacto,
        $email,
        $turma,
        $morada,
        $encarregado_nome,
        $encarregado_contacto,
        $observacao
    );

    if (mysqli_stmt_execute($stmt)) {
        $mensagem = "Aluno registado com sucesso!";
    } else {
        $mensagem = "Erro ao registar aluno: " . mysqli_error($conn);
    }
}

$resultado = mysqli_query($conn, "SELECT * FROM alunos ORDER BY id_aluno DESC");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<main class="conteudo">

    <section class="cabecalho-pagina">
        <h2>Gestão de Alunos</h2>
        <p>Registe, consulte e organize os alunos da instituição.</p>
    </section>

    <section class="formulario-container">
        <h3>Registar Novo Aluno</h3>

        <?php if (!empty($mensagem)) { ?>
            <p class="mensagem-formulario"><?php echo $mensagem; ?></p>
        <?php } ?>

        <form class="formulario" method="post" action="alunos.php">
            <div class="campo">
                <label for="numero_estudante">Número de Estudante</label>
                <input type="text" id="numero_estudante" name="numero_estudante" placeholder="Ex: ALU2026001" required maxlength="30">
            </div>

            <div class="campo">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" required maxlength="120">
            </div>

            <div class="campo">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>

            <div class="campo">
                <label for="genero">Género</label>
                <select id="genero" name="genero" required>
                    <option value="">Selecione</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div class="campo">
                <label for="contacto">Contacto</label>
                <input type="tel" id="contacto" name="contacto" placeholder="Ex: +245 955 000 000" maxlength="30">
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="exemplo@email.com">
            </div>

            <div class="campo">
                <label for="turma">Turma</label>
                <select id="turma" name="turma" required>
                    <option value="">Selecione a turma</option>
                    <option value="7.º Ano A">7.º Ano A</option>
                    <option value="8.º Ano A">8.º Ano A</option>
                    <option value="9.º Ano A">9.º Ano A</option>
                    <option value="10.º Ano A">10.º Ano A</option>
                    <option value="11.º Ano A">11.º Ano A</option>
                    <option value="12.º Ano A">12.º Ano A</option>
                </select>
            </div>

            <div class="campo">
                <label for="morada">Morada</label>
                <input type="text" id="morada" name="morada" placeholder="Ex: Bissau, Bairro Militar" maxlength="200">
            </div>

            <div class="campo">
                <label for="encarregado_nome">Nome do Encarregado</label>
                <input type="text" id="encarregado_nome" name="encarregado_nome" placeholder="Nome do encarregado de educação" maxlength="120">
            </div>

            <div class="campo">
                <label for="encarregado_contacto">Contacto do Encarregado</label>
                <input type="tel" id="encarregado_contacto" name="encarregado_contacto" placeholder="Contacto do encarregado" maxlength="30">
            </div>

            <div class="campo campo-largo">
                <label for="observacao">Observação</label>
                <textarea id="observacao" name="observacao" rows="4" placeholder="Informações adicionais sobre o aluno"></textarea>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="botao">Guardar Aluno</button>
                <button type="reset" class="botao-secundario">Limpar</button>
            </div>
        </form>
    </section>

    <section class="tabela-container">
        <h3>Lista de Alunos</h3>

        <table class="tabela">
            <thead>
                <tr>
                    <th>N.º Estudante</th>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Contacto</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($aluno = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aluno["numero_estudante"]); ?></td>
                        <td><?php echo htmlspecialchars($aluno["nome"]); ?></td>
                        <td><?php echo htmlspecialchars($aluno["turma"]); ?></td>
                        <td><?php echo htmlspecialchars($aluno["contacto"]); ?></td>
                        <td><?php echo htmlspecialchars($aluno["email"]); ?></td>
                        <td>
                            <button class="acao editar">Editar</button>
                            <button class="acao eliminar">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>