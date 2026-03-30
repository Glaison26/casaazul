<?php
session_start();
include("../conexao.php");
include("../links.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexao = new mysqli('localhost', 'root', '', 'casaazul');


    $nome = $_POST['nome'];
    $datanasc =  new DateTime($_POST['datanasc']);
    $datanasc = $datanasc->format('Y-m-d');

    $identidade = $_POST['identidade'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $nomepai = $_POST['nomepai'];
    $nomemae = $_POST['nomemae'];
    $fone1 = $_POST['fone1'];
    $fone2 = $_POST['fone2'];
    $fone3 = $_POST['fone3'];
    $niss = $_POST['niss'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $data_cadastro =  new DateTime($_POST['data_cadastro']);
    $data_cadastro = $data_cadastro->format('Y-m-d');
    $numerofilhos = $_POST['numerofilhos'];
    $observacao = $_POST['observacao'];

    $c_sql = "INSERT INTO cadastro (nome, datanasc, identidade, cpf, cep, endereco, bairro, cidade, nomepai, nomemae, fone1, fone2, fone3,
     niss, email, sexo, data_cadastro, numerofilhos, observacao) VALUES ('$nome', '$datanasc', '$identidade', '$cpf', '$cep', '$endereco', 
     '$bairro', '$cidade', '$nomepai', '$nomemae', '$fone1', '$fone2', '$fone3', '$niss', '$email', '$sexo', '$data_cadastro',
     '$numerofilhos', '$observacao')";

    $result = $conection->query($c_sql);
    // verifico se a query foi correto
    if (!$result) {
        echo "<script>alert('Erro ao cadastrar: " . $conexao->error . "');</script>";
    } else {
        echo "<script>alert('Pessoa cadastrada com sucesso!'); window.location='pessoas_novo.php';</script>";
    }
    header('location: /casaazul/pessoas/pessoas_lista.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/casaazul/css/basico.css">
    <title>Cadastro de Pessoas</title>

    <script>
        const handlePhone = (event) => {
            let input = event.target
            input.value = phoneMask(input.value)
        }

        const phoneMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{2})(\d)/, "($1) $2")
            value = value.replace(/(\d)(\d{4})$/, "$1-$2")
            return value
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Novo Cadastro de Pessoa física<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">

            <form method="POST" action="">
                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Nome:</label>
                    <div class="col-sm-8">
                        <input type="text" name="nome" class="form-control" maxlength="200" required>
                    </div>

                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Identidade:</label>
                    <div class="col-sm-2">
                        <input type="text" name="identidade" class="form-control" maxlength="9" required>
                    </div>
                    <label class="col-sm-1">CPF:</label>
                    <div class="col-sm-2">
                        <input type="text" name="cpf" class="form-control" maxlength="11" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Data de Nascimento:</label>
                    <div class="col-sm-2">
                        <input type="date" name="datanasc" class="form-control" required>
                    </div>
                </div>

                <hr>
                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">CEP:</label>
                    <div class="col-sm-2">
                        <input type="text" name="cep" maxlength="12" class="form-control" required>
                    </div>
                    <label class="col-sm-1">Endereço:</label>
                    <div class="col-sm-5">
                        <input type="text" name="endereco" class="form-control" maxlength="150" required>
                    </div>

                </div>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Bairro:</label>
                    <div class="col-sm-3">
                        <input type="text" name="bairro" class="form-control" maxlength="120" required>
                    </div>
                    <label class="col-sm-1">Cidade:</label>
                    <div class="col-sm-4">
                        <input type="text" name="cidade" class="form-control" maxlength="120" value='Sabará'>
                    </div>

                </div>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Nome do Pai:</label>
                    <div class="col-sm-3">
                        <input type="text" name="nomepai" class="form-control" maxlength="200">
                    </div>


                    <label class="col-sm-1">Nome da Mãe:</label>
                    <input type="text" name="nomemae" class="form-control" maxlength="200">
                </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Telefone 1:</label>
                <input type="tel" name="fone1" class="form-control" maxlength="20" onkeyup="handlePhone(event)" required>
            </div>
            <div class="form-group">
                <label>Telefone 2:</label>
                <input type="tel" name="fone2" class="form-control" maxlength="20" onkeyup="handlePhone(event)">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Telefone 3:</label>
                <input type="tel" name="fone3" class="form-control" maxlength="20" onkeyup="handlePhone(event)">
            </div>
            <div class="form-group">
                <label>NISS:</label>
                <input type="text" name="niss" class="form-control" maxlength="11">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" maxlength="150">
            </div>
            <div class="form-group">
                <label>Sexo:</label>
                <select name="sexo" class="form-control" class="form-control" required>
                    <option value=""></option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Data de Cadastro:</label>
                <input type="date" name="data_cadastro" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label>Número de Filhos:</label>
                <input type="number" class="form-control" name="numerofilhos" requered value="0">
            </div>
        </div>

        <div class="form-group">
            <label>Observação:</label>
            <textarea name="observacao" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
        </form>
    </div>>
    </div>
</body>

</html>