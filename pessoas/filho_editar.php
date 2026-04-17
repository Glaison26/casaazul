<?php
// rotina para editar filho na tabela de pessoas vinda da janela modal de filhos
include_once("../conexao.php");
// rotina de atualização
$c_id = $_POST['id_pessoa'];
$c_nome = $_POST['nome'];
$c_data_nasc = $_POST['data_nasc'];
$c_sexo = $_POST['sexo'];
$c_sql = "update dependentes set nome='$c_nome', data_nasc='$c_data_nasc', sexo='$c_sexo' where id=$c_id";
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