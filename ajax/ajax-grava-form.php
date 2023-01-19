<?php
spl_autoload_register(function($class) {
    require '../classes/'.$class.'.php';
    });
require_once("../config.php");

$obj = $_POST['dados'];
$questionario = $_POST['q'];
$q = new Questionario($pdo);
$dados  = json_decode($obj, true);



$usuario = $dados['hash-rai'];

if($questionario =='1'){
for ($i = 1; $i <= count($dados); $i++) {

    if (!empty($dados["idPergunta-$i"]) && !empty($dados["optionsVA-$i"]) && !empty($dados["optionsVE-$i"])) {

        $q->finalizaQuestionario($usuario, $dados["idPergunta-$i"], $dados["optionsVA-$i"], 1, 1);
        $q->finalizaQuestionario($usuario , $dados["idPergunta-$i"], $dados["optionsVE-$i"], 1, 2);

    }
}
} else {
    for ($i = 1; $i <= count($dados); $i++) {

        if (!empty($dados["idPergunta-$i"]) && !empty($dados["optionsVA-$i"])) {

            $q->finalizaQuestionario($usuario, $dados["idPergunta-$i"], $dados["optionsVA-$i"], 2, 3);

        }
    }
}
echo 'true';
// if ($dados):
//     for ($i = 1; $i <= 1; $i++) {
//         if ( $dados ) {
//             $perguntas = $dados["idpergunta"];
//             echo $dados["idusuario"];
//                  
//         }
//     }    
// endif;

