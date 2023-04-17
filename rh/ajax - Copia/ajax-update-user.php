<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");
$usuario = new Funcionario($pdo);

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
$cpf = str_replace('-', "", $cpf);
$setor = filter_input(INPUT_POST, 'setor', FILTER_SANITIZE_NUMBER_INT);
$flagSetor = filter_input(INPUT_POST, 'radio', FILTER_SANITIZE_NUMBER_INT);
$gestor = filter_input(INPUT_POST, 'gestor', FILTER_SANITIZE_NUMBER_INT);

$campos = [$id, $nome, $email, $cpf, $setor,$flagSetor,$gestor];

$upUse = $usuario->uploadUsuario($id, $nome, $email, $cpf, $setor,$flagSetor,$gestor);
                                
echo true;


