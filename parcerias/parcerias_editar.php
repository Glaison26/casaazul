
<?php
include_once("../conexao.php");
include_once("../links.php");
$id = $_GET['id'];
$sql = "SELECT * FROM parcerias WHERE id = $id";
$result = $conection->query($sql);
if (!$result) {
    die("Erro ao Executar Sql!!" . $conection->connect_error);
}
$row = $result->fetch_assoc();
// rotina para atualizar a parceria no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $identificacao = $_POST['identificacao'];
    $numero = $_POST['numero'];
    $vigencia_inicio = $_POST['vigencia_inicio'];
    $vigencia_fim = $_POST['vigencia_fim'];
    // converto as datas para o formato do banco de dados
    $prorrogacao_inicio = new DateTime($_POST['prorrogacao_inicio']);
    $prorrogacao_inicio = $prorrogacao_inicio->format('Y-m-d');
    $prorrogacao_fim = new DateTime($_POST['prorrogacao_fim']);
    $prorrogacao_fim = $prorrogacao_fim->format('Y-m-d');
    // insiro dado no bacode dados com data de prorrogação preenchida, caso a data de prorrogação esteja em branco, insiro o valor null no banco de dados
    if ($_POST['prorrogacao_inicio'] == "") {
        $prorrogacao_inicio = 'null';
    }
    if ($_POST['prorrogacao_fim'] == "") {
        $prorrogacao_fim = 'null';
    }
    if ($_POST['prorrogacao_inicio'] == "" && $_POST['prorrogacao_fim'] == "") {
        $sql_update = "UPDATE parcerias SET identificacao='$identificacao', numero='$numero', vigencia_inicio='$vigencia_inicio', 
        vigencia_fim='$vigencia_fim', prorrogacao_inicio=null, prorrogacao_fim=null WHERE id=$id";
    } else
    $sql_update = "UPDATE parcerias SET identificacao='$identificacao', numero='$numero', vigencia_inicio='$vigencia_inicio', 
    vigencia_fim='$vigencia_fim', prorrogacao_inicio='$prorrogacao_inicio', prorrogacao_fim='$prorrogacao_fim' WHERE id=$id";
    if ($conection->query($sql_update) === TRUE) {
        echo "<script>alert('Parceria atualizada com sucesso!'); window.location.href='/casaazul/parcerias/parcerias_lista.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar parceria: " . $conection->error . "');</script>";
    }
    // fecho a conexão com o banco de dados
    $conection->close();
    // voltopara a página de lista de parcerias
    header("Location: /casaazul/parcerias/parcerias_lista.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/casaazul/css/basico.css">
    <title>Cadastro de Parcerias</title>
</head>

<body>
    <div class="container-fluid">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>Casa Azul - Sistema de Gestão</h4>
                <h5>Editar Parceria<h5>
            </div>
        </div>
    </div>
    <hr>
    <div class="container content-box">
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="row mb-4">

                <label class="col-sm-2 col-form-label" for="identificacao">Identificação da Parceria</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="identificacao" name="identificacao" value="<?php echo $row['identificacao']; ?>" required>
                </div>

                <label class="col-sm-2 col-form-label" for="numero">Número da Parceria</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $row['numero']; ?>" required>
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label" for="vigencia_inicio">Início da Vigência</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="vigencia_inicio" name="vigencia_inicio" value="<?php echo $row['vigencia_inicio']; ?>" required>
                </div>

                <label class="col-sm-2 col-form-label" for="vigencia_fim">Fim da Vigência</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="vigencia_fim" name="vigencia_fim" value="<?php echo $row['vigencia_fim']; ?>" required>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-2 col-form-label" for="prorrogacao_inicio">Prorrogação Início</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="prorrogacao_inicio" name="prorrogacao_inicio" value="<?php echo $row['prorrogacao_inicio']; ?>">
                </div>
                <label class="col-sm-2 col-form-label" for="prorrogacao_fim">Prorrogação Fim</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="prorrogacao_fim" name="prorrogacao_fim" value="<?php echo $row['prorrogacao_fim']; ?>">
                </div>
            </div>
            <hr>

            <div class="row mb-3">
                <div class="offset-sm-0 col-sm-3">
                    <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                    <a class='btn btn-danger' href='/casaazul/parcerias/parcerias_lista.php'><span class='glyphicon glyphicon-log-out'></span> Voltar</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>