<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("SELECT * FROM Productos");
$productos = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarProducto() {
        $.get("modulos/productos/formulario.php", function(data) {
            $("#nuevo_productoModal .modal-body").html(data);
            $("#nuevo_productoModal").modal("show");
        });
    }

    function editarProducto(idproducto) {
        const url = `modulos/productos/formulario.php?id=${idproducto}`;
        $.get(url, function(data) {
            $("#modificarModal .modal-body").html(data);
            $("#modificarModal").modal("show");
        }).fail(function() {
            alert("Error al cargar el formulario.");
        });
    }

    function eliminarProducto(idproducto, nombreProducto) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Estás seguro de que deseas eliminar el producto "${nombreProducto}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("modulos/productos/eliminar.php?id=" + idproducto, function(data) {
                    var response = JSON.parse(data);
                    if (response.status === "success") {
                        $.get("modulos/productos/listar.php", function(data) {
                            $("#workspace").html(data);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar producto. ' + response.message
                        });
                    }
                });
            }
        });
    }
</script>

<div class="col-xs-12">
    <h1>Productos</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarProducto()" class="btn btn-success">
            Nuevo Producto
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $producto) { ?>
            <tr>
                <td><?php echo $producto->id; ?></td>
                <td><?php echo $producto->nombre; ?></td>
                <td><?php echo $producto->descripcion; ?></td>
                <td><?php echo $producto->precio; ?></td>
                <td><?php echo $producto->stock; ?></td>
                <td><?php echo $producto->unidad; ?></td>
                <td>
                    <button onclick="editarProducto(<?php echo $producto->id; ?>)" class="btn btn-primary">
                        Modificar
                    </button>
                </td>
                <td>
                    <button onclick="eliminarProducto(<?php echo $producto->id; ?>, '<?php echo htmlspecialchars($producto->nombre, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-danger">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Ventana modal para nuevo producto -->
<div class="modal fade" id="nuevo_productoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para agregar producto -->
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para modificar producto -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para editar producto -->
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Actualizar</button> -->
            </div>
        </div>
    </div>
</div>