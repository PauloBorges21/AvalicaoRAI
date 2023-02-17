<?php
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php");

$obj = $_POST['dados'];
$questionario = $_POST['q'];
$q = new Questionario($pdo);
$dados  = json_decode($obj, true);

$usuario = $dados['hash-rai'];

if($questionario =='2'){
    $q->finalizaQuestionario1($usuario, $questionario);
    // for ($i = 1; $i <= count($dados); $i++) {

    //     if (!empty($dados["idPergunta-$i"]) && !empty($dados["optionsVA-$i"])) {

    //         $q->finalizaQuestionario($usuario, $dados["idPergunta-$i"], $dados["optionsVA-$i"], $questionario, 3);

    //     }
    // }

    echo 'true';
}


