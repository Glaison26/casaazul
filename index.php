<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $l_erro = '';
} else {
    session_start();
    include("conexao.php");
    
    $c_login = $_POST['usuario'];
    $c_sql = "SELECT count(*) as achou FROM usuarios where usuarios.login='$c_login'";
    $result = $conection->query($c_sql);
    // verifico se a query foi correto
    if (!$result) {
        die("Erro ao Executar Sql !!" . $conection->connect_error);
    }
    $c_linha = $result->fetch_assoc();
    //if ($c_login == 'Glaison') {
    //    $_SESSION["newsession"] = "gop";
    //    $_SESSION["id_usuario"] = 16;

    //    $_SESSION['c_usuario'] = $c_login;
    //    $_SESSION['tipo'] = 'Administrador';
    //    header('location: /casaazul/menu.php');
    //}
    if ($c_linha['achou'] == 0) {
        $l_erro = ' Nome ou senha inválido. Tente novamente!';
    } else {
        // procuro senha
        $c_sql = "SELECT usuarios.id,usuarios.senha, usuarios.tipo FROM usuarios where usuarios.login='$c_login'";
        $result = $conection->query($c_sql);
        $registro = $result->fetch_assoc();
        $c_senha = base64_decode($registro['senha']);
        if ($c_senha != $_POST['senha']) {
            $l_erro = 'Nome ou senha inválido, Verifique e tente novamente !!!';
        } else {
            $l_erro = ' ';
            $_SESSION["newsession"] = "gop";
            $_SESSION["id_usuario"] = $registro['id'];
            $_SESSION['c_usuario'] = $c_login;
            $_SESSION['tipo'] = $registro['tipo'];
            header('location: /casaazul/menu.php');
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="imagex/png" href="./imagens/casaazul.ico">
    <title>Login - Casa Azul</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
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

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="imagens/casaazul.jpg" alt="Casa Azul">
        </div>
        
        <h1>Login</h1>
        <?php if ($l_erro != '') { ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <?php echo $l_erro; ?>
            </div>
        <?php } ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" id="mostrarSenha" onchange="toggleSenha()">
                    Mostrar senha
                </label>
            </div>
            
            <script>
                function toggleSenha() {
                    const senhaInput = document.getElementById('senha');
                    const checkbox = document.getElementById('mostrarSenha');
                    senhaInput.type = checkbox.checked ? 'text' : 'password';
                }
            </script>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>