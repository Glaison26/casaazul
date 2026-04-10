<?php
////////////////////////////////////////////////////////////
// rotina principal da agenda médica
///////////////////////////////////////////////////////////
// 
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";

date_default_timezone_set('America/Sao_Paulo');
// funcão para retornar o dia da semana por extenso
function diaSemana($data)
{
    $diasemana = date("w", strtotime($data));
    switch ($diasemana) {
        case 0:
            return "Domingo";
            break;
        case 1:
            return "Segunda-feira";
            break;
        case 2:
            return "Terça-feira";
            break;
        case 3:
            return "Quarta-feira";
            break;
        case 4:
            return "Quinta-feira";
            break;
        case 5:
            return "Sexta-feira";
            break;
        case 6:
            return "Sábado";
            break;
    }
}

$c_mostradata = date("Y-m-d");
if ((isset($_POST["btnagenda"])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {  // botão para executar sql de pesquisa na agenda
    // rotina para pesquisa na tabela de atividades com base na data selecionada
    $d_data = $_POST["data1"];
    $c_dia_semana = diaSemana($d_data);
    $c_sql2 = "select  data_inicio, data_final,num_vagas, carga_horaria, instrutores.NOME AS instrutor, cursos.DESCRICAO AS atividade,
    observacao 
    from atividades_realizadas 
    JOIN cursos ON atividades_realizadas.id_curso=cursos.ID
    JOIN instrutores ON atividades_realizadas.id_instrutor=instrutores.ID
    where data_inicio = '$d_data' order by data_inicio desc";
    //echo $c_sql2;
    $result2 = $conection->query($c_sql2);
}
?>


<!-- front end da agenda -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/smedweb/css/basico.css">
    <title>Casa Azul - Sistema de Gestão </title>

</head>

<body>
    <!-- script para chamar janela modal de inclusão -->
    <script type="text/javascript">
        // Função javascript e ajax para inclusão dos dados da janela modal de inclusão da agenda de atividades
        $(document).ready(function() {
            $('#frmadd').on('submit', function(e) {
                e.preventDefault();
                
                var atividade = $('#up_atividadeField').val();
                var data_inicio = $('#up_data_inicioField').val();
                var data_final = $('#up_data_finalField').val();
                var num_vagas = $('#up_num_vagasField').val();
                var carga_horaria = $('#up_carga_horariaField').val();
                var instrutor = $('#up_instrutorField').val();
                var observacao = $('#up_observacaoField').val();

                $.ajax({
                    type: 'POST',
                    url: 'atividades_incluir.php',
                    data: {
                        id: id,
                        atividade: atividade,
                        data_inicio: data_inicio,
                        data_final: data_final,
                        num_vagas: num_vagas,
                        carga_horaria: carga_horaria,
                        instrutor: instrutor,
                        observacao: observacao
                    },
                    success: function(response) {
                        // Aqui você pode tratar a resposta do servidor, se necessário
                        alert('Atividade incluída com sucesso!');
                        location.reload(); // Recarrega a página para mostrar a nova atividade na lista
                    },
                    error: function(xhr, status, error) {
                        // Aqui você pode tratar erros de requisição, se necessário
                        alert('Erro ao incluir atividade: ' + error);
                    }
                });
            });
        });
    </script>
    <!-- script jquery para tabela da agenda -->
    <script>
        $(document).ready(function() {
            $('.tabagenda').DataTable({
                // 
                "iDisplayLength": 5,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                }, {
                    'aTargets': [0],
                    "visible": true
                }],
                "oLanguage": {
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sInfoFiltered": " - filtrado de _MAX_ registros",
                    "oPaginate": {
                        "spagingType": "full_number",
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",

                        "sLast": "Último"
                    },
                    "sSearch": "Pesquisar",
                    "sLengthMenu": 'Mostrar <select>' +
                        '<option value="5">5</option>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">Todos</option>' +
                        '</select> Registros'

                }

            });

        });
    </script>



    <?php
    if (isset($d_data)) {
        $c_mostradata = date("d-m-Y", strtotime(str_replace('/', '-', $d_data)));
    }
    ?>

    <div class="container-fluid">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Lista de Atividade agendadas <?php echo $_SESSION['meu_sql']; ?><h5>
            </div>
        </div>
        <!-- Formulário com as datas -->
        <form method="post">
            <div class="row mb-3">
                <label class="col-md-1 form-label">Pesquisa Data</label>
                <div class="col-sm-2">
                    <input type="Date" required maxlength="10" class="form-control" name="data1" id="data1" value=<?php echo $c_mostradata; ?> onkeypress="mascaraData(this)">
                </div>
                <!-- botão para abrir modal de inclusão de atividades -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editmodal"><span class="glyphicon glyphicon-plus"></span> Nova Atividade</button>&nbsp;
                <button type="submit" return false name='btnagenda' id='btnagenda' class="btn btn-primary"><img src="\casaazul\images\buscar.png" alt="" width="20" height="20"></span> Consultar</button>&nbsp;
                <a class='btn btn-info' title="Voltar ao menu" href='/casaazaul/menu.php'> <img src="\casaazul\images\voltar.png" alt="" width="20" height="20"> Voltar</a>
            </div>
        </form>

        <hr>

        <!-- aba da agenda-->


        <div class="panel panel-info">
            <div class="panel-heading text-left">
                <?php
                if (isset($d_data)) {

                    echo "
                            <h4>Agenda de  $c_dia_semana  $c_mostradata <h4>
                            ";
                }
                ?>
            </div>
        </div>

        <hr>
        <!-- montagem da tabela de agenda -->
        <table class="table display table-striped table-bordered tabagenda">
            <thead class="thead">
                <tr class="info">
                    <th scope="col" style="width: 3px;"></th>
                    <th scope="col">Atividade</th>
                    <th scope="col">Data Término</th>
                    <th scope="col">No. de Vagas</th>
                    <th scope="col">Carga Horária</th>
                    <th scope="col">Instrutor</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Opções</th>

                </tr>
            </thead>
            <tbody>
                <?php

                // loop para dados da agenda
                if (!empty($c_sql2)) {

                    while ($c_linha2 = $result2->fetch_assoc()) {


                        echo "
                                    <tr>
                                    <td  style='width: 3px;' class='some'>$c_linha2[id]</td>
                                    <td>$c_linha2[horario]</td>
                                    <td $c_cor_ativo style='text-align: center;' class='h4'>$c_linha2[status]</td>
                                    <td>$c_linha2[nome]</td>
                                    <td>$c_linha2[matricula]</td>
                                    <td>$c_linha2[convenio]</td>
                                    <td>$c_linha2[telefone]</td>
                                    <td>$c_linha2[email]</td>
                                    <td>$c_linha2[observacao]</td>
                                    <td $c_cor_novo style='text-align: center;' class='h4'>$c_linha2[paciente_novo]</td>
                                    <td $c_cor_compareceu style='text-align: center;' class='h4'>$c_linha2[paciente_compareceu]</td>
                                    <td $c_cor_atendido style='text-align: center;' class='h4'>$c_linha2[paciente_atendido]</td>
                                    <td>
                                   
                                   <button type='button'  class='btn btn-light btn-sm editbtn' data-toggle='modal' data-target='#editmodal'  title='Editar'><img src='\smedweb\images\calendario.png' alt='' width='15' height='15'> Marcação</button>
                                   <button type='button' name='btnparticipantes' onclick='incluir($c_linha2[id],\"$c_linha2[nome]\",\"$c_linha2[paciente_novo]\")' id='btnincluir' class='btn btn-light'><span class='glyphicon glyphicon-save-file'></span> Incluir</button>
                                   
                                   </td>
                                   
                                    </tr>
                                    ";
                    }
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- janela Modal para nova Atividade -->

    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agenda de Atividades - Inclusão</h4>
                </div>
                <div class="modal-body">
                    <div class='alert alert-warning' role='alert'>
                        <h5>Campos com (*) são obrigatórios</h5>
                    </div>
                    <form id="frmadd" method="POST" action="">
                        
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
                                <select  class="form-control form-control-lg" name="up_instrutorField" id="up_instrutorField" required>
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
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>



</html>

<style>
    .some {
        visibility: collapse;
    }
</style>