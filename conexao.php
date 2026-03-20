<?php
// rotina para entrada do usuário
$servername = "localhost";
$username = "root";
$password =  "";
$database = "gop";
// criando a conexão com banco de dados
$conection = new mysqli($servername, $username, $password, $database);
// checo erro na conexão
if ($conection->connect_error) {
    die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
}
?>