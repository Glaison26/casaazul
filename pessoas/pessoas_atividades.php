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
            <a class="btn btn-secondary btn-sm" href="/casaazul/pessoas/pessoas_lista.php"><span class="glyphicon glyphicon-arrow-left"></span> Voltar para Lista de Pessoas Físicas</a>
            <hr>
            <?php
            // rotina para listar as atividades realizadas por cada pessoa física
            // sql para buscar as atividades realizadas por cada pessoa física na tabela participantes_atividade ligado a tabela cadastro de pessoas
            $c_sql = "SELECT atividades_realizadas.data_inicio, atividades_realizadas.data_final, atividades_realizadas.num_vagas, atividades_realizadas.carga_horaria, atividades_realizadas.observacao, 
atividades_realizadas.observacao, cursos.descricao AS curso, instrutores.nome AS instrutor FROM participamentes_atividade
JOIN atividades_realizadas ON participamentes_atividade.id_atividade = atividades_realizadas.id
JOIN cursos ON atividades_realizadas.id_curso=cursos.ID
JOIN instrutores ON atividades_realizadas.id_instrutor=instrutores.id
where participamentes_atividade.id_participante = " . $_GET['id'] . "
ORDER BY instrutores.nome, atividades_realizadas.data_inicio";

            $result = $conection->query($c_sql);
            // sql para buscar o nome da pessoa física
            $c_sql_pessoa = "SELECT nome FROM cadastro WHERE id = " . $_GET['id'];
            $result_pessoa = $conection->query($c_sql_pessoa);
            if ($result_pessoa->num_rows > 0) {
                $row_pessoa = $result_pessoa->fetch_assoc();
                echo "<h3>Atividades com participação de: " . $row_pessoa['nome'] . "</h3>";
            }

            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered tablista'>
                    <thead>
                        <tr>
                            <th>Instrutor</th>
                            <th>Curso</th>
                            <th>Data Início</th>
                            <th>Data Final</th>
                            <th>Número de Vagas</th>
                            <th>Carga Horária</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row['instrutor'] . "</td>
                        <td>" . $row['curso'] . "</td>
                        <td>" . date('d/m/Y', strtotime($row['data_inicio'])) . "</td>
                        <td>" . date('d/m/Y', strtotime($row['data_final'])) . "</td>
                        <td>" . $row['num_vagas'] . "</td>
                        <td>" . $row['carga_horaria'] . "</td>
                        <td>" . $row['observacao'] . "</td>
                    </tr>";
                }
            } else {
                echo "<p>Nenhuma atividade encontrada para esta pessoa.</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>