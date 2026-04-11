<?php
session_start();
include("../conexao.php");
include("../links.php");
// configuro fuso horário
date_default_timezone_set('America/Sao_Paulo');
// post das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // grava dados da nova atividade
    $c_atividade = $_POST['up_atividadeField'];
    $c_data_inicio = $_POST['up_data_inicioField'];
    $c_data_final = $_POST['up_data_finalField'];
    $c_num_vagas = $_POST['up_num_vagasField'];
    $c_carga_horaria = $_POST['up_carga_horariaField'];
    $c_instrutor = $_POST['up_instrutorField'];
    $c_observacao = $_POST['up_observacaoField'];
    $c_sql = "INSERT INTO atividades_realizadas (id_curso, data_inicio, data_final, num_vagas, carga_horaria,
    id_instrutor, observacao) VALUES ('$c_atividade', '$c_data_inicio', '$c_data_final', '$c_num_vagas',
     '$c_carga_horaria', '$c_instrutor', '$c_observacao')";
    $result = $conection->query($c_sql);

    header('location: /casaazul/atividades/atividades_lista.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/casaazul/css/basico.css">
    <title>Inclusão de Atividade</title>

</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Inclusão de Nova Atividade<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">

            <form method="POST" action="">
                <hr>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Atividade (*)</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-lg" name="up_atividadeField" id="up_atividadeField" required>
                            <option value="">Selecione a Atividade</option>
                            <?php
                            $c_sql_atividade = "SELECT ID, DESCRICAO FROM cursos ORDER BY DESCRICAO";
                            $result_atividade = $conection->query($c_sql_atividade);
                            while ($c_linha_atividade = $result_atividade->fetch_assoc()) {
                                echo "<option value='$c_linha_atividade[ID]'>$c_linha_atividade[DESCRICAO]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Data Início (*)</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="up_data_inicioField" id="up_data_inicioField" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Data Final (*)</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="up_data_finalField" id="up_data_finalField" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Número de Vagas (*)</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="up_num_vagasField" id="up_num_vagasField" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Carga Horária (*)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="up_carga_horariaField" id="up_carga_horariaField" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Instrutor (*)</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-lg" name="up_instrutorField" id="up_instrutorField" required>
                            <option value="">Selecione o Instrutor</option>
                            <?php
                            $c_sql_instrutor = "SELECT ID, NOME FROM instrutores ORDER BY NOME";
                            $result_instrutor = $conection->query($c_sql_instrutor);
                            while ($c_linha_instrutor = $result_instrutor->fetch_assoc()) {
                                echo "<option value='$c_linha_instrutor[ID]'>$c_linha_instrutor[NOME]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Observação</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="up_observacaoField" id="up_observacaoField" rows="6"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="offset-sm-0 col-sm-3">
                        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                        <a class='btn btn-danger' href='/casaazul/atividades/atividades_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                    </div>
                </div>

            </form>
        </div>
    </div>
</body>

</html>