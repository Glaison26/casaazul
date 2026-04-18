<?php
include("../conexao.php");

if (isset($_GET['id'])) {
    // verifico via sql se o instrutor tem atividades realizadas associadas
    // se tiver, não permito a exclusão e exibo uma mensagem de erro
    $id = $_GET['id'];
    $check_sql = "SELECT * FROM atividades_realizadas WHERE id_instrutor = $id";
    $check_result = $conection->query($check_sql);
    if ($check_result->num_rows > 0) {
        // mensagem de erro          
        echo "<script>alert('Não é possível excluir este instrutor, pois ele tem atividades realizadas associadas.');</script>";
        exit();
    }

    $id = $_GET['id'];

    $sql = "DELETE FROM instrutores WHERE id = $id";

    if ($conection->query($sql) === TRUE) {
        header("Location: instrutores_lista.php");
        exit();
    } else {
        echo "Erro ao excluir registro: " . $conection->error;
    }
} else {
    echo "ID não especificado.";
}
