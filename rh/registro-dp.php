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
                            <div class="form-group">
                                <label for="usu_nome">Departamento</label>
                                <input type="text" class="form-control" name="nome-departamento" id="nome-dp" required>
                                <span id="cvnome">Campo Vazio!</span>
                            </div>
    
                            <button type="submit" id="btn-gravar-dp" class="btn btn-dark mr-2">Cadastrar</button>
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