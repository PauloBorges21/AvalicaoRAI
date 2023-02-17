<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$media = new Respostas($pdo);

function getData(){
    $perguntasConfianca = [78, 79]; // IDS Perguntas
     return $perguntasConfianca;
  }
  
  if(isset($_GET['action']) && $_GET['action'] == "getData"){
    $perguntasConfianca = getData();
    $totalConfiancaRespostas = $media->countResposta($perguntasConfianca);

    $auxiliarConfianca = [];
    $auxiliarConfiancaResult = [];
    foreach ($perguntasConfianca as $key => $qtdP): 
        foreach ($totalConfiancaRespostas as $itens):
          if ($qtdP == intval($itens->id)) {            
            array_push($auxiliarConfianca, $itens->total);
          }
        endforeach;
        $gconfianca = $media->porcentagemTotal($auxiliarConfianca, 4, false);       
        array_push($auxiliarConfiancaResult, $gconfianca);
         $auxiliarConfianca = [];
      endforeach;   
  }
  echo json_encode($auxiliarConfiancaResult);
  
