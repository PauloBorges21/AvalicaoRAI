<?php
include 'header-rh.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rhRai'])) {
    header("Location: index-rh.php");
    exit();
}
?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
<!--<div class="load" id="loadingGif">-->
<!--    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>-->
<!--    <span class="sr-only">Loading...</span>-->
<!--</div>-->
<!-- partial:partials/_sidebar.html -->
<?php include('inc/side-nav.php'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVTotalChartOpt" class="card-body">
                        <h4 class="card-title">Geral</h4>
                        <canvas id="BarTotalChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVCredibilidadeChartOpt" class="card-body">
                        <h4 class="card-title">Credibilidade</h4>
                        <canvas id="BarCredibilidadeChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVRespeitoChartOpt" class="card-body">
                        <h4 class="card-title">Respeito</h4>
                        <canvas id="BarRespeitoChartOpt"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVImparcialidadeChartOpt" class="card-body">
                        <h4 class="card-title">Imparcialidade</h4>
                        <canvas id="BarImparcialidadeChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVOrgulhoChartOpt" class="card-body">
                        <h4 class="card-title">Orgulho</h4>
                        <canvas id="BarOrgulhoChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVCamaradagemChartOpt" class="card-body">
                        <h4 class="card-title">Camaradagem</h4>
                        <canvas id="BarCamaradagemChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <button id="criaPDF" type="button" class="btn btn-success btn-icon-text" title="Descargar Gráfico">
                <i class="ti-download btn-icon-prepend"></i>Gerar PDF
            </button>
            <button id="criaPPT" type="button" class="btn btn-warning btn-icon-text" title="Descargar Gráfico">
                <i class="ti-download btn-icon-prepend"></i>Gerar PPT
            </button>
        </div>
    </div>

<?php include 'footer-rh.php'; ?>
<script src="../scripts/chart-q-d.js"></script>