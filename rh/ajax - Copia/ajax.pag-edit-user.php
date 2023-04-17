<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");

$departamento = filter_input(INPUT_POST, 'departamento', FILTER_SANITIZE_NUMBER_INT);
if($departamento == 'Selecione')
{
    $departamento = '';
}

$paginador = new Paginacao($pdo);
$tableU = $paginador->getPagtbUser($departamento);

echo (json_encode($tableU));



