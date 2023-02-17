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

$usuario = new Funcionario($pdo);
$u = $usuario->getAllFG();
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
            <h4 class="card-title">Usuário</h4>
            <p class="card-description">Cadastrar Usuário</p>
            <form class="forms-sample">
              <div class="form-group">
                <label for="usu_nome">Nome</label>
                <input type="text" class="form-control" name="nome-usuario" id="nome-usuario" required>
                <span id="cvnome">Campo Vazio!</span>
              </div>
              <div class="form-group">
                <label for="usu_nome">E-mail</label>
                <input type="email" class="form-control" name="email-usuario" id="email-usuario" required>
                <span id="cvemail">Campo Vazio!</span>
                <span id="cvemailV">Endereço de e-mail inválido!</span>
              </div>
              <div class="form-group">
                <label for="experienciaCad_desc">CPF</label>
                <input type="text" class="form-control" name="cpf" id="cpf-usuario" required>
                <span id="cvcpf">Campo Vazio!</span>
                <span id="cvcpfA">CPF Inválido ou já Cadastrado</span>
                <span id="cvcpfAT">CPF Valido</span>
              </div>
              <div class="form-group">
                <label for="usu_setor">Departamento</label>
                <select class="form-control" id="usu_setor" required>
                  <option value="Selecione">Selecione</option>
                  <?php foreach ($d as $itens): ?>
                    <option value="<?php echo $itens['id'] ?>">
                      <?php echo $itens['nome'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <span id="cvdepar">Campo Vazio!</span>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">É Gestor</label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membergerente" id="membershipRadios1"
                          value="1">
                        Sim
                        <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membergerente" id="membershipRadios2"
                          value="0" checked>
                        Não
                        <i class="input-helper"></i></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gestor Direto</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="usu_gestorD" required>
                      <option value="Selecione">Selecione</option>
                      <?php foreach ($u as $itens): ?>
                        <option value="<?php echo $itens['id'] ?>">
                          <?php echo mb_strtoupper($itens['nome']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <span id="cvgestor">Campo Vazio!</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Busca Gestor</label>
                  <div class="col-sm-9">
                    <input type="text" id="searchusu_gestorD" class="form-control" name="search"
                      placeholder="Pesquisar Usuário">
                  </div>
                </div>
              </div>
              </div>
              <button type="submit" id="btn-gravar" class="btn btn-dark mr-2">Cadastrar</button>
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