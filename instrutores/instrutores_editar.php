<?php
session_start();
include("../conexao.php");
include("../links.php");
// configuro fuso horário
date_default_timezone_set('America/Sao_Paulo');
// get do id do instrutor
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $c_sql = "SELECT * FROM instrutores where id=$id";
    $result = $conection->query($c_sql);
    if (!$result) {
        die("Erro ao Executar Sql!!" . $conection->connect_error);
    }
    $registro = $result->fetch_assoc();
    // PEGO OS DADOS DO BANCO DE DADOS PARA EXIBIR NO FORMULÁRIO
    $nome = $registro['nome'];
    $identidade = $registro['identidade'];
    $cpf = $registro['cpf'];
    $datanasc = $registro['datanasc'];
    $cep = $registro['cep'];
    $endereco = $registro['endereco'];
    $bairro = $registro['bairro'];
    $cidade = $registro['cidade'];
    $fone1 = $registro['fone1'];
    $fone2 = $registro['fone2'];
    $escolaridade = $registro['escolaridade'];
    $sexo = $registro['sexo'];
    $email = $registro['email'];
    $nome_banco = $registro['banco'];
    $numero_agencia = $registro['agencia'];
    $numero_conta = $registro['conta'];
    $tipo_conta = $registro['tipo_conta'];
    $titular_conta = $registro['titular'];
    $observacao = $registro['observacao'];
}
// post das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $identidade = $_POST['identidade'];
    $cpf = $_POST['cpf'];
    $datanasc = $_POST['datanasc'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $fone1 = $_POST['fone1'];
    $fone2 = $_POST['fone2'];
    $escolaridade = $_POST['escolaridade'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $nome_banco = $_POST['nome_banco'];
    $numero_agencia = $_POST['numero_agencia'];
    $numero_conta = $_POST['numero_conta'];
    $tipo_conta = $_POST['tipo_conta'];
    $titular_conta = $_POST['titular_conta'];
    $observacao = $_POST['observacao'];
    $uf = 'MG';
    // inclusão dos dadospor sql
    $c_sql = "Update instrutores SET NOME='$nome', IDENTIDADE='$identidade', CPF='$cpf', DATANASC='$datanasc', CEP='$cep', ENDERECO='$endereco', BAIRRO='$bairro', 
    CIDADE='$cidade', UF='$uf', FONE1='$fone1', FONE2='$fone2', ESCOLARIDADE='$escolaridade', SEXO='$sexo', EMAIL='$email', BANCO='$nome_banco',
    AGENCIA='$numero_agencia', CONTA='$numero_conta', TIPO_CONTA='$tipo_conta', TITULAR='$titular_conta', OBSERVACAO='$observacao' where id=$id";
    $result = $conection->query($c_sql);
    if (!$result) {
        die("Erro ao Executar Sql!!" . $conection->connect_error);
    }
    header('location: /casaazul/instrutores/instrutores_lista.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/casaazul/css/basico.css">
    <title>Cadastro de Instrutor - Editar</title>

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
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Editar Cadastro de Instrutor<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">


            <form method="POST" action="">
                <!-- abas de cadastro ede instrutores -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#apresentacao" aria-controls="apresentacao" role="tab" data-toggle="tab">Apresentação</a></li>
                    <li role="presentation"><a href="#bancos" aria-controls="bancos" role="tab" data-toggle="tab">Dados Bancários</a></li>
                    <li role="presentation"><a href="#observacao" aria-controls="observacao" role="tab" data-toggle="tab">Observações</a></li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="apresentacao">
                        <div style="padding-top:15px;padding-left:20px;">
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Nome:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nome" placeholder="Nome completo" class="form-control" maxlength="200" value="<?php echo $nome; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Identidade:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="identidade" class="form-control" maxlength="9" value="<?php echo $identidade; ?>" required>
                                </div>
                                <label class="col-sm-1">CPF:</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Apenas números" name="cpf" class="form-control" maxlength="11" value="<?php echo $cpf; ?>" required>
                                </div>
                                <label class="col-sm-1 col-form-label">Data de Nascimento:</label>
                                <div class="col-sm-2">
                                    <input type="date" name="datanasc" class="form-control" value="<?php echo $datanasc; ?>" required>
                                </div>
                            </div>

                            <hr>
                            <div class="row mb-3">

                                <label class="col-sm-1 col-form-label">CEP:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="cep" id="cep" maxlength="12" class="form-control" value="<?php echo $cep; ?>" required>
                                </div>
                                <label class="col-sm-1">Endereço:</label>
                                <div class="col-sm-5">
                                    <input type="text" name="endereco" id="endereco" class="form-control" maxlength="150" value="<?php echo $endereco; ?>" required>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label class="col-sm-1 col-form-label">Bairro:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="bairro" id="bairro" class="form-control" maxlength="120" value="<?php echo $bairro; ?>" required>
                                </div>
                                <label class="col-sm-1 col-form-label">Cidade:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="cidade" id="cidade" class="form-control" maxlength="120" value="<?php echo $cidade; ?>" required>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Telefone 1:</label>
                                <div class="col-sm-3">
                                    <input type="tel" name="fone1" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo $fone1; ?>" required>
                                </div>
                                <label class="col-sm-1">Telefone 2:</label>
                                <div class="col-sm-4">

                                    <input type="tel" name="fone2" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo $fone2; ?>">
                                </div>
                            </div>
                            <!-- combobox com ESCOLARIDADE do instrutor -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Escolaridade:</label>
                                <div class="col-sm-3">
                                    <select name="escolaridade" class="form-control form-control-lg" required>
                                        <option value=""></option>
                                        <option value="Ensino Fundamental Incompleto" <?php echo (isset($registro['escolaridade']) && $registro['escolaridade'] === 'Ensino Fundamental Incompleto') ? 'selected' : ''; ?>>Ensino Fundamental Incompleto</option>
                                        <option value="Ensino Fundamental Completo" <?php echo (isset($registro['escolaridade']) && $registro['escolaridade'] === 'Ensino Fundamental Completo') ? 'selected' : ''; ?>>Ensino Fundamental Completo</option>
                                        <option value="Ensino Médio Incompleto" <?php echo (isset($registro['escolaridade']) && $registro['escolaridade'] === 'Ensino Médio Incompleto') ? 'selected' : ''; ?>>Ensino Médio Incompleto</option>
                                        <option value="Ensino Médio Completo" <?php echo (isset($registro['escolaridade']) && $registro['escolaridade'] === 'Ensino Médio Completo') ? 'selected' : ''; ?>>Ensino Médio Completo</option>
                                        <option value="Ensino Superior Incompleto" <?php echo (isset($registro['escolaridade']) && $registro['escolaridade'] === 'Ensino Superior Incompleto') ? 'selected' : ''; ?>>Ensino Superior Incompleto</option>
                                        <option value="Ensino Superior Completo" <?php echo (isset($registro['escolaridade']) && $registro['escolaridade'] === 'Ensino Superior Completo') ? 'selected' : ''; ?>>Ensino Superior Completo</option>
                                    </select>
                                </div>
                                <label class="col-sm-1">Sexo:</label>
                                <div class="col-sm-4">
                                    <select name="sexo" class="form-control form-control-lg" class="form-control" required>
                                        <option value=""></option>
                                        <option value="M" <?php echo (isset($registro['sexo']) && $registro['sexo'] === 'M') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="F" <?php echo (isset($registro['sexo']) && $registro['sexo'] === 'F') ? 'selected' : ''; ?>>Feminino</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Email:</label>
                                <div class="col-sm-8">

                                    <input type="email" class="form-control" name="email" maxlength="150" value="<?php echo $email; ?>">
                                </div>

                            </div>
                        </div>
                    </div> <!-- fim da aba apresentação -->



                    <div role="tabpanel" class="tab-pane" id="bancos">
                        <div style="padding-top:15px;padding-left:20px;">
                            <!-- dados bancários nome do banco, número da agência, número da conta tipo da conta e titular da conta -->
                            <!-- nome do banco -->

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Nome do Banco:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="nome_banco" class="form-control" maxlength="100" value="<?php echo $nome_banco; ?>">
                                </div>
                                <label class="col-sm-1">Número da Agência:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="numero_agencia" class="form-control" maxlength="20" value="<?php echo $numero_agencia; ?>">
                                </div>
                            </div>
                            <!-- número da conta -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Número da Conta:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="numero_conta" class="form-control" maxlength="20" value="<?php echo $numero_conta; ?>">
                                </div>
                                <label class="col-sm-1">Tipo da Conta:</label>
                                <div class="col-sm-4">
                                    <select name="tipo_conta" class="form-control form-control-lg">
                                        <option value=""></option>
                                        <option value="Corrente" <?php echo (isset($registro['tipo_conta']) && $registro['tipo_conta'] === 'Corrente') ? 'selected' : ''; ?>>Corrente</option>
                                        <option value="Poupança" <?php echo (isset($registro['tipo_conta']) && $registro['tipo_conta'] === 'Poupança') ? 'selected' : ''; ?>>Poupança</option>
                                    </select>
                                </div>
                            </div>
                            <!-- titular da conta -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Titular da Conta:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="titular_conta" class="form-control" maxlength="100" value="<?php echo $titular_conta; ?>">
                                </div>
                            </div>
                        </div>

                    </div> <!-- fim de aba de dados bancários -->

                    <div role="tabpanel" class="tab-pane" id="observacao">
                        <div style="padding-top:15px;padding-left:20px;">

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Observação:</label>
                                <div class="col-sm-8">
                                    <textarea name="observacao" class="form-control" rows="8"><?php echo $observacao; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="offset-sm-0 col-sm-3">
                            <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                            <a class='btn btn-danger' href='/casaazul/instrutores/instrutores_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                        </div>
                    </div>

            </form>
        </div>

    </div>
</body>

</html>