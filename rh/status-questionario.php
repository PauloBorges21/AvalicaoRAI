<?php
include 'header-rh.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rhRai'])) {
    header("Location: index-rh.php");
    exit();
}
$media = new Respostas($pdo);
$departamento = new Departamento($pdo);
$d = $departamento->getDepartamento();
function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

//$grupo = [49, 54, 61, 62, 65];
$grupoMidiaBiDigital = [
    'id' => '54',
    'nome' => 'Mídia / BI / Digital Insights'
];
$grupoCriacaoTrafego = [
    'id' => '49',
    'nome' => 'Criação / Tráfego / RTV'
];
$grupoServiçosManutencao =[
    'id' => '53',
    'nome' => 'Serviços / Manutenção'
];

$grupo = [49,53,54,61,62,63,65];
$dpAgrupado = array_filter($d, function ($dpAgrupado) use ($grupo) {
    return !in_array($dpAgrupado['id'], $grupo);
});
array_push($dpAgrupado,$grupoCriacaoTrafego);
array_push($dpAgrupado,$grupoMidiaBiDigital);
array_push($dpAgrupado,$grupoServiçosManutencao);
sort($dpAgrupado);

?>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="load" id="loadingGif">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    <span class="sr-only">Loading...</span>
</div>
<!-- partial:partials/_sidebar.html -->
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
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Departamento</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="grafic_p_dp" required>
                                    <option value="0">Selecione</option>
                                    <?php foreach ($dpAgrupado as $itens): ?>
                                        <option value="<?php echo $itens['id'] ?>">
                                            <?php echo $itens['nome'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <h4 class="card-title">Índice de Confiança</h4>
                        <div id="DIVbarChart" class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">

            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVbarChart2" class="card-body">
                        <h4 class="card-title">Dimensões</h4>
                        <canvas id="barChart2"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVbarChart3" class="card-body">
                        <h4 class="card-title">Práticas Culturais</h4>
                        <canvas id="barChart3"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVdoughnutChart" class="card-body">
                        <h4 class="card-title">Motivo de Permanência</h4>
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVdoughnutChartFeed" class="card-body">
                        <h4 class="card-title">FeedBack</h4>
                        <canvas id="doughnutChartFeed"></canvas>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVdoughnutChartOpt" class="card-body">
                        <h4 class="card-title">Oportunidade</h4>
                        <canvas id="doughnutChartOpt"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVdoughnutChartTimeW" class="card-body">
                        <h4 class="card-title">Tempo de casa</h4>
                        <canvas id="doughnutChartTimeW"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div id="DIVbarChart4" class="card-body">
                        <h4 class="card-title">Visão Global</h4>
                        <canvas id="barChart4"></canvas>
                    </div>
                </div>
            </div>
            <button id="criaPDF" type="button" class="btn btn-success btn-icon-text" title="Descargar Gráfico">
                <i class="ti-download btn-icon-prepend"></i>Gerar PDF
            </button>
            <button id="criaPPT" type="button" class="btn btn-warning btn-icon-text" title="Descargar Gráfico">
                <i class="ti-download btn-icon-prepend"></i>Gerar PPT
            </button>
            <!-- <a id="criaPDF" class="btn btn-primary float-right bg-flat-color-1" title="Descargar Gráfico"><i class="ti-bar-chart-alt text-info"></i></a> -->
        </div>
    </div>

    <?php include 'footer-rh.php'; ?>
    <script src="../scripts/chart-q.js"></script>