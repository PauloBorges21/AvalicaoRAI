<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$usuario = new Funcionario($pdo);

$gestores = $usuario->getAllFG();

if($gestores):
    echo "<option value='Selecione'>Selecione</option>";
    foreach ($gestores as $item):
        echo "<option value='".$item["id"]."'>".strtoupper($item['nome'])."</option>";
    endforeach;
    else:
        echo 'false';
    endif;
    