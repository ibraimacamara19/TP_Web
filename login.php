<?php
require_once 'config/conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = "";

if (isset($_SESSION["utilizador_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $palavra_passe = trim($_POST["palavra_passe"]);

    $sql = "SELECT * FROM utilizadores WHERE email = ? AND estado = 'ativo' LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($utilizador = mysqli_fetch_assoc($resultado)) {
        if (password_verify($palavra_passe, $utilizador["palavra_passe"])) {
            $_SESSION["utilizador_id"] = $utilizador["id_utilizador"];
            $_SESSION["utilizador_nome"] = $utilizador["nome"];
            $_SESSION["utilizador_email"] = $utilizador["email"];
            $_SESSION["utilizador_perfil"] = $utilizador["perfil"];

            header("Location: index.php");
            exit;
        } else {
            $mensagem = "Email ou palavra-passe incorretos.";
        }
    } else {
        $mensagem = "Email ou palavra-passe incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Gestão Escolar GB</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>

<body class="login-body">

    <main class="login-container">
        <section class="login-card">
            <h1>Sistema de Gestão Escolar GB</h1>
            <p>República da Guiné-Bissau</p>

            <h2>Iniciar Sessão</h2>

            <?php if (!empty($mensagem)) { ?>
                <p class="mensagem-erro"><?php echo htmlspecialchars($mensagem); ?></p>
            <?php } ?>

            <form method="post" action="login.php" class="formulario-login">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="admin@escola.gb">

                <label for="palavra_passe">Palavra-passe</label>
                <input type="password" id="palavra_passe" name="palavra_passe" required placeholder="Digite a palavra-passe">

                <button type="submit" class="botao">Entrar</button>
            </form>
        </section>
    </main>

</body>
</html>