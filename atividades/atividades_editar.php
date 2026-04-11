<?php
session_start();
include("../conexao.php");
include("../links.php");

$erro = null;

$id = $_GET['id'] ?? null;

if ($id) {
   // leitura do paciente através de sql usando id passada
    $c_sql = "select * from atividades_realizadas where id=$id";
    $result = $conection->query($c_sql);
    $registro = $result->fetch_assoc();

    if (!$registro) {
        header('location: /casaazul/atividades/atividades_lista.php');
        exit;
    }
    
  
    // variaveis para preencher os campos do formulário
    $c_atividade = $registro['id_curso'] ?? '';
    $c_instrutor = $registro['id_instrutor'] ?? '';
    $c_num_vagas = $registro['num_vagas'] ?? '';
    $c_carga_horaria = $registro['carga_horaria'] ?? '';
    $c_observacao = $registro['observacao'] ?? '';
    // pego as datas do banco de dados e converto para o formato do input date
    $c_data_inicio = isset($registro['data_inicio']) ? date('Y-m-d', strtotime($registro['data_inicio'])) : '';
    $c_data_final = isset($registro['data_final']) ? date('Y-m-d', strtotime($registro['data_final'])) : '';
       

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // rotina para atualizar os dados da atividade
    $c_atividade = $_POST['up_atividadeField'];
    $c_data_inicio = $_POST['up_data_inicioField'];
    $c_data_final = $_POST['up_data_finalField'];
    $c_num_vagas = $_POST['up_num_vagasField'];
    $c_carga_horaria = $_POST['up_carga_horariaField'];
    $c_instrutor = $_POST['up_instrutorField'];
    $c_observacao = $_POST['up_observacaoField'];
    $c_sql = "UPDATE atividades_realizadas SET id_curso='$c_atividade', data_inicio='$c_data_inicio',
         data_final='$c_data_final', num_vagas='$c_num_vagas', carga_horaria='$c_carga_horaria',
         id_instrutor='$c_instrutor', observacao='$c_observacao'
         WHERE id=$id";

    // fecha o banco de dados e volta para a lista de pessoas
    if ($conection->query($c_sql) === TRUE) {
        header('location: /casaazul/atividades/atividades_lista.php');
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

   
</head>

<body>
    <div class="container-fluid">
        <div style="padding-top:5px;">
            <div class="panel panel-primary class">
                <div class="panel-heading text-center">
                    <h4>Gestão - Caso Azul</h4>
                    <h5>Editar Atividade Cadastrada<h5>
                </div>
            </div>
        </div>
        <div class="container content-box">

            <form method="POST" action="">
                <hr>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Atividade (*)</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-lg" name="up_atividadeField" id="up_atividadeField" required>
                            <option value="">Selecione a Atividade</option>
                            <?php
                            $c_sql_atividade = "SELECT ID, DESCRICAO FROM cursos ORDER BY DESCRICAO";
                            $result_atividade = $conection->query($c_sql_atividade);
                            while ($c_linha_atividade = $result_atividade->fetch_assoc()) {
                                $selected = ($c_linha_atividade['ID'] == $c_atividade) ? 'selected' : '';
                                echo "<option value='$c_linha_atividade[ID]' $selected>$c_linha_atividade[DESCRICAO]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Data Início (*)</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="up_data_inicioField" id="up_data_inicioField" value="<?php echo htmlspecialchars($c_data_inicio); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Data Final (*)</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="up_data_finalField" id="up_data_finalField" value="<?php echo htmlspecialchars($c_data_final); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Número de Vagas (*)</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="up_num_vagasField" id="up_num_vagasField" value="<?php echo htmlspecialchars($c_num_vagas); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Carga Horária (*)</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="up_carga_horariaField" id="up_carga_horariaField" value="<?php echo htmlspecialchars($c_carga_horaria); ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Instrutor (*)</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-lg" name="up_instrutorField" id="up_instrutorField" required>
                            <option value="">Selecione o Instrutor</option>
                            <?php
                            $c_sql_instrutor = "SELECT ID, NOME FROM instrutores ORDER BY NOME";
                            $result_instrutor = $conection->query($c_sql_instrutor);
                            while ($c_linha_instrutor = $result_instrutor->fetch_assoc()) {
                                $selected = ($c_linha_instrutor['ID'] == $c_instrutor) ? 'selected' : '';
                                echo "<option value='$c_linha_instrutor[ID]' $selected>$c_linha_instrutor[NOME]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class ="row mb-3">
                    <label class= "col-sm-4 col-form-label">Observação</label>
                    <div class= "col-sm-8">
                        <textarea class= "form-control" name= "up_observacaoField" id= "up_observacaoField" rows= "6"><?php echo htmlspecialchars($c_observacao); ?></textarea>
                    </div>
                </div>

                <div class ="row mb-3">
                    <div class= "offset-sm-0 col-sm-3">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Salvar</button>
                        <a class="btn btn-danger" href="/casaazul/atividades/atividades_lista.php"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>

                    </div>
                </div>


            </form>
        </div>
    </div>
</body>

</html>