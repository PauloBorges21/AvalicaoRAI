<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");
$media = new Respostas($pdo);
function getData()
{
    $visao = [1, 2]; // IDS Perguntas
    return $visao;
}
//if ($_GET['selectedValue'] == 49) {
//    $dp = [49, 61, 62];
//} elseif ($_GET['selectedValue'] == 54) {
//    $dp = [54, 65];
//} elseif ($_GET['selectedValue'] == 53) {
//    $dp = [53, 63];
//} else {
//    intval($_GET['selectedValue']);
//    $dp[] = $_GET['selectedValue'];
//}
$dp[] = $_GET['selectedValue'];
if (isset($_GET['action']) && $_GET['action'] == "getData") {
    $questionario = getData();
    $totalConfiancaRespostas = $media->countRespostaQ(array(1), $_GET['presidencia'], $dp);
    $auxiliarConfianca = [];
    $auxiliarConfiancaResult = [];
    foreach ($questionario as $key => $qtdP):
        foreach ($totalConfiancaRespostas as $itens):
            if ($qtdP == intval($itens->id_visao)) {
                array_push($auxiliarConfianca, $itens->total);
            }
        endforeach;
        // $auxiliarConfianca = array_reverse($auxiliarConfianca, false);

        $gconfianca = $media->porcentagemTotal($auxiliarConfianca, 5, false);
        if (is_nan($gconfianca)) {
            $gconfianca = 0;
        }
        array_push($auxiliarConfiancaResult, $gconfianca);
        $auxiliarConfianca = [];
    endforeach;
}
//var_dump($auxiliarConfiancaResult);
echo json_encode($auxiliarConfiancaResult);
