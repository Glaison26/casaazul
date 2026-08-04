<?php
include("../conexao.php");
include("../links.php");
//
$c_sql = "SELECT * FROM instrutores ORDER BY nome";

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Instrutores</title>
    <script>
        $(document).ready(function() {
            $('.tabpessoas').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [0, 'asc'],
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
                window.location.href = "instrutores_excluir.php?id=" + id;
            }
        }
    </script>

</head>

<body>
    <div class="container-fluid">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Lista de Colaboradores<h5>
            </div>
        </div>
        <br>
        <a class="btn btn-success btn-sm" href="/casaazul/instrutores/instrutores_novo.php"><span class="glyphicon glyphicon-plus"></span> Incluir</a>
        <a class="btn btn-secondary btn-sm" href="/casaazul/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped  tabpessoas">
                <thead class="thead">
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>CEP</th>
                        <th>Telefone 1</th>
                        <th>Telefone 2</th>
                       
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
                        if ($c_linha['sexo'] == 'M')
                            $c_sexo = 'Masculino';
                        else
                            $c_sexo = 'Feminino';
                        $qtd_atividades = 0;
                        $c_sql_atividades = "SELECT COUNT(*) AS qtd_atividades FROM atividades_realizadas WHERE id_instrutor = $c_linha[id]";
                        $result_atividades = $conection->query($c_sql_atividades);
                        $row_atividades = $result_atividades->fetch_assoc();
                        $qtd_atividades = $row_atividades['qtd_atividades'];
                        echo "
                    <tr>
                        <!-- registro do nome com link para visualizar o registro completo -->
                        <td><a href='/casaazul/instrutores/instrutores_visualizar.php?id=$c_linha[id]'>$c_linha[nome]</a></td>
                        <td>$c_linha[endereco]</td>
                        <td>$c_linha[bairro]</td>
                        <td>$c_linha[cep]</td>
                        <td>$c_linha[fone1]</td>
                        <td>$c_linha[fone2]</td>
                        
                        <td>
                        <a class='btn btn-secondary btn-sm' href='/casaazul/instrutores/instrutores_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                        <a class='btn btn-primary btn-sm' href='/casaazul/instrutores/instrutor_atividade.php?id=$c_linha[id]'><span class='glyphicon glyphicon-list-alt'></span> Atividades</span></a>
                        <a class='btn btn-danger btn-sm' href='javascript:func()'onclick='confirmacao($c_linha[id])'><span class='glyphicon glyphicon-trash'></span> Excluir</a>
                    </td>

                    </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
        .fixed-table {
            table-layout: fixed;
            width: 100%;
            /* Required for fixed layout to activate */
            border-collapse: collapse;
        }

        .fixed-table th,
        .fixed-table td {
            border: 1px solid #ccc;
            padding: 8px;
            /* Optional: Truncate overflowing text with ellipses */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Define explicit column widths on the first row or headers */
        .col-small {
            width: 100px;
        }

        .col-large {
            width: 300px;
        }

        .col-flexible {
            width: auto;
        }

        /* Takes up remaining space */
    </style>

</body>

</html>