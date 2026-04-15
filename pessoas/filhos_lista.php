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
$pessoa = $result_pessoa->fetch_assoc();
$pessoa_nome = $pessoa['nome'] ?? 'Pessoa Desconecida';
$pessoa_numero_filhos = $pessoa['numerofilhos'] ?? 0;
// função para calcular idade a partir da data de nascimento
// desabilito o botão de incluir filhos caso numero de registros seja igual ao numero de filhos da pessoa
if ($id) {
    $result_filhos = $conection->query($c_sql);
    if (!$result_filhos) {
        die("Erro ao Executar Sql!!" . $conection->connect_error);
    }
    $numero_filhos_cadastrados = $result_filhos->num_rows;
    if ($numero_filhos_cadastrados >= $pessoa['numerofilhos']) {
        echo "<script>$(document).ready(function() { $('#btn_novo_filho').prop('disabled', true); });</script>";
    }
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
                
                <a class="btn btn-success btn-sm" name="btn_novo_filho" id="btn_novo_filho" href="/casaazul/pessoas/filhos_novo.php?id=<?php echo $id; ?>"><span class="glyphicon glyphicon-plus"></span> Incluir Filho</a>
                <a class="btn btn-secondary btn-sm" href="/casaazul/pessoas/pessoas_lista.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
            </div>
            <!-- botão para voltar para a lista de pessoas -->
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped tabfilhos">
                <thead class="thead">
                    <tr>
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
                        $i_idade = calcularIdade($c_linha['datanasc']);

                        echo "
                    <tr>
                        <td>$c_linha[nome]</td>
                        <td>$c_linha[data_nasc]</td>
                        <td>$c_linha[$i_idade]</td>
                        <td>$c_sexo</td>
                       
                        <td>$c_sexo</td>
                        <td>
                    <a class='btn btn-secondary btn-sm' href='/casaazul/pessoas/pessoas_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
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