<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");
$obj = $_POST['dados'];
$p = new Perguntas($pdo);
$obj = $_POST['dados'];
$avaliacao = $obj['avaliacao']["idavaliacao"];
$respostas = $obj['respostas'];
$perguntaText = $obj["pergunta"]['pergunta'];
$idPergunta = $obj["pergunta"]['idpergunta'];
$questionario = $obj["selects"]['questionario'];
$modeloPratica = $obj["selects"]['modelo-pratica'][0];
$modeloDimensao = $obj["selects"]['modelo-dimensao'][0];

if ($questionario[0] == '1') {
    for ($i = 1; $i <= count($respostas); $i++) {
        $p->insertPerguntaRespostas($idPergunta, 1, $questionario[0], $respostas["resposta{$i}"], $avaliacao);
        $p->insertPerguntaRespostas($idPergunta, 2, $questionario[0], $respostas["resposta{$i}"], $avaliacao);
    }
} else {
    for ($i = 1; $i <= count($respostas); $i++) {
        $p->insertPerguntaRespostas($idPergunta, 3, $questionario[0], $respostas["resposta{$i}"], $avaliacao);
    }
}

echo true;