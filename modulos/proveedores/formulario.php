<?php
include_once("../../db/conexion.php");

$id = '';
$nombre = '';
$apellido = '';
$empresa = '';
$direccion = '';
$altura = '';
$email = '';
$telefono = '';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM proveedores WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id]);
    $proveedor = $stmt->fetch(PDO::FETCH_OBJ);

    $nombre = $proveedor->nombre;
    $apellido = $proveedor->apellido;
    $empresa = $proveedor->empresa;   
    $direccion = $proveedor->direccion;
    $altura = $proveedor->altura;
    $email = $proveedor->email;
    $telefono = $proveedor->telefono;
 
}
?>

<form id="formProveedor" method="POST" action="modulos/proveedores/<?php echo $id ? 'editar.php' : 'agregar.php'; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="col-form-label">Apellido:</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
    </div>
    <div class="mb-3">
        <label for="empresa" class="col-form-label">Empresa:</label>
        <input type="text" class="form-control" id="empresa" name="empresa" value="<?php echo $empresa; ?>" required>
    </div>
    <div class="mb-3">
        <label for="direccion" class="col-form-label">Dirección:</label>
        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
    </div>
    <div class="mb-3">
        <label for="altura" class="col-form-label">Altura:</label>
        <input type="number" class="form-control" id="altura" name="altura" value="<?php echo $altura; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="col-form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="mb-3">
        <label for="telefono" class="col-form-label">Teléfono:</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>

<!-- Llama al script de validación justo después del formulario -->
<script src="js/validarProveedor.js"></script>

<script>
    // Script AJAX para enviar el formulario
    $("#formProveedor").submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    console.log("Operación exitosa");
                    $.get("modulos/proveedores/listar.php", function(data) {
                        $("#workspace").html(data);
                    });
                    $("#nuevo_proveedoresModal").modal("hide");
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