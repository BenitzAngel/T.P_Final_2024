<?php
# Salir si alguno de los datos no está presente
// $required_fields = ["nombre", "descripcion", "fecha_ingreso", "cantidad", "precio"];

// foreach ($required_fields as $field) {
//     if (!isset($_POST[$field])) {
//         exit(json_encode(["status" => "error", "message" => "Campo '$field' no proporcionado"]));
//     }
// }

# Si todo va bien, se ejecuta esta parte del código...
// include_once("../../db/conexion.php");

// $nombre = $_POST["nombre"];
// $descripcion = $_POST["descripcion"];
// $fecha_ingreso = $_POST["fecha"];
// $cantidad = $_POST["cantidad"];
// $precio = $_POST["precio_venta"];
// $stock = $_POST["stock"];

// try {
//     $sentencia = $base_de_datos->prepare("INSERT INTO producto (
//         nombre, descripcion, fecha_ingreso, cantidad, precio ,) VALUES (
//         :nombre, :descripcion, :fecha_ingreso, :cantidad, :precio)");

    // Bind de parámetros
    // $sentencia->bindParam(':nombre', $nombre);
    // $sentencia->bindParam(':descripcion', $descripcion);
    // $sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);
    // $sentencia->bindParam(':cantidad', $cantidad);
    // $sentencia->bindParam(':precio', $precio);
    // $sentencia->bindParam(':stock', $stock);


    // $resultado = $sentencia->execute();

    // if ($resultado === TRUE) {
    //     # Redirigir después de la edición exitosa
    //     echo json_encode(["status" => "success"]);
    // } else {
    //     throw new Exception("Error al insertar el producto");
    // }
// } catch (Exception $e) {
    # Manejo de errores
//     echo json_encode(["status" => "error", "message" => $e->getMessage()]);
// }

# Salir si alguno de los datos no está presente
$required_fields = ["nombre", "descripcion", "fecha", "cantidad", "precio_venta"];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        exit(json_encode(["status" => "error", "message" => "Campo '$field' no proporcionado"]));
    }
}

# Si todo va bien, se ejecuta esta parte del código...
include_once("../../db/conexion.php");

$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$fecha = $_POST["fecha"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio_venta"];

try {
    $sentencia = $base_de_datos->prepare("INSERT INTO producto (nombre, descripcion, fecha_ingreso, cantidad, precio) VALUES (:nombre, :descripcion, :fecha, :cantidad, :precio)");

    // Bind de parámetros
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':fecha', $fecha);
    $sentencia->bindParam(':cantidad', $cantidad);
    $sentencia->bindParam(':precio', $precio);

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