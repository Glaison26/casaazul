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
    $cnpj = $registro['cnpj'];
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
    $id_parceria = $registro['id_parceria'];
    $tipovinculacao = $registro['tipo_vinculacao'];
    $pix = $registro['chave_pix'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/casaazul/css/basico.css">
    <title>Cadastro de Colaboradores - Editar</title>

    <link rel="shortcut icon" type="imagex/png" href="/casaazul/imagens/img_gop.ico">
</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Casa Azul</h4>
                    <h5>Editar Cadastro de Colaboradores<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">


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
                                <label class="col-sm-1 col-form-label">Nome:</label>
                                <div class="col-sm-8">
                                    <input readonly type="text" name="nome" placeholder="Nome completo" class="form-control" maxlength="200" value="<?php echo $nome; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Identidade:</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" name="identidade" class="form-control" maxlength="9" value="<?php echo $identidade; ?>" required>
                                </div>

                                <label class="col-sm-2 col-form-label">Data de Nascimento:</label>
                                <div class="col-sm-2">
                                    <input readonly type="date" name="datanasc" class="form-control" value="<?php echo $datanasc; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-1">CPF:</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" placeholder="Apenas números" name="cpf" class="form-control" maxlength="11" value="<?php echo $cpf; ?>" required>
                                </div>
                                <label class="col-sm-2 col-form-label">CNPJ:</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" placeholder="Apenas números" name="cnpj" class="form-control" maxlength="14" value="<?php echo $cnpj; ?>">
                                </div>
                            </div>

                            <hr>
                            <div class="row mb-3">

                                <label class="col-sm-1 col-form-label">CEP:</label>
                                <div class="col-sm-2">
                                    <input readonly type="text" name="cep" id="cep" maxlength="12" class="form-control" value="<?php echo $cep; ?>" required>
                                </div>
                                <label class="col-sm-1">Endereço:</label>
                                <div class="col-sm-5">
                                    <input readonly type="text" name="endereco" id="endereco" class="form-control" maxlength="150" value="<?php echo $endereco; ?>" required>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <label class="col-sm-1 col-form-label">Bairro:</label>
                                <div class="col-sm-3">
                                    <input readonly type="text" name="bairro" id="bairro" class="form-control" maxlength="120" value="<?php echo $bairro; ?>" required>
                                </div>
                                <label class="col-sm-1 col-form-label">Cidade:</label>
                                <div class="col-sm-4">
                                    <input readonly type="text" name="cidade" id="cidade" class="form-control" maxlength="120" value="<?php echo $cidade; ?>" required>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Telefone 1:</label>
                                <div class="col-sm-3">
                                    <input readonly type="tel" name="fone1" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo $fone1; ?>" required>
                                </div>
                                <label class="col-sm-1">Telefone 2:</label>
                                <div class="col-sm-4">

                                    <input readonly type="tel" name="fone2" class="form-control" maxlength="20" onkeyup="handlePhone(event)" value="<?php echo $fone2; ?>">
                                </div>
                            </div>
                            <!-- combobox com ESCOLARIDADE do instrutor -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Escolaridade:</label>
                                <div class="col-sm-3">
                                    <select readonly name="escolaridade" class="form-control form-control-lg" required>
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
                                    <select readonly name="sexo" class="form-control form-control-lg" class="form-control" required>
                                        <option value=""></option>
                                        <option value="M" <?php echo (isset($registro['sexo']) && $registro['sexo'] === 'M') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="F" <?php echo (isset($registro['sexo']) && $registro['sexo'] === 'F') ? 'selected' : ''; ?>>Feminino</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Email:</label>
                                <div class="col-sm-8">

                                    <input readonly type="email" class="form-control" name="email" maxlength="150" value="<?php echo $email; ?>">
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
                                    <input readonly type="text" name="nome_banco" class="form-control" maxlength="100" value="<?php echo $nome_banco; ?>">
                                </div>
                                <label class="col-sm-1">Número da Agência:</label>
                                <div class="col-sm-4">
                                    <input readonly type="text" name="numero_agencia" class="form-control" maxlength="20" value="<?php echo $numero_agencia; ?>">
                                </div>
                            </div>
                            <!-- número da conta -->
                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Número da Conta:</label>
                                <div class="col-sm-3">
                                    <input readonly type="text" name="numero_conta" class="form-control" maxlength="20" value="<?php echo $numero_conta; ?>">
                                </div>
                                <label class="col-sm-1">Tipo da Conta:</label>
                                <div class="col-sm-4">
                                    <select readonly name="tipo_conta" class="form-control form-control-lg">
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
                                    <input readonly type="text" name="titular_conta" class="form-control" maxlength="100" value="<?php echo $titular_conta; ?>">
                                </div>
                                   <label class="col-sm-1 col-form-label">Chave PIX:</label>
                                <div class="col-sm-3">
                                    <input readonly type="text" name="pix" class="form-control" maxlength="100" value="<?php echo $pix; ?>">
                                </div>
                            </div>
                        </div>

                    </div> <!-- fim de aba de dados bancários -->
                    <!-- aba de vinculação -->
                    <div role="tabpanel" class="tab-pane" id="vinculacao">
                        <div style="padding-top:15px;padding-left:20px;">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tipo de vinculação:</label>
                                <div class="col-sm-3">
                                    <input readonly type="text" name="tipovinculacao" class="form-control" maxlength="100" value="<?php echo $tipovinculacao; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- combobox com a parceria da tabela paricerias para vincular o instrutor a uma parceria, o combobox com identificação e número da parceria    -->
                                <label class="col-sm-2 col-form-label">Vincular a Parceria:</label>
                                <div class="col-sm-3">
                                    <?php
                                    // consulta para pegar o nome da parceria vinculada ao instrutor
                                    $p_sql = "SELECT identificacao FROM parcerias WHERE id=$id_parceria";
                                    $p_result = $conection->query($p_sql);
                                    if (!$p_result) {
                                        die("Erro ao Executar Sql!!" . $conection->connect_error);
                                    }
                                    $p_registro = $p_result->fetch_assoc();
                                    $nome_parceria = $p_registro['identificacao'];
                                    echo "<input readonly type='text' name='nome_parceria' class='form-control' maxlength='100' value='$nome_parceria'>";
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="observacao">
                        <div style="padding-top:15px;padding-left:20px;">

                            <div class="row mb-3">
                                <label class="col-sm-1 col-form-label">Observação:</label>
                                <div class="col-sm-8">
                                    <textarea readonly name="observacao" class="form-control" rows="8"><?php echo $observacao; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="offset-sm-0 col-sm-3">

                            <a class='btn btn-primary' href='/casaazul/instrutores/instrutores_lista.php'><span class='glyphicon glyphicon-log-out'></span> Voltar</a>

                        </div>
                    </div>

            </form>
        </div>

    </div>
</body>

</html>