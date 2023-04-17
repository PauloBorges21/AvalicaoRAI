<?php
spl_autoload_register(function($class) {
    require '../../classes/'.$class.'.php';
    });
require_once("../../config.php");

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
$cpf = str_replace('-', "", $cpf); 
$departamento = filter_input(INPUT_POST, 'setor', FILTER_SANITIZE_NUMBER_INT);
$id_gestor_direto = filter_input(INPUT_POST, 'gestor', FILTER_SANITIZE_NUMBER_INT);
$flag_gestor = filter_input(INPUT_POST, 'radio', FILTER_SANITIZE_NUMBER_INT);

$usuario = new Funcionario($pdo);

$u = $usuario->gravarUsuario($nome, $departamento,$cpf,$email,$flag_gestor,$id_gestor_direto);

echo 'true';

