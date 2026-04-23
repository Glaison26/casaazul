<?php
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";
?>

<!-- Página para exibir as ações participadas por cada pessoa física -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ações Participadas</title>
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
                    <h5>Ações Participadas por Pessoa Física<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            <!-- botão para voltar para a lista de pessoas físicas -->
            <a class="btn btn-secondary btn-sm" href="/casaazul/pessoas/pessoas_lista.php"><span class="glyphicon glyphicon-arrow-left"></span> Voltar para Lista de Pessoas Físicas</a>
            <hr>
            <?php
            // rotina para listar as ações participadas por cada pessoa física
            // sql para buscar as ações participadas por cada pessoa física na tabela participantes_atividade ligado a tabela cadastro de pessoas
            $c_sql = "SELECT acoes.`data`, acoes.descricao, atividades.descricao AS acao, acoes.participantes, acoes.observacao FROM participantes_acoes
JOIN acoes ON participantes_acoes.id_acao = acoes.id
JOIN atividades ON acoes.id_tipo_atividade = atividades.id
where participantes_acoes.id_participante = " . $_GET['id'];
            $result = $conection->query($c_sql);
            // sql para buscar o nome da pessoa física
            $c_sql_pessoa = "SELECT nome FROM cadastro WHERE id = " . $_GET['id'];
            $result_pessoa = $conection->query($c_sql_pessoa);
            if ($result_pessoa->num_rows > 0) {
                $row_pessoa = $result_pessoa->fetch_assoc();
                echo "<h3>Ações com participação de: " . $row_pessoa['nome'] . "</h3>";
            }

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
                            
                            <td>{$row['acao']}</td>
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