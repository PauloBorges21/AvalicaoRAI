<?php
include 'header-rh.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rhRai'])) {
    header("Location: index-rh.php");
    exit();
}
$departamento = new Departamento($pdo);
$d = $departamento->getDepartamento();

$usuario = new Funcionario($pdo);
$u = $usuario->getAllF();

$paginador = new Paginacao($pdo);
$tableU = $paginador->getPagtbUser("");
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
<!-- partial:partials/_sidebar.html -->
<?php include('inc/side-nav.php'); ?>
<!-- partial -->

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usuário</h4>
                    <form class="form-sample">
                        <p class="card-description">Editar Usuário</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Departamento</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="usu_tb_setor" required>
                                            <option value="Selecione">Selecione</option>
                                            <?php foreach ($d as $itens): ?>
                                                <option value="<?php echo $itens['id'] ?>">
                                                    <?php echo mb_strtoupper($itens['nome']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Busca DP</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="searchdepertamento" class="form-control" name="search"
                                            placeholder="Pesquisar Departamento">
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
                                                        <th>Departamento</th>
                                                        <th>Nome</th>
                                                        <th>Email</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tableU as $tbItens): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo mb_strtoupper($tbItens['departamento']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo mb_strtoupper($tbItens['nome']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $tbItens['email']; ?>
                                                            </td>
                                                            <td><a
                                                                    href="editar-users.php?id_nome=<?php echo $tbItens['id'] ?>&id_departamento=<?php echo $tbItens['id_departamento'] ?>"><button
                                                                        type="button"
                                                                        class="btn btn-primary btn-sm">Editar</button></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <ul id="pagination" class="pagination">
                                        <li>
                                            <?php $montar = $paginador->ordenarTbUser() ?>
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