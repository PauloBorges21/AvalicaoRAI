<?php
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php");
$q = new Questionario($pdo);

$usuario = $_POST['iduser'];
$questionario = $_POST['qs'];

$q->finalizaQuestionario1($usuario, $questionario);


echo 'true';

