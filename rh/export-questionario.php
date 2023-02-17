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
?>

<?php include('inc/side-nav.php'); ?>
<div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Relatório</h4>
                  <p class="card-description">
                    Escolha o tipo de relátorio 
                  </p>
                  <form class="forms-sample" action="relatorio-submit.php" method="POST">
                     <div class="form-group">                   
                    <select class="js-example-basic-multiple w-100" name="tipoR[]" multiple="multiple">
                      <option value="1">Confiança</option>
                      <option value="2">Dimensões</option>
                      <option value="3">Práticas Culturais</option>
                      <option value="4">Motivo De Permanência</option>
                      <option value="5">FeedBack</option>
                      <option value="6">Oportunidade</option>
                      <option value="7">Tempo De Casa</option>
                    </select>
                  </div>

                    <div class="form-group">
                     <label class="col-sm-3 col-form-label">Departamento</label>
                       <select class="js-example-basic-multiple w-100" name="tb_setor[]"  multiple="multiple">
                         <option value="Selecione">Selecione</option>
                           <?php foreach ($d as $itens): ?>
                              <option value="<?php echo $itens['id'] ?>">
                                <?php echo mb_strtoupper($itens['nome']) ?>
                              </option>
                            <?php endforeach; ?>
                            </select>                        
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Gerar</button>
                    <button class="btn btn-light">Limpar</button>
                  </form>
                </div>
              </div>
            </div>
<?php include 'footer-rh.php'; ?>
