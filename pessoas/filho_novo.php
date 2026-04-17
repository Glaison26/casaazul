<?php
// rotina para incluir filho na tabela de pessoas vinda da janela modal de filhos
include_once("../conexao.php");
// rotina de inclusão
$c_id_pessoa = $_POST['c_id_pessoa'];
$c_nome = rtrim($_POST['c_nome']);
$c_data_nasc = $_POST['c_data_nasc'];
$c_sexo = $_POST['c_sexo'];
$c_sql = "insert into dependentes (id_pessoa,nome,data_nasc,sexo) value ('$c_id_pessoa', '$c_nome', '$c_data_nasc', '$c_sexo')";
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

