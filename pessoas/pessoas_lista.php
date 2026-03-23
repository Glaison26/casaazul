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

<body>
    <div class="container>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>CEP</th>
                        <th>Telefone 1</th>
                        <th>Telefone 2</th>
                        <th>Sexo</th>
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
                        echo "
                    <tr>
                        <td>></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                    <a class='btn btn-secondary btn-sm' href='/gop/cadastros/fabricantes/fabricantes_editar.php?id=$c_linha[id]'><span class='glyphicon glyphicon-pencil'></span> Editar</a>
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