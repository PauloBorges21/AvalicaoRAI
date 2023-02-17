<?php
include 'header-rh.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['rhRai'])) {
    header("Location: index-rh.php");
    exit();
}

$id_departamento = filter_input(INPUT_GET, 'id_departamento', FILTER_SANITIZE_URL);
$id_usuario = filter_input(INPUT_GET, 'id_nome', FILTER_SANITIZE_URL);


$departamento = new Departamento($pdo);
$d = $departamento->getDepartamento();

$usuario = new Funcionario($pdo);
$u = $usuario->getAll($id_usuario);

$g = $usuario->getGestores();
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
                <input type="text" class="form-control" name="nome-usuario-edit" value="<?php echo $u['NOME_FUNC']?>" id="nome-usuario-edit" required>
                <input type="hidden" class="form-control" name="nome-usuario-edit" value="<?php echo $u['id']?>" id="id-usuario-edit" required>
                <span id="cvnome">Campo Vazio!</span>
              </div>
              <div class="form-group">
                <label for="usu_nome">E-mail</label>
                <input type="email" class="form-control" name="email-usuario-edit" id="email-usuario-edit" value="<?php echo $u['email']?>" required>
                <span id="cvemail">Campo Vazio!</span>
                <span id="cvemailV">Endereço de e-mail inválido!</span>
              </div>
              <div class="form-group">
                <label for="experienciaCad_desc">CPF</label>
                <input type="text" class="form-control" disabled value="<?php echo $u['cpf']?>" name="cpf" id="cpf-usuario-edit" required>
                <span id="cvcpf">Campo Vazio!</span>
                <span id="cvcpfA">CPF Inválido ou já Cadastrado</span>
                <span id="cvcpfAT">CPF Valido</span>
              </div>
              <div class="form-group">
                <label for="usu_setor">Departamento</label>
                <select class="form-control" id="dp-usuario-edit" required>
                  <option value="Selecione">Selecione</option>
                  <?php foreach ($d as $itens): ?>
                    <option <?php echo ($itens['id'] == $u['id_departamento'] ? ' selected' : '' )?> value="<?php echo $itens['id']?>">
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
                          value="1" <?php echo ($u['flag_gestor'] != 0 || $u['flag_gestor'] != ""   ? ' CHECKED' : '') ?> id='membershipRadios1' value='1'>                        
                        Sim
                        <i class="input-helper"></i></label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membergerente" id="membershipRadios2"
                        <?php echo ($u['flag_gestor'] == 0 || $u['flag_gestor'] == ""   ? ' CHECKED' : '') ?> value="0">
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
                    <select class="form-control" id="dp-gestor-edit" required>
                      <option value="Selecione">Selecione</option>
                      <?php foreach ($g as $itens): ?>
                        <option value="<?php echo $itens['id'] ?>" <?php echo ($itens['id'] == $u['id_gestor_direto'] ? ' selected' : '' )?>>
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
              <button type="submit" id="btn-editar" class="btn btn-dark mr-2">Editar</button>
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