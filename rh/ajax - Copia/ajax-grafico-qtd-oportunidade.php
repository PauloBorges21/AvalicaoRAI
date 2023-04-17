<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");
$media = new Respostas($pdo);
function getData()
{
    $perguntas = 74; // IDS Perguntas
    return $perguntas;
}
$selectedValue = $_GET['selectedValue'];
$respostas = [90, 91, 92, 93];
intval($selectedValue);
//$selectedValue = 10;
//$totalRespostas = $media->countRespostaOP(74, $selectedValue);
if (isset($_GET['action']) && $_GET['action'] == "getData") {
    $perguntasP = getData();
    $totalPRespostas = $media->countRespostaOP($perguntasP, $selectedValue , $_GET['presidencia']);
    $sum = 0;
    foreach ($totalPRespostas as $value) {
        $sum += $value->total;
    }
    if($sum > 0)
    {
    $auxiliarP = [];
    $auxiliarPResult = [];
    foreach ($totalPRespostas as $itens):
        array_push($auxiliarP, $itens->total);
    endforeach;
    $gconfianca = $media->porcentagemSingularTotal($auxiliarP, 4, true, $sum);
    $auxiliarP = [];
    echo json_encode($gconfianca);
    } else {
        $arrayZerado = [0,0,0,0];
        echo json_encode($arrayZerado);
    }
}
//echo json_encode($totalRespostas);