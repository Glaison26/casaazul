<?php
// rotina para excluir a atividade
session_start();
if (!isset($_GET["id"])) {
    header('location: /casaazul/acoes/acoes_lista.php');
    exit;
}
$id = $_GET["id"];
// conexão dom o banco de dados
include("../conexao.php");
// checo se não existe nenhum participante vinculado a esta ação
$c_sql = "SELECT * FROM participantes_acoes WHERE id_acao = $id";

$result_check = $conection->query($c_sql);
if ($result_check->num_rows > 0) {
    // se existir, exibo uma mensagem de erro e redireciono para a lista de ações
    // mensagem de erro          
    echo "<script>alert('Não é possível excluir esta ação, pois existem participantes vinculados a ela.');</script>";
    exit();
}
// Exclusão do registro
$c_sql = "DELETE FROM acoes WHERE id=$id";
$c_result = $conection->query($c_sql);
header('location: /casaazul/acoes/acoes_lista.php');
