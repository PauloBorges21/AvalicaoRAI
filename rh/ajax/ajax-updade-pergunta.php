<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");

$p = new Perguntas($pdo);
$obj = $_POST['dados'];
$avaliacao = $obj['avaliacao']["idavaliacao"];
$respostas = $obj['respostas'];
$perguntaText = $obj["pergunta"]['pergunta'];
$idPergunta = $obj["pergunta"]['idpergunta'];
$questionario = $obj["selects"]['questionario'];
$modeloPratica = $obj["selects"]['modelo-pratica'][0];
$modeloDimensao = $obj["selects"]['modelo-dimensao'][0];
$p->updatePerguntaRespostas($idPergunta,$perguntaText,$modeloDimensao,$modeloPratica);

echo true;