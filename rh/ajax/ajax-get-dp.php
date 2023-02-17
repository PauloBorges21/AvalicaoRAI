<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");


$setor = $_POST['setor'];
$usuario = new Funcionario($pdo);
$u = $usuario->getFuncDP($setor);


if($u):
echo "<option value='Selecione'>Selecione</option>";
foreach ($u as $item):
    echo "<option value='$item->id'>".strtoupper($item->nome)."</option>";
endforeach;
else:
    echo 'false';
endif;
