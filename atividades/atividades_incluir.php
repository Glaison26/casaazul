<?php

session_start();

// conexão dom o banco de dados
include("../conexao.php");
// rotina de inclusão da atividade pegandos dados da janela modal em atividades_lista.php
$c_atividade = $_POST['up_atividadeField'];
$d_data_inicio = $_POST['up_data_inicioField'];
$d_data_termino = $_POST['up_data_finalField'];
$n_vagas = $_POST['up_num_vagasField'];
$c_cargahoraria = $_POST['up_carga_horariaField'];
$c_instrutor = $_POST['up_instrutorField'];
$c_observacao = $_POST['up_observacaoField'];
// sql para incluir nova atividade
$sql = "INSERT INTO atividades_realizadas (atividade, data_inicio, data_termino, num_vagas, carga_horaria, instrutor, observacao) 
VALUES ('$c_atividade', '$d_data_inicio', '$d_data_termino', '$n_vagas', '$c_cargahoraria', '$c_instrutor', '$c_observacao')";
$_SESSION['meu_sql'] = $sql;


$result = $connection->query($sql);

// mostro na tela a variavel $sql para verificar se o comando sql está correto
echo $sql;

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

