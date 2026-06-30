<?php
session_start();
include("../conexao.php");
include("../links.php");
include_once "../lib_gop.php";
// configuro fuso horário
date_default_timezone_set('America/Sao_Paulo');
// post das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    do {
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
        $pix = $_POST['pix'];
        $uf = 'MG';
        $cpf = preg_replace('/[^0-9]/', '', $cpf); // Remove caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']); // Remove caracteres não numéricos
        $id_parceria = $_POST['parceria_id'];
        $tipovinculacao = $_POST['vinculacao'];

        // validando se os campos obrigatórios foram preenchidos
        if (empty($nome)) {

            $msg_erro = "Favor preencher Campo Nome!!";
            break;
        }
        if (empty($identidade)) {

            $msg_erro = "Favor preencher Campo Identidade!!";
            break;
        }
        if (empty($cpf)) {

            $msg_erro = "Favor preencher Campo CPF!!";
            break;
        }
        if (empty($datanasc)) {

            $msg_erro = "Favor preencher Campo Data de Nascimento!!";
            break;
        }
        if (empty($cep)) {

            $msg_erro = "Favor preencher Campo CEP!!";
            break;
        }
        if (empty($endereco)) {

            $msg_erro = "Favor preencher Campo Endereço!!";
            break;
        }
        if (empty($bairro)) {

            $msg_erro = "Favor preencher Campo Bairro!!";
            break;
        }
        if (empty($cidade)) {

            $msg_erro = "Favor preencher Campo Cidade!!";
            break;
        }
        if (empty($fone1)) {

            $msg_erro = "Favor preencher Campo Telefone 1!!";
            break;
        }
        if (empty($escolaridade)) {

            $msg_erro = "Favor preencher Campo Escolaridade!!";
            break;
        }
        if (empty($sexo)) {

            $msg_erro = "Favor preencher Campo Sexo!!";
            break;
        }
        if (empty($id_parceria)) {

            $msg_erro = "Favor preencher Campo Vincular a Parceria!!";
            break;
        }
        if (empty($tipovinculacao)) {

            $msg_erro = "Favor preencher Campo Tipo de Vinculação!!";
            break;
        }


        // verifico se o cpf já existe no banco de dados
        $sql_check_cpf = "SELECT id FROM instrutores WHERE cpf = '$cpf'";
        $result_check_cpf = $conection->query($sql_check_cpf);
        if ($result_check_cpf->num_rows > 0) {
            $msg_erro = "CPF informado já cadastrado favor verificar!!";
            break;
        }
        // verifico se o cnpj já existe no banco de dados

        $sql_check_cnpj = "SELECT id FROM instrutores WHERE cnpj = '$cnpj'";
        $result_check_cnpj = $conection->query($sql_check_cnpj);
        if (($result_check_cnpj->num_rows > 0) && (!empty($cnpj))) {
            $msg_erro = "CNPJ informado já cadastrado favor verificar!!";
            break;
        }

        // valido o cpf


        if (!validaCPF($cpf) && !empty($cpf)) {
            $msg_erro = "CPF informado inválido!!";
            break;
        }
        // valido o cnpj
        if (!valida_CNPJ($cnpj) && !empty($cnpj)) {
            $msg_erro = "CNPJ informado inválido!!";
            break;
        }
        // inclusão dos dadospor sql
        $c_sql = "INSERT INTO instrutores (nome, identidade, cpf, datanasc, cep, endereco, bairro, cidade, fone1, fone2, escolaridade, sexo, email,
     banco, agencia, conta, tipo_conta, titular, observacao, uf, chave_pix, cnpj, id_parceria, tipo_vinculacao) VALUES ('$nome', '$identidade', '$cpf', '$datanasc', '$cep', '$endereco',
     '$bairro', '$cidade', '$fone1', '$fone2', '$escolaridade', '$sexo', '$email', '$nome_banco', '$numero_agencia', '$numero_conta', '$tipo_conta',
     '$titular_conta', '$observacao', '$uf', '$pix', '$cnpj', '$id_parceria', '$tipovinculacao')";
        $result = $conection->query($c_sql);
        echo $c_sql;
        // die();
        // verifico se a query foi correto
        if (!$result) {
            die("Erro ao Executar Sql!!" . $conection->connect_error);
        }
        header('location: /casaazul/instrutores/instrutores_lista.php');
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
                    <h5>Novo Cadastro de Colaboradores<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">
            
            <!-- mensagem alertando que os campos com * são obrigatórios -->
            <div class="alert alert-info" role="alert">
                <h4>Campos com * são obrigatórios!!</h4>
            </div>

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
                <!-- abas de cadastro ede instrutores -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#apresentacao" aria-controls="apresentacao" role="tab" data-toggle="tab">Dados Pessoais</a></li>
                    <li role="presentation"><a href="#bancos" aria-controls="bancos" role="tab" data-toggle="tab">Dados Bancários</a></li>
                    <li role="presentation"><a href="#vinculacao" aria-controls="vinculacao" role="tab" data-toggle="tab">Vinculação</a></li>
                    <li role="presentation"><a href="#observacao" aria-controls="observacao" role="tab" data-toggle="tab">Observações</a></li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="apresentacao">
                        <div style="padding-top:15px;padding-left:20px;">
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Nome *:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nome" placeholder="Nome completo" class="form-control" maxlength="200" value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Identidade *:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="identidade" class="form-control" maxlength="10" value="<?php echo isset($_POST['identidade']) ? $_POST['identidade'] : ''; ?>">
                                </div>

                                <label class="col-sm-2 col-form-label">Data de Nascimento *:</label>
                                <div class="col-sm-2">
                                    <input type="date" name="datanasc" class="form-control" value="<?php echo isset($_POST['datanasc']) ? $_POST['datanasc'] : ''; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-1">CPF *:</label>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="Apenas números" name="cpf" class="form-control" maxlength="11" value="<?php echo isset($_POST['cpf']) ? $_POST['cpf'] : ''; ?>">
                                </div>
                                <label class="col-sm-2 col-form-label">CNPJ:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="cnpj" maxlength="18" placeholder="Apenas números" class="form-control" value="<?php echo isset($_POST['cnpj']) ? $_POST['cnpj'] : ''; ?>">
                                </div>
                            </div>

                            <hr>
                            <div class="row mb-3">

                                <label class="col-sm-1 col-form-label">CEP *:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="cep" id="cep" maxlength="12" class="form-control" value="<?php echo isset($_POST['cep']) ? $_POST['cep'] : ''; ?>">
                                </div>
                                <label class="col-sm-1">Endereço *:</label>
                                <div class="col-sm-5">
                                    <input type="text" name="endereco" id="endereco" class="form-control" maxlength="150" value="<?php echo isset($_POST['endereco']) ? $_POST['endereco'] : ''; ?>">
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label class="col-sm-1 col-form-label">Bairro *:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="bairro" id="bairro" class="form-control" maxlength="100" value="<?php echo isset($_POST['bairro']) ? $_POST['bairro'] : ''; ?>">
                                </div>
                                <label class="col-sm-1 col-form-label">Cidade :</label>
                                <div class="col-sm-4">
                                    <input type="text" name="cidade" id="cidade" class="form-control" maxlength="120" value="<?php echo isset($_POST['cidade']) ? $_POST['cidade'] : ''; ?>">
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Telefone 1 *:</label>
                                <div class="col-sm-3">
                                    <input type="tel" name="fone1" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($_POST['fone1']) ? $_POST['fone1'] : ''; ?>">
                                </div>
                                <label class="col-sm-1">Telefone 2:</label>
                                <div class="col-sm-4">

                                    <input type="tel" name="fone2" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo isset($_POST['fone2']) ? $_POST['fone2'] : ''; ?>">
                                </div>
                            </div>
                            <!-- combobox com escolaridade do instrutor -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Escolaridade*:</label>
                                <div class="col-sm-3">
                                    <select name="escolaridade" class="form-control form-control-lg" value="<?php echo isset($_POST['escolaridade']) ? $_POST['escolaridade'] : ''; ?>">
                                        <option value=""></option>
                                        <option value="Ensino Fundamental Incompleto">Ensino Fundamental Incompleto</option>
                                        <option value="Ensino Fundamental Completo">Ensino Fundamental Completo</option>
                                        <option value="Ensino Médio Incompleto">Ensino Médio Incompleto</option>
                                        <option value="Ensino Médio Completo">Ensino Médio Completo</option>
                                        <option value="Ensino Superior Incompleto">Ensino Superior Incompleto</option>
                                        <option value="Ensino Superior Completo">Ensino Superior Completo</option>
                                    </select>
                                </div>
                                <label class="col-sm-1">Sexo *:</label>
                                <div class="col-sm-4">
                                    <select name="sexo" class="form-control form-control-lg" class="form-control" value="<?php echo isset($_POST['sexo']) ? $_POST['sexo'] : ''; ?>">
                                        <option value=""></option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Email:</label>
                                <div class="col-sm-8">

                                    <input type="email" class="form-control" name="email" maxlength="150" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
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
                                    <input type="text" name="nome_banco" class="form-control" maxlength="50" value=>
                                </div>
                                <label class="col-sm-1">Número da Agência:</label>
                                <div class="col-sm-4">
                                    <input type="text" name="numero_agencia" class="form-control" maxlength="6" value="<?php echo isset($_POST['numero_agencia']) ? $_POST['numero_agencia'] : ''; ?>">
                                </div>
                            </div>
                            <!-- número da conta -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Número da Conta:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="numero_conta" class="form-control" maxlength="15" value="<?php echo isset($_POST['numero_conta']) ? $_POST['numero_conta'] : ''; ?>">
                                </div>
                                <label class="col-sm-1">Tipo da Conta:</label>
                                <div class="col-sm-4">
                                    <select name="tipo_conta" class="form-control form-control-lg" value="<?php echo isset($_POST['tipo_conta']) ? $_POST['tipo_conta'] : ''; ?>">
                                        <option value=""></option>
                                        <option value="Corrente">Corrente</option>
                                        <option value="Poupança">Poupança</option>
                                    </select>
                                </div>
                            </div>
                            <!-- titular da conta -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Titular da Conta:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="titular_conta" class="form-control" maxlength="90" value="<?php echo isset($_POST['titular_conta']) ? $_POST['titular_conta'] : ''; ?>">
                                </div>
                                <label class="col-sm-1 col-form-label">Chave PIX:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="pix" class="form-control" maxlength="100" value="<?php echo isset($_POST['pix']) ? $_POST['pix'] : ''; ?>">
                                </div>
                            </div>

                        </div>

                    </div> <!-- fim de aba de dados bancários -->
                    <div role="tabpanel" class="tab-pane" id="vinculacao">
                        <div style="padding-top:15px;padding-left:20px;">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tipo de vinculação *:</label>
                                <div class="col-sm-3">
                                    <select name="vinculacao" class="form-control requered form-control-lg" value="<?php echo isset($_POST['vinculacao']) ? $_POST['vinculacao'] : ''; ?>">
                                        <option value=""></option>
                                        <option value="MEI" <?php echo (isset($_POST['vinculacao']) && $_POST['vinculacao'] === 'MEI') ? 'selected' : ''; ?>>MEI</option>
                                        <option value="Autônomo" <?php echo (isset($_POST['vinculacao']) && $_POST['vinculacao'] === 'Autônomo') ? 'selected' : ''; ?>>Autônomo</option>
                                        <option value="Voluntário" <?php echo (isset($_POST['vinculacao']) && $_POST['vinculacao'] === 'Voluntário') ? 'selected' : ''; ?>>Voluntário</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- combobox com a parceria da tabela paricerias para vincular o instrutor a uma parceria, o combobox com identificação e número da parceria    -->
                                <label class="col-sm-2 col-form-label">Vincular a Parceria *:</label>
                                <div class="col-sm-3">
                                    <select name="parceria_id" class="form-control form-control-lg" value="<?php echo isset($_POST['parceria_id']) ? $_POST['parceria_id'] : ''; ?>">
                                        <option value=""></option>
                                        <?php
                                        $sql_parcerias = "SELECT id, identificacao, numero FROM parcerias";
                                        $result_parcerias = $conection->query($sql_parcerias);
                                        if ($result_parcerias->num_rows > 0) {
                                            while ($row_parceria = $result_parcerias->fetch_assoc()) {
                                                echo "<option value='" . $row_parceria['id'] . "'>" . $row_parceria['identificacao'] . " - " . $row_parceria['numero'] . (isset($_POST['parceria_id']) && $_POST['parceria_id'] === $row_parceria['id'] ? " selected" : "") . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="observacao">
                        <div style="padding-top:15px;padding-left:20px;">

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Observação:</label>
                                <div class="col-sm-8">
                                    <textarea name="observacao" class="form-control" rows="8"><?php echo isset($_POST['observacao']) ? $_POST['observacao'] : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="offset-sm-0 col-sm-3">
                            <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                            <a class='btn btn-danger' href='/casaazul/instrutores/instrutores_lista.php'><span class='glyphicon glyphicon-log-out'></span> Voltar</a>

                        </div>
                    </div>

            </form>
        </div>

    </div>
</body>

</html>