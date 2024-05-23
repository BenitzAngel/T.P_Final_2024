<?php  

$required_fields = ["id_producto", "nombre", "descripcion", "fecha", "cantidad", "precio_venta"];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        exit(json_encode(["status" => "error", "message" => "Campo '$field' no proporcionado"]));
    }
}

# Si todo va bien, se ejecuta esta parte del código...
include_once("../../db/conexion.php");

// Verifica que la conexión a la base de datos sea exitosa
if (!$base_de_datos) {
    exit(json_encode(["status" => "error", "message" => "Error de conexión a la base de datos."]));
}

$id_producto = $_POST["id_producto"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$fecha = $_POST["fecha"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio_venta"];



try {
    $sentencia = $base_de_datos->prepare("UPDATE producto SET 
    nombre= :nombre,
    descripcion= :descripcion,
    fecha_ingreso= :fecha,
    cantidad= :cantidad,
    precio= :precio 
    WHERE id_producto = :id_producto
    ");

    // Bind de parámetros
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':cantidad', $cantidad);
    $sentencia->bindParam(':precio', $precio);
    $sentencia->bindParam(':id_producto', $id_producto);

    // Ejecuta la sentencia
    $resultado = $sentencia->execute();

    if ($resultado === TRUE) {
        # Redirigir después de la inserción exitosa
        echo json_encode(["status" => "success"]);
    } else {
        throw new Exception("Error al insertar el producto");
    }
} catch (Exception $e) {
    # Manejo de errores
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

