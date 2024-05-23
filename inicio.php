
<?php include_once("db/conexion.php") ?>
<?php include("encabezado.php") ?>


<body>
<!-- nav-bar -->
<div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="inicio.php">Panaderia La Reina</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" id="cliente" data-item="cliente" data-destino="<?php echo BASE_URL; ?>modulos/cliente/clientes.php">
                        <i class="lni lni-user"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" id="producto" data-item="producto" data-destino="<?php echo BASE_URL; ?>modulos/productos/listar.php">
                        <i class="lni lni-agenda"></i>
                        <span>Productos Panificados</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Auth</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Login</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Register</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Multi Level</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                Two Links
                            </a>
                            <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Link 1</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Link 2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="modulos/login/cierre_sesion.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">
        

        <!-- dashwork o sona de trabajo -->
<div class="container mt-4" id="workspace">
    <!-- Contenido de tu sistema, aquí puedes cargar dinámicamente tus módulos -->
    <div class="text-center">
        <h2>Bienvenido al Sistema de Gestión</h2>
        <img src="img/inicio.png" alt="Imagen de trabajo" class="img-fluid mt-3" style="width: 300px; height: auto;">
    </div>
</div>


<script>
// $(document).ready(function() {
//     $("#home").click(function() {
//                 $.get("inicio.php", function(data) {
//                     $("#workspace").html(data);
//                 });
//             });
//         });

$(document).ready(function() {
    $("#cliente").click(function() {
                $.get("modulos/cliente/clientes.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });

$(document).ready(function() {
    $("#producto").click(function() {
                $.get("modulos/productos/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });
        
</script>


    <?php include("pie.php") ?>