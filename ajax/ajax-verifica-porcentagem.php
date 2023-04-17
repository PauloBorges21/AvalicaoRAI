<?php
spl_autoload_register(/**
 * @param $class
 */ function ($class) {
    require '../classes/' . $class . '.php';
});
require_once("../config.php");

$perguntas = new Perguntas($pdo);
$resposta = new Respostas($pdo);
$avaliacao = new Avaliacao($pdo);


$q = new Questionario($pdo);
$usuario = $_POST['iduser'];
$questionario = $_POST['qs'];
$boolean = $_POST['boolean'];
$a = $avaliacao->getAvaliacao();
$idAv = $a['id'];

$perguntasTotal = $perguntas->getTotalPerguntas(1,$idAv);
$totalRespodido = $perguntas->getVerificaRespondido($usuario, $questionario,$idAv);
$porcentagem = $perguntas->porcentagem($perguntasTotal,$totalRespodido['TOTAL']);
// $dados  = json_decode($obj, true);
if($boolean){
    $arr = [$totalRespodido,$porcentagem];
    echo (json_encode($arr));
}else{
    echo (json_encode($porcentagem));
}

