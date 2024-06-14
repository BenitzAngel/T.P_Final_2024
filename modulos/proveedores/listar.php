<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("SELECT * FROM proveedores");
$proveedores = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarProveedor() {
        $.get("modulos/proveedores/formulario.php", function(data) {
            $("#nuevo_proveedoresModal .modal-body").html(data);
            $("#nuevo_proveedoresModal").modal("show");
        });
    }

    function editarProveedor(idproveedor) {
        const url = `modulos/proveedores/formulario.php?id=${idproveedor}`;
        $.get(url, function(data) {
            $("#modificarModal .modal-body").html(data);
            $("#modificarModal").modal("show");
        }).fail(function() {
            alert("Error al cargar el formulario.");
        });
    }

    function eliminarProveedor(idproveedor, nombreProveedor) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Estás seguro de que deseas eliminar al proveedor "${nombreProveedor}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("modulos/proveedores/eliminar.php?id=" + idproveedor, function(data) {
                    var response = JSON.parse(data);
                    if (response.status === "success") {
                        $.get("modulos/proveedores/listar.php", function(data) {
                            $("#workspace").html(data);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar cliente. ' + response.message
                        });
                    }
                });
            }
        });
    }
</script>

<div class="col-xs-12">
    <h1>Proveedores</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarProveedor()" class="btn btn-success">
            Nuevo Proveedor
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Empresa</th>
                <th>Dirección</th>
                <th>Altura</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($proveedores as $proveedor) { ?>
            <tr>
                <td><?php echo $proveedor->id; ?></td>
                <td><?php echo $proveedor->nombre; ?></td>
                <td><?php echo $proveedor->apellido; ?></td>
                <td><?php echo $proveedor->empresa; ?></td>                 
                <td><?php echo $proveedor->direccion; ?></td>
                <td><?php echo $proveedor->altura; ?></td>
                <td><?php echo $proveedor->email; ?></td>
                <td><?php echo $proveedor->telefono; ?></td>

                <td>
                    <button onclick="editarProveedor(<?php echo $proveedor->id; ?>)" class="btn btn-primary">
                        Modificar
                    </button>
                </td>
                <td>
                    <button onclick="eliminarProveedor(<?php echo $proveedor->id; ?>, '<?php echo htmlspecialchars($proveedor->nombre, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-danger">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Ventana modal para nuevo cliente -->
<div class="modal fade" id="nuevo_proveedoresModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para agregar cliente -->
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para modificar cliente -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Proveedor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para editar cliente -->
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Actualizar</button>
            </div> -->
        </div>
    </div>
</div>