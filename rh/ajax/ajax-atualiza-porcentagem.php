<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$perguntas = new Perguntas($pdo);
$resposta = new Respostas($pdo);
$q = new Questionario($pdo);

$resultado = $_POST['objCompleto'];
//$questionario = $_POST['q'];
$dados = json_decode($resultado, true);
//var_dump($dados['objres']);

// $perguntasTotal = $perguntas->getTotalPerguntas(1);
// $totalRespodido = $perguntas->getVerificaRespondido($usuario, $questionario);
// foreach ($dados as $itens) :

// echo $itens;
//  echo '</br>'   ;

//  //$porcentagem = $perguntas->porcentagem($perguntasTotal,$totalRespodido['TOTAL']);
// // // $dados  = json_decode($obj, true);
// endforeach;
$array = [];
foreach ($dados['objres'] as $keyRes => $itensRes): foreach ($dados['objfunc'] as $keyFunc => $itensFunc):
        if ($keyRes == $keyFunc) {
            $porcentagem = $perguntas->porcentagem($itensFunc, $itensRes);
            $found_keyC = in_array($keyFunc, $array);
            if (!$found_keyC) {
                $novoArray = [
                    'idDP' => $keyFunc,
                    'porcentagem' => $porcentagem
                ];

                array_push($array, $novoArray);
            }

        }


    endforeach;
endforeach;
//var_dump($array);
//echo (json_encode($porcentagem));
echo (json_encode($array));