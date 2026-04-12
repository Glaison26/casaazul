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
    $c_sql2 = "select atividades_realizadas.id,  data_inicio, data_final,num_vagas, carga_horaria, instrutores.NOME AS instrutor,
     cursos.DESCRICAO AS atividade,
    atividades_realizadas.observacao 
    from atividades_realizadas 
    JOIN cursos ON atividades_realizadas.id_curso=cursos.ID
    JOIN instrutores ON atividades_realizadas.id_instrutor=instrutores.ID
    where data_inicio >= '$d_data' and data_final <= '$d_data2' or data_inicio <= '$d_data2' and data_final >= '$d_data' order by data_inicio desc";
    //echo $c_sql2;
    $result2 = $conection->query($c_sql2);
}
?>


<!-- front end dos participantes de atividades -->
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
            $('.participantes').DataTable({
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

    <!-- Função javascript e ajax para inclusão dos dados -->
    <script>
        $(document).ready(function() {
            $('#frmadd').submit(function(e) {
                e.preventDefault();
                var id_atividade = <?php echo $_GET['id']; ?>;
                var id_participante = $('#add_participanteField').val();
                var observacao = $('#add_observacaoField').val();

                $.ajax({
                    type: 'POST',
                    url: 'atividades_participantes_add.php',
                    data: {
                        id_atividade: id_atividade,
                        id_participante: id_participante,
                        observacao: observacao
                    },
                    success: function(response) {
                        // Lógica para lidar com a resposta do servidor, se necessário
                        console.log(response);
                        // Fechar o modal após a inclusão
                        $('#novoModal').modal('hide');
                        // Recarregar a página para atualizar a lista de participantes
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Lógica para lidar com erros, se necessário
                        console.error(error);
                    }
                });
            });
        });
    </script>


    <div class="container-fluid">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Lista de Participantes<h5>
            </div>
        </div>


        <!-- botão para abrir modal de inclusão de participante -->
        <button type="button" title="Inclusão de Novo Participante" class="btn btn-success btn-sm" data-toggle="modal" data-target="#novoModal"><span class="glyphicon glyphicon-plus"></span>
            Novo Participante
        </button>
        <a class="btn btn-info btn-sm" type="button" title="Voltar ao menu" href='/casaazul/atividades/atividades_lista.php'> <img src="\casaazul\images\voltar.png" alt="" width="20" height="20"> Voltar</a>

        <hr>
        <!-- montagem da tabela de agenda -->
        <table class="table display table-striped table-bordered participantes">
            <thead class="thead">
                <tr class="info">
                    <th scope="col">Participante</th>
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
                                    <td>$c_linha2[participante]</td>
                                    <td>$c_linha2[observacao]</td>
                                    <td>
                                    <a class='btn btn-secondary btn-sm' href='/casaazul/atividades/atividades_editar.php?id=$c_linha2[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                                    </td>
                                   
                                    </tr>
                                    ";
                    }
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- janela Modal para inclusão de registro de participante -->
    <div class="modal fade" class="modal-dialog modal-lg" id="novoModal" name="novoModal" tabindex="-1" role="dialog" aria-labelledby="novoModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Inclusão de novo participante</h4>
                </div>
                <div class="modal-body">
                    <div class='alert alert-warning' role='alert'>
                        <h5>Campos com (*) são obrigatórios</h5>
                    </div>
                    <form id="frmadd" action="">
                        <!-- campo de participantes tira da tabela cadastro em combobox -->
                        <div class="mb-3 row">
                            <label for="add_participanteField" class="col-md-3 form-label">Participante (*)</label>
                            <div class="col-md-9">
                                <select class="form-control form-control-lg" name="add_participanteField" id="add_participanteField" required>
                                    <option value="">Selecione o Participante</option>
                                    <?php
                                    $c_sql_participante = "SELECT ID, NOME FROM cadastro ORDER BY NOME";
                                    $result_participante = $conection->query($c_sql_participante);
                                    while ($c_linha_participante = $result_participante->fetch_assoc()) {
                                        echo "<option value='$c_linha_participante[ID]'>$c_linha_participante[NOME]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="add_observacaoField" class="col-md-3 form-label">Observação</label>
                            <div class="col-md-9">
                                <textarea type="text" class="form-control" id="add_observacaoField" name="add_observacaoField" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Fechar</button>

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