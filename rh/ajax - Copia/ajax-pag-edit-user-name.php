<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

$paginador = new Paginacao($pdo);
$tableU = $paginador->getPagtbUserName($nome);

echo (json_encode($tableU));



