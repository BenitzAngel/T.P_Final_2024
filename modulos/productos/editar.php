<?php

// Incluye el archivo de conexión a la base de datos
include_once("../../db/conexion.php");

if ($base_de_datos === false) {
  exit("Error al conectar a la base de datos.");
}


// Verifica si se proporciona un ID en la URL
if (!isset($_GET["id"])) {
    exit("No se proporcionó un ID de producto.");
}
// Obtiene el ID del producto desde la URL
$id_producto = $_GET["id"];



// Prepara y ejecuta la consulta para obtener los datos del producto
$sentencia = $base_de_datos->prepare("SELECT * FROM producto WHERE id_producto = ?;");
$sentencia->execute([$id_producto]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);

// Verifica si se encontró el producto
if ($producto === false) {
    exit("El producto no existe o no se encontró en la base de datos.");
}

?>

<form id="formulario_editar">

<input type="hidden" id="id_producto" name="id_producto" value="<?php echo htmlspecialchars($producto->id_producto); ?>">


<div class="mb-3">
  <label for="recipient-name" class="col-form-label">Nombre:</label>
  <input type="text" class="form-control" id="nombre" name= "nombre" value="<?php echo $producto->nombre; ?>">
</div>

<div class="mb-3">
  <label for="message-text" class="col-form-label">Descripción:</label>
  <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($producto->descripcion); ?></textarea></div>

<div class="mb-3">
  <label for="fecha" class="col-form-label">Fecha de Elaboración:</label>
  <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $producto->fecha_ingreso ; ?>">
</div>

<div class="mb-3">
  <label for="cantidad" class="col-form-label">Cantidad (kg):</label>
  <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $producto->cantidad; ?>">
</div>

<div class="mb-3">
  <label for="precio_venta" class="col-form-label">Precio de Venta:</label>
  <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" value="<?php echo $producto->precio; ?>">
</div>

<div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit"  class="btn btn-primary">Guardar</button>
</div>
</form>


<script>
$("#formulario_editar").submit(function(event) {
    event.preventDefault();
    ("Formulario enviado"); // Agregado para verificar si el evento se activa correctamente
    var formData = $(this).serialize();
    
    $.ajax({
        type: "POST",
        url: "modulos/productos/guardarDatosEditados.php",
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                // Éxito: manejar según necesidades
                console.log("Operación exitosa");
                $.get("modulos/productos/listar.php", function(data) {
                    $("#workspace").html(data);
                });
                // Cerrar la ventana modal después de guardar
                $("#modificarModal").modal("hide");
            } else {
                // Error: manejar según necesidades
                console.error("Error en el servidor:", response.message);
                alert("Error en el servidor: " + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Error de conexión o error no esperado
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            alert("Error en la solicitud AJAX. Por favor, inténtalo de nuevo.");
        }
    });
});
</script>