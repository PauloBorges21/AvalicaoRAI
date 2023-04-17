<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$media = new Respostas($pdo);
function getData(){
    $perguntasPermancia = [64]; // IDS Perguntas
     return $perguntasPermancia;
  }

  if(isset($_GET['action']) && $_GET['action'] == "getData"){
    $perguntasP = getData();
    
    $totalPRespostas = $media->countResposta($perguntasP,$_GET['presidencia']);
    $totalR = $media->getTotalPerguntaRespondida($perguntasP[0],$_GET['presidencia']);

    $auxiliarP = [];
    $auxiliarPResult = [];
        foreach ($totalPRespostas as $itens):
            array_push($auxiliarP, $itens->total);
        endforeach;
        $gporcentagemSingularTotal = $media->porcentagemSingularTotal($auxiliarP, 5, true,$totalR);
         $auxiliarP = [];
  }
  echo json_encode($gporcentagemSingularTotal);
  
