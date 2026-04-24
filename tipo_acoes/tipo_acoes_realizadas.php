<?php
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";
?>

<!-- Página para exibir as atividades realizadas por cada pessoa física -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividades</title>
    <script>
        $(document).ready(function() {
            $('.tablista').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [0, 1, 2, 3, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [3]
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

</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Atividades por Pessoa Física<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            <!-- botão para voltar para a lista de pessoas físicas -->
            <a class="btn btn-secondary btn-sm" href="/casaazul/tipo_acoes/tipo_acoes_lista.php"><span class="glyphicon glyphicon-arrow-left"></span> Voltar para Lista de tipos de ações</a>
            <hr>
            <?php
            // rotina para listar as atividades realizadas por cada pessoa física
            // sql para buscar as ações realizadas por tipo de ação
            $c_sql = "SELECT acoes.* FROM acoes
            WHERE acoes.id_tipo_atividade = " . $_GET['id'] . "
            ORDER BY  acoes.data";

            $result = $conection->query($c_sql);
            // sql para buscar o nome do tipo de ação
            $c_sql_tipo = "SELECT descricao FROM atividades WHERE id = " . $_GET['id'];
            $result_tipo = $conection->query($c_sql_tipo);
            $c_linha_tipo = $result_tipo->fetch_assoc();
            // exibir o nome do tipo de ação            
            echo "<h3>Ação realizada para o tipo de ação: " . $c_linha_tipo['descricao'] . "</h3>";
            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered tablista'>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Ação</th>
                                <th>Número de Participantes</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . date("d/m/Y", strtotime($row['data'])) . "</td>
                            
                            <td>{$row['descricao']}</td>
                            <td>{$row['participantes']}</td>
                            <td>{$row['observacao']}</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Nenhuma ação encontrada para esta pessoa física.</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>