<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");

$dp= filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$departamento = new Departamento($pdo);

$d = $departamento->gravarDepartamento($dp);

echo 'true';

