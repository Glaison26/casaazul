<?php
session_start();
include("../conexao.php");
include("../links.php");

$erro = null;
$pessoa = null;
$id = $_GET['id'] ?? null;

if ($id) {
    // leitura do paciente através de sql usando id passada
    $c_sql = "select * from cadastro where id=$id";
    $result = $conection->query($c_sql);
    $pessoa = $result->fetch_assoc();

    if (!$pessoa) {
        header('location: /casaazul/pessoas/pessoas_lista.php');
        exit;
    }

    // Converto as datas para o formato 'Y-m-d' para exibição no formulário
    if ($pessoa['datanasc']) {
        $pessoa['datanasc'] = date('Y-m-d', strtotime($pessoa['datanasc']));
    }
    if ($pessoa['data_cadastro']) {
        $pessoa['data_cadastro'] = date('Y-m-d', strtotime($pessoa['data_cadastro']));
    }
    // variaveis para preencher os campos do formulário
    $nome = $pessoa['nome'] ?? '';
    $identidade = $pessoa['identidade'] ?? '';
    $cpf = $pessoa['cpf'] ?? '';
    $datanasc = $pessoa['datanasc'] ?? '';
    $cep = $pessoa['cep'] ?? '';
    $endereco = $pessoa['endereco'] ?? '';
    $bairro = $pessoa['bairro'] ?? '';
    $cidade = $pessoa['cidade'] ?? '';
    $nomepai = $pessoa['nomepai'] ?? '';
    $nomemae = $pessoa['nomemae'] ?? '';
    $genero = $pessoa['genero'] ?? '';
    $fone1 = $pessoa['fone1'] ?? '';
    $fone2 = $pessoa['fone2'] ?? '';
    $fone3 = $pessoa['fone3'] ?? '';
    $niss = $pessoa['niss'] ?? '';
    $email = $pessoa['email'] ?? '';
    $sexo = $pessoa['sexo'] ?? '';
    $data_cadastro = $pessoa['data_cadastro'] ?? '';    
    $numerofilhos = $pessoa['numerofilhos'] ?? 0;
    $observacao = $pessoa['observacao'] ?? '';

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $identidade = $_POST['identidade'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $datanasc = $_POST['datanasc'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $nomepai = $_POST['nomepai'] ?? '';
    $nomemae = $_POST['nomemae'] ?? '';
    $fone1 = $_POST['fone1'] ?? '';
    $fone2 = $_POST['fone2'] ?? '';
    $fone3 = $_POST['fone3'] ?? '';
    $niss = $_POST['niss'] ?? '';
    $email = $_POST['email'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $data_cadastro = $_POST['data_cadastro'] ?? '';
    $numerofilhos = $_POST['numerofilhos'] ?? 0;
    $observacao = $_POST['observacao'] ?? '';
    $id = $_GET['id'] ?? null;


    if ($id) {
        $c_sql = "UPDATE cadastro SET nome='$nome', identidade='$identidade', cpf='$cpf', datanasc='$datanasc', cep='$cep', endereco='$endereco',
         bairro='$bairro', cidade='$cidade', nomepai='$nomepai', nomemae='$nomemae', fone1='$fone1', fone2='$fone2', 
         fone3='$fone3', niss='$niss', email='$email', sexo='$sexo', data_cadastro='$data_cadastro', numerofilhos='$numerofilhos', 
         observacao='$observacao' WHERE id=$id";
    } else {
        $c_sql = "INSERT INTO cadastro (nome, identidade, cpf, datanasc, cep, endereco, bairro, cidade, nomepai, nomemae, fone1, fone2, fone3, niss, email, sexo, data_cadastro, numerofilhos, observacao) VALUES ('$nome', '$identidade', '$cpf', '$datanasc', '$cep', '$endereco', '$bairro', '$cidade', '$nomepai',
         '$nomemae', '$fone1', '$fone2', '$fone3', '$niss', '$email', '$sexo', '$data_cadastro', '$numerofilhos', '$observacao')";
    }
    // fecha o banco de dados e volta para a lista de pessoas
    if ($conection->query($c_sql) === TRUE) {
        header('location: /casaazul/pessoas/pessoas_lista.php');
        exit;
    } else {
        $erro = "Erro ao salvar os dados: " . $conection->error;
    }
}

$id = $_GET['id'] ?? null;
if ($id) {
    $c_sql = "select * from cadastro where id=$id";
    $result = $conection->query($c_sql);
    $pessoa = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/casaazul/css/basico.css">
    <title>Cadastro de Pessoas físicas</title>

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
                    <h5>Editar Cadastro de Pessoa física<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">

            <form method="POST" action="">
                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Nome:</label>
                    <div class="col-sm-8">
                        <input type="text" name="nome" class="form-control" maxlength="200" value="<?php echo isset($pessoa['nome']) ? $pessoa['nome'] : ''; ?>" required>
                    </div>

                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Identidade:</label>
                    <div class="col-sm-2">
                        <input type="text" name="identidade" class="form-control" maxlength="9" value="<?php echo isset($pessoa['identidade']) ? $pessoa['identidade'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1">CPF:</label>
                    <div class="col-sm-2">
                        <input type="text" name="cpf" class="form-control" maxlength="11" value="<?php echo isset($pessoa['cpf']) ? $pessoa['cpf'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Data de Nascimento:</label>
                    <div class="col-sm-2">
                        <input type="date" name="datanasc" class="form-control" value="<?php echo isset($pessoa['datanasc']) ? $pessoa['datanasc'] : ''; ?>" required>
                    </div>
                </div>

                <hr>
                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">CEP:</label>
                    <div class="col-sm-2">
                        <input type="text" name="cep" maxlength="12" class="form-control" value="<?php echo isset($pessoa['cep']) ? $pessoa['cep'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1">Endereço:</label>
                    <div class="col-sm-5">
                        <input type="text" name="endereco" class="form-control" maxlength="150" value="<?php echo isset($pessoa['endereco']) ? $pessoa['endereco'] : ''; ?>" required>
                    </div>

                </div>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Bairro:</label>
                    <div class="col-sm-3">
                        <input type="text" name="bairro" class="form-control" maxlength="120" value="<?php echo isset($pessoa['bairro']) ? $pessoa['bairro'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Cidade:</label>
                    <div class="col-sm-4">
                        <input type="text" name="cidade" class="form-control" maxlength="120" value="<?php echo isset($pessoa['cidade']) ? $pessoa['cidade'] : ''; ?>">
                    </div>
                </div>
                <hr>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Nome do Pai:</label>
                    <div class="col-sm-3">
                        <input type="text" name="nomepai" class="form-control" maxlength="200" value="<?php echo isset($pessoa['nomepai']) ? $pessoa['nomepai'] : ''; ?>">
                    </div>
                    <label class="col-sm-1">Nome da Mãe:</label>
                    <div class="col-sm-4">
                        <input type="text" name="nomemae" class="form-control" maxlength="200" value="<?php echo isset($pessoa['nomemae']) ? $pessoa['nomemae'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Telefone 1:</label>
                    <div class="col-sm-3">
                        <input type="tel" name="fone1" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($pessoa['fone1']) ? $pessoa['fone1'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1">Telefone 2:</label>
                    <div class="col-sm-4">

                        <input type="tel" name="fone2" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($pessoa['fone2']) ? $pessoa['fone2'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Telefone 3:</label>
                    <div class="col-sm-3">
                        <input type="tel" name="fone3" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($pessoa['fone3']) ? $pessoa['fone3'] : ''; ?>">
                    </div>
                    <label class="col-sm-1">NISS:</label>
                    <div class="col-sm-4">
                        <input type="text" name="niss" class="form-control" maxlength="11" value="<?php echo isset($pessoa['niss']) ? $pessoa['niss'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Email:</label>
                    <div class="col-sm-3">

                        <input type="email" class="form-control" name="email" maxlength="150" value="<?php echo isset($pessoa['email']) ? $pessoa['email'] : ''; ?>">
                    </div>
                    <label class="col-sm-1">Sexo:</label>
                    <div class="col-sm-4">
                        <select name="sexo" class="form-control form-control-lg" class="form-control" required>
                            <option value=""></option>
                            <option value="M" <?php echo (isset($pessoa['sexo']) && $pessoa['sexo'] === 'M') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="F" <?php echo (isset($pessoa['sexo']) && $pessoa['sexo'] === 'F') ? 'selected' : ''; ?>>Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-1">Gênero:</label>
                    <div class="col-sm-3">
                        <select name="genero" class="form-control form-control-lg" class="form-control" required value="<?php echo isset($_POST['genero']) ? $_POST['genero'] : ''; ?>">
                            <option value=""></option>
                            <option value="M" <?php echo (isset($pessoa['genero']) && $pessoa['genero'] === 'M') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="F" <?php echo (isset($pessoa['genero']) && $pessoa['genero'] === 'F') ? 'selected' : ''; ?>>Feminino</option>
                        </select>
                    </div>
                    <label class="col-sm-1">Número de Filhos:</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="numerofilhos" requered value="<?php echo $numerofilhos?>">
                    </div>

                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Data de Cadastro:</label>
                    <div class="col-sm-3">
                        <input type="date" name="data_cadastro" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                   
                </div>
                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Observação:</label>
                    <div class="col-sm-8">
                        <textarea name="observacao" class="form-control" rows="4"><?php echo isset($pessoa['observacao']) ? $pessoa['observacao'] : ''; ?></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="offset-sm-0 col-sm-3">
                        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                        <a class='btn btn-danger' href='/casaazul/pessoas/pessoas_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                    </div>
                </div>

            </form>
        </div>
    </div>
</body>

</html>