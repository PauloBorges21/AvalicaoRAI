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
$paginador = new Paginacao($pdo);
$perguntasTotal = $perguntas->getTotalPerguntas(1);
$totalRespodido = $perguntas->getVerificaRespondido($_SESSION['funcionarioRai'], 1);
$porcentagem = $perguntas->porcentagem($perguntasTotal, $totalRespodido['TOTAL']);

$p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1);
$p2 = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 2);

if (!empty($p2)) {
    
    foreach ($p2 as $itemV):
        if (($itemV['FINALIZADO'] != "" && $itemV["IDQUESTIONARIO"] == "2")) { ?>
            <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
        <div class="row flex-grow">
          <div class="col-lg-7 mx-auto text-white">
            <div class="row align-items-center d-flex flex-row">
              <div class="col-lg-12 pr-lg-4">
                <h2>Obrigado pesquisa respondida!</h2>
              </div>
              <div class="col-lg-12 pr-lg-4">
                <h2>Agradecemos a sua participação!</h2>                
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

            <?php break;
        }
    endforeach;
} else {
    if (!empty($p)) {
        foreach ($p as $itemV):

            if (($itemV['FINALIZADO'] != "" && $itemV["IDQUESTIONARIO"] == "2")) {              
                ?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
        <div class="row flex-grow">
          <div class="col-lg-7 mx-auto text-white">
            <div class="row align-items-center d-flex flex-row">
              <div class="col-lg-6 text-lg-right pr-lg-4">
                <h1 class="display-1 mb-0">Obrigado tudo Respondido</h1>
              </div>
              <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                <h2>Agradecemos a sua participação!</h2>                
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

              <?php  break;

            } elseif ($itemV['FINALIZADO'] == "" && $itemV["IDQUESTIONARIO"] == "1") {
                
                //require('inc/questionario1-pag.php');
                $p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1);

                $vFlagTotal = $perguntas->getTotalFlag($_SESSION['funcionarioRai'], 1);

                //$relacaoPerguntaResposta = $perguntas->getPerguntaRespostas(1);
                $relacaoPerguntaResposta = $paginador->getPagQuestionario(1);
                // echo '<pre>';
                // var_dump($relacaoPerguntaResposta);
                // echo '</pre>';
                $filterP = $perguntas->setPergunta($relacaoPerguntaResposta);
                $filterR = $resposta->setResposta($relacaoPerguntaResposta);
                $rsP = $resposta->setResposta($p);
                $perguntasTotal = $perguntas->getTotalPerguntas(1);
                $totalRespodido = $perguntas->getVerificaRespondido($_SESSION['funcionarioRai'], 1);
                $porcentagem = $perguntas->porcentagem($perguntasTotal, $totalRespodido['TOTAL']);
                ?>
                            <style>
                                .pf {
                                    display: flex;
                                    z-index: 99;
                                    justify-content: right;
                                    align-items: right;
                                    /* align-items: center; */
                                    position: sticky;
                                    top: -10px;
                                    position: fixed;
                                    width: 100%;
                                }

                                .rai__center {
                                    text-align: center;
                                    border-left: 6px solid #2196F3 !important;
                                    background-color: #cccccc1c !important;
                                }

                                .rai__table {
                                    padding: 0.01em 16px
                                }

                                .pagination {
                                    display: flex;
                                    list-style: none;
                                    justify-content: center
                                }

                                .pagination a {
                                    color: black;
                                    padding: 8px 16px;
                                    text-decoration: none;
                                }

                                .pagination a.active {
                                    background-color: #4B49AC;
                                    ;
                                    color: white;
                                    border-radius: 5px;
                                }

                                @media screen and (max-width: 600px) {
                                    .flex-wrap {
                                        justify-content: center;
                                    }

                                    .rai__center {
                                        background-color: #0c0202 !important;
                                    }
                                }
                            </style>
                            <div class="pf">
                                <div class="d-flex flex-wrap mb-5 rai__center">
                                    <div class="rai__table mt-3">
                                        <p class="text-muted">Essa etapa tem</p>
                                        <h5 class="text-primary fs-20 font-weight-medium">
                                            <?php echo $perguntasTotal; ?> Perguntas
                                        </h5>
                                    </div>
                                    <div class="mr-5 mt-3">
                                        <p class="text-muted" id="p-respondido">Você Respondeu</p>
                                        <h5 class="text-primary fs-20 font-weight-medium" id="total-respondido">
                                            <?php echo $totalRespodido['TOTAL'] ?>
                                        </h5>
                                    </div>
                                    <div class="mr-5 mt-3">
                                        <p class="text-muted">Porcentagem</p>
                                        <h5 class="text-primary fs-20 font-weight-medium" id="porcentagem">
                                            <?php echo $porcentagem; ?>%
                                        </h5>
                                    </div>
                                    <div class="mr-5 mt-3">
                                        <p class="text-muted">Status da Página</p>
                                        <h5 class="text-primary fs-20 font-weight-medium" id="status-pag">
                                            <?php echo 'Incompleto' ?>
                                        </h5>
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

                                            <input id="questionario" type="hidden" name="questionario" value="1">
                                            <?php
                                            $i = 1;
                                            foreach ($filterP as $pergunta) { ?>
                                                    <label for="exampleInputName1">
                                                        <?php echo $i . '. ' ?>
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
                                                                                                name="optionsVE-<?php echo $pergunta['idPergunta']; ?>"
                                                                                                value="<?php echo $resposta['idResposta']; ?>">
                                                                                            <?php echo $resposta['resposta'] ?>
                                                                                        </label>
                                                                                    </div>
                                                                            <?php }
                                                                }
                                                            endforeach;
                                                            ?>
                                                        </div>
                                                        <div class="form-group col-4 pt-3">
                                                            <button type="buttom" <?php echo ($auxPergunta == "0") ? "disabled" : ''; ?>
                                                                class="btn btn-primary mr-2 sub__mit" id="btn-salvar">Enviar</button>
                                                            <!-- <button class="btn btn-secondary">Limpar</button> -->
                                                        </div>
                                                    </div>

                                                    <?php $i++;
                                            } ?>
                                            <ul class="pagination">
                                                <li>
                                                    <?php $montar = $paginador->ordenarQuestionario() ?>
                                                </li>
                                            </ul>
                                            <button type="submit" class="btn btn-primary mr-2 " id="btn-finalizar">Finalizar</button>
                                        </div>
                                    </div>
                            </form>
                            <?php break;
            } else {
                $p2 = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 2);
                require('inc/questionario2.php');
                break;
            }
        endforeach;
    } else {        
        $p = $perguntas->getPerguntas($_SESSION['funcionarioRai'], 1);
        $vFlagTotal = $perguntas->getTotalFlag($_SESSION['funcionarioRai'], 1);

        //$relacaoPerguntaResposta = $perguntas->getPerguntaRespostas(1);
        $relacaoPerguntaResposta = $paginador->getPagQuestionario(1);
        // echo '<pre>';
        // var_dump($relacaoPerguntaResposta);
        // echo '</pre>';
        $filterP = $perguntas->setPergunta($relacaoPerguntaResposta);
        $filterR = $resposta->setResposta($relacaoPerguntaResposta);
        $rsP = $resposta->setResposta($p);
        $perguntasTotal = $perguntas->getTotalPerguntas(1);
        $totalRespodido = $perguntas->getVerificaRespondido($_SESSION['funcionarioRai'], 1);
        $porcentagem = $perguntas->porcentagem($perguntasTotal, $totalRespodido['TOTAL']);
        ?>
        <style>
            .pf {
                display: flex;
                z-index: 99;
                justify-content: right;
                align-items: right;
                /* align-items: center; */
                position: sticky;
                top: -10px;
                position: fixed;
                width: 100%;
            }

            .rai__center {
                text-align: center;
                border-left: 6px solid #2196F3 !important;
                background-color: #cccccc1c !important;
            }

            .rai__table {
                padding: 0.01em 16px
            }

            .pagination {
                display: flex;
                list-style: none;
                justify-content: center
            }

            .pagination a {
                color: black;
                padding: 8px 16px;
                text-decoration: none;
            }

            .pagination a.active {
                background-color: #4B49AC;
                ;
                color: white;
                border-radius: 5px;
            }

            @media screen and (max-width: 600px) {
                .flex-wrap {
                    justify-content: center;
                }

                .rai__center {
                    background-color: #0c0202 !important;
                }
            }
        </style>
        <div class="pf">
            <div class="d-flex flex-wrap mb-5 rai__center">
                <div class="rai__table mt-3">
                    <p class="text-muted">Essa etapa tem</p>
                    <h5 class="text-primary fs-20 font-weight-medium">
                        <?php echo $perguntasTotal; ?> Perguntas
                    </h5>
                </div>
                <div class="mr-5 mt-3">
                    <p class="text-muted" id="p-respondido">Você Respondeu</p>
                    <h5 class="text-primary fs-20 font-weight-medium" id="total-respondido">
                        <?php echo $totalRespodido['TOTAL'] ?>
                    </h5>
                </div>
                <div class="mr-5 mt-3">
                    <p class="text-muted">Porcentagem</p>
                    <h5 class="text-primary fs-20 font-weight-medium" id="porcentagem">
                        <?php echo $porcentagem; ?>%
                    </h5>
                </div>
                <div class="mr-5 mt-3">
                    <p class="text-muted">Status da Página</p>
                    <h5 class="text-primary fs-20 font-weight-medium" id="status-pag">
                        <?php echo 'Incompleto' ?>
                    </h5>
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

                        <input id="questionario" type="hidden" name="questionario" value="1">
                        <?php
                        $i = 1;
                        foreach ($filterP as $pergunta) { ?>
                                <label for="exampleInputName1">
                                    <?php echo $i . '. ' ?>
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
                                                                            name="optionsVE-<?php echo $pergunta['idPergunta']; ?>"
                                                                            value="<?php echo $resposta['idResposta']; ?>">
                                                                        <?php echo $resposta['resposta'] ?>
                                                                    </label>
                                                                </div>
                                                        <?php }
                                            }
                                        endforeach;
                                        ?>
                                    </div>
                                    <div class="form-group col-4 pt-3">
                                        <button type="buttom" <?php echo ($auxPergunta == "0") ? "disabled" : ''; ?>
                                            class="btn btn-primary mr-2 sub__mit" id="btn-salvar">Enviar</button>
                                        <!-- <button class="btn btn-secondary">Limpar</button> -->
                                    </div>
                                </div>

                                <?php $i++;
                        } ?>
                        <ul class="pagination">
                            <li>
                                <?php $montar = $paginador->ordenarQuestionario() ?>
                            </li>
                        </ul>
                        <button type="submit" class="btn btn-primary mr-2 " id="btn-finalizar">Finalizar</button>
                    </div>
                </div>
        </form>
        <?php
    }
}
include 'footer.php'; ?>