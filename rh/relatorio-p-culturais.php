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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="load" id="loadingGif">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    <span class="sr-only">Loading...</span>
</div>
<?php include('inc/side-nav.php'); ?>
<style>
    .load {
        width: 100px;
        height: 100px;
        position: absolute;
        top: 30%;
        left: 45%;
        color: blue;
        z-index: 99999;
    }
    </style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVContratarChartOpt" class="card-body">
                        <h4 class="card-title">Contratar e Receber</h4>
                        <canvas id="BarContratarChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVInspirarChartOpt" class="card-body">
                        <h4 class="card-title">Inspirar</h4>
                        <canvas id="BarInspirarChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVFalarChartOpt" class="card-body">
                        <h4 class="card-title">Falar</h4>
                        <canvas id="BarFalarChartOpt"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVEscutarChartOpt" class="card-body">
                        <h4 class="card-title">Escutar</h4>
                        <canvas id="BarEscutarChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVAgradecerChartOpt" class="card-body">
                        <h4 class="card-title">Agradecer</h4>
                        <canvas id="BarAgradecerChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVDesenvolverChartOpt" class="card-body">
                        <h4 class="card-title">Desenvolver</h4>
                        <canvas id="BarDesenvolverChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVCuidarChartOpt" class="card-body">
                        <h4 class="card-title">Cuidar</h4>
                        <canvas id="BarCuidarChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVCompartilharChartOpt" class="card-body">
                        <h4 class="card-title">Compartilhar</h4>
                        <canvas id="BarCompartilharChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVCelebrarChartOpt" class="card-body">
                        <h4 class="card-title">Celebrar</h4>
                        <canvas id="BarCelebrarChartOpt"></canvas>
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
<script src="../scripts/chart-q-c.js"></script>