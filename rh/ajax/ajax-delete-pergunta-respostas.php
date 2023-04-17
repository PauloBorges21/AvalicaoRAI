<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");
$obj = $_POST['dados'];
$p = new Perguntas($pdo);
$avaliacao = $obj['avaliacao']["idavaliacao"];
$respostas = $obj['respostas'];
$perguntaText = $obj["pergunta"]['pergunta'];
$idPergunta = $obj["pergunta"]['idpergunta'];
$questionario = $obj["selects"]['questionario'][0];
$modeloPratica = $obj["selects"]['modelo-pratica'][0];
$modeloDimensao = $obj["selects"]['modelo-dimensao'][0];
$arrayRespostas =[];
for ($i = 1; $i <= count($respostas); $i++) {
   array_push($arrayRespostas,$respostas["resposta{$i}"]) ;
}
$p->deletePerguntaRespostas($avaliacao,$questionario,$idPergunta);

echo true;

