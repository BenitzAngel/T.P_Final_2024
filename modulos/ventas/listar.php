<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("
    SELECT v.id, v.fecha_venta, v.total, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente 
    FROM Ventas v
    JOIN Clientes c ON v.id_cliente = c.id
");
$ventas = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarVenta() {
        $.get("modulos/ventas/formulario.php", function(data) {
            $("#nueva_ventaModal .modal-body").html(data);
            $("#nueva_ventaModal").modal("show");
        });
    }

    function editarVenta(idventa) {
        const url = `modulos/ventas/formulario.php?id=${idventa}`;
        $.get(url, function(data) {
            $("#modificarModal .modal-body").html(data);
            $("#modificarModal").modal("show");
        }).fail(function() {
            alert("Error al cargar el formulario.");
        });
    }

    function eliminarVenta(idventa) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro de que deseas eliminar esta venta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("modulos/ventas/eliminar.php?id=" + idventa, function(data) {
                    var response = JSON.parse(data);
                    if (response.status === "success") {
                        $.get("modulos/ventas/listar.php", function(data) {
                            $("#workspace").html(data);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar la venta. ' + response.message
                        });
                    }
                });
            }
        });
    }

    // Función para manejar el envío del formulario de agregar o editar
    $(document).on('submit', '#formVenta', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');

        $.post(actionUrl, formData, function(response) {
            if (response.status === "success") {
                $('#nueva_ventaModal').modal('hide');
                $('#modificarModal').modal('hide');
                $.get("modulos/ventas/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar la venta. ' + response.message
                });
            }
        }, 'json');
    });
</script>

<div class="col-xs-12">
    <h1>Ventas</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarVenta()" class="btn btn-success">
            Nueva Venta
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha Venta</th>
                <th>Total</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ventas as $venta) { ?>
            <tr>
                <td><?php echo $venta->id; ?></td>
                <td><?php echo $venta->nombre_cliente . ' ' . $venta->apellido_cliente; ?></td>
                <td><?php echo $venta->fecha_venta; ?></td>
                <td><?php echo $venta->total; ?></td>
                <td>
                    <button onclick="editarVenta(<?php echo $venta->id; ?>)" class="btn btn-primary">
                        Modificar
                    </button>
                </td>
                <td>
                    <button onclick="eliminarVenta(<?php echo $venta->id; ?>)" class="btn btn-danger">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Ventana modal para nueva venta -->
<div class="modal fade" id="nueva_ventaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Venta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para agregar venta -->
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para modificar venta -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Venta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para editar venta -->
            </div>
        </div>
    </div>
</div>
