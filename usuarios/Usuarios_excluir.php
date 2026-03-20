<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

if (!isset($_GET["id"])) {
    header('location: /gop/cadastros/usuarios/usuarios_lista.php');
    exit;
}
$c_id = "";
$c_id = $_GET["id"];
// conexão dom o banco de dados
$servername = $_SESSION['local'];
$username = $_SESSION['usuario'];
$password =  $_SESSION['senha'];
$database = $_SESSION['banco'];
// criando a conexão com banco de dados
$conection = new mysqli($servername, $username, $password, $database);
// checo erro na conexão
if ($conection->connect_error) {
    die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
}
// Exclusão do registro
$c_sql = "delete from usuarios where id=$c_id";
echo $c_sql;
echo $c_id;
$result = $conection->query($c_sql);

header('location: /gop/cadastros/usuarios/usuarios_lista.php');
