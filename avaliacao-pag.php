<?php
include 'header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['funcionarioRai'])) {
    header("Location: index.php");
    exit();
}
$avaliacao = new Avaliacao($pdo);
$perguntas = new Perguntas($pdo);
$resposta = new Respostas($pdo);
$paginador = new Paginacao($pdo);

$idAvaliacao = $avaliacao->getAvaliacao();
$avaliacaoAtiva = $idAvaliacao['id'];
$avaliacaoNome = $idAvaliacao['avaliacao'];
$perguntasTotal = $perguntas->getTotalPerguntas(1, $avaliacaoAtiva);
$totalRespodido = $perguntas->getVerificaRespondido($_SESSION['funcionarioRai'], 1,$avaliacaoAtiva);
$porcentagem = $perguntas->porcentagem($perguntasTotal, $totalRespodido['TOTAL']);
$p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1,$avaliacaoAtiva);
$p2 = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 2,$avaliacaoAtiva);

if (!empty($p2)) {
    foreach ($p2 as $itemV):
        if (($itemV['FINALIZADO'] != "" && $itemV["IDQUESTIONARIO"] == "2")) {
            require('inc/questionario-sucesso.php');
            break;
        } else {
            $p2 = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 2,$avaliacaoAtiva);
            require('inc/questionario2.php');
            break;
        }
    endforeach;
} else {
    if (!empty($p)) {
        foreach ($p as $itemV):
            if (($itemV['FINALIZADO'] != "" && $itemV["IDQUESTIONARIO"] == "2")) {
                require('inc/questionario-sucesso.php');
                break;
            } elseif ($itemV['FINALIZADO'] == "" && $itemV["IDQUESTIONARIO"] == "1") {
                $p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1,$avaliacaoAtiva);
                require('inc/questionario1.php');
                break;
            } else {
                $p2 = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 2,$avaliacaoAtiva);
                require('inc/questionario2.php');
                break;
            }
        endforeach;
    } else {
        $p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1,$avaliacaoAtiva);
        require('inc/questionario1.php');
    }
}
include 'footer.php'; ?>