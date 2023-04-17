<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");
$media = new Respostas($pdo);
$departamento = new Departamento($pdo);
$d = $departamento->getDepartamento();
function getData()
{
    $visao = [1, 2]; // IDS Perguntas
    return $visao;
}
$auxiliarResultVA = [];
$auxiliarResultVE = [];
$auxiliarVA = [];
$auxiliarVE = [];
$arrayAux =[];
$resultados = [];
if (isset($_GET['action']) && $_GET['action'] == "getData") {
    $questionario = getData();
    $totalConfiancaRespostas = $media->countRespostaQTotal(1);
    $auxiliarConfianca = [];
    $auxiliarConfiancaResult = [];
    foreach ($d as $dp):
        foreach ($totalConfiancaRespostas as $itens):
            if ($itens->id_visao == 1 && $itens->id_departamento == $dp['id']) {
                array_push($auxiliarVA, $itens->total);
            }
            if ($itens->id_visao == 2 && $itens->id_departamento == $dp['id']) {
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
        // Verifica se a chave já existe no array e, caso não exista, cria um novo array vazio
        $arrayAux = ["id_departamento" => intval($dp['id']), "departamento"=>$dp['nome'],"visao" => 1 ,"modelo" => 6, "total" => $gconfiancaVA];
        array_push($resultados,$arrayAux);

        $arrayAux = ["id_departamento" => intval($dp['id']), "departamento"=>$dp['nome'],"visao" => 2 ,"modelo" => 6, "total" => $gconfiancaVE];
        array_push($resultados,$arrayAux);

        // Limpa os arrays auxiliares
        $auxiliarVA = [];
        $auxiliarVE = [];
    endforeach;
}
echo json_encode($resultados);