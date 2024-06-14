<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos->query("
    SELECT p.id AS id_producto, p.nombre AS p_nombre, GROUP_CONCAT(i.nombre SEPARATOR ', ') AS ingredientes
    FROM Productos p
    JOIN ProductosIngredientes pi ON p.id = pi.id_producto
    JOIN Ingredientes i ON pi.id_ingrediente = i.id
    GROUP BY p.id, p.nombre
");
$recetas = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<script>
    function agregarReceta() {
      // console.log("Función agregarProducto() llamada.")
        // Realiza una petición AJAX para obtener el contenido del formulario
        $.get("modulos/recetas/formulario.php", function(data) {
          // console.log("Contenido del formulario recibido:", data);
            // Inserta el contenido del formulario en el cuerpo de la ventana modal
            $("#nuevo_recetaModal").modal("show");
        });
    }



    function verReceta(id_producto) {
        $.get("modulos/recetas/ver_receta.php", { id: id_producto }, function(data) {
            $("#verRecetaModal .modal-body").html(data);
            $("#verRecetaModal").modal("show");
        }).fail(function() {
            alert("Error al cargar la receta.");
        });
    }

    function eliminarReceta(id_producto, nombreproducto) {
    console.log("ID del producto:", id_producto, nombreproducto);
    // Utiliza SweetAlert en lugar de confirm y alert
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Estás seguro de que deseas eliminar la receta del producto "${nombreproducto}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log("AJAX GET URL:", "modulos/recetas/eliminar.php?id=" + id_producto);
            $.get("modulos/recetas/eliminar.php?id=" + id_producto, function (data) {
                console.log("Response from server:", data);
                try {
                    var response = JSON.parse(data);

                    if (response.status === "success") {
                        // La eliminación fue exitosa, actualizar la vista
                        console.log("Operación exitosa");
                        $.get("modulos/recetas/listar_recetas.php", function (data) {
                            $("#workspace").html(data);
                        });
                    } else {
                        // Hubo un error, mostrar el mensaje de error con SweetAlert
                        console.error("Error al eliminar receta:", response.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar receta. ' + response.message
                        });
                    }
                } catch (error) {
                    // Manejar errores al analizar JSON con SweetAlert
                    console.error("Error al analizar respuesta JSON:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al analizar respuesta JSON.'
                    });
                }
            });
        }
    });
}

</script>



<!-- tabla -->

<div class="col-xs-12">
    <h1>Recetas</h1>
    <div>
        <button type="button" id="btnAbrirModal" onclick="agregarReceta()" class="btn btn-success">
            Nueva Receta
        </button>
    </div>
    <br>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Producto</th>
                <th>Ver receta</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($recetas as $receta){ ?>
                <tr>
                    <td><?php echo $receta->p_nombre ?></td>
                    <td>
                        <button onclick="verReceta(<?php echo $receta->id_producto; ?>)" class="btn btn-primary">
                            Ver receta
                        </button>
                    </td>
                    <td>
                    <button id="eliminarProducto" onclick="eliminarReceta(<?php echo $receta->id_producto; ?>, '<?php echo htmlspecialchars($receta->p_nombre, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-danger">
                                Eliminar
                            </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- ventanas modal -->



    
        <!-- Ventana modal para nueva receta -->
<div class="modal fade" id="nuevo_recetaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Receta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php include("formulario.php"); ?>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para ver receta -->
<div class="modal fade" id="verRecetaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Receta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se carga el contenido de ver_receta.php -->
            </div>
        </div>
    </div>
</div>
 



