<?php

// $vFlag = $perguntas->getVerificaFlag($_SESSION['funcionarioRai'], 2);
// $vFlagTotal = $perguntas->getTotalFlag($_SESSION['funcionarioRai'], 2);
// $relacaoPerguntaResposta = $perguntas->getPerguntaRespostas(2);
// $filterP = $perguntas->setPergunta($relacaoPerguntaResposta);
// $filterR = $resposta->setResposta($relacaoPerguntaResposta);

// $perguntasTotal = $perguntas->getTotalPerguntas(2);


$vFlagTotal = $perguntas->getTotalFlag($_SESSION['funcionarioRai'], 2);
$relacaoPerguntaResposta = $perguntas->getPerguntaRespostas(2);
$filterP = $perguntas->setPergunta($relacaoPerguntaResposta);
$filterR = $resposta->setResposta($relacaoPerguntaResposta);
$rsP = $resposta->setResposta($p2);
$perguntasTotal = $perguntas->getTotalPerguntas(2);
$totalRespodido = $perguntas->getVerificaRespondido($_SESSION['funcionarioRai'], 2);
$porcentagem = $perguntas->porcentagem($perguntasTotal,$totalRespodido['TOTAL']);

?>
<form method="POST" id="form">
    <input type="hidden" id="func" value="<?php echo md5("rai") . 'f' . $_SESSION['funcionarioRai']; ?>">
    <div class="col-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" id="nomeFunc"></h4>
                <h4 class="card-title" id="departamentoFunc"></h4>
                <h4 class="card-title" id="gestorFunc"></h4>
                <h4 class="card-title">Avaliação Essa etapa tem <?php echo $perguntasTotal; ?></h4>
                <input id="questionario" type="hidden" name="questionario" value="2">
                <p class="card-description">Questionário 2</p>
                <?php
                $i = 1;
                
                foreach ($filterP as $pergunta) { ?>
                 
                    <label for="exampleInputName1"><?php echo $i . '. ' ?>
                        <?php echo $pergunta['pergunta']; ?>
                    </label>
                    <div class="row pb-4 mb-3 border-bottom">
                        <div class="form-group va col-4" id="va">
                            <input type="hidden" name="hash-rai" value="<?php echo $_SESSION['funcionarioRai'] ?>">
                            <input class="pergunta" type="hidden" name="idPergunta-<?php echo $pergunta['idPergunta'] ?>"
                                value="<?php echo $pergunta['idPergunta'] ?>">
                            <?php

                            $auxPergunta = "";                          
                            foreach ($filterR as $resposta):
                                if ($pergunta['idPergunta'] == $resposta['idPergunta'] && $resposta['visao'] == "3") { ?>
                                    <?php if (!empty($rsP) || $rsP != NULL) { ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" <?php foreach ($rsP as $pRespondida):
                                                    if (
                                                        $pRespondida['idResposta'] == $resposta['idResposta'] &&
                                                        $resposta['idPergunta'] == $pRespondida['idPergunta'] &&
                                                        $resposta['visao'] == "3" && $pRespondida['flag'] == "0" &&
                                                        $pRespondida['visao'] == "3"
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
                                                    name="optionsVA-<?php echo $pergunta['idPergunta']; ?>"
                                                    value="<?php echo $resposta['idResposta']; ?>">
                                                <?php echo $resposta['resposta'] ?>
                                            </label>
                                        </div>
                                    <?php }
                                }
                            endforeach;
                            ?>
                            <input class="perguntaRespondida"
                                value="<?php echo ($auxPergunta == "0") ? "checked" : null; ?>" type="hidden"
                                id="idPerguntaRespondida-<?php echo $pergunta['idPergunta'] ?>">
                            <div class="form-group col-4 pt-3">

                                <button type="buttom" <?php echo ($auxPergunta == "0") ? "disabled" : ''; ?>
                                    class="btn btn-primary mr-2 sub__mit" id="btn-salvar">Enviar</button>

                                <!-- <button class="btn btn-secondary">Limpar</button> -->
                            </div>
                        </div>
                    </div>
                    <?php $i++;

                } ?>
                <button type="submit" class="btn btn-primary mr-2 " id="btn-finalizar">Finalizar</button>
            </div>

        </div>
</form>