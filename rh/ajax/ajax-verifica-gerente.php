<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");

$idSetor = $_POST['setor'];

$f = new Funcionario($pdo);

$check = $f->validarCampoUnico($idSetor);

if ($check > 0) {
    echo 'false';
} else {
    echo 'true';
}
