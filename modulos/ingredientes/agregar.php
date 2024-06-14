<?php
include_once("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $unidad = $_POST['unidad'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $sql = "INSERT INTO Ingredientes (nombre, descripcion, stock, unidad, fecha_vencimiento) VALUES (?, ?, ?, ?, ?)";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$nombre, $descripcion, $stock, $unidad, $fecha_vencimiento])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar el ingrediente."]);
    }
}
?>