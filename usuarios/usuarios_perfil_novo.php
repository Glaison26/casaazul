<?php
// controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}

include('../../conexao.php');
include('../../links2.php');
include_once "../../lib_gop.php";

$c_descricao = "";


// variaveis para mensagens de erro e suscessso da gravação
$msg_gravou = "";
$msg_erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    do {
        $c_descricao = $_POST['add_descricaoField'];
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
        // prestadores de serviço
        if (isset($_POST['chkprestadoresdeservico'])) {
            $c_chkprestadoresdeservico = 'S';
        } else {
            $c_chkprestadoresdeservico = 'N';
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
        if (isset($_POST['chkchecklist'])) {
            $c_chkchecklist = 'S';
        } else {
            $c_chkchecklist = 'N';
        }
        //
        if (isset($_POST['chktipo'])) {
            $c_chktipo = 'S';
        } else {
            $c_chktipo = 'N';
        }
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
        // serviços agenda de executores
        if (isset($_POST['chkagendaexecutores'])) {
            $c_chkagendaexecutores = 'S';
        } else {
            $c_chkagendaexecutores = 'N';
        }
        // gerar ordens de serviços
        if (isset($_POST['chkgera_os'])) {
            $c_chkgera_os = 'S';
        } else {
            $c_chkgera_os = 'N';
        }
        // grava dados no banco

        // faço a Leitura da tabela com sql
        $c_sql = "INSERT INTO perfil_usuarios (descricao,cadastros_recursosfisicos, cadastros_espacosfisicos, cadastros_fornecedores,
        cadastros_fabricantes, cadastros_executores,  cadastros_cargosfuncoes,cadastros_oficinas, cadastro_centrosdecusto,
        cadastros_setores, cadastros_ferramentas, cadastros_grupos, cadastros_marcas, cadastros_pop, cadastros_checklist,
        servicos_solicitacoes, servicos_ordens,servicos_preventivas,servicos_ocorrencias_padroes,servicos_plano_acao,
        almoxarifado_cotacoes, almoxarifado_pedidodecompra, almoxarifado_materiais, almoxarifado_unidadesmedidas,
        indicadores_ocorrencias, indicadores_comparativos, custos_ocorrencias, custos_comparativos, cadastros_tipos,
         obras, cadastros_prestadores, servicos_agenda,gera_os) value
        ('$c_descricao','$c_chkrecursosfisicos', '$c_chkespacosfisicos', '$c_chkfornecedores', '$c_chkfabricantes',
        '$c_chkexecutores', '$c_chkexecutores', '$c_chkfcargosfuncoes', '$c_chkoficinas', '$c_chkcentrosdecusto', '$c_chksetores',
        '$c_chkferramentas', '$c_chkgruposrecursos', '$c_chkmarcasrecursos','$c_chkpop', '$c_chksolicitacoes', '$c_chkordens',
        '$c_chkpreventivas', '$c_chkocorrencias', '$c_chkplanoacao','$c_chkcotacao','$c_chkpedidodecompra','$c_chkmateriais', '$c_chkunidades',
        '$c_chkcontagem', '$c_chkcomparativo', '$c_chkcustoindividual', '$c_chkcomparativocustos', '$c_chktipo', '$c_chkobras',
         '$c_chkprestadoresdeservico', '$c_chkagendaexecutores', '$c_chkgera_os')";

        $result = $conection->query($c_sql);
        // verifico se a query foi correto
        if (!$result) {
            die("Erro ao Executar Sql!!" . $conection->connect_error);
        }


        $msg_gravou = "Dados Gravados com Sucesso!!";

        header('location: /gop/cadastros/usuarios/usuarios_perfil_lista.php');
    } while (false);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gop/css/basico.css">
    <title>GOP - Novo Perfil de Usuário</title>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#cpf").mask("999.999.999-99");
        });
    </script>

</head>

<div class="container-fluid">
    <div style="padding-top:5px;">
        <div class="panel panel-primary class">
            <div class="panel-heading text-center">
                <h4>GOP - Gestão Operacional</h4>
                <h5>Novo perfil para Usuários do Sistema<h5>
            </div>
        </div>
    </div>

    <body>
        <br>

        <div class="container content-box">
            <?php
            if (!empty($msg_erro)) {
                echo "
            <div class='alert alert-warning' role='alert'>
                <div style='padding-left:15px;'>
                    
                </div>
                <h4><img Align='left' src='\gop\images\aviso.png' alt='30' height='35'> $msg_erro</h4>
            </div>
            ";
            }
            ?>

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
                                    <input type="text" class="form-control" id="add_descricaoField" name="add_descricaoField" required Value="<?php echo $c_descricao; ?>">
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
                                        <input class="form-check-input" type="checkbox" value="S" name="chkrecursosfisicos" id="chkrecursosfisicos" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Espaços Físicos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkespacosfisicos" id="chkespacosfisicos" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Fornecedores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkfornecedores" id="chkfornecedores" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Fabricantes</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkfabricantes" id="chkfabricantes" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Executores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkexecutores" id="chkexecutores" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Prestadores de Serviço</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkprestadoresdeservico" id="chkprestadoresdeservico" checked>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Cargos e Funções</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkfcargosfuncoes" id="chkfcargosfuncoes" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Oficinas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkoficinas" id="chkoficinas" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Centros de Custo</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcentrosdecusto" id="chkcentrosdecusto" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Setores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chksetores" id="chksetores" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Ferramentas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkferramentas" id="chkferramentas" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Marcas de Recursos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkmarcasrecursos" id="chkmarcasrecursos" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">


                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Tipos de Recursos</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chktipo" id="chktipo" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">CheckList</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkchecklist" id="chkchecklist" checked>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Unidades e Medidas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkunidades" id="chkunidades" checked>
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
                                        <input class="form-check-input" type="checkbox" value="S" name="chksolicitacoes" id="chksolicitacoes" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Ordens de Serviços</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkordens" id="chkordens" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Preventivas</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpreventivas" id="chkpreventivas" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Ocorrencias Padrões</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkocorrencias" id="chkocorrencias" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Agenda de Executores</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkagendaexecutores" id="chkagendaexecutores" checked>
                                    </div>
                                </div>
                                 <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Gerar Ordem de Serviço</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkgera_os" id="chkgera_os" checked>
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
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcotacao" id="chkcotacao" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Pedidos de Compra</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpedidodecompra" id="chkpedidodecompra" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Cadastro de Materiais</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkmateriais" id="chkmateriais" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">Grupos de Materiais</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkgruposrecursos" id="chkgruposrecursos" checked>
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
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcontagem" id="chkcontagem" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Comparativos de Ocorrências</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcomparativo" id="chkcomparativo" checked>
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
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcustoindividual" id="chkcustoindividual" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Comparativos de Custos</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkcomparativocustos" id="chkcomparativocustos" checked>
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
                                        <input class="form-check-input" type="checkbox" value="S" name="chkplanosacao" id="chkplanoacao" checked>
                                    </div>
                                </div>
                                <div class="form-check col-sm-3">
                                    <label class="form-check-label col-form-label">POP</label>
                                    <div class="col-sm-3">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpop" id="chkpop" checked>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="form-check col-sm-4">
                                    <label class="form-check-label col-form-label">Custos de Obras</label>
                                    <div class="col-sm-2">
                                        <input class="form-check-input" type="checkbox" value="S" name="chkpbras" id="chkobras" checked>
                                    </div>
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
    </body>
</div>


</div>

</html>