<?php
// rotina para excluir a atividade
session_start();
if (!isset($_GET["id"])) {
    header('location: /casaazul/atividades/atividades_lista.php');
    exit;
}
$id = $_GET["id"];
// conexão dom o banco de dados
include("../conexao.php");
// checo se não existe nenhum participante vinculado a esta atividade
$sql_check = "select * from participamentes_atividade where id_atividade=$id";
$result_check = $conection->query($sql_check);
if ($result_check->num_rows > 0) {
    // se existir, exibo uma mensagem de erro e redireciono para a lista de atividades
    // mensagem de erro          
    echo "<script>alert('Não é possível excluir esta atividade, pois existem participantes vinculados a ela.');</script>";
    exit();
}
// Exclusão do registro
$sql = "delete from atividades_realizadas where id=$id";
$result = $conection->query($sql);
header('location: /casaazul/atividades/atividades_lista.php');
