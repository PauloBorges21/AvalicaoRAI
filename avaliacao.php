<?php
include 'header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



if (empty($_SESSION['funcionarioRai'])) {
    header("Location: index.php");
    exit();
}

$perguntas = new Perguntas($pdo);
$resposta = new Respostas($pdo);

$p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1);

if (!empty($p)) {
    foreach ($p as $itemV):

        if (($itemV['FINALIZADO'] != "" && $itemV["IDQUESTIONARIO"] == "1") && ($itemV['FINALIZADO'] != "" && $itemV["IDQUESTIONARIO"] == "2")) {
            echo 'Obrigado tudo Respondido';
            break;

        } elseif ($itemV['FINALIZADO'] == "" && $itemV["IDQUESTIONARIO"] == "1") {
            require('inc/questionario1.php');
            break;

        } else {
            $p2 = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 2);
            require('inc/questionario2.php');
            
            break;
        }
    endforeach;
} else {
    $p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1);

    require('inc/questionario1.php');
}
?>
<?php include 'footer.php'; ?>

  
