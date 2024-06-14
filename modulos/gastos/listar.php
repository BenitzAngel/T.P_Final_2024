<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("SELECT id, descripcion, monto, 

           DATE_FORMAT(fecha_gasto, '%h-%d-%m-%Y %h:%i %p') as fecha_gasto_formateada
            FROM Gastos");
$gastos = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarGasto() {
        $.get("modulos/gastos/formulario.php", function(data) {
            $("#nuevo_gastoModal .modal-body").html(data);
            $("#nuevo_gastoModal").modal("show");
        });
    }

    function editarGasto(idgasto) {
        const url = `modulos/gastos/formulario.php?id=${idgasto}`;
        $.get(url, function(data) {
            $("#modificarModal .modal-body").html(data);
            $("#modificarModal").modal("show");
        }).fail(function() {
            alert("Error al cargar el formulario.");
        });
    }

    function eliminarGasto(idgasto) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro de que deseas eliminar este gasto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("modulos/gastos/eliminar.php?id=" + idgasto, function(data) {
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

                        $.get("modulos/gastos/listar.php", function(data) {
                            $("#workspace").html(data);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar el gasto. ' + response.message
                        });
                    }
                });
            }
        });
    }

    // Función para manejar el envío del formulario de agregar o editar
    $(document).on('submit', '#formGasto', function(event) {
        event.preventDefault();
  
        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');

        $.post(actionUrl, formData, function(response) {
            if (response.status === "success") {
            // ventana de exito
                Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Gasto guardado exitosamente.',
                timer: 2000, // Tiempo en milisegundos antes de cerrar automáticamente
                showConfirmButton: false // Ocultar el botón de confirmación
            });

                $('#nuevo_gastoModal').modal('hide');
                $('#modificarModal').modal('hide');
                $.get("modulos/gastos/listar.php", function(data) {
                    $("#workspace").html(data);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar el gasto. ' + response.message
                });
            }
        }, 'json');
    });

    // Limpiar contenido del modal cuando se cierra
    $('#nuevo_gastoModal, #modificarModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-body').html('');
    });
</script>

<div class="col-xs-12">
    <h1>Gastos</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarGasto()" class="btn btn-success">
            Nuevo Gasto
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Fecha Gasto</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($gastos as $gasto) { ?>
            <tr>
                <td><?php echo $gasto->id; ?></td>
                <td><?php echo $gasto->descripcion; ?></td>
                <td><?php echo $gasto->monto; ?></td>
                <td><?php echo $gasto->fecha_gasto_formateada; ?></td>
                <td>
                    <button onclick="editarGasto(<?php echo $gasto->id; ?>)" class="btn btn-primary">
                        Modificar
                    </button>
                </td>
                <td>
                    <button onclick="eliminarGasto(<?php echo $gasto->id; ?>)" class="btn btn-danger">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Ventana modal para nuevo gasto -->
<div class="modal fade" id="nuevo_gastoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Gasto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para agregar gasto -->
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para modificar gasto -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Gasto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para editar gasto -->
            </div>
        </div>
    </div>
</div>
