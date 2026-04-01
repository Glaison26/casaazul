<?php
// controle de acesso ao formulário
session_start();
if (!isset($_SESSION['newsession'])) {
    die('Acesso não autorizado!!!');
}
include('conexao.php');

date_default_timezone_set('America/Sao_Paulo');
$agora = date('d/m/Y H:i');
$c_data = date('Y-m-d');

?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão de Manutenção</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" type="imagex/png" href="./imagens/img_gop.ico">
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>


<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar resposiva -->
    <nav class="bg-blue-800 p-4 shadow-lg" responsive-navbar>
         <div class="container mx-auto mt-2 text-white">
        <p>Bem-vindo, <span class="font-bold"><?php echo $_SESSION['c_usuario']; ?></span>! Hoje é <?php echo date('d/m/Y'); ?>, <?php echo date('H:i'); ?> horas.</p>
    </div>

        <br>
        <div class="container mx-auto flex items-center justify-between">
             <div class="text-white font-bold text-xl">
                 Casa Azul - Sistema Gerencial 
            </div>

            <div class="hidden md:flex items-center space-x-6">


                <!-- Dropdown Cadastro -->


                <div class="relative dropdown">
                    <button class="text-white hover:text-blue-200 transition flex items-center focus:outline-none">
                        Cadastros <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="dropdown-menu absolute hidden bg-white text-gray-800 pt-2 shadow-xl rounded-md w-48 z-50">
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="/casaazul/pessoas/pessoas_lista.php">Pessoas Físicas</a>
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="#">Agenda de Atividades</a>
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="#">Agenda de Ações</a>
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="#">Cadastro de Cursos</a>
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="#">Cadastro de Instrutores</a>
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="#">Tipo de Ações</a>

                    </div>
                </div>


                <!-- Relatórios -->


                <div class="relative dropdown">
                    <button class="text-white hover:text-blue-200 transition flex items-center focus:outline-none">
                        Relatórios <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="dropdown-menu absolute hidden bg-white text-gray-800 pt-2 shadow-xl rounded-md w-48 z-50">
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="#">Atividades</a>


                    </div>
                </div>

                <!-- configurações -->
                <?php
                if ($_SESSION['tipo'] == 'Administrador') {
                    echo '
                <div class="relative dropdown">
                    <button class="text-white hover:text-blue-200 transition flex items-center focus:outline-none">
                        Configurações <i class="fas fa-chevron-down ml-1 text-xs"></i>  
                    </button>
                    <div class="dropdown-menu absolute hidden bg-white text-gray-800 pt-2 shadow
                    rounded-md w-48 z-50">
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="/casaazul/usuarios/usuarios_lista.php">Usuários do Sistema</a>
                        
                       
                    </div>
                </div>';
                }
                ?>
                <!-- User Profile -->
                <div class="relative dropdown">
                    <button class="text-white hover:text-blue-200 transition flex items-center focus:outline-none">
                        <i class="fas fa-user-circle text-2xl"></i>
                    </button>
                    <div class="dropdown-menu absolute hidden bg-white text-gray-800 pt-2 shadow-xl rounded-md w-48 z-50 right-0">
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="/casaazul/alterasenha.php">Alterar Senha</a>
                        <a class="block px-4 py-2 hover:bg-blue-100 border-b border-gray-100" href="/casaazul/index.php">Sair</a>

                    </div>
                    <div class="md:hidden">
                        <button class="text-white focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </nav>
    <!-- subnav barra de navegação secundária com atalhos de solicitações e ordens -->
    <nav class="bg-blue-600 p-3 shadow-md">
        <div class="container mx-auto flex items-center space-x-6">
            <a href="/casaazul/pessoas/pessoas_lista.php" class="text-white hover:text-blue-200 transition flex items-center">
                <i class="fas fa-user-plus mr-2"></i>Pessoa Física
            </a>
            <a href="#" class="text-white hover:text-blue-200 transition flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>Atividades
            </a>
            <a href="#" class="text-white hover:text-blue-200 transition flex items-center">
                <i class="fas fa-tasks mr-2"></i>Ações
            </a>
        </div>
        <!--painel de boas vindas com data e hora e nome do usuário -->
    
   
    </nav>
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bem-vindo ao Sistema</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Visualização de Prescrições -->
                <div class="border-l-4 border-blue-800 pl-4">
                    <h3 class="text-xl font-bold text-blue-800 mb-3">
                        <i class="fas fa-user-plus mr-2"></i>Gerenciamento Cadastro de Pessoas Físicas
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Gerencie o cadastro de todas as pessoas físicas que utilizam os serviços de cultura, cursos e lazer oferecidos pela Casa Azul. 
                        Mantenha informações atualizadas de participantes, consulte históricos de participação em atividades e acompanhe o engajamento de cada usuário. 
                        O sistema oferece controle completo sobre registros pessoais, documentação e histórico de frequência em cursos e eventos culturais.
                    </p>
                </div>
                
                <!-- Inclusão de Prescrições -->
                <div class="border-l-4 border-blue-800 pl-4">
                    <h3 class="text-xl font-bold text-blue-800 mb-3">
                        <i class="fas fa-calendar-alt mr-2"></i>Agenda de Atividades e ações realizadas
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        Organize e acompanhe todas as atividades, cursos e ações comunitárias oferecidas pela Casa Azul. 
                        Crie cronogramas de eventos culturais, cursos de capacitação e atividades de lazer. 
                        Gerencie inscrições de participantes, controle de frequência e avaliação de desempenho. 
                        O sistema permite visualizar agendas, atribuir instrutores, definir tipos de ações e monitorar o sucesso de cada iniciativa. 
                        Mantenha um registro completo de todas as atividades realizadas e acompanhe o impacto social das ações comunitárias desenvolvidas pela instituição.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-20 py-6 text-center text-gray-500 text-sm">
        &copy; 2026 Casa Azul. Todos os direitos reservados.
    </footer>

</body>

</html>

<style>
    .body_btn {
        background-color: #0f1de7;
        color: #e7e2e2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container_btn {
        text-align: center;
        border: 2px solid #f0f3f7;
        padding: 30px;
        border-radius: 10px;
        background-color: #ffffff;
    }

    h1_btn {
        font-size: 48px;
        margin-bottom: 20px;
    }

    p_btn {
        font-size: 18px;
    }

    .btn-home_btn {
        margin-top: 20px;
    }

    .btn-home_btn a {
        text-decoration: none;
        color: #ffffff;
        background-color: #1640cc;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .btn-home_bnt a:hover {
        background-color: #123250;
    }
</style>