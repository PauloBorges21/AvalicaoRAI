<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$usu = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
$usuario = new Funcionario($pdo);
$u = $usuario->desativaUsuario($usu);
