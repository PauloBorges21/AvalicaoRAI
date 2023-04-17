<?php
spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
require_once("../../config.php");


$idUsuario = $_POST['usuario'];
$usuario = new Funcionario($pdo);
$departamento = new Departamento($pdo);

$u = $usuario->getAll($idUsuario);
$gestores = $usuario->getAllFG();
$d = $departamento->getDepartamento();
$g = $departamento->getGestor($idUsuario);

if ($u):
    echo "
  <div class='row'>  
<div class='col-md-6'>
  <div class='form-group row'>
    <label class='col-sm-6 col-form-label'>Nome</label>
    <div class='col-sm-9'>
      <input type='text' id='nome-usuario-edit' class='form-control' value='" . mb_strtoupper($u["NOME_FUNC"]) . "'/>
      <span id='cvemail'style='display:none;'>Campo Vazio!</span>  
      <span id='cvemailV'style='display:none;'>Endereço de e-mail inválido!</span>
      <input type='hidden' id='id-usuario-edit' value='". $u["id"] ."'/>
    </div>
  </div>
</div>
<div class='col-md-6'>
<div class='form-group row'>
    <label class='col-sm-6 col-form-label'>Departamento</label>
    <div class='col-sm-9'>
        <select class='form-control' id='dp-usuario-edit' required>
            <option value='Selecione'>Selecione</option>";
    foreach ($d as $itens):
        echo '<option value="' . $itens['id'] . '"' . ($itens['id'] == $u["id_departamento"] ? ' selected' : '') . '>' . $itens['nome'] . '</option>';
    endforeach;
    echo "</select>
    <span id='cvdepar'style='display:none;'>Campo Vazio!</span>
    </div>
</div>
</div>


<div class='col-md-6'>
  <div class='form-group row'>
    <label class='col-sm-6 col-form-label'>E-mail</label>
    <div class='col-sm-9'>
      <input type='text' id='email-usuario-edit' class='form-control' value='" . $u["email"] . "'/>
    </div>
    <span id='cvemail' style='display:none;'>Campo Vazio!</span>  
    <span id='cvemailV' style='display:none;'>Endereço de e-mail inválido!</span>
  </div>
</div>
<div class='col-md-6'>
  <div class='form-group row'>
    <label class='col-sm-6 col-form-label'>CPF</label>
    <div class='col-sm-9'>
      <input type='text' class='form-control' disabled name='cpf' id='cpf-usuario-edit' value='" . $u["cpf"] . "'/>
    </div>
  </div>
</div>
<div class='col-md-6'>
<div class='form-group row'>
  <label class='col-sm-3 col-form-label'>É Gerente</label>
  <div class='col-sm-4'>
    <div class='form-check'>
      <label class='form-check-label'>
        <input type='radio' class='form-check-input' name='membergerente' ". ($g != false  ? ' CHECKED' : '') ." id='membershipRadios1' value='1'>
        Sim
      <i class='input-helper'></i></label>
    </div>
  </div>
  <div class='col-sm-5'>
    <div class='form-check'>
      <label class='form-check-label'>
        <input type='radio' class='form-check-input' name='membergerente' id='membershipRadios2' value='0' ". ($g == false  ? ' CHECKED' : '') ." >
        Não
      <i class='input-helper'></i></label>
    </div>
  </div>
</div>
</div>
<div class='col-md-6'>
<div class='form-group row'>
    <label class='col-sm-6 col-form-label'>Gestor</label>
    <div class='col-sm-9'>
        <select class='form-control' id='dp-gestor-edit' required>
            <option value='Selecione'>Selecione</option>";
    foreach ($gestores as $itens):
        echo '<option value="' . $itens['id'] . '"' . ($itens['id'] == $u["id_gestor_direto"] ? ' selected' : '') . '>' . $itens['nome'] . '</option>';
    endforeach;
    echo "</select>
    <span id='cvgestores'style='display:none;'>Campo Vazio!</span>
    </div>
</div>
</div>"
;
else:
    echo 'false';
endif;