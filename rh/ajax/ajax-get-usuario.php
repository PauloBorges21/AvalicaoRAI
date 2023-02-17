<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");


//$usu = $_POST['usuario'];
$usu = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
$usuario = new Funcionario($pdo);
$u = $usuario->getFunc($usu);


if($u):
echo "<option value='Selecione'>Selecione</option>";
foreach ($u as $item):
    echo "<option value='$item->id'>".strtoupper($item->nome)."</option>";
endforeach;
else:
    echo 'false';
endif;
