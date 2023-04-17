<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$media = new Respostas($pdo);

function getData()
{
    $perguntasConfianca = [78, 79]; // IDS Perguntas
    return $perguntasConfianca;
}

if (isset($_GET['action']) && $_GET['action'] == "getData") {

    $perguntasConfianca = getData();
    $totalConfiancaRespostas = $media->countResposta($perguntasConfianca, $_GET['presidencia']);

    $auxiliarConfianca = [];
    $auxiliarConfiancaResult = [];
    foreach ($perguntasConfianca as $key => $qtdP):
        foreach ($totalConfiancaRespostas as $itens):
            if ($qtdP == intval($itens->id_pergunta)) {
                array_push($auxiliarConfianca, $itens->total);
            }
        endforeach;

        $auxiliarConfianca = array_reverse($auxiliarConfianca, false);



        $gconfianca = $media->porcentagemTotal($auxiliarConfianca, 4, false);
        if (is_nan($gconfianca)) {
            $gconfianca = 0;
        }
        array_push($auxiliarConfiancaResult, $gconfianca);
         $auxiliarConfianca = [];
    endforeach;
}
//var_dump($auxiliarConfiancaResult);
echo json_encode($auxiliarConfiancaResult);
  
