<?php
include 'header-rh.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rhRai'])) {
    header("Location: index-rh.php");
    exit();
}
include('inc/side-nav.php');

$ativo = true;

$paginador = new Paginacao($pdo);
$tableP = $paginador->getListPerguntas($ativo);

$d = new Dimensoes($pdo);
$dimensoes = $d->getDimesoes();

$filterD = $d->setDimensoes($dimensoes);

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
    #modal-container {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #modal {
        background-color: white;
        width: 300px;
        padding: 20px;
        margin: auto;
        margin-top: 100px;
    }

    #confirm-button, #cancel-button {
        padding: 10px;
        margin: 10px;
        border-radius: 5px;
    }

    #confirm-button {
        background-color: red;
        color: white;
    }

    #cancel-button {
        background-color: gray;
        color: white;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Perguntas</h4>
                    <form class="form-sample">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Busca Nome</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="searchpergunta" class="form-control" name="search"
                                               placeholder="Pesquisar Pergunta">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Modelo</label>
                                    <div class="col-md-7">
                                        <select class="form-control" id="usu_tb_setor" required>
                                            <option value="Selecione">Selecione</option>
                                            <?php foreach ($filterD as $item): ?>
                                                <option value="<?php echo $item['modelo'] ?>">
                                                    <?php echo mb_strtoupper($item['modelo']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tb-striped" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Ação</th>
                                                    <th>Pergunta</th>
                                                    <th>Modelo Dimensões</th>
                                                    <th>Modelo Práticas</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($tableP as $tbItem): ?>
                                                    <tr>
                                                        <td>
                                                            <a href="editar-pergunta.php?id_pergunta=<?php echo $tbItem['id_pergunta'];?>&id_avaliacao=<?php echo $tbItem['id_avaliacao'];?>">
                                                                <button type="button" class="btn btn-primary btn-sm">Editar</button>
                                                            </a>
                                                            <button type="button" id="delete-button" data-id="<?php echo $tbItem['id_pergunta'];?>" class="btn btn-danger btn-sm">Desativar</button>
                                                        </td>
                                                        <td>
                                                            <?php echo mb_strtoupper($tbItem['pergunta']);?>
                                                        </td>
                                                        <td>
                                                            <?php echo strtoupper($tbItem['modelo_dimensao_nome']);?>
                                                        </td>
                                                        <td>
                                                            <?php echo strtoupper($tbItem['modelo_praticas_nome']);?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <div id="modal-container">
                                                <div id="modal">
                                                    <p>Tem certeza que deseja ativar?</p>
                                                    <button id="confirm-button">Confirmar</button>
                                                    <button id="cancel-button">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul id="pagination" class="pagination">
                                        <li>
                                            <?php $montar = $paginador->ordenarListPerguntas($ativo) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <span id="formceditar"></span>
                        <button type="submit" id="btn-editar" class="btn btn-dark mr-2">Editar</button>
                        <button type="reset" class="btn btn-light">Limpar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer-rh.php'; ?>
