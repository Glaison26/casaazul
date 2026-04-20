<?php
session_start();

// conexão dom o banco de dados
include("../conexao.php");
// rotina de inclusão
$c_participante = rtrim($_POST['c_participante']);
$c_observacao = $_POST['c_observacao'];
$i_id_acao = $_GET['id'];
$c_sql = "insert into participantes_acoes (id_participante,observacao,id_acao) value 
('$c_participante', '$c_observacao', '$i_id_acao')";
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