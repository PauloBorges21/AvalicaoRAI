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
function generateRandomString($length = 10) {
  return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}


//calcPeso($tPerguntas, $porIgual = false)
?>


<!-- partial:partials/_sidebar.html -->
<?php include('inc/side-nav.php'); ?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">

          <div class="card-body">
            <h4 class="card-title">Índice de Confiança</h4>
            <canvas id="barChart"></canvas>
            
          </div>
        </div>
      </div>
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Dimensões</h4>
            <canvas id="barChart2"></canvas>
            
          </div>
        </div>
      </div>

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Práticas Culturais</h4>
            <canvas id="barChart3"></canvas>
            
          </div>
        </div>
      </div>

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Motivo de Permanência</h4>
            <canvas id="doughnutChart"></canvas>
            
          </div>
        </div>
      </div>

      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">FeedBack</h4>
            <canvas id="doughnutChartFeed"></canvas>
            
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Oportunidade</h4>
            <div class="form-group row">
<!--          <label class="col-sm-3 col-form-label">Departamento</label>-->
<!--          <div class="col-sm-9">-->
<!--            <select class="form-control" id="grafic_dp" required>-->
<!--              <option value="0">Selecione</option>-->
<!--              --><?php //foreach ($d as $itens): ?>
<!--                <option value="--><?php //echo $itens['id'] ?><!--">-->
<!--                  --><?php //echo $itens['nome'] ?>
<!--                </option>-->
<!--              --><?php //endforeach; ?>
<!--            </select>-->
<!--          </div>-->
        </div>
            <canvas id="doughnutChartOpt"></canvas>
            
          </div>
        </div>
      </div>
      <div class="col-lg-12 grid-margin stretch-card">        
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Tempo de casa</h4>
            <div class="form-group row">
<!--          <label class="col-sm-3 col-form-label">Departamento</label>-->
<!--          <div class="col-sm-9">-->
<!--            <select class="form-control" id="grafic_tw" required>-->
<!--              <option value="0">Selecione</option>-->
<!--              --><?php //foreach ($d as $itens): ?>
<!--                <option value="--><?php //echo $itens['id'] ?><!--">-->
<!--                  --><?php //echo $itens['nome'] ?>
<!--                </option>-->
<!--              --><?php //endforeach; ?>
<!--            </select>-->
<!--          </div>-->
        </div>
            <canvas id="doughnutChartTimeW"></canvas>            
          </div>
        </div>
      </div>
      <button id="criaPDF" type="button"class="btn btn-success btn-icon-text" title="Descargar Gráfico">
        <i class="ti-download btn-icon-prepend"></i>Gerar PDF</button>
      <!-- <a id="criaPDF" class="btn btn-primary float-right bg-flat-color-1" title="Descargar Gráfico"><i class="ti-bar-chart-alt text-info"></i></a> -->
    </div>    
  </div>  
  
  <?php include 'footer-rh.php'; ?>