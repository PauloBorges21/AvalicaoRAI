<?php
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php");
$q = new Questionario($pdo);
$avaliacao = new Avaliacao($pdo);

$usuario = $_POST['iduser'];
$questionario = $_POST['qs'];

$a = $avaliacao->getAvaliacao();
$idAv = $a['id'];
$q->finalizaQuestionario1($usuario, $questionario,$idAv);
echo 'true';

