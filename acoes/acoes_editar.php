<?php
include("../conexao.php");
include("../links.php");
// configuro fuso horário
date_default_timezone_set('America/Sao_Paulo');
// post das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // grava dados da nova atividade
    $id = $_GET['id'];
    $c_acao = $_POST['descricao'];
    $c_data = $_POST['data'];
    $c_participantes = $_POST['participantes'];
    $c_tipo = $_POST['tipo'];
    $c_observacao = $_POST['observacao'];
    
    $c_sql = "UPDATE acoes SET descricao='$c_acao', data='$c_data', participantes='$c_participantes', id_tipo_atividade='$c_tipo', observacao='$c_observacao' WHERE id=$id";
    $result = $conection->query($c_sql);

    header('location: /casaazul/acoes/acoes_lista.php');
}
?>
<!-- html para editar registro de ação -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ação</title>
    <link rel="stylesheet" href="/casaazul/css/basico.css">
</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Edição de Ação<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            <!-- form para editar os dados da ação -->
            <form action="" method="post">
                <?php
                // rotina para buscar os dados da ação selecionada e preencher o formulário
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $c_sql = "SELECT * FROM acoes WHERE id = $id";
                    $result = $conection->query($c_sql);
                    if ($result->num_rows > 0) {
                        $c_linha = $result->fetch_assoc();
                        // preenche os campos do formulário com os dados da ação
                        echo "
                            <div class='row mb-3'>
                                <label for='descricao' class='col-sm-3 col-form-label'>Descrição:</label><br>
                                <div class='col-sm-6'>
                                    <input type='text' id='descricao' class='form-control' name='descricao' value='$c_linha[descricao]' required><br>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='data' class='col-sm-3 col-form-label'>Data:</label><br>
                                <div class='col-sm-3'>
                                    <input type='date' id='data' name='data' class='form-control' value='" . date("Y-m-d", strtotime($c_linha['data'])) . "' required><br>
                                </div>
                                <label for='participantes' class='col-sm-1 col-form-label'> No. de Participantes:</label><br>
                                <div class='col-sm-2'>
                                    <input type='number' id='participantes' class='form-control' name='participantes' min='0' value='$c_linha[participantes]'><br>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='tipo' class='col-sm-3 col-form-label'>Tipo de Atividade:</label><br>
                                <div class='col-sm-6'>
                                    <select id='tipo' class='form-control form-control-lg' name='tipo'>
                                        <option value=''>Selecione o Tipo de Atividade</option>";
                        // Preencher o dropdown com os tipos de atividades disponíveis
                        $c_sql_tipo = "SELECT ID, DESCRICAO FROM atividades ORDER BY DESCRICAO";
                        $result_tipo = $conection->query($c_sql_tipo);
                        while ($c_linha_tipo = $result_tipo->fetch_assoc()) {
                            $selected = ($c_linha['id_tipo_atividade'] == $c_linha_tipo['ID']) ? 'selected' : '';
                            echo "<option value='$c_linha_tipo[ID]' $selected>$c_linha_tipo[DESCRICAO]</option>";
                        }
                        echo "</select>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <label for='observacao' class='col-sm-3 col-form-label'>Observação:</label><br>
                                <div class='col-sm-6'>
                                    <textarea id='observacao' class='form-control' name='observacao' rows='4' cols='50'>$c_linha[observacao]</textarea><br>
                                </div>  
                            </div>  
                            ";
                    }
                }
                ?>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-6">

                        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                        <a class='btn btn-danger' href='/casaazul/acoes/acoes_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>
                    </div>
                </div>