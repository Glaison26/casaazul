<?php
include("../conexao.php");
include("../links.php");
//
$c_sql = "SELECT * FROM cadastro ORDER BY nome";

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pessoas Físicas</title>
    <script>
        $(document).ready(function() {
            $('.tabpessoas').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [7]
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
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Lista de Pessoas Fisicas<h5>
            </div>
        </div>
        <br>
        <a class="btn btn-success btn-sm" href="/casaazul/pessoas/pessoas_novo.php"><span class="glyphicon glyphicon-plus"></span> Incluir</a>
        <a class="btn btn-secondary btn-sm" href="/casaazul/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped tabpessoas">
                <thead class="thead">
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>CEP</th>
                        <th>Telefone 1</th>
                        
                        <th>Sexo</th>
                        <th style="width: 30px;">No. de Filhos</th>
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
                        // sql para contar o numero de filhos da pessoa
                        $c_sql_filhos = "SELECT COUNT(*) AS qtd_filhos FROM dependentes WHERE id_pessoa = $c_linha[id]";
                        $result_filhos = $conection->query($c_sql_filhos);
                        $row_filhos = $result_filhos->fetch_assoc();
                        $qtd_filhos = $row_filhos['qtd_filhos'];
                        // sql para contar o numero de atividades realizadas pela pessoa
                        $c_sql_atividades = "SELECT COUNT(*) AS qtd_atividades FROM participamentes_atividade WHERE id_participante = $c_linha[id]";
                        $result_atividades = $conection->query($c_sql_atividades);
                        $row_atividades = $result_atividades->fetch_assoc();
                        $qtd_atividades = $row_atividades['qtd_atividades'];
                        // sql para contar o numero de ações participadas pela pessoa
                        $c_sql_acoes = "SELECT COUNT(*) AS qtd_acoes FROM participantes_acoes WHERE id_participante = $c_linha[id]";
                        $result_acoes = $conection->query($c_sql_acoes);
                        $row_acoes = $result_acoes->fetch_assoc();
                        $qtd_acoes = $row_acoes['qtd_acoes'];

                        if ($c_linha['sexo']=='M')
                            $c_sexo = 'Masculino';
                        else
                            $c_sexo = 'Feminino';
                 
                        echo "
                    <tr>
                        <td>$c_linha[nome]</td>
                        <td>$c_linha[endereco]</td>
                        <td>$c_linha[bairro]</td>
                        <td>$c_linha[cep]</td>
                        <td>$c_linha[fone1]</td>
                        
                        <td>$c_sexo</td>
                        <td>$c_linha[numerofilhos]</td>
                        <td>
                    <a class='btn btn-secondary btn-sm' href='/casaazul/pessoas/pessoas_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                    <a class='btn btn-info btn-sm' href='/casaazul/pessoas/filhos_lista.php?id=$c_linha[id]'><span class='glyphicon glyphicon-user'></span> Filhos&nbsp<span style='background-color: #c0af1a; color: white; padding: 5px 10px; border-radius: 10px;'> $qtd_filhos</span></a>
                    <a class='btn btn-primary btn-sm' href='/casaazul/pessoas/pessoas_atividades.php?id=$c_linha[id]'><span class='glyphicon glyphicon-list-alt'></span> Atividades&nbsp<span style='background-color: #c0af1a; color: white; padding: 5px 10px; border-radius: 10px;'> $qtd_atividades</span></a>
                    <a class='btn btn-success btn-sm' href='/casaazul/pessoas/pessoas_acoes.php?id=$c_linha[id]'><span class='glyphicon glyphicon-list-alt'></span> Ações&nbsp<span style='background-color: #c0af1a; color: white; padding: 5px 10px; border-radius: 10px;'> $qtd_acoes</span></a>
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
</body>

</html>