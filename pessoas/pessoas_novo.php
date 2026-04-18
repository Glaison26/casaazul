<?php
session_start();
include("../conexao.php");
include("../links.php");
include("../lib_gop.php");
// configuro fuso horário
date_default_timezone_set('America/Sao_Paulo');


// post das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$conexao = new mysqli('localhost', 'root', '', 'casaazul');
    // faço consistencia do cpf digitado
    $cpf = $_POST['cpf'];
    $cpf = preg_replace('/[^0-9]/', '', $cpf); // Remove caracteres não numéricos
    do {

        // verifico se o cpf já existe no banco de dados
        $sql_check_cpf = "SELECT id FROM cadastro WHERE cpf = '$cpf'";
        $result_check_cpf = $conection->query($sql_check_cpf);
        if ($result_check_cpf->num_rows > 0) {
            $msg_erro = "CPF informado já cadastrado favor verificar!!";
            break;
        }

        if (!validaCPF($cpf) && !empty($cpf)) {
            $msg_erro = "CPF informado inválido!!";
            break;
        }

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
        $genero = $_POST['genero'];
        $data_cadastro =  new DateTime($_POST['data_cadastro']);
        $data_cadastro = $data_cadastro->format('Y-m-d');
        $numerofilhos = $_POST['numerofilhos'];
        $observacao = $_POST['observacao'];

        $c_sql = "INSERT INTO cadastro (nome, datanasc, identidade, cpf, cep, endereco, bairro, cidade, nomepai, nomemae, fone1, fone2, fone3,
     niss, email, sexo, data_cadastro, numerofilhos, observacao, genero) VALUES ('$nome', '$datanasc', '$identidade', '$cpf', '$cep', '$endereco', 
     '$bairro', '$cidade', '$nomepai', '$nomemae', '$fone1', '$fone2', '$fone3', '$niss', '$email', '$sexo', '$data_cadastro',
     '$numerofilhos', '$observacao', '$genero')";

        $result = $conection->query($c_sql);

        header('location: /casaazul/pessoas/pessoas_lista.php');
    } while (false);
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

    <!-- script para capturar cep -->
    <script>
        // script para capturar endereço pelo cep
        document.addEventListener('DOMContentLoaded', () => {
            const cepInput = document.getElementById('cep');
            // Adiciona um ouvinte de evento para quando o campo de CEP perder o foco
            cepInput.addEventListener('blur', () => {
                let cep = cepInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                // Verifica se o campo CEP possui valor informado
                if (cep) {
                    // Faz a requisição usando a Fetch API
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.erro) {
                                alert('CEP não encontrado.');
                                return;
                            }
                            document.getElementById('endereco').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            //document.getElementById('uf').textContent = data.uf;
                        })
                        .catch(error => {
                            alert('Erro ao buscar o CEP.');
                            alert(error);
                            console.error('Erro:', error);
                        });
                }
            });

            // Função para limpar os campos do formulário
            function limpaFormulario() {
                document.getElementById('endereco').value = '';
                document.getElementById('bairro').value = '';
                document.getElementById('cidade').value = '';
                //document.getElementById('uf').value = '';
            }
        });
    </script>
    <!-- Fim do script de CEP -->
</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Casa Azul</h4>
                    <h5>Novo Cadastro de Pessoa física<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            <?php
            if (!empty($msg_erro)) {
                echo "
            <div class='alert alert-warning' role='alert'>
                <h4>$msg_erro</h4>
            </div>
                ";
            }
            ?>

            <form method="POST" action="">
                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Nome:</label>
                    <div class="col-sm-8">
                        <input type="text" name="nome" placeholder="Nome completo" class="form-control" maxlength="200" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Identidade:</label>
                    <div class="col-sm-2">
                        <input type="text" name="identidade" class="form-control" maxlength="9" value="<?php echo isset($_POST['identidade']) ? $_POST['identidade'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1">CPF:</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Apenas números" name="cpf" class="form-control" maxlength="11" value="<?php echo isset($_POST['cpf']) ? $_POST['cpf'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Data de Nascimento:</label>
                    <div class="col-sm-2">
                        <input type="date" name="datanasc" class="form-control" value="<?php echo isset($_POST['datanasc']) ? $_POST['datanasc'] : ''; ?>" required>
                    </div>
                </div>

                <hr>
                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">CEP:</label>
                    <div class="col-sm-2">
                        <input type="text" name="cep" id="cep" maxlength="12" class="form-control" value="<?php echo isset($_POST['cep']) ? $_POST['cep'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1">Endereço:</label>
                    <div class="col-sm-5">
                        <input type="text" name="endereco" id="endereco" class="form-control" maxlength="150" value="<?php echo isset($_POST['endereco']) ? $_POST['endereco'] : ''; ?>" required>
                    </div>

                </div>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Bairro:</label>
                    <div class="col-sm-3">
                        <input type="text" name="bairro" id="bairro" class="form-control" maxlength="120" value="<?php echo isset($_POST['bairro']) ? $_POST['bairro'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1 col-form-label">Cidade:</label>
                    <div class="col-sm-4">
                        <input type="text" name="cidade" id="cidade" class="form-control" maxlength="120" value="<?php echo isset($_POST['cidade']) ? $_POST['cidade'] : ''; ?>">
                    </div>
                </div>
                <hr>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Nome do Pai:</label>
                    <div class="col-sm-3">
                        <input type="text" name="nomepai" class="form-control" maxlength="200" value="<?php echo isset($_POST['nomepai']) ? $_POST['nomepai'] : ''; ?>">
                    </div>
                    <label class="col-sm-1">Nome da Mãe:</label>
                    <div class="col-sm-4">
                        <input type="text" name="nomemae" class="form-control" maxlength="200" value="<?php echo isset($_POST['nomemae']) ? $_POST['nomemae'] : ''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Telefone 1:</label>
                    <div class="col-sm-3">
                        <input type="tel" name="fone1" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($_POST['fone1']) ? $_POST['fone1'] : ''; ?>" required>
                    </div>
                    <label class="col-sm-1">Telefone 2:</label>
                    <div class="col-sm-4">

                        <input type="tel" name="fone2" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($_POST['fone2']) ? $_POST['fone2'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">

                    <label class="col-sm-1 col-form-label">Telefone 3:</label>
                    <div class="col-sm-3">
                        <input type="tel" name="fone3" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($_POST['fone3']) ? $_POST['fone3'] : ''; ?>">
                    </div>
                    <label class="col-sm-1">NISS:</label>
                    <div class="col-sm-4">
                        <input type="text" name="niss" class="form-control" maxlength="11" value="<?php echo isset($_POST['niss']) ? $_POST['niss'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Email:</label>
                    <div class="col-sm-3">

                        <input type="email" class="form-control" name="email" maxlength="150" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    </div>
                    <label class="col-sm-1">Sexo:</label>
                    <div class="col-sm-3">
                        <select name="sexo" class="form-control form-control-lg" class="form-control" required value="<?php echo isset($_POST['sexo']) ? $_POST['sexo'] : ''; ?>">
                            <option value=""></option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-1">Gênero:</label>
                    <div class="col-sm-3">
                        <select name="genero" class="form-control form-control-lg" class="form-control" required value="<?php echo isset($_POST['genero']) ? $_POST['genero'] : ''; ?>">
                            <option value=""></option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                    <label class="col-sm-1">Número de Filhos:</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="numerofilhos" required value="<?php echo isset($_POST['numerofilhos']) ? $_POST['numerofilhos'] : '0'; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Data de Cadastro:</label>
                    <div class="col-sm-3">
                        <input type="date" name="data_cadastro" class="form-control" value="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($_POST['data_cadastro']) ? $_POST['data_cadastro'] : ''; ?>" required>
                    </div>

                </div>
                <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Observação:</label>
                    <div class="col-sm-8">
                        <textarea name="observacao" class="form-control" rows="4"><?php echo isset($_POST['observacao']) ? $_POST['observacao'] : ''; ?></textarea>
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