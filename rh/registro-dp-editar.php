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
//$inD = $departamento->

?>
<style>
    span {
        display: none;
    }
</style>
<!-- partial:partials/_sidebar.html -->
<?php include('inc/side-nav.php'); ?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Departamento</h4>
                        <p class="card-description">Cadastrar Departamento</p>
                        <form class="forms-sample">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Departamento</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="usu_setor" required>
                                                <option value="Selecione">Selecione</option>
                                                <?php foreach ($d as $itens): ?>
                                                    <option value="<?php echo $itens['id'] ?>">
                                                        <?php echo $itens['nome'] ?>
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
                                            <input type="text" id="searchdepertamento" class="form-control"
                                                name="search" placeholder="Pesquisar Departamento">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Usuário</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="usu_user" required>
                                                <option value="Selecione">Selecione</option>
                                                <?php foreach ($u as $itens): ?>
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
                                        <label class="col-sm-3 col-form-label">Busca Usuário</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="searchusuario" class="form-control" name="search"
                                                placeholder="Pesquisar Usuário">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="btn-gravar-dp-usu" class="btn btn-dark mr-2">Cadastrar</button>
                            <button type="reset" class="btn btn-light">Cancelar</button>
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