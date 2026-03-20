<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include("../conexao.php");
include("../links.php");
?>
<!doctype html>
<html lang="en">

<body>
  
    

    <script language="Javascript">
        function mensagem(msg) {
            alert(msg);
        }
    </script>


    <script>
        $(document).ready(function() {
            $('.tabusuarios').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [4]
                }, {
                    'aTargets': [0],
                    "visible": false
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
     <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>Sistema de Gestão - Casa Azul</h4>
            <h5>Lista de Usuários do Sistema<h5>
        </div>
    </div>

    <br>
    <div class="container-fluid">

        <a class="btn btn-success btn-sm" href="/casaazul/usuarios/Usuarios_novo.php"><span class="glyphicon glyphicon-plus"></span> Incluir</a>
        <a class="btn btn-secondary btn-sm" href="/casaazul/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>

        <hr>
        <table class="table table-bordered table-striped tabusuarios">
            <thead class="thead">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Login</th>
                    <th scope="col">Tipo de acesso</th>
                    
                    <th scope="col">Ativo</th>
                    <th scope="col">Opções</th>

                </tr>
            </thead>
            <tbody>
                <?php
               
                // faço a Leitura da tabela com sql
                $c_sql = "SELECT usuarios.id, usuarios.nome, usuarios.login, usuarios.senha,
                usuarios.ativo, usuarios.tipo
                FROM usuarios ORDER BY usuarios.nome";
                $result = $conection->query($c_sql);
                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }

                // insiro os registro do banco de dados na tabela 
                while ($c_linha = $result->fetch_assoc()) {
                    // Coloco string sim ou não ao invés de s ou n
                    $c_ativo = $c_linha['ativo'];
                    if ($c_ativo == "S") {
                        $c_ativo = "SIM";
                    }
                    if ($c_ativo == "N") {
                        $c_ativo = "NÃO";
                    }
                    echo "
                    <tr>
                    <td>$c_linha[id]</td>
                    <td>$c_linha[nome]</td>
                    <td>$c_linha[login]</td>
                    <td>$c_linha[tipo]</td>
                    <td>$c_ativo</td>
                    <td>
                    <a class='btn btn-secondary btn-sm' href='/casaazul/usuarios/Usuarios_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                    
                    </td>

                    </tr>
                    ";
                }
                ?>


            </tbody>
        </table>
    </div>
</body>



</html>