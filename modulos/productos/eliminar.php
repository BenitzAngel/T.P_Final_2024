<?php
// Verificar si se proporcionó el parámetro "id"
if (!isset($_GET["id"])) {
    exit(json_encode(["status" => "error", "message" => "ID no proporcionado"]));
}

$id = $_GET["id"];

include_once("../../db/conexion.php");

try {
    // Preparar la sentencia SQL para eliminar el producto
    $sentencia = $base_de_datos->prepare("DELETE FROM producto WHERE id_producto = ?;");

    // Ejecutar la sentencia con el ID proporcionado
    $resultado = $sentencia->execute([$id]);

    // Verificar si la eliminación fue exitosa
    if ($resultado) {
        echo json_encode(["status" => "success"]);
    } else {
        throw new Exception("Error al eliminar el producto");
    }
} catch (Exception $e) {
    // Capturar cualquier excepción y devolver un mensaje de error
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}