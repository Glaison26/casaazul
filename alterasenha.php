<?php
session_start();
// conexão com banco de dados
include("conexao.php");


$msg_erro = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c_senhaatual = $_POST['senha_atual'];
    $c_senhanova = $_POST['senha_nova'];
    $c_senhaconfirma = $_POST['confirmar_senha'];
    do {
        $c_login = $_SESSION['c_usuario'];
        $c_sql = "SELECT usuarios.senha, usuarios.id FROM usuarios where usuarios.login='$c_login'";
        $result = $conection->query($c_sql);
        $registro = $result->fetch_assoc();
        $c_senhaatual = base64_decode($registro['senha']);
        $i_tamsenha = strlen($c_senhanova);
        // consitencias de senha
        if ($c_senhaatual != $_POST['senha_atual']) {
            $msg_erro = "Senha Atual Inválida!!";
            break;
        }
        if (($i_tamsenha < 8) || ($i_tamsenha > 32)) {
            $msg_erro = "Campo Senha nova deve ter no mínimo 8 caracteres e no máximo 32 caracteres!!";
            break;
        }

        if ($c_senhanova != $c_senhaconfirma) {
            $msg_erro = "Campo Senha diferente de senha de confirmação!!";
            break;
        }
        // consiste se senha tem pelo menos 1 caracter numérico
        if (filter_var($c_senhanova, FILTER_SANITIZE_NUMBER_INT) == '') {
            $msg_erro = "Campo Senha deve ter pelo menos (1) caracter numérico";
            break;
        }
        if (ctype_digit($c_senhanova)) {
            $msg_erro = "Campo Senha deve conter pelo menos uma letra do Alfabeto";
            break;
        }
        // criptografo a senha digitada
        $c_senhanova = base64_encode($c_senhanova);
        // grava dados no banco
        $c_id = $registro['id'];
        // faço a Leitura da tabela com sql

        $c_sql = "Update usuarios SET usuarios.senha ='$c_senhanova' where id=$c_id";
        $result = $conection->query($c_sql);
        // verifico se a query foi correto
        if (!$result) {
            die("Erro ao Executar Sql!!" . $conection->connect_error);
        }
        $success = "Senha foi alterada com sucesso!!!";
        // header('location: /menu.php');
    } while (false);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5568d3;
        }

        .link-back {
            text-align: center;
            margin-top: 20px;
        }

        .link-back a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }

        .link-back a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Alterar Senha</h1>

        <?php if ($msg_erro): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($msg_erro); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="senha_atual">Senha Atual:</label>
                <input type="password" id="senha_atual" name="senha_atual" required>
            </div>

            <div class="form-group">
                <label for="senha_nova">Nova Senha:</label>
                <input type="password" id="senha_nova" name="senha_nova" required>
            </div>

            <div class="form-group">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>

            <button type="submit">Alterar Senha</button>
        </form>

        <div class="link-back">
            <a href="menu.php">Voltar ao Menu</a>
        </div>
    </div>
</body>

</html>