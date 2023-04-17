<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");
$departamento = new Departamento($pdo);
$d = $departamento->getDepartamento();
$media = new Respostas($pdo);
function getData()
{
    $perguntasCultural =[1,2,3,4,5,6,7,8,9]; // IDS Perguntas
    return $perguntasCultural;
}

if (isset($_GET['action']) && $_GET['action'] == "getData") {
    $perguntasCultural = getData();
    $totalRespostas = $media->countRespostaDDP($perguntasCultural, "praticas", $_GET['presidencia']);
    $dpCriacao = [49, 61, 62];
    $dpmidia = [54, 65];
    $auxiliarVE = [];
    $auxiliarVA = [];
    $auxiliarResultVE = [];
    $auxiliarResultVA = [];

    $resultTotal = [];

    $resultados = [];

    foreach ($d as $key => $dpitem) {
        foreach ($perguntasCultural as $idArray) {
            $totalVADPT1 = 0;
            $totalVEDPT1 = 0;

            $totalVADPT2 = 0;
            $totalVEDPT2 = 0;

            $totalVADPT3 = 0;
            $totalVEDPT3 = 0;

            foreach ($totalRespostas as $itens) {
                if ($idArray == intval($itens->modelo_praticas) && $itens->id_departamento == $dpitem['id']) {
                    if ($itens->id_visao == 1 && in_array($itens->id_departamento, [49, 61, 62])) {
                        $totalVADPT1 += $itens->total;
                        array_push($auxiliarVA, $totalVADPT1);
                    } elseif ($itens->id_visao == 1 && in_array($itens->id_departamento, [54, 65])) {
                        $totalVADPT2 += $itens->total;
                        array_push($auxiliarVA, $totalVADPT2);
                    } elseif ($itens->id_visao == 2 && in_array($itens->id_departamento, [49, 61, 62])) {
                        $totalVEDPT1 += $itens->total;
                        array_push($auxiliarVE, $totalVEDPT1);
                    } elseif ($itens->id_visao == 2 && in_array($itens->id_departamento, [54, 65])) {
                        $totalVEDPT2 += $itens->total;
                        array_push($auxiliarVE, $totalVEDPT2);
                    } else {
                        if ($itens->id_visao == 1) {
                            array_push($auxiliarVA, $itens->total);
                        } elseif ($itens->id_visao == 2) {
                            array_push($auxiliarVE, $itens->total);
                        }
                    }
                    $gconfiancaVE = $media->porcentagemTotal($auxiliarVE, 5, false);
                    $gconfiancaVA = $media->porcentagemTotal($auxiliarVA, 5, false);
                }
            }

            // Verifica se a chave já existe no array e, caso não exista, cria um novo array vazio
            $arrayAux = ["id_departamento" => intval($dpitem['id']), "departamento"=>$dpitem['nome'],"visao" => 1 ,"modelo" => $idArray, "total" => $gconfiancaVA];
            array_push($resultados,$arrayAux);

            $arrayAux = ["id_departamento" => intval($dpitem['id']), "departamento"=>$dpitem['nome'],"visao" => 2 ,"modelo" => $idArray, "total" => $gconfiancaVE];
            array_push($resultados,$arrayAux);

            // Limpa os arrays auxiliares
            $auxiliarVA = [];
            $auxiliarVE = [];
        }
    }
// Retorna o array de resultados em formato JSON para a requisição AJAX
    echo json_encode($resultados);
}