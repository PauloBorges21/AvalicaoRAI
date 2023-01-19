<?php 
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php"); 
$funcionario = new Funcionario($pdo);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);


echo json_encode($funcionario->getAll($id));

 