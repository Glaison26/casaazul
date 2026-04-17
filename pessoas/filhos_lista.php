<?php
include("../conexao.php");
include("../links.php");
//
$id = $_GET['id'] ?? null;
$c_sql = "SELECT * FROM dependentes WHERE id_pessoa = $id ORDER BY nome";
// sql para pegar o nome dapessoa
$c_sql_pessoa = "SELECT nome, numerofilhos FROM cadastro WHERE id = $id";
$result_pessoa = $conection->query($c_sql_pessoa);
if (!$result_pessoa) {
    die("Erro ao Executar Sql!!" . $conection->connect_error);
}
// sql para pegar a quantidade de filhos cadastrados para a pessoa
$c_sql_filhos = "SELECT COUNT(*) as total FROM dependentes WHERE id_pessoa = $id";
$result_filhos = $conection->query($c_sql_filhos);
if (!$result_filhos) {
    die("Erro ao Executar Sql!!" . $conection->connect_error);
}
$i_total_filhos = $result_filhos->fetch_assoc()['total'] ?? 0;

$pessoa = $result_pessoa->fetch_assoc();
$pessoa_nome = $pessoa['nome'] ?? 'Pessoa Desconecida';
$pessoa_numero_filhos = $pessoa['numerofilhos'] ?? 0;
// função para calcular idade a partir da data de nascimento
// desabilito o botão de incluir filhos caso numero de registros de dependentes seja igual ou maior ao numero de filhos da pessoa
if ($pessoa_numero_filhos <= $i_total_filhos) {
    // desabilitar o botão de incluir filhos usando php para adicionar a classe disabled do bootstrap
    echo "<style>
    #btn_novo_filho {
        pointer-events: none;
        opacity: 0.5;
    }
    </style>";
}


function calcularIdade($data_nascimento)
{
    $data_nascimento = new DateTime($data_nascimento);
    $data_atual = new DateTime();
    $idade = $data_atual->diff($data_nascimento)->y;
    return $idade;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Filhos de Pessoa Fisica</title>
    <script>
        $(document).ready(function() {
            $('.tabfilhos').DataTable({
                // 
                "iDisplayLength": -1,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [4]
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

    <!-- script para incluir filho -->
    <script type="text/javascript">
        // Função javascript e ajax para inclusão dos dados

        $(document).on('submit', '#formNovoFilho', function(e) {
            e.preventDefault();
            var c_nome = $('#nome').val();
            var c_data_nasc = $('#data_nasc').val();
            var c_sexo = $('#sexo').val();
            var c_id_pessoa = <?php echo $id; ?>;


            if (c_nome != '') {

                $.ajax({
                    url: "filho_novo.php",
                    type: "post",
                    data: {
                        c_nome: c_nome,
                        c_data_nasc: c_data_nasc,
                        c_sexo: c_sexo,
                        c_id_pessoa: c_id_pessoa
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;

                        location.reload();
                        if (status == 'true') {

                            $('#modalNovoFilho').modal('hide');
                            location.reload();
                        } else {
                            alert('falha ao incluir dados');
                        }
                    }
                });
            } else {
                alert('Preencha todos os campos obrigatórios');
            }
        });
    </script>

    <!--  script javascript Coleta dados da tabela de dependentes (filhos) -->
    <!-- Coleta dados da tabela para edição do registro -->
     <script>
        $(document).ready(function() {

            $('.editbtn').on('click', function() {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#up_idField').val(data[0]);
                $('#up_descricaoField').val(data[1]);
                $('#up_observacaoField').val(data[2]);

            });
        });
    </script>


    <script type="text/javascript">
        ~
        // Função javascript e ajax para Alteração dos dados
        $(document).on('submit', '#frmup', function(e) {
            e.preventDefault();
            var c_id = $('#id_pessoa').val();
            var c_nome = $('#up_nomeField').val();
            var c_data_nasc = $('#up_data_nascField').val();
            var c_sexo = $('#up_sexoField').val();

            if (c_nome != '') {

                $.ajax({
                    url: "filho_editar.php",
                    type: "post",
                    data: {
                        c_id: c_id,
                        c_nome: c_nome,
                        c_data_nasc: c_data_nasc,
                        c_sexo: c_sexo
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if (status == 'true') {
                            $('#editmodal').modal('hide');
                            location.reload();
                        } else {
                            alert('falha ao alterar dados');
                        }
                    }
                });

            } else {
                alert('Todos os campos devem ser preenchidos!!');
            }
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
        <!-- painel para mostrar o nome da pessoa -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Filhos de <?php echo $pessoa_nome; ?></h3>
            </div>
            <div class="panel-body">

                <!-- botao para chamar a janela modal para incluir novo filho -->
                <button id="btn_novo_filho" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNovoFilho">
                    <span class="glyphicon glyphicon-plus"></span> Incluir Novo Filho
                </button>
                <a class="btn btn-secondary btn-sm" href="/casaazul/pessoas/pessoas_lista.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
            </div>
            <!-- botão para voltar para a lista de pessoas -->
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped tabfilhos">
                <thead class="thead">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Data do Nascimento</th>
                        <th>Idade</th>
                        <th>Sexo</th>
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
                        $i_idade = calcularIdade($c_linha['data_nasc']);
                        // data de nascimento formatada para o padrão brasileiro
                        $c_data_nasc = date('d/m/Y', strtotime($c_linha['data_nasc']));

                        echo "
                    <tr>
                        <td>$c_linha[id]</td>
                        <td>$c_linha[nome]</td>
                        <td>$c_data_nasc</td>
                        <td>$i_idade</td>
                        <td>$c_sexo</td>
                    <td>
                    <button type='button' class='btn btn-primary btn-sm editbtn' data-toggle='modal' data-target='#editmodal' title='Editar'><span class='glyphicon glyphicon-pencil'></span> Editar</button>
                    <a class='btn btn-danger btn-sm' href='javascript:func()'onclick='confirmacao($c_linha[id])'><span class='glyphicon glyphicon-trash'></span> Excluir</a>
                    </td>

                    </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <!-- Janela modal para incluir novo filho com nome, data de nascimento e sexo -->
    <div class="modal fade" id="modalNovoFilho" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Incluir Novo Filho</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNovoFilho" method="POST">
                        <input type="hidden" name="id_pessoa" id="id_pessoa" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="data_nasc">Data de Nascimento:</label>
                            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
                        </div>
                        <div class="form-group">
                            <label for="sexo">Sexo:</label>
                            <select class="form-control form-control-lg" id="sexo" name="sexo" required>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
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
    <!-- Modal para edição dos dados -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Editar Grupo</h4>
                </div>
                <div class="modal-body">
                    <div class='alert alert-warning' role='alert'>
                        <h5>Campos com (*) são obrigatórios</h5>
                    </div>
                    <form id="frmup" method="POST" action="">
                        <input type="hidden" id="up_idField" name="up_idField">


                        <div class="modal-footer">
                              <button type='button' class='btn btn-secondary btn-sm editbtn' data-toggle='modal' title='Editar Tipo de Ação'><span class='glyphicon glyphicon-pencil'></span> Editar</button>
                            <button class="btn btn-secondary" data-dismiss="modal"><span class='glyphicon glyphicon-remove'></span> Fechar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>