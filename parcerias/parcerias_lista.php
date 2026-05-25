<?php
include("../conexao.php");
include("../links.php");
//
$c_sql = "SELECT * FROM parcerias ORDER BY identificacao";

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Parcerias</title>
    <script>
        $(document).ready(function() {
            $('.tabparcerias').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [6]
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
    <!-- script para confirmar a exclusão do registro -->
    <script>
        function confirmacao(id) {
            if (confirm("Deseja realmente excluir este registro?")) {
                window.location.href = "parcerias_excluir.php?id=" + id;
            }
        }
    </script>

</head>

<body>
    <div class="container-fluid">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Lista de Parcerias<h5>
            </div>
        </div>
        <br>
        <a class="btn btn-success btn-sm" href="/casaazul/parcerias/parcerias_novo.php"><span class="glyphicon glyphicon-plus"></span> Incluir</a>
        <a class="btn btn-secondary btn-sm" href="/casaazul/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped tabparcerias">
                <thead class="thead">
                    <tr>
                        <th>Identificação</th>
                        <th>Número</th>
                        <th>Vigência Inicio</th>
                        <th>Vigência Fim</th>
                        <th>Prorrogação Inicio</th>
                        <th>Prorrogação Fim</th>

                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conection->query($c_sql);
                    // verifico se a query foi correto
                    if (!$result) {
                        die("Erro ao Executar Sql!!" . $conection->connect_error);
                    }

                    // insiro os registro do banco de dados na tabela 
                    while ($c_linha = $result->fetch_assoc()) {
                        // verifico se as datas de prorrogação estão em branco, se sim, atribuo a string "Sem Prorrogação" para exibir na tabela

                        // substituo o formato da data para o formato brasileiro dd/mm/yyyy
                       
                        if (empty($c_linha['prorrogacao_inicio'])) {
                            $c_data_prorrogacao_inicio = "Sem Prorrogação";
                        } else
                            $c_data_prorrogacao_inicio = date("d-m-Y", strtotime(str_replace('/', '-', $c_linha['prorrogacao_inicio'])));
                        if (empty($c_linha['prorrogacao_fim'])) {
                            $c_data_prorrogacao_fim  = "Sem Prorrogação";
                        }else
                        $c_data_prorrogacao_fim = date("d-m-Y", strtotime(str_replace('/', '-', $c_linha['prorrogacao_fim'])));

                        echo "
                    <tr>
                       
                        <td>$c_linha[identificacao]</td>
                        <td>$c_linha[numero]</td>
                        
                        <td>" . date("d-m-Y", strtotime(str_replace('/', '-', $c_linha['vigencia_inicio']))) . "</td>
                        <td>" . date("d-m-Y", strtotime(str_replace('/', '-', $c_linha['vigencia_fim']))) . "</td>
                        <td>" .  $c_data_prorrogacao_inicio . "</td>
                        <td>" . $c_data_prorrogacao_fim . "</td>
                        <td>
                            
                            <a href='/casaazul/parcerias/parcerias_editar.php?id=$c_linha[id]' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                            <button onclick='confirmacao($c_linha[id])' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span> Excluir</button>
                        </td>

                    </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>