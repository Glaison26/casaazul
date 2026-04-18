<?php // controle de acesso ao formulário
session_start();

if (!isset($_GET["id"])) {
    header('location: /casaazul/tipo_acoes/tipo_acoes_lista.php');
    exit;
}

$c_id = $_GET["id"];
// conexão dom o banco de dados
include("../conexao.php");
// Exclusão do registro
$c_sql = "delete from atividades where id=$c_id";
$result = $conection->query($c_sql);
header('location: /casaazul/tipo_acoes/tipo_acoes_lista.php');
