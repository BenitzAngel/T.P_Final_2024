<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("SELECT * FROM clientes");
$clientes = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarCliente() {
        $.get("modulos/clientes/formulario.php", function(data) {
            $("#nuevo_clienteModal .modal-body").html(data);
            $("#nuevo_clienteModal").modal("show");
        });
    }

    function editarCliente(idcliente) {
        const url = `modulos/clientes/formulario.php?id=${idcliente}`;
        $.get(url, function(data) {
            $("#modificarModal .modal-body").html(data);
            $("#modificarModal").modal("show");
        }).fail(function() {
            alert("Error al cargar el formulario.");
        });
    }

    function eliminarCliente(idcliente, nombreCliente) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Estás seguro de que deseas eliminar el cliente "${nombreCliente}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("modulos/clientes/eliminar.php?id=" + idcliente, function(data) {
                    var response = JSON.parse(data);
                    if (response.status === "success") {
                    // ventana de exto
                    Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Gasto eliminado exitosamente.',
                            timer: 2000,
                            showConfirmButton: false
                        });


                        $.get("modulos/clientes/listar.php", function(data) {
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
    <h1>Clientes</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarCliente()" class="btn btn-success">
            Nuevo Cliente
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Altura</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $cliente) { ?>
            <tr>
                <td><?php echo $cliente->id; ?></td>
                <td><?php echo $cliente->nombre; ?></td>
                <td><?php echo $cliente->apellido; ?></td>
                <td><?php echo $cliente->email; ?></td>
                <td><?php echo $cliente->telefono; ?></td>
                <td><?php echo $cliente->direccion; ?></td>
                <td><?php echo $cliente->altura; ?></td>
                <td>
                    <button onclick="editarCliente(<?php echo $cliente->id; ?>)" class="btn btn-primary">
                        Modificar
                    </button>
                </td>
                <td>
                    <button onclick="eliminarCliente(<?php echo $cliente->id; ?>, '<?php echo htmlspecialchars($cliente->nombre, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-danger">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Ventana modal para nuevo cliente -->
<div class="modal fade" id="nuevo_clienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Cliente</h1>
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