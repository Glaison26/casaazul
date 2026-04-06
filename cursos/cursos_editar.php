<?php


// conexão dom o banco de dados
include("../conexao.php");

// rotina de edição
$c_id = $_POST['c_id'];
$c_descricao = rtrim($_POST['c_descricao']);
$c_observacao = $_POST['c_observacao'];

$c_sql = "Update cursos" .
    " SET descricao = '$c_descricao', observacao = '$c_observacao' where id=$c_id";

$result = $conection->query($c_sql);

if ($result == true) {

    $data = array(
        'status' => 'true',

    );

    echo json_encode($data);
} else {
    $data = array(
        'status' => 'false',

    );

    echo json_encode($data);
}