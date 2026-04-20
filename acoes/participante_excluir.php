<?php
// rotina para excluir o participante da atividade
session_start();
if (!isset($_GET["id"])) {
    header('location: /casaazul/acoes/participantes_acoes.php');
    exit;
}
$id = $_GET["id"];
// conexão dom o banco de dados
include("../conexao.php");
// Exclusão do registro
$sql = "delete from participantes_acoes where id=$id";
$result = $conection->query($sql);
header('location: /casaazul/acoes/participantes_acoes.php');
