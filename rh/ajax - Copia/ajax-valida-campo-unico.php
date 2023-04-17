<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");

$cpf = $_POST['cpf'];

$f = new Funcionario($pdo);

$check = $f->validarCampoUnico($cpf);

if ($check > 0) {
    echo 'false';
} else {
    echo 'true';
}
