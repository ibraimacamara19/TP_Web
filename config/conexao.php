<?php

$servidor = "localhost";
$utilizador = "root";
$palavra_passe = "";
$base_dados = "gestao_escolar_gb";

$conn = mysqli_connect($servidor, $utilizador, $palavra_passe, $base_dados);

if (!$conn) {
    die("Erro na ligação à base de dados: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>