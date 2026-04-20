<?php
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";
?>

<!-- Página para exibir as atividades realizadas por cada instrutor -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividades por Instrutor - Casa Azul</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Atividades por Instrutor<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            <!-- botão para voltar para a lista de instrutores -->
            <a class="btn btn-secondary btn-sm" href="/casaazul/instrutores/instrutores_lista.php"><span class="glyphicon glyphicon-arrow-left"></span> Voltar para Lista de Instrutores</a>
            <hr>
            <?php
            // rotina para listar as atividades realizadas por cada instrutor
            $c_sql = "SELECT i.nome AS instrutor, c.descricao AS curso, ar.data_inicio, ar.data_final, ar.num_vagas, ar.carga_horaria, ar.observacao
            FROM atividades_realizadas ar
            JOIN instrutores i ON ar.id_instrutor = i.id
            JOIN cursos c ON ar.id_curso = c.id
            where ar.id_instrutor = " . $_GET['id'] . "
            ORDER BY i.nome, ar.data_inicio";
            $result = $conection->query($c_sql);
            // sql para buscar o nome do instrutor
            $c_sql_instrutor = "SELECT nome FROM instrutores WHERE id = " . $_GET['id'];
            $result_instrutor = $conection->query($c_sql_instrutor);
            if ($result_instrutor->num_rows > 0) {
                $row_instrutor = $result_instrutor->fetch_assoc();
                echo "<h3>Atividades realizadas por: " . $row_instrutor['nome'] . "</h3>";
            }

            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>Instrutor</th>
                                <th>Curso</th>
                                <th>Data de Início</th>
                                <th>Data Final</th>
                                <th>Número de Vagas</th>
                                <th>Carga Horária</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['instrutor']}</td>
                            <td>{$row['curso']}</td>
                            <td>" . date("d/m/Y", strtotime($row['data_inicio'])) . "</td>
                            <td>" . date("d/m/Y", strtotime($row['data_final'])) . "</td>
                            <td>{$row['num_vagas']}</td>
                            <td>{$row['carga_horaria']}</td>
                            <td>{$row['observacao']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Nenhuma atividade encontrada.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>