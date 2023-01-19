<?php 
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php");

$perguntas = new Perguntas($pdo);
$resposta = new Respostas($pdo);
$q = new Questionario($pdo);

$usuario = $_POST['usuario'];
$questionario = $_POST['q'];

$perguntasTotal = $perguntas->getTotalPerguntas(1);
$totalRespodido = $perguntas->getVerificaRespondido($usuario, $questionario);
$porcentagem = $perguntas->porcentagem($perguntasTotal,$totalRespodido['TOTAL']);
// $dados  = json_decode($obj, true);


 $arr = [$totalRespodido,$porcentagem];


echo (json_encode($arr));


