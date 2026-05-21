<?php
include("../conexao.php");

if (isset($_GET['id'])) {
    // verifico via sql se a pessoa tem atividades realizadas associadas
    // se tiver, não permito a exclusão e exibo uma mensagem de erro
    $id = $_GET['id'];
    $check_sql = "SELECT * FROM participamentes_atividade WHERE id_participante = $id";
    $check_result = $conection->query($check_sql);
    if ($check_result->num_rows > 0) {
        // mensagem de erro          
        echo "<script>alert('Não é possível excluir este beneficiário, pois ele tem atividades realizadas associadas.');</script>";
        exit();
    }
    // verifico via sql se a pessoa tem dependentes associadas
    // se tiver, não permito a exclusão e exibo uma mensagem de erro
    $check_sql_dependentes = "SELECT * FROM dependentes WHERE id_pessoa = $id";
    $check_result_dependentes = $conection->query($check_sql_dependentes);  
    if ($check_result_dependentes->num_rows > 0) {
        // mensagem de erro          
        echo "<script>alert('Não é possível excluir este beneficiário, pois ele tem dependentes associados.');</script>";
        exit();
    }
    // verifico via sql se a pessoa tem ações participadas associadas
    // se tiver, não permito a exclusão e exibo uma mensagem de erro
    $check_sql_acoes = "SELECT * FROM participantes_acoes WHERE id_participante = $id";
    $check_result_acoes = $conection->query($check_sql_acoes);

    if ($check_result_acoes->num_rows > 0) {
        // mensagem de erro          
        echo "<script>alert('Não é possível excluir este beneficiário, pois ele tem ações participadas associadas.');</script>";
        exit();
    }

    $id = $_GET['id'];
    $sql = "DELETE FROM cadastro WHERE id = $id";

    if ($conection->query($sql) === TRUE) {
        header("Location: pessoas_lista.php");
        exit();
    } else {
        echo "Erro ao excluir registro: " . $conection->error;
    }
} else {
    echo "ID não especificado.";
}
