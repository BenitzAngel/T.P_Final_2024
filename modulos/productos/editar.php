<?php
// Verifica si se proporciona un ID en la URL
if (!isset($_GET["id"])) {
    exit("No se proporcionó un ID de producto.");
}
// Obtiene el ID del producto desde la URL
$id_producto = $_GET["id"];

// Incluye el archivo de conexión a la base de datos
include_once("../../db/conexion.php");

// Prepara y ejecuta la consulta para obtener los datos del producto
$sentencia = $base_de_datos->prepare("SELECT * FROM producto WHERE id_producto = ?;");
$sentencia->execute([$id_producto]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);

// Verifica si se encontró el producto
if ($producto === false) {
    exit("El producto no existe o no se encontró en la base de datos.");
}

?>

<form>

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

</form>