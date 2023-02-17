<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");
$idusuario= $_POST['idusuario'];
$iddepartamento = $_POST['iddepartamento'];
$dp = new Departamento($pdo);
$upUse = $dp->dpGerencia($idusuario, $iddepartamento);
echo true;