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
    $d_data2 = $_POST["data2"];
    $c_dia_semana = diaSemana($d_data);
    $c_dia_semana2 = diaSemana($d_data2);
    $c_sql2 = "select acoes.id,  DATA, acoes.descricao, participantes, atividades.descricao AS tipo
            from acoes 
            JOIN atividades ON acoes.id=atividades.id
    where data >= '$d_data' and data <= '$d_data2' order by data desc";
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


    <!-- script jquery para tabela da agenda -->
    <script>
        $(document).ready(function() {
            $('.tabacoes').DataTable({
                // 
                "iDisplayLength": 5,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [5]
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

    <script>
        function confirmacao(id) {
            var resposta = confirm("Deseja realmente excluir este registro?");
            if (resposta == true) {
                window.location.href = "acoes_excluir.php?id=" + id;
            }
        }
    </script>

    <!-- script para abrir modal de inclusão de participante -->




    <?php
    if (isset($d_data)) {
        $c_mostradata = date("d-m-Y", strtotime(str_replace('/', '-', $d_data)));
        $c_mostradata2 = date("d-m-Y", strtotime(str_replace('/', '-', $d_data2)));
    }
    ?>

    <div class="container-fluid">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Lista de Açoes agendadas <h5>
            </div>
        </div>
        <!-- Formulário com as datas -->
        <form method="post">
            <div class="row mb-2">
                <label class="col-md-2 form-label">Pesquisa Data</label>
                <div class="col-sm-2">
                    <input type="Date" required maxlength="10" class="form-control" name="data1" id="data1" value=<?php echo $c_mostradata; ?>>
                </div>
                <p class="col-md-0 form-label">a</p>
                <div class="col-sm-2">
                    <input type="date" required maxlength="10" class="form-control" name="data2" id="data2" value=<?php echo $c_mostradata; ?>>
                </div>
                
                <a class="btn btn-success btn-sm" href="/casaazul/atividades/atividades_incluir.php"><span class="glyphicon glyphicon-plus"></span> Nova Ação</a>&nbsp;&nbsp;
                <button type="submit" return false name='btnagenda' id='btnagenda' class="btn btn-primary "><img src="\casaazul\images\buscar.png" alt="" width="20" height="20"></span> Consultar</button>&nbsp;&nbsp;
                <a class='btn btn-info' title="Voltar ao menu" href='/casaazul/menu.php'> <img src="\casaazul\images\voltar.png" alt="" width="20" height="20"> Voltar</a>
            </div>
        </form>

        <hr>

        <!-- aba da agenda-->
        <div class="panel panel-info">
            <div class="panel-heading text-left">
                <?php
                if (isset($d_data)) {

                    echo "
                            <h4>Agenda de Ações do dia $c_mostradata $c_dia_semana ao dia $c_mostradata2 " . diaSemana($_POST['data2']) . "</h4>
                            ";
                }
                ?>
            </div>
        </div>

        <hr>
        <!-- montagem da tabela de agenda -->
        <table class="table display table-striped table-bordered tabacoes">
            <thead class="thead">
                <tr class="info">

                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">Ação</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">No. de Participantes</th>
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
                                    
                                    <td>$c_linha2[id]</td>
                                    <td>" . date("d-m-Y", strtotime($c_linha2['data_inicio'])) . "</td>
                                    <td>$c_linha2[atividade]</td>
                                    <td>" . date("d-m-Y", strtotime($c_linha2['data_final'])) . "</td>
                                    <td>$c_linha2[num_vagas]</td>
                                    <td>$c_linha2[carga_horaria]</td>
                                    <td>$c_linha2[instrutor]</td>
                                   
                                    
                                    <td>
                                    <a class='btn btn-info btn-sm' href='/casaazul/atividades/atividades_participantes.php?id=$c_linha2[id]'><span class='glyphicon glyphicon-user'></span> Participantes</a>
                                    <a class='btn btn-secondary btn-sm' href='/casaazul/atividades/atividades_editar.php?id=$c_linha2[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                                    <a class='btn btn-danger btn-sm' href='javascript:func()'onclick='confirmacao($c_linha2[id])'><span class='glyphicon glyphicon-trash'></span> Excluir</a>

                                   
                                   </td>
                                   
                                    </tr>
                                    ";
                    }
                }
                ?>
            </tbody>
        </table>

    </div>

</body>



</html>

<style>
    .some {
        visibility: collapse;
    }
</style>