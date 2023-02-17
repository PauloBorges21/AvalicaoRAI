<style>
    .page-body-wrapper {

        padding-top: 0px !important;
    }
</style>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">

                <li class="nav-item">
                    <a class="nav-link" href="rh-dash.php">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                        <i class="icon-bar-graph menu-icon"></i>
                        <span class="menu-title">Graficos</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="status-questionario.php">Status</a></li>
                            
                        </ul>
                    </div>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title">Usuário</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="registro-users.php"> Cadastro </a></li>
                            <li class="nav-item"> <a class="nav-link" href="editar-list-users.php"> Editar </a></li>
                        </ul>
                    </div>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#dp" aria-expanded="false" aria-controls="auth">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title">Departamento</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="dp">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="registro-dp.php"> Cadastro </a></li>                            
                        </ul>
                    </div>
                </li>               
            </ul>
        </nav>



