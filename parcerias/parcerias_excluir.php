<?php
// rotina para excluir uma parceria
include("../conexao.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // não deixo excluir uma parceria se o id estiver cadastrado na tabela de instrutores, para evitar inconsistências no banco de dados
    $check_sql = "SELECT * FROM instrutores WHERE id_parceria = $id";
    $result = $conection->query($check_sql);
    if ($result->num_rows > 0) {
        echo "<script>alert('Não é possível excluir esta parceria, pois ela está associada a um ou mais instrutores.'); window.location.href='/casaazul/parcerias/parcerias_lista.php';</script>";
        exit();
    }
    $d_sql = "DELETE FROM parcerias WHERE id = $id";
    
    if ($conection->query($d_sql) === TRUE) {
        echo "<script>alert('Parceria excluída com sucesso!'); window.location.href='/casaazul/parcerias/parcerias_lista.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir parceria: " . $conection->error . "');</script>";
    }
    // fecho a conexão com o banco de dados
    $conection->close();
} else {
    echo "<script>alert('ID da parceria não fornecido.'); window.location.href='/casaazul/parcerias/parcerias_lista.php';</script>";
}
?>