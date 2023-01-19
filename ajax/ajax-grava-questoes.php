<?php 
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php");

$obj = $_POST['dados'];
$questionario = $_POST['q'];
$q = new Questionario($pdo);
$dados  = json_decode($obj, true);
if($questionario == '1'){    
        if ( $dados ) {
            $perguntas = $dados["idpergunta"];                      
            $q->gravarQuestionario($dados["idusuario"],  $perguntas, $dados["optionsVA-$perguntas"], 1 ,1); 
            $q->gravarQuestionario($dados["idusuario"],  $perguntas,  $dados["optionsVE-$perguntas"], 1 ,2);      
        }
} else {
    if ($dados) {
        $perguntas = $dados["idpergunta"];
        $q->gravarQuestionario($dados["idusuario"], $perguntas, $dados["optionsVA-$perguntas"], 2, 3);
    }
}
echo $perguntas;




