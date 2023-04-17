<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$media = new Respostas($pdo);

function getData(){
    $perguntasDimensoes = [1,2,3,4,5]; // IDS Perguntas
     return $perguntasDimensoes;
  }
  
  if(isset($_GET['action']) && $_GET['action'] == "getData"){
    $perguntasDimensoes = getData();
    $totalRespostas = $media->countRespostaD($perguntasDimensoes,"dimensoes", $_GET['presidencia']);
  
    $auxiliarVE = [];
    $auxiliarVA = [];
    $auxiliarResultVE = [];
    $auxiliarResultVA = [];
    foreach ($perguntasDimensoes as $idArray):
        foreach ($totalRespostas as $itens):
          if ($idArray == intval($itens->modelo_dimensao) && $itens->id_visao == '1') {
            array_push($auxiliarVA, $itens->total);
          } elseif($idArray == intval($itens->modelo_dimensao) && $itens->id_visao == '2')  {        
            array_push($auxiliarVE, $itens->total);
          }
        endforeach;

         $gconfiancaVA = $media->porcentagemTotal($auxiliarVA, 5, false);

         $gconfiancaVE = $media->porcentagemTotal($auxiliarVE, 5, false);

        if (is_nan($gconfiancaVA)) {
            $gconfiancaVA = 0;
        }
        if (is_nan($gconfiancaVE)) {
            $gconfiancaVE = 0;
        }
         array_push($auxiliarResultVA, $gconfiancaVA);
         array_push($auxiliarResultVE, $gconfiancaVE);
         $auxiliarVE = [];
         $auxiliarVA = [];
      endforeach;
     }
     
     $result = array_merge($auxiliarResultVA, $auxiliarResultVE);
  //var_dump($result);
     echo json_encode($result);
     //echo json_encode($auxiliarResultVE);
     //print_r($auxiliar);
  
  
