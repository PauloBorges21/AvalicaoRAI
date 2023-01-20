<?php
    $perguntas = new Perguntas($pdo);
    $resposta = new Respostas($pdo);
    $paginador = new Paginacao($pdo);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['funcionarioRai'])) {
        header("Location: index.php");
        exit();
    }

$p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1);
$vFlagTotal = $perguntas->getTotalFlag($_SESSION['funcionarioRai'], 1);
$relacaoPerguntaResposta = $perguntas->getPerguntaRespostas(1);
$filterP = $perguntas->setPergunta($relacaoPerguntaResposta);
$filterR = $resposta->setResposta($relacaoPerguntaResposta);
$rsP = $resposta->setResposta($p);
$perguntasTotal = $perguntas->getTotalPerguntas(1);
$totalRespodido = $perguntas->getVerificaRespondido($_SESSION['funcionarioRai'], 1);
$porcentagem = $perguntas->porcentagem($perguntasTotal,$totalRespodido['TOTAL']);

$pg = $paginador->getPagQuestionario(1);
var_dump($pg);
?>

<style>
    .pf{
        display: flex;
        z-index:99;
        justify-content: right;
        align-items: right;
        /* align-items: center; */
        position: sticky;
        top: -10px; 
        position: fixed;
        width: 100%;       
    }
    .rai__center{
        text-align: center;
        border-left: 6px solid #2196F3!important;
        background-color: #cccccc1c!important;
    }
    .rai__table {
        padding: 0.01em 16px
    }
    /* .text-muted {
        text-align: center;
        color: #4B49AC;
        font-size: 1em;
    }
    .text-primary{
        text-align: center;
        color: black;
        font-size: 12px;
    } */
    </style>
<div class="pf">
<div class="d-flex flex-wrap mb-5 rai__center">
                    <div class="rai__table mt-3">     
                      <p class="text-muted">Essa etapa tem</p>
                      <h3 class="text-primary fs-20 font-weight-medium"><?php echo $perguntasTotal; ?> Perguntas</h3>
                    </div>
                    <div class="mr-5 mt-3">
                      <p class="text-muted" id="p-respondido">Você Respondeu</p>
                      <h3 class="text-primary fs-20 font-weight-medium" id="total-respondido"><?php echo $totalRespodido['TOTAL']?></h3>
                    </div>
                    <div class="mr-5 mt-3">
                      <p class="text-muted">Porcentagem</p>
                      <h3 class="text-primary fs-20 font-weight-medium" id="porcentagem"><?php echo $porcentagem; ?>%</h3>
                    </div>
    </div>
</div>

<form method="POST" id="form">
    <input type="hidden" id="func" value="<?php echo md5("rai") . 'f' . $_SESSION['funcionarioRai']; ?>">
    <div class="col-12 col-lg-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" id="nomeFunc"></h4>
                <h4 class="card-title" id="departamentoFunc"></h4>
                <h4 class="card-title" id="gestorFunc"></h4>
                <!-- <h4 class="card-title">Avaliação Essa etapa tem <?php echo $perguntasTotal; ?> Perguntas</h4>
                <h4 class="card-title">Porcentagem <?php echo $porcentagem; ?>% Perguntas</h4> -->
                <input id="questionario" type="hidden" name="questionario" value="1">
                <?php
                $i = 1;
                foreach ($filterP as $pergunta) { ?>
                    <label for="exampleInputName1"><?php echo $i . '. ' ?>
                        <?php echo $pergunta['pergunta']; ?>
                    </label>
                    <div class="row pb-4 mb-3 border-bottom">
                        <div class="form-group va col-12 col-sm-4" id="va">
                            <input type="hidden" name="hash-rai" value="<?php echo $_SESSION['funcionarioRai'] ?>">
                            <input class="pergunta" type="hidden" name="idPergunta-<?php echo $pergunta['idPergunta'] ?>"
                                value="<?php echo $pergunta['idPergunta'] ?>">                                
                            <p class="card-description">Visão Área</p>
                            <?php                           
                            $auxPergunta = "";                           
                            foreach ($filterR as $resposta):
                                if ($pergunta['idPergunta'] == $resposta['idPergunta'] && $resposta['visao'] == "1") { ?>
                                    <?php if (!empty($rsP) || $rsP != NULL) { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" <?php foreach ($rsP as $pRespondida):
                                                    if (
                                                        $pRespondida['idResposta'] == $resposta['idResposta'] &&
                                                        $resposta['idPergunta'] == $pRespondida['idPergunta'] &&
                                                        $resposta['visao'] == "1" && $pRespondida['flag'] == "0" &&
                                                        $pRespondida['visao'] == "1"
                                                    ) {
                                                        $auxPergunta = $pRespondida['flag'];
                                                        echo ($pRespondida['flag'] == "0") ? "disabled " : null;
                                                        echo ($pRespondida['flag'] == "0" && $pRespondida['tohave'] == "1") ? "checked " : null;
                                                    }
                                                endforeach;
                                                ?> class="form-check-input" <?php ?>
                                                    name="optionsVA-<?php echo $pergunta['idPergunta'] ?>"
                                                    value="<?php echo $resposta['idResposta'] ?>" id="<?php echo $resposta['visao'] ?>">
                                                <?php echo $resposta['resposta'] ?>
                                            </label>
                                        </div>
                                        <?php
                                    } else { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input"
                                                    name="optionsVA-<?php echo $pergunta['idPergunta'];?>"
                                                    value="<?php echo $resposta['idResposta'];?>" >
                                                <?php echo $resposta['resposta'] ?>
                                            </label>
                                        </div>
                                    <?php }
                                }
                            endforeach;
                            ?>
                            <input class="perguntaRespondida" value="<?php echo ($auxPergunta == "0") ? "checked" : null; ?>" type="hidden" id="idPerguntaRespondida-<?php echo $pergunta['idPergunta']  ?>">
                        </div>
                        <div class="form-group ve col-12 col-sm-4" id="ve">
                            <input class="pergunta" type="hidden" name="idPergunta-<?php echo $pergunta['idPergunta']; ?>"
                                id="<?php echo $pergunta['idPergunta']; ?>" value="<?php echo $pergunta['idPergunta'] ?>">
                            <!-- <input id="visao" type="hidden" name="visaoE" id="visaoE" value="2"> -->
                            <p class="card-description">
                                Visão Empresa
                            </p>
                            <!-- Tratar o if caso não tenha Perguna respondidas -->
                            <?php foreach ($filterR as $resposta):
                                if ($pergunta['idPergunta'] == $resposta['idPergunta'] && $resposta['visao'] == "2") { ?>
                                    <?php if (!empty($rsP) || $rsP != NULL) { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" <?php foreach ($rsP as $pRespondida):
                                                    if (
                                                        $pRespondida['idResposta'] == $resposta['idResposta'] &&
                                                        $resposta['idPergunta'] == $pRespondida['idPergunta'] &&
                                                        $resposta['visao'] == "2" && $pRespondida['flag'] == "0" &&
                                                        $pRespondida['visao'] == "2"
                                                    ) {
                                                        echo ($pRespondida['flag'] == "0") ? "disabled " : null;
                                                        echo ($pRespondida['flag'] == "0" && $pRespondida['tohave'] == "1") ? "checked " : null;
                                                    }
                                                endforeach;
                                                ?> class="form-check-input" <?php ?>
                                                    name="optionsVE-<?php echo $pergunta['idPergunta'] ?>"
                                                    value="<?php echo $resposta['idResposta'] ?>" id="<?php echo $resposta['visao'] ?>">
                                                <?php echo $resposta['resposta'] ?>
                                            </label>
                                        </div>
                                        <?php
                                    } else { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input"
                                                    name="optionsVE-<?php echo $pergunta['idPergunta'];?>"
                                                    value="<?php echo $resposta['idResposta'];?>" >
                                                <?php echo $resposta['resposta'] ?>
                                            </label>
                                        </div>
                                    <?php }
                                }
                            endforeach;
                            ?>
                        </div>
                        <div class="form-group col-4 pt-3">
                            <button type="buttom" <?php echo ($auxPergunta == "0") ? "disabled" : ''; ?> class="btn btn-primary mr-2 sub__mit" id="btn-salvar">Enviar</button>
                            <!-- <button class="btn btn-secondary">Limpar</button> -->
                        </div>
                    </div>
                    <?php $i++;
                } ?>
                <button type="submit" class="btn btn-primary mr-2 " id="btn-finalizar">Finalizar</button>
            </div>
        </div>
</form>
<!-- <script>

$(document).ready(function () {
    const tbody = document.querySelector(".listar-pergunta");

const listarPerguntas = async (pagina) => {
    const dados = await fetch("./inc/questionario1-pag.php?pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;

}


listarPerguntas(1);
})


</script> -->