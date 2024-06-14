<?php
include_once("../../db/conexion.php");

$id = '';
$nombre = '';
$descripcion = '';
$precio = '';
$stock = '';
$unidad = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Productos WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_OBJ);

    $nombre = $producto->nombre;
    $descripcion = $producto->descripcion;
    $precio = $producto->precio;
    $stock = $producto->stock;
    $unidad = $producto->unidad;
}
?>

<form id="formProducto" method="POST" action="modulos/productos/<?php echo $id ? 'editar.php' : 'agregar.php'; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" ><?php echo $descripcion; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="precio" class="col-form-label">Precio:</label>
        <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $precio; ?>" required>
    </div>
    <div class="mb-3">
        <label for="stock" class="col-form-label">Stock:</label>
        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $stock; ?>">
    </div>
    <div class="mb-3">
        <label for="unidad" class="col-form-label">Unidad:</label>
        <input type="text" class="form-control" id="unidad" name="unidad" value="<?php echo $unidad; ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>



<script>
    $("#formProducto").submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Producto guardado exitosamente.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $.get("modulos/productos/listar.php", function(data) {
                        $("#workspace").html(data);
                    });

                    $("#nuevo_productoModal").modal("hide");
                    $("#modificarModal").modal("hide");
                } else {
                    console.error("Error en el servidor:", response.message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al guardar el producto. ' + response.message
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                console.error("Response Text:", jqXHR.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud AJAX. Por favor, inténtalo de nuevo.'
                });
            }
        });
    });
</script>

