<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");
$paginador = new Paginacao($pdo);

//$parametros = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
$departamento = filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_INT);

$tableU = $paginador->ordenarTbUser2($departamento);

