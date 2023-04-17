<?php
include 'header-rh.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rhRai'])) {
    header("Location: index-rh.php");
    exit();
}

$idAvaliacao = filter_input(INPUT_GET, 'id_avaliacao', FILTER_SANITIZE_URL);
$idPergunta = filter_input(INPUT_GET, 'id_pergunta', FILTER_SANITIZE_URL);


$p = new Perguntas($pdo);
$r = new Respostas($pdo);
$q = new Questionario($pdo);
$pergunta = $p->getEditPergunta($idAvaliacao, $idPergunta);
$questionario = $q->getQuestionarios();
$arrayResposta = $r->getEditResposta($idAvaliacao, $idPergunta);
$modeloPratica = $q->getModelosPratica();
$modeloDimensoes = $q->getModelosDimensoes();

//var_dump($pergunta);
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
        background-color: #4B49AC;;
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

    span {
        display: none;
    }

    .form-group label {
        margin-right: 35%
    }
</style>
<!-- partial:partials/_sidebar.html -->
<?php include('inc/side-nav.php'); ?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pergunta</h4>
                        <form class="form-sample" id="myForm">
                            <p class="card-description">
                                Editar Pergunta
                            </p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Questionário</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="questionario" id="qs-edit" onchange="removeInputs(this)">
                                                <option value="Selecione">Selecione</option>
                                                <?php foreach ($questionario as $item): ?>
                                                    <option <?php echo($item['id'] == $pergunta['id_questionario'] ? ' selected' : '') ?>
                                                            value="<?php echo $item['id'] ?>">
                                                        <?php echo $item['nome'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <input type="hidden" id="id_avaliacao" name="id_avaliacao" value="<?php echo $idAvaliacao ?>">
                                        <label class="col-sm-3 col-form-label">Modelo Pratica</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="modelo-pratica">
                                                <option value="Selecione">Selecione</option>
                                                <?php foreach ($modeloPratica as $item): ?>
                                                    <option <?php echo($item['id'] == $pergunta['modelo_praticas'] ? ' selected' : '') ?>
                                                            value="<?php echo $item['id'] ?>">
                                                        <?php echo $item['categoria'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Modelo Dimensões</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="modelo-dimensao">
                                                <option value="Selecione">Selecione</option>
                                                <?php foreach ($modeloDimensoes as $item): ?>
                                                    <option <?php echo($item['id'] == $pergunta['modelo_dimensao'] ? ' selected' : '') ?>
                                                            value="<?php echo $item['id'] ?>">
                                                        <?php echo $item['categoria'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row" id="inputs-container">
                                        <label class="col-sm-3 col-form-label">Pergunta</label>
                                        <div class="col-sm-9" id="inputs-container">
                                            <?php
                                            $perguntaTexto = $pergunta['pergunta'];
                                            $perguntaTexto = trim(str_replace("\r\n", '', $perguntaTexto)); ?>
                                            <input class="form-control" name="pergunta" id="pergunta" value="<?php echo $perguntaTexto; ?>">
                                            <input type="hidden" class="form-control" name="id-pergunta"
                                                   value="<?php echo $pergunta['id_pergunta'] ?>" id="id-pergunta">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Respostas</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                            <?php if ($pergunta['id_questionario'] == 1): ?>
                                                    <div class="form-group" id="input-respostas">
                                                            <?php foreach ($arrayResposta as $item): ?>
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" checked="true" disabled
                                                                       name="resposta" value="<?php echo $item['id'] ?>" /><?php echo $item['resposta'] ?>
                                                                <i class="input-helper"></i>
                                                            </label>
                                                                <input type="hidden" name="id-resposta" value="<?php echo $item['id'] ?>">

                                                            <?php endforeach; ?>
                                                        </div>
                                            <?php else : ?>
                                                    <div class="form-group" id="input-respostas">
                                                            <?php foreach ($arrayResposta as $item): ?>
                                                                <input type="ckeckbox" class="form-check-input"
                                                                       value="">
                                                                <?php echo $item['resposta'] ?>
                                                                <i class="input-helper"></i>
                                                                <input type="hidden" name="id-resposta"  value="<?php echo $item['id'] ?>">
                                                            <?php endforeach; ?>
                                                    </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                            <button type="button" id="btn-editarPerguntaResposta" class="btn btn-dark mr-2">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- loading -->
        <!-- <div class="loading" data-id="load">
                <div class="text-center">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div> -->
        <!-- loading ends -->
    </div>
    <!-- content-wrapper ends -->
</div>
<?php include 'footer-rh.php'; ?>
<script src="../scripts/editarPerguntaRespostas.js"></script>

