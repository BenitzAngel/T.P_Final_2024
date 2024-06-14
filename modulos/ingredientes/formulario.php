<?php
include_once("../../db/conexion.php");

$id = '';
$nombre = '';
$descripcion = '';
$stock = '';
$fecha_vencimiento = '';
$unidad = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Ingredientes WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id]);
    $ingrediente = $stmt->fetch(PDO::FETCH_OBJ);

    $nombre = $ingrediente->nombre;
    $descripcion = $ingrediente->descripcion;
    $fecha_vencimiento = $ingrediente->fecha_vencimiento;
    $stock = $ingrediente->stock;
    $unidad = $ingrediente->unidad;
}
?>

<form id="formIngrediente" method="POST" action="modulos/ingredientes/<?php echo $id ? 'editar.php' : 'agregar.php'; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $descripcion; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="fecha_vencimiento" class="col-form-label">Fecha de Vencimiento:</label>
        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $fecha_vencimiento; ?>" required>
    </div>
    <div class="mb-3">
        <label for="stock" class="col-form-label">Stock:</label>
        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $stock; ?>" required>
    </div>
    <div class="mb-3">
        <label for="unidad" class="col-form-label">Unidad:</label>
        <select class="form-control" id="unidad" name="unidad">
            <option value="kg" <?php if ($unidad == 'kg') echo 'selected'; ?>>Kilogramos</option>
            <option value="cm3" <?php if ($unidad == 'cm3') echo 'selected'; ?>>Centímetros Cúbicos</option>
            <option value="g" <?php if ($unidad == 'grs') echo 'selected'; ?>>Gramos</option>
            <option value="docenas" <?php if ($unidad == 'docenas') echo 'selected'; ?>>Docenas</option>
            <option value="unidad" <?php if ($unidad == 'unidad') echo 'selected'; ?>>Unidad</option>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>


<script>
    // Script AJAX para enviar el formulario
    $("#formIngrediente").submit(function(event) {
        event.preventDefault();
        // validaciones
        var nombre = $("#nombre").val().trim();

        var letrasRegex = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/;
        

         // Validación para nombre
       if (!nombre.match(letrasRegex)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El campo Nombre solo debe contener letras y espacios.'
            });
            return false;
        }

        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    console.log("Operación exitosa");
                    $.get("modulos/ingredientes/listar.php", function(data) {
                        $("#workspace").html(data);
                    });
                    $("#nuevo_ingredienteModal").modal("hide");
                    $("#modificarModal").modal("hide");
                } else {
                    console.error("Error en el servidor:", response.message);
                    alert("Error en el servidor: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                alert("Error en la solicitud AJAX. Por favor, inténtalo de nuevo.");
            }
        });
    });
</script>