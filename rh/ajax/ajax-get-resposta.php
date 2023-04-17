<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");


//$usu = $_POST['usuario'];
$questionario = filter_input(INPUT_POST, 'questionario', FILTER_SANITIZE_STRING);

$r = new Respostas($pdo);

$resposta = $r->getRespostaQ();
$resposta2 = $r->getRespostaQ2();

if($questionario == 1)
{
    echo json_encode($resposta);
} else {
    echo json_encode($resposta2);
}

