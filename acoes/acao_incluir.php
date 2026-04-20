<?php
session_start();
include("../conexao.php");
include("../links.php");
// configuro fuso horário
date_default_timezone_set('America/Sao_Paulo');
// post das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // grava dados da nova atividade
    $c_acao = $_POST['descricao'];
    $c_data = $_POST['data'];
    $c_participantes = $_POST['participantes'];
    $c_tipo = $_POST['tipo'];
    $c_observacao = $_POST['observacao'];
    
    $c_sql = "INSERT INTO acoes (descricao, data, participantes, id_tipo_atividade, observacao) 
    VALUES ('$c_acao', '$c_data', '$c_participantes', '$c_tipo', '$c_observacao')";
    $result = $conection->query($c_sql);

    header('location: /casaazul/acoes/acoes_lista.php');
}

?>

<!-- html para cadastro de nova ação -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Ação</title>
    <link rel="stylesheet" href="/smedweb/css/basico.css">
</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Inclusão de Nova Ação<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            <form action="" method="post">
                <div class="row mb-3">
                    <label for="descricao" class="col-sm-3 col-form-label">Descrição:</label><br>
                    <div class="col-sm-6">
                        <input type="text" id="descricao" class="form-control" name="descricao" required><br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="data" class="col-sm-3 col-form-label">Data:</label><br>
                    <div class="col-sm-3">
                        <input type="date" id="data" name="data" class="form-control" required><br>
                    </div>
                    <label for="participantes" class="col-sm-1 col-form-label"> No. de Participantes:</label><br>
                    <div class="col-sm-2">
                        <input type="number" id="participantes" class="form-control" name="participantes" min="0"><br>
                    </div>
                </div>

                <div class="row mb-3">

                    <label for="tipo" class="col-sm-3 col-form-label">Tipo de Atividade:</label><br>
                    <div class="col-sm-6">
                        <select id="tipo" class="form-control form-control-lg" name="tipo">
                            <?php
                            // Preencher o dropdown com os tipos de atividades disponíveis
                            $sql = "SELECT id, descricao FROM atividades";
                            $result = $conection->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                            ?>
                        </select><br>
                    </div>
                </div>
                <!-- input com campo observação para a ação -->
                <div class="row mb-3">

                    <label for="observacao" class="col-sm-3 col-form-label">Observação:</label><br>
                    <div class="col-sm-6">
                        <textarea id="observacao" class="form-control" name="observacao" rows="4" cols="50"></textarea><br>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="offset-sm-0 col-sm-3">
                        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                        <a class='btn btn-danger' href='/casaazul/acoes/acoes_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>