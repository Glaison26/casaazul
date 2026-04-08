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
    <title>Casa Azul - Sistema de Gestão</title>

</head>

<body>
    <!-- função para chamar marcação -->

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
                <h5>Lista de Atividade agendadas<h5>
            </div>
        </div>
        <!-- Formulário com as datas -->
        <form method="post">
            <div class="row mb-3">
                <label class="col-md-1 form-label">Pesquisa Data</label>
                <div class="col-sm-2">
                    <input type="Date" required maxlength="10" class="form-control" name="data1" id="data1" value=<?php echo $c_mostradata; ?> onkeypress="mascaraData(this)">
                </div>
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
                                   
                                   <button type='button'  class='btn btn-light btn-sm editbtn' data-toggle='modal' data-target='#editmodal'  title='Marcação de consulta' onclick='marcacao($c_linha2[id])'><img src='\smedweb\images\calendario.png' alt='' width='15' height='15'> Marcação</button>
                                   <button type='button' name='btnincluir' onclick='incluir($c_linha2[id],\"$c_linha2[nome]\",\"$c_linha2[paciente_novo]\")' id='btnincluir' class='btn btn-light'><span class='glyphicon glyphicon-save-file'></span> Incluir</button>
                                   <button type='button' name='btncorta' onclick='cortar($c_linha2[id],\"$c_linha2[nome]\")' id='btncorta' class='btn btn-light'><img src='\smedweb\images\corta.png' alt='' width='15' height='15'> Cortar</button>
                                   <button type='button' name='btncola' onclick='colar($c_linha2[id],\"$c_linha2[nome]\", \"$c_linha2[status]\")' id='btncola' class='btn btn-light'><img src='\smedweb\images\copiar.png' alt='' width='15' height='15'> Colar</button>
                                   <button type='button' name='btnemail' onclick='email($c_linha2[id],\"$c_linha2[nome]\")' id='btnemail' class='btn btn-light'><img src='\smedweb\images\o-email.png' alt='' width='15' height='15'> e-mail</button>
                                   <a class='btn btn-light btn-sm' title='Desativar / Ativar Horário' href='javascript:func()'onclick='status($c_linha2[id],\"$c_linha2[nome]\")'>
                                   <img src='\smedweb\images\certo.png' alt='' width='15' height='15'> Ativar/Desativar</a><a class='btn btn-light btn-sm' title='Desmarcar consulta' href='javascript:func()'onclick='desmarca($c_linha2[id], \"$c_linha2[nome]\")'>
                                   <img src='\smedweb\images\borracha.png' alt='' width='15' height='15'> Desmarcar</a>
                                   <a class='btn btn-light btn-sm' name='btnlog' class='btn btn-light btn-sm' title='Log da Agenda'
                                   href='/smedweb/agenda/log_agenda.php?id=$c_linha2[id]'><img src='\smedweb\images\log.png'alt='' width='15' height='15'> Log</button>
                                   </td>
                                   
                                    </tr>
                                    ";
                    }
                }
                ?>
            </tbody>
        </table>

    </div>




    <!-- janela Modal para marcação de consulta -->

    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Agênda Médica - Marcação</h4>
                </div>
                <div class="modal-body">
                    <div class='alert alert-warning' role='alert'>
                        <h5>Campos com (*) são obrigatórios</h5>
                    </div>
                    <form id="frmadd" method="POST" action="">
                        <input type="hidden" id="up_idField" name="up_idField">
                        <input type="hidden" id="up_novo" name="up_novo">
                        <input type="hidden" id="up_atendido" name="up_atendido">
                        <input type="hidden" id="up_compareceu" name="up_compareceu">
                        <input type="hidden" id="up_vazio" name="up_vazio">
                        <div class="mb-3 row">
                            <label for="up_horarioField" class="col-md-3 form-label">Horário</label>
                            <div class="col-md-4">
                                <input type="time" readonly class="form-control" id="up_horarioField" name="up_horarioField">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="up_nomeField" class="col-md-3 form-label">Nome (*) </label>
                            <div class="col-md-9">
                                <input type="text" required class="form-control" id="up_nomeField" name="up_nomeField">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="up_matriculaField" class="col-md-3 form-label">Matricula</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="up_matriculaField" name="up_matriculaField">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Convênio </label>
                            <div class="col-sm-6">
                                <select required class="form-control form-control-lg" id="up_convenioField" name="up_convenioField">
                                    <?php
                                    $c_sql3 = "SELECT convenios.id, convenios.nome FROM convenios where id <>3 ORDER BY convenios.nome";
                                    $result3 = $conection->query($c_sql3);
                                    // insiro os registro do banco de dados na tabela 
                                    while ($c_linha3 = $result3->fetch_assoc()) {

                                        echo "
                                        <option $c_op>$c_linha3[nome]</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Telefone </label>
                            <div class="col-sm-4">
                                <input type="tel" required maxlength="25" onkeyup="handlePhone(event)" class=" form-control" id="up_telefoneField" name="up_telefoneField">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">E-mail</label>
                            <div class="col-sm-9">
                                <input type="text" required maxlength="225" class="form-control" id="up_emailField" name="up_emailField">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Observações</label>
                            <div class="col-sm-9">
                                <input type="text" maxlength="100" class="form-control" id="up_obsField" name="up_obsField">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Situação</label>

                        </div>
                        <div class="row mb-3">

                            <!-- checkbox para situação de paciente novo -->
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" id="chk_novopaciente">
                                    </div>
                                    <label class="form-check-label" for="chk_novopaciente">
                                        Paciente Novo
                                    </label>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="row mb-3">
                            <!-- checkbox para situação de paciente comparecimento -->
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" name="chk_compareceu" id="chk_compareceu">
                                    </div>
                                    <label class="form-check-label" for="chk_compareceu">
                                        Paciente Compareceu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <!-- checkbox para situação de paciente foi atendido -->
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" id="chk_atendido">
                                    </div>
                                    <label class="form-check-label" for="chk_atendido">
                                        Paciente foi atendido
                                    </label>
                                </div>
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