<?php // controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include("../../conexao.php");
include("../../links.php");
?>
<!doctype html>
<html lang="en">

<body>
  
    <script language="Javascript">
        function confirmacao(id) {
            var resposta = confirm("Deseja remover esse registro?");
            if (resposta == true) {
                window.location.href = "/gop/marcas_excluir.php?id=" + id;
            }
        }
    </script>

    <script language="Javascript">
        function mensagem(msg) {
            alert(msg);
        }
    </script>


    <script>
        $(document).ready(function() {
            $('.tabperfil').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [2]
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
            <h4>GOP - Gestão Operacional</h4>
            <h5>Lista de Perfis de Usuários do Sistema<h5>
        </div>
    </div>

    <br>
    <div class="container-fluid">

        <a class="btn btn-success btn-sm" href="/gop/cadastros/usuarios/usuarios_perfil_novo.php"><span class="glyphicon glyphicon-plus"></span> Incluir</a>
        <a class="btn btn-secondary btn-sm" href="/gop/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>

        <hr>
        <table class="table table-bordered table-striped tabperfil">
            <thead class="thead">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Descrição do Perfil</th>
                    <th scope="col">Opções</th>

                </tr>
            </thead>
            <tbody>
                <?php
               
                // faço a Leitura da tabela com sql
                $c_sql = "SELECT perfil_usuarios.id, perfil_usuarios.descricao FROM perfil_usuarios ORDER BY perfil_usuarios.descricao";
                $result = $conection->query($c_sql);
                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }

                // insiro os registro do banco de dados na tabela 
                while ($c_linha = $result->fetch_assoc()) {
                 
                    echo "
                    <tr>
                    <td>$c_linha[id]</td>
                    <td>$c_linha[descricao]</td>
          
                    <td>
                    <a class='btn btn-secondary btn-sm' href='/gop/cadastros/usuarios/usuarios_perfil_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
                    
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