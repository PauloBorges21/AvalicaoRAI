<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$media = new Respostas($pdo);

function getData(){
    $perguntasPermancia = [63]; // IDS Perguntas
    return $perguntasPermancia;
}

if ($_GET['selectedValue'] == 49) {
    $dp = [49, 61, 62];
} elseif ($_GET['selectedValue'] == 54) {
    $dp = [54, 65];
} elseif ($_GET['selectedValue'] == 53) {
    $dp = [53, 63];
} else {
    intval($_GET['selectedValue']);
    $dp[] = $_GET['selectedValue'];
}

if(isset($_GET['action']) && $_GET['action'] == "getData"){
    $perguntasP = getData();
    $totalPRespostas = $media->countResposta($perguntasP,$_GET['presidencia'],$dp);
    $totalR = $media->getTotalPerguntaRespondida($perguntasP[0],$_GET['presidencia'],$dp);
    $auxiliarP = [];
    $auxiliarPResult = [];

    foreach ($totalPRespostas as $itens):
        array_push($auxiliarP, $itens->total);
    endforeach;
    $gconfianca = $media->porcentagemSingularTotal($auxiliarP, 5, true,$totalR);
    $auxiliarP = [];
    //var_dump($gconfianca);
    if(!$gconfianca){
        $gconfianca = [0,0,0,0,0];
    }
}
echo json_encode($gconfianca);
  
