<?php
$servername = "localhost";
$username = "root";
$password = ""; // Deixe em branco se não tiver senha
$database = "controle";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
