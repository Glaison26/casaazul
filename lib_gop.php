<?php
// função para validação de cnpj
function valida_cnpj($cnpj)
{
    // Deixa o CNPJ com apenas números
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    // Garante que o CNPJ é uma string
    $cnpj = (string)$cnpj;

    // O valor original
    $cnpj_original = $cnpj;

    // Captura os primeiros 12 números do CNPJ
    $primeiros_numeros_cnpj = substr($cnpj, 0, 12);

    /**
     * Multiplicação do CNPJ
     *
     * @param string $cnpj Os digitos do CNPJ
     * @param int $posicoes A posição que vai iniciar a regressão
     * @return int O
     *
     */
    if (! function_exists('multiplica_cnpj')) {
        function multiplica_cnpj($cnpj, $posicao = 5)
        {
            // Variável para o cálculo
            $calculo = 0;

            // Laço para percorrer os item do cnpj
            for ($i = 0; $i < strlen($cnpj); $i++) {
                // Cálculo mais posição do CNPJ * a posição
                $calculo = $calculo + ($cnpj[$i] * $posicao);

                // Decrementa a posição a cada volta do laço
                $posicao--;

                // Se a posição for menor que 2, ela se torna 9
                if ($posicao < 2) {
                    $posicao = 9;
                }
            }
            // Retorna o cálculo
            return $calculo;
        }
    }

    // Faz o primeiro cálculo
    $primeiro_calculo = multiplica_cnpj($primeiros_numeros_cnpj);

    // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
    // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
    $primeiro_digito = ($primeiro_calculo % 11) < 2 ? 0 :  11 - ($primeiro_calculo % 11);

    // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
    // Agora temos 13 números aqui
    $primeiros_numeros_cnpj .= $primeiro_digito;

    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    $segundo_calculo = multiplica_cnpj($primeiros_numeros_cnpj, 6);
    $segundo_digito = ($segundo_calculo % 11) < 2 ? 0 :  11 - ($segundo_calculo % 11);

    // Concatena o segundo dígito ao CNPJ
    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;

    // Verifica se o CNPJ gerado é idêntico ao enviado
    if ($cnpj === $cnpj_original) {
        return true;
    }
}

// função de validação de cpf
function validaCPF($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

// função para colocar mascaras

function mask($val, $mask)
{
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function gravaData($data)
{

    if ($data != '') {

        return (substr($data, 3, 2) . '/' . substr($data, 0, 2) . '/' . substr($data, 6, 4));
    } else {
        return '';
    }
}

function mes_extenso($mes)
{
    // tabela de meses
    if ($mes == '1')
        $c_mes = 'Janeiro';
    if ($mes == '2')
        $c_mes = 'Fevereiro';

    if ($mes == '3')
        $c_mes = 'Março';

    if ($mes == '4')
        $c_mes = 'Abril';

    if ($mes == '5')
        $c_mes = 'Maio';

    if ($mes == '6')
        $c_mes = 'Junho';

    if ($mes == '7')
        $c_mes = 'Julho';

    if ($mes == '8')
        $c_mes = 'Agosto';

    if ($mes == '9')
        $c_mes = 'Setembro';

    if ($mes == '10')
        $c_mes = 'Outubro';

    if ($mes == '11')
        $c_mes = 'Novembro';

    if ($mes == '12')
        $c_mes = 'Dezembro';
    return $c_mes;
}
