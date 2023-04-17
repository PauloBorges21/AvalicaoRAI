<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$ativo = filter_input(INPUT_POST, 'ativo', FILTER_VALIDATE_BOOLEAN);
$paginador = new Paginacao($pdo);
$tableU = $paginador->getPagtbUserName($nome,$ativo);
echo (json_encode($tableU));



