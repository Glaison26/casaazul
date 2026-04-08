<?php
session_start();

// conexão dom o banco de dados
include("../conexao.php");
// rotina de inclusão
$c_descricao = rtrim($_POST['c_descricao']);
$c_observacao = $_POST['c_observacao'];
$c_sql = "insert into atividades (descricao,observacao) value ('$c_descricao', '$c_observacao')";
$result = $conection->query($c_sql);

if($result ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
  
    );

    echo json_encode($data);
} 

?>