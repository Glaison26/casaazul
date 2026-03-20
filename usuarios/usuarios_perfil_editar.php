<?php
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include('../../conexao.php');
include('../../links2.php');
include_once "../../lib_gop.php";

$c_id = $_GET["id"];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {  // metodo get para carregar dados no formulário

    if (!isset($_GET["id"])) {
        header('location: /gop/cadastros/usuarios/usuarios_perfil_lista.php');
        exit;
    }


    // leitura do convenio através de sql usando id passada
    $c_sql = "select * from perfil_usuarios where id=$c_id";
    $result = $conection->query($c_sql);
    $registro = $result->fetch_assoc();

    if (!$registro) {
        header('location: /gop/cadastros/usuarios/usuarios_perfil_lista.php');
        exit;
    }
    // captura valores para as variaveis
    $c_descricao = $registro['descricao'];
    // checks
    if ($registro['cadastros_recursosfisicos'] == 'S') {
        $c_chkrecursosfisicos = 'checked';
    } else {
        $c_chkrecursosfisicos = 'N';
    }
    //
    if ($registro['cadastros_espacosfisicos'] == 'S') {
        $c_chkespacosfisicos = 'checked';
    } else {
        $c_chkespacosfisicos = 'N';
    }
    //
    if ($registro['cadastros_fornecedores'] == 'S') {
        $c_chkfornecedores = 'checked';
    } else {
        $c_chkfornecedores = 'N';
    }

    //
    if ($registro['cadastros_fabricantes'] == 'S') {
        $c_chkfabricantes = 'checked';
    } else {
        $c_chkfabricantes = 'N';
    }
    //
    if ($registro['cadastros_executores'] == 'S') {
        $c_chkexecutores = 'checked';
    } else {
        $c_chkexecutores = 'N';
    }
    //
    if ($registro['cadastros_cargosfuncoes'] == 'S') {
        $c_chkfcargosfuncoes = 'checked';
    } else {
        $c_chkfcargosfuncoes = 'N';
    }
    //
    if ($registro['cadastros_oficinas'] == 'S') {
        $c_chkoficinas = 'checked';
    } else {
        $c_chkoficinas = 'N';
    }
    //
    if ($registro['cadastro_centrosdecusto'] == 'S') {
        $c_chkcentrosdecusto = 'checked';
    } else {
        $c_chkcentrosdecusto = 'N';
    }
    //
    if ($registro['cadastros_setores'] == 'S') {
        $c_chksetores = 'checked';
    } else {
        $c_chksetores = 'N';
    }
    //
    if ($registro['cadastros_ferramentas'] == 'S') {
        $c_chkferramentas = 'checked';
    } else {
        $c_chkferramentas = 'N';
    }
    //
    if ($registro['cadastros_grupos'] == 'S') {
        $c_chkgruposrecursos = 'checked';
    } else {
        $c_chkgruposrecursos = 'N';
    }
    //
    if ($registro['cadastros_marcas'] == 'S') {
        $c_chkmarcasrecursos = 'checked';
    } else {
        $c_chkmarcasrecursos = 'N';
    }
    //
    if ($registro['cadastros_pop'] == 'S') {
        $c_chkpop = 'checked';
    } else {
        $c_chkpop = 'N';
    }
    if ($registro['cadastros_tipos'] == 'S') {
        $c_chktipo = 'checked';
    } else {
        $c_chktipo = 'N';
    }
    if ($registro['cadastros_checklist'] == 'S') {
        $c_chkchecklist = 'checked';
    } else {
        $c_chkchecklist = 'N';
    }

    //
    if ($registro['servicos_solicitacoes'] == 'S') {
        $c_chksolicitacoes = 'checked';
    } else {
        $c_chksolicitacoes = 'N';
    }
    //
    if ($registro['servicos_ordens'] == 'S') {
        $c_chkordens = 'checked';
    } else {
        $c_chkordens = 'N';
    }
    //
    if ($registro['servicos_preventivas'] == 'S') {
        $c_chkpreventivas = 'checked';
    } else {
        $c_chkpreventivas = 'N';
    }
    //
    if ($registro['servicos_ocorrencias_padroes'] == 'S') {
        $c_chkocorrencias = 'checked';
    } else {
        $c_chkocorrencias = 'N';
    }
    //
    if ($registro['servicos_plano_acao'] == 'S') {
        $c_chkplanoacao = 'checked';
    } else {
        $c_chkplanoacao = 'N';
    }
    //
    if ($registro['almoxarifado_cotacoes'] == 'S') {
        $c_chkcotacao = 'checked';
    } else {
        $c_chkcotacao = 'N';
    }
    //
    if ($registro['almoxarifado_pedidodecompra'] == 'S') {
        $c_chkpedidodecompra = 'checked';
    } else {
        $c_chkpedidodecompra = 'N';
    }
    //
    if ($registro['almoxarifado_materiais'] == 'S') {
        $c_chkmateriais = 'checked';
    } else {
        $c_chkmateriais = 'N';
    }
    //
    if ($registro['almoxarifado_unidadesmedidas'] == 'S') {
        $c_chkunidades = 'checked';
    } else {
        $c_chkunidades = 'N';
    }
    //
    if ($registro['indicadores_ocorrencias'] == 'S') {
        $c_chkcontagem = 'checked';
    } else {
        $c_chkcontagem = 'N';
    }
    //
    if ($registro['indicadores_comparativos'] == 'S') {
        $c_chkcomparativo = 'checked';
    } else {
        $c_chkcomparativo = 'N';
    }
    //
    if ($registro['custos_ocorrencias'] == 'S') {
        $c_chkcustoindividual = 'checked';
    } else {
        $c_chkcustoindividual = 'N';
    }
    //
    if ($registro['custos_comparativos'] == 'S') {
        $c_chkcomparativocustos = 'checked';
    } else {
        $c_chkcomparativocustos = 'N';
    }
    //
    if ($registro['obras'] == 'S') {
        $c_chkobras = 'checked';
    } else {
        $c_chkobras = 'N';
    }
    // agenda executores
    if ($registro['servicos_agenda'] == 'S') {
        $c_chkagendaexecutores = 'checked';
    } else {
        $c_chkagendaexecutores = 'N';
    }
    // prestadores de serviço
    if ($registro['cadastros_prestadores'] == 'S') {
        $c_chkprestadoresdeservico = 'checked';
    } else {
        $c_chkprestadoresdeservico = 'N';
    }
    // gerador de Ordem de Serviço
    if ($registro['gera_os'] == 'S') {
        $c_chkgera_os = 'checked';
    } else {
        $c_chkgera_os = 'N';
    }
}
// Metodo post para gravação dos dados editados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $c_descricao = $_POST['up_descricaoField'];
    if (isset($_POST['chkativo'])) {
        $c_ativo = 'S';
    } else {
        $c_ativo = 'N';
    }
    if (isset($_POST['chkrecursosfisicos'])) {
        $c_chkrecursosfisicos = 'S';
    } else {
        $c_chkrecursosfisicos = 'N';
    }
    //
    if (isset($_POST['chkespacosfisicos'])) {
        $c_chkespacosfisicos = 'S';
    } else {
        $c_chkespacosfisicos = 'N';
    }
    //
    if (isset($_POST['chkfornecedores'])) {
        $c_chkfornecedores = 'S';
    } else {
        $c_chkfornecedores = 'N';
    }

    //
    if (isset($_POST['chkfabricantes'])) {
        $c_chkfabricantes = 'S';
    } else {
        $c_chkfabricantes = 'N';
    }
    //
    if (isset($_POST['chkexecutores'])) {
        $c_chkexecutores = 'S';
    } else {
        $c_chkexecutores = 'N';
    }
    //
    if (isset($_POST['chkfcargosfuncoes'])) {
        $c_chkfcargosfuncoes = 'S';
    } else {
        $c_chkfcargosfuncoes = 'N';
    }
    //
    if (isset($_POST['chkoficinas'])) {
        $c_chkoficinas = 'S';
    } else {
        $c_chkoficinas = 'N';
    }
    //
    if (isset($_POST['chkcentrosdecusto'])) {
        $c_chkcentrosdecusto = 'S';
    } else {
        $c_chkcentrosdecusto = 'N';
    }
    //
    if (isset($_POST['chksetores'])) {
        $c_chksetores = 'S';
    } else {
        $c_chksetores = 'N';
    }
    //
    if (isset($_POST['chkferramentas'])) {
        $c_chkferramentas = 'S';
    } else {
        $c_chkferramentas = 'N';
    }
    //
    if (isset($_POST['chkgruposrecursos'])) {
        $c_chkgruposrecursos = 'S';
    } else {
        $c_chkgruposrecursos = 'N';
    }
    //
    if (isset($_POST['chkmarcasrecursos'])) {
        $c_chkmarcasrecursos = 'S';
    } else {
        $c_chkmarcasrecursos = 'N';
    }
    //
    if (isset($_POST['chkpop'])) {
        $c_chkpop = 'S';
    } else {
        $c_chkpop = 'N';
    }
    //
    if (isset($_POST['chkpop'])) {
        $c_chkpop = 'S';
    } else {
        $c_chkpop = 'N';
    }
    //
    if (isset($_POST['chktipo'])) {
        $c_chktipo = 'S';
    } else {
        $c_chktipo = 'N';
    }
    //
    if (isset($_POST['chkchecklist'])) {
        $c_chkchecklist = 'S';
    } else {
        $c_chkchecklist = 'N';
    }
    //
    if (isset($_POST['chksolicitacoes'])) {
        $c_chksolicitacoes = 'S';
    } else {
        $c_chksolicitacoes = 'N';
    }
    //
    if (isset($_POST['chkordens'])) {
        $c_chkordens = 'S';
    } else {
        $c_chkordens = 'N';
    }
    //
    if (isset($_POST['chkpreventivas'])) {
        $c_chkpreventivas = 'S';
    } else {
        $c_chkpreventivas = 'N';
    }
    //
    if (isset($_POST['chkocorrencias'])) {
        $c_chkocorrencias = 'S';
    } else {
        $c_chkocorrencias = 'N';
    }
    //
    if (isset($_POST['chkplanoacao'])) {
        $c_chkplanoacao = 'S';
    } else {
        $c_chkplanoacao = 'N';
    }
    //
    if (isset($_POST['chkcotacao'])) {
        $c_chkcotacao = 'S';
    } else {
        $c_chkcotacao = 'N';
    }
    //
    if (isset($_POST['chkpedidodecompra'])) {
        $c_chkpedidodecompra = 'S';
    } else {
        $c_chkpedidodecompra = 'N';
    }
    //
    if (isset($_POST['chkmateriais'])) {
        $c_chkmateriais = 'S';
    } else {
        $c_chkmateriais = 'N';
    }
    //
    if (isset($_POST['chkunidades'])) {
        $c_chkunidades = 'S';
    } else {
        $c_chkunidades = 'N';
    }
    //
    if (isset($_POST['chkcontagem'])) {
        $c_chkcontagem = 'S';
    } else {
        $c_chkcontagem = 'N';
    }
    //
    if (isset($_POST['chkcomparativo'])) {
        $c_chkcomparativo = 'S';
    } else {
        $c_chkcomparativo = 'N';
    }
    //
    if (isset($_POST['chkcustoindividual'])) {
        $c_chkcustoindividual = 'S';
    } else {
        $c_chkcustoindividual = 'N';
    }
    //
    if (isset($_POST['chkcomparativocustos'])) {
        $c_chkcomparativocustos = 'S';
    } else {
        $c_chkcomparativocustos = 'N';
    }
    //
    if (isset($_POST['chkobras'])) {
        $c_chkobras = 'S';
    } else {
        $c_chkobras = 'N';
    }
    // agenda executores
    if (isset($_POST['chkagendaexecutores'])) {
        $c_chkagendaexecutores = 'S';
    } else {
        $c_chkagendaexecutores = 'N';
    }
    // prestadores de serviço
    if (isset($_POST['chkprestadoresdeservico'])) {
        $c_chkprestadoresdeservico = 'S';
    } else {
        $c_chkprestadoresdeservico = 'N';
    }
    // // gera ordem de serviço
    if (isset($_POST['chkgera_os'])) {
        $c_chkgera_os = 'S';
    } else {
        $c_chkgera_os = 'N';
    }

    do {

        // gravo os dados com sql
        $c_sql = "Update perfil_usuarios set descricao='$c_descricao', cadastros_recursosfisicos='$c_chkrecursosfisicos', 
        cadastros_espacosfisicos='$c_chkespacosfisicos',
        cadastros_fornecedores='$c_chkfornecedores', cadastros_fabricantes='$c_chkfabricantes', cadastros_executores='$c_chkexecutores',
        cadastros_cargosfuncoes='$c_chkfcargosfuncoes',cadastros_oficinas='$c_chkoficinas', cadastro_centrosdecusto='$c_chkcentrosdecusto',
        cadastros_setores='$c_chksetores', cadastros_ferramentas='$c_chkferramentas', cadastros_grupos='$c_chkgruposrecursos',
        cadastros_marcas='$c_chkmarcasrecursos', cadastros_pop='$c_chkpop', cadastros_checklist='$c_chkchecklist',
        servicos_solicitacoes='$c_chksolicitacoes', servicos_ordens='$c_chkordens',servicos_preventivas='$c_chkpreventivas',
        servicos_ocorrencias_padroes='$c_chkocorrencias',servicos_plano_acao='$c_chkplanoacao',
        almoxarifado_cotacoes='$c_chkcotacao', almoxarifado_pedidodecompra='$c_chkpedidodecompra', almoxarifado_materiais='$c_chkmateriais',
        almoxarifado_unidadesmedidas='$c_chkunidades', indicadores_ocorrencias='$c_chkcontagem', indicadores_comparativos='$c_chkcomparativo',
        custos_ocorrencias='$c_chkcustoindividual', custos_comparativos='$c_chkcomparativocustos', cadastros_tipos='$c_chktipo',
        obras='$c_chkobras', servicos_agenda='$c_chkagendaexecutores', cadastros_prestadores='$c_chkprestadoresdeservico',
        gera_os='$c_chkgera_os'
        where id='$c_id'";
        //echo $c_sql;
        $result = $conection->query($c_sql);
        // verifico se a query foi correto
        if (!$result) {
            die("Erro ao Executar Sql!!" . $conection->connect_error);
        }
        // fim de gravação
        $msg_gravou = "Dados Gravados com Sucesso!!";
        header('location: /gop/cadastros/usuarios/usuarios_perfil_lista.php');
    } while (false);
}
?>

<!-- formulário de edição dos perfis -->


<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gop/css/basico.css">
    <title>GOP - Editar Perfil de Usuário</title>
</header>

<body>

    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>GOP - Gestão Operacional</h4>
            <h5>Editar Perfil para Usuários do Sistema<h5>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <?php
        if (!empty($msg_erro)) {
            echo "
            <div class='alert alert-danger' role='alert'>
                <h4>$msg_erro</h4>
            </div>
                ";
        }
        ?>
        <!-- Definição das tabs  -->
        <div class="container content-box">
            <div class='alert alert-info' role='alert'>
                <div style="padding-left:15px;">
                    <img Align="left" src="\gop\images\escrita.png" alt="30" height="35">

                </div>
                <h5>Campos com (*) são obrigatórios</h5>
            </div>
            <form method="post">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#descricao" aria-controls="home" role="tab" data-toggle="tab">Descrição</a></li>
                    <li role="presentation"><a href="#cadastro" aria-controls="cadastro" role="tab" data-toggle="tab">Cadastros</a></li>
                    <li role="presentation"><a href="#servico" aria-controls="servico" role="tab" data-toggle="tab">Serviços</a></li>
                    <li role="presentation"><a href="#almoxarifado" aria-controls="almoxarifado" role="tab" data-toggle="tab">Almoxarifado</a></li>
                    <li role="presentation"><a href="#indicadores" aria-controls="indicadores" role="tab" data-toggle="tab">Indicadores</a></li>
                    <li role="presentation"><a href="#custo" aria-controls="custo" role="tab" data-toggle="tab">Custos da Manutenção</a></li>
                    <li role="presentation"><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Outros</a></li>
                </ul>
                <div class="tab-content">
                    <!-- aba de descrição -->
                    <div role="tabpanel" class="tab-pane active" id="descricao">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-2">
                                    <div style="padding-left:20px;">
                                        <label class="form-check-label col-form-label">Perfil Ativo</label>
                                        <div class="col-sm-3">
                                            <input class="form-check-input" type="checkbox" value="S" name="chkativo" id="chkativo" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="mb-3 row">
                                <label for="add_descricaoField" class="col-md-2 form-label">Descrição do Perfil (*)</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="up_descricaoField" name="up_descricaoField" required Value="<?php echo $c_descricao; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cadastro">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Recursos Físicos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkrecursosfisicos" id="chkrecursosfisicos" <?php echo $c_chkrecursosfisicos ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Espaços Físicos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkespacosfisicos" id="chkespacosfisicos" <?php echo $c_chkespacosfisicos ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Fornecedores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkfornecedores" id="chkfornecedores" <?php echo $c_chkfornecedores ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Fabricantes</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkfabricantes" id="chkfabricantes" <?php echo $c_chkfabricantes ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Executores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkexecutores" id="chkexecutores" <?php echo $c_chkexecutores ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Prestadores de Serviço</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkprestadoresdeservico" id="chkprestadoresdeservico" <?php echo $c_chkprestadoresdeservico ?>>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Cargos e Funções</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkfcargosfuncoes" id="chkcargosfuncoes" <?php echo $c_chkfcargosfuncoes ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Oficinas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkoficinas" id="chkoficinas" <?php echo $c_chkoficinas ?>>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Centros de Custo</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcentrosdecusto" id="chkcentrosdecusto" <?php echo $c_chkcentrosdecusto ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Setores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chksetores" id="chksetores" <?php echo $c_chksetores ?>>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Ferramentas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkferramentas" id="chkferramentas" <?php echo $c_chkferramentas ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Marcas de Recursos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkmarcasrecursos" id="chkmarcasrecursos" <?php echo $c_chkmarcasrecursos ?>>
                                    </div>

                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Tipos de Recursos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chktipo" id="chktipo" <?php echo $c_chktipo ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">CheckList</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkchecklist" id="chkchecklist" <?php echo $c_chkchecklist ?>>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Unidades e Medidas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkunidades" id="chkunidades" <?php echo $c_chkunidades ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="servico">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Solicitações de Serviço</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chksolicitacoes" id="chksolicitacoes" <?php echo $c_chksolicitacoes ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Ordens de Serviços</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkordens" id="chkordens" <?php echo $c_chkordens ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Preventivas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpreventivas" id="chkpreventivas" <?php echo $c_chkpreventivas ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Ocorrencias Padrões</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkocorrencias" id="chkocorrencias" <?php echo $c_chkocorrencias ?>>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Agenda de Executores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkagendaexecutores" id="chkagendaexecutores" <?php echo $c_chkagendaexecutores ?>>
                                    </div>
                                </div>
                                 <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Gerar Ordem de Serviço</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkgera_os" id="chkgera_os" <?php echo $c_chkgera_os ?>>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="almoxarifado">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Cotações</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcotacao" id="chkcotacao" <?php echo $c_chkcotacao ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Pedidos de Compra</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpedidodecompra" id="chkpedidodecompra" <?php echo $c_chkpedidodecompra ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Cadastro de Materiais</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkmateriais" id="chkmateriais" <?php echo $c_chkmateriais ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Grupos de Materiais</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkgruposrecursos" id="chkgruposrecursos" <?php echo $c_chkgruposrecursos ?>>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="indicadores">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Contagem de Ocorrências</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcontagem" id="chkcontagem" <?php echo $c_chkcontagem ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Comparativos de Ocorrências</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcomparativo" id="chkcomparativo" <?php echo $c_chkcomparativo ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="custo">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Custos individuais da Manutenção</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcustoindividual" id="chkcustoindividual" <?php echo $c_chkcustoindividual ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Comparativos de Custos</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcomparativocustos" id="chkcomparativocustos" <?php echo $c_chkcomparativocustos ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="outros">
                        <div style="padding-top:20px;">
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Planos de Ação</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkplanosacao" id="chkplanoacao" <?php echo $c_chkplanoacao ?>>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">POP</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpop" id="chkpop" <?php echo $c_chkpop ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-check col-sm-4">
                                <label class="form-check-label col-form-label">Custos de Obras</label>
                                <div class="col-sm-2">
                                    <input class="form-check-input" type="checkbox" value="S" name="chkobras" id="chkobras" <?php echo $c_chkobras ?>>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <hr>
                <div class="row mb-3">
                    <div class="offset-sm-0 col-sm-3">
                        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-saved'></span> Salvar</button>
                        <a class='btn btn-danger' href='/gop/cadastros/usuarios/usuarios_perfil_lista.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</body>


</html>