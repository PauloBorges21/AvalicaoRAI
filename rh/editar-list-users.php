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

$usuario = new Funcionario($pdo);
$u = $usuario->getAllF();

$paginador = new Paginacao($pdo);
$ativo = true;
$tableU = $paginador->getPagtbUser("",$ativo);
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
    #modal-container {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #modal {
        background-color: white;
        width: 300px;
        padding: 20px;
        margin: auto;
        margin-top: 100px;
    }

    #confirm-button, #cancel-button {
        padding: 10px;
        margin: 10px;
        border-radius: 5px;
    }

    #confirm-button {
        background-color: red;
        color: white;
    }

    #cancel-button {
        background-color: gray;
        color: white;
    }
</style>
<!-- partial:partials/_sidebar.html -->
<?php include('inc/side-nav.php'); ?>
<!-- partial -->

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usuário</h4>
                    <form class="form-sample">
                        <p class="card-description">Editar Usuário</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Busca Nome</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="searchusuario" class="form-control" name="search"
                                               placeholder="Pesquisar Departamento">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Departamento</label>
                                    <div class="col-md-7">
                                        <select class="form-control" id="usu_tb_setor" required>
                                            <option value="Selecione">Selecione</option>
                                            <?php foreach ($d as $itens): ?>
                                                <option value="<?php echo $itens['id'] ?>">
                                                    <?php echo mb_strtoupper($itens['nome']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
<!--                            <div class="col-md-6">-->
<!--                                <div class="form-group row">-->
<!--                                    <label class="col-sm-3 col-form-label">Busca DP</label>-->
<!--                                    <div class="col-sm-9">-->
<!--                                        <input type="text" id="searchdepertamento" class="form-control" name="search"-->
<!--                                            placeholder="Pesquisar Departamento">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tb-striped" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Departamento</th>
                                                        <th>Nome</th>
                                                        <th>Email</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tableU as $tbItens): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo mb_strtoupper($tbItens['departamento']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo strtoupper($tbItens['nome']); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $tbItens['email']; ?>
                                                            </td>
                                                            <td>
                                                                <a href="editar-users.php?id_nome=<?php echo $tbItens['id'] ?>&id_departamento=<?php echo $tbItens['id_departamento'] ?>">
                                                                    <button type="button" class="btn btn-primary btn-sm">Editar</button>
                                                                </a>
                                                                <button type="button" id="delete-button" data-id="<?php echo $tbItens['id'] ?>" class="btn btn-danger btn-sm">Desativar</button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <div id="modal-container">
                                                <div id="modal">
                                                    <p>Tem certeza que deseja excluir?</p>
                                                    <button id="confirm-button">Confirmar</button>
                                                    <button id="cancel-button">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul id="pagination" class="pagination">
                                        <li>
                                            <?php $montar = $paginador->ordenarTbUser($ativo) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <span id="formceditar"></span>
                        <button type="submit" id="btn-editar" class="btn btn-dark mr-2">Editar</button>
                        <button type="reset" class="btn btn-light">Limpar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer-rh.php'; ?>
<script>
    const deleteButton = document.getElementById('delete-button');
    const modalContainer = document.getElementById('modal-container');
    const confirmButton = document.getElementById('confirm-button');
    const cancelButton = document.getElementById('cancel-button');
    const buttons = document.querySelectorAll('button[data-id]');

    console.log(buttons)
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            modalContainer.style.display = 'block';
            const id = button.getAttribute('data-id');
            desativaUsuario(id)
        });
    });
        deleteButton.addEventListener('click', () => {
            modalContainer.style.display = 'block';
        });

        confirmButton.addEventListener('click', () => {

            modalContainer.style.display = 'none';
        });

        cancelButton.addEventListener('click', () => {
            modalContainer.style.display = 'none';
        });

        function desativaUsuario(iduser) {
            $.ajax({
                url: "ajax/ajax-desativa-usuario.php",
                method: "POST",
                dataType: "json",
                data: {
                    usuario: iduser,
                },
                success: function (arr) {
                    alert('DEU CERTO');
                }
            });
        }

</script>
