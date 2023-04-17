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

$meuJson = json_encode($d);
$questionario = new Questionario($pdo);
$q = $questionario->statusReport();

//var_dump($meuJson);+
?>
<script>
  var dpsObject = { dp:<?php echo $meuJson; ?> };
</script>

<!-- partial -->
<?php include('inc/side-nav.php'); ?>

<div class="content-wrapper">

  <div class="form-group">
    <label for="Dsetor">Departamento</label>
    <select class="form-control" id="Dsetor" required>
      <option value="Selecione">Selecione</option>
      <?php foreach ($d as $itens): ?>
        <option value="<?php echo $itens['id'] ?>">
          <?php echo $itens['nome'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card position-relative">
        <div class="card-body">
          <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2"
            data-ride="carousel">
            <div class="carousel-inner">

              <?php foreach ($d as $key => $dp) { ?>
                <div class="carousel-item <?php if ($key == 0)
                  echo 'active' ?>" data-id="<?php echo $dp['id']; ?>">
                  
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">Status Reports </p>
                          <h3 class="text-primary">
                          <?php echo ucfirst($dp['nome']); ?>
                        </h3>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-9 border-right">
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                          <table class="table table-borderless report-table">
                            <thead>
                              <tr>
                                <th>Colaborador</th>
                                <!-- <th>Departamento</th> -->
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $total = 0;
                              $totalDP = 0;
                              foreach ($q as $key => $statusReport) {
                                if ($statusReport['id_departamento'] == $dp['id']) {
                                  if ($statusReport['id_questionario'] == "" || $statusReport['finalizacao_questionario'] == "") {
                                    $classBtn = "danger";
                                    $stringBtn = "Pendente";
                                  } else {
                                    $classBtn = "success";
                                    $stringBtn = "Concluído";
                                  }

                                  ?>
                                  <tr>
                                    <td>
                                      <?php $str = mb_strtolower($statusReport['nome'],'UTF-8')?>
                                      <?php echo ucfirst($str) ?>
                                    </td>
                                    <!-- <td class="font-weight-bold">
                                            <?php //echo ucfirst($statusReport['Departamento']; ?>
                                          </td> -->

                                    <td class="font-weight-medium">
                                      <div class="badge badge-<?php echo $classBtn; ?>"><?php echo $stringBtn ?></div>
                                    </td>
                                  </tr>
                                  <?php
                                  $resultB = $statusReport['total_finalizados'];
                                  $total = $resultB + $total;
                                  $totalDP = $statusReport['total_colaborador'];
                                  $idDPN = $statusReport['id_departamento'];
                                }

                              }

                              echo '<input type="hidden" data-res="' . $idDPN . '" value="' . $total . '">';
                              echo '<input type="hidden" data-f="' . $idDPN . '" value="' . $totalDP . '">';
                              $resultB = 0;
                              $total = 0;
                              $totalDP = 0;
                              $idDPN = 0;
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="col-md-3 stretch-card grid-margin grid-margin-md-0">

                        <div class="mr-5 mt-3">
                          <p class="text-muted">Conclusão</p>
                          <h3 class="text-primary fs-30 font-weight-medium" data-por='<?php echo $dp['id'] ?>'></h3>
                        </div>


                      </div>
                    </div>

                  </div>
                </div>
              <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php function formatString($str)
  {
    // Remove espaços em branco e troca por hífen
    $str = str_replace(' ', '-', $str);
    // Converte para minúsculas
    $str = strtolower($str);
    return $str;
  }

  // $texto = "Algum texto com espaços";
  // $textoFormatado = formatString($texto);
  // echo $textoFormatado;
  ?>
  <?php include 'footer-rh.php'; ?>