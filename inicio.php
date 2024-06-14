
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
                    <!-- <a href="#" class="sidebar-link" id="cliente" data-item="cliente" data-destino="<?php echo BASE_URL; ?>modulos/cliente/clientes.php">
                        <i class="lni lni-user"></i>
                        <span>Clientes</span>
                    </a> -->
                </li>
                <li class="sidebar-item">
                    <!-- <a href="#" class="sidebar-link" id="producto" data-item="producto" data-destino="<?php echo BASE_URL; ?>modulos/productos/listar.php">
                        <i class="lni lni-agenda"></i>
                        <span>Productos Panificados</span>
                    </a> -->
                </li>

                <!-- venta -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#venta" aria-expanded="false" aria-controls="venta">
                        <i class="lni lni-investment"></i>
                        <span>Ventas</span>
                    </a>
                    <ul id="venta" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="clientes" data-item="clientes" data-destino="<?php echo BASE_URL; ?>modulos/clientes/listar.php">
                            <i class="lni lni-users"></i>
                                Clientes
                            </a>
                        </li>
                        <a href="#" class="sidebar-link" id="factura_venta" data-item="factura_venta" data-destino="<?php echo BASE_URL; ?>modulos/ventas/listar.php">
                        <i class="lni lni-ticket-alt"></i>
                                Factura de ventas
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Inventario</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                        <a href="#" class="sidebar-link" id="producto" data-item="producto" data-destino="<?php echo BASE_URL; ?>modulos/productos/listar.php">
                            <i class="lni lni-agenda"></i>
                            <span>Productos Panificados</span>
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
                </li> -->

                <!-- compra -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#compra" aria-expanded="false" aria-controls="compra">
                        <i class="lni lni-revenue"></i>
                        <span>Compra</span>
                    </a>
                    <ul id="compra" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="proveedor" data-item="proveedor" data-destino="<?php echo BASE_URL; ?>modulos/proveedores/listar.php">
                            <i class="lni lni-network"></i>
                                Proveedores
                            </a>
                        </li>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="factura_compra" data-item="factura_compra" data-destino="<?php echo BASE_URL; ?>modulos/gastos/listar.php">
                            <i class="lni lni-ticket-alt"></i>
                                Facturas de compras
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- inventario -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#inventario" aria-expanded="false" aria-controls="inventario">
                        <i class="lni lni-package"></i>
                        <span>Inventario</span>
                    </a>
                    <ul id="inventario" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        
                        <li class="sidebar-item">
                        <a href="#" class="sidebar-link" id="ingredientes" data-item="ingredientes" data-destino="<?php echo BASE_URL; ?>modulos/ingredientes/listar.php">
                            <i class="lni lni-clipboard"></i>
                                Ingredientes
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="recetas" data-item="recetas" data-destino="<?php echo BASE_URL;?>modulos/recetas/listar_recetas.php">
                            <i class="lni lni-pencil-alt"></i>
                                Recetas
                            </a>
                        </li>
                        <li class="sidebar-item">
                        <a href="#" class="sidebar-link" id="producto" data-item="producto" data-destino="<?php echo BASE_URL; ?>modulos/productos/listar.php">
                        <i class="lni lni-producthunt"></i>
                            Productos Panificados
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" id="ayuda"class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Ayuda</span>
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
    $("#clientes").click(function() {
                $.get("modulos/clientes/listar.php", function(data) {
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

$(document).ready(function() {
    $("#proveedor").click(function() {
                $.get("modulos/proveedores/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });

$(document).ready(function() {
    $("#ingredientes").click(function() {
                $.get("modulos/ingredientes/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });
        
$(document).ready(function() {
    $("#recetas").click(function() {
                $.get("modulos/recetas/listar_recetas.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });

$(document).ready(function() {
    $("#factura_venta").click(function() {
                $.get("modulos/ventas/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });
        
        $(document).ready(function() {
    $("#factura_compra").click(function() {
                $.get("modulos/gastos/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            });
        });

        document.getElementById('ayuda').addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del enlace
            console.log("Botón de ayuda clickeado."); // Verificación de evento
            window.open("Manual_del_Usuario.pdf", '_blank');
        });
</script>


    <?php include("pie.php") ?>