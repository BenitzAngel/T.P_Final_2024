<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("SELECT * FROM Ingredientes");
$ingredientes = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarIngrediente() {
        $.get("modulos/ingredientes/formulario.php", function(data) {
            $("#nuevo_ingredienteModal .modal-body").html(data);
            $("#nuevo_ingredienteModal").modal("show");
        });
    }

    function editarIngrediente(idIngrediente) {
        const url = `modulos/ingredientes/formulario.php?id=${idIngrediente}`;
        $.get(url, function(data) {
            $("#modificarModal .modal-body").html(data);
            $("#modificarModal").modal("show");
        }).fail(function() {
            alert("Error al cargar el formulario.");
        });
    }

    function eliminarIngrediente(idIngrediente, nombreIngrediente) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Estás seguro de que deseas eliminar el ingrediente "${nombreIngrediente}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get("modulos/ingredientes/eliminar.php?id=" + idIngrediente, function(data) {
                    var response = JSON.parse(data);
                    if (response.status === "success") {
                        $.get("modulos/ingredientes/listar.php", function(data) {
                            $("#workspace").html(data);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar ingrediente. ' + response.message
                        });
                    }
                });
            }
        });
    }
</script>

<div class="col-xs-12">
    <h1>Ingredientes</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarIngrediente()" class="btn btn-success">
            Nuevo Ingrediente
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Fecha de Compra</th>
                <th>Fecha de Vencimiento</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ingredientes as $ingrediente) { ?>
            <tr>
                <td><?php echo $ingrediente->id; ?></td>
                <td><?php echo $ingrediente->nombre; ?></td>
                <td><?php echo $ingrediente->descripcion; ?></td>
                <td><?php echo $ingrediente->stock; ?></td>
                <td><?php echo $ingrediente->unidad; ?></td>
                <td><?php echo $ingrediente->fecha_compra; ?></td>
                <td><?php echo $ingrediente->fecha_vencimiento; ?></td>
                <td>
                    <button onclick="editarIngrediente(<?php echo $ingrediente->id; ?>)" class="btn btn-primary">
                        Modificar
                    </button>
                </td>
                <td>
                    <button onclick="eliminarIngrediente(<?php echo $ingrediente->id; ?>, '<?php echo htmlspecialchars($ingrediente->nombre, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-danger">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Ventana modal para nuevo ingrediente -->
<div class="modal fade" id="nuevo_ingredienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Ingrediente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para agregar ingrediente -->
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para modificar ingrediente -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Ingrediente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluirá el formulario para editar ingrediente -->
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Actualizar</button>
            </div> -->
        </div>
    </div>
</div>