<?php


include 'header.php';
// $query = 'SELECT * FROM TipoVisao';
// $statement = $pdo->prepare($query);
// $statement->execute();
// $result = $statement->fetchAll(PDO::FETCH_NUM);

// var_dump($result);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?>


<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-center py-5 px-4 px-sm-5">
              <div class="brand-logo">
              <img src="../images/favicon.png" alt="logo">
              </div>
              <h4>Faça seu login para continuar.</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                <label for="login_un">E-mail</label>
                  <input type="email" class="form-control form-control-md" name="login_un" id="login_un" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <label for="login_pw">CPF</label>
                  <input type="password" class="form-control form-control-md" name="login_pw" id="login_pw" placeholder="Ex:12312312312">
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-dark btn-md font-weight-medium auth-form-btn" id="login-btn">Entrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
        $email = filter_input(INPUT_POST, 'login_un', FILTER_SANITIZE_EMAIL);
        $cpf = filter_input(INPUT_POST, 'login_pw', FILTER_SANITIZE_NUMBER_INT);        
        $cpf = str_replace('-', "", $cpf);


        $loginFuncionario = new Funcionario($pdo);

        if(!empty($cpf) && !empty($email))
        {
            $loginFuncionario = $loginFuncionario->getFuncionario($email,$cpf);
               if($loginFuncionario){
                header("Location: avaliacao-pag.php");
            }else{
                echo '<p>Usuário e/ou Senha errados!</p>';
            }
        }
?>

      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
  <?php include 'footer.php';?>