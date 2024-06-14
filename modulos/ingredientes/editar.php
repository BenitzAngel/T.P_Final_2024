<?php
include_once("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $unidad = $_POST['unidad'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $sql = "UPDATE Ingredientes SET nombre = ?, descripcion = ?, stock = ?, unidad = ?, fecha_vencimiento = ? WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$nombre, $descripcion, $stock, $unidad, $fecha_vencimiento, $id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el ingrediente."]);
    }
}
?>