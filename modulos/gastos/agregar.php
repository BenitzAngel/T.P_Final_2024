<?php
include_once("../../db/conexion.php");

$descripcion = $_POST['descripcion'];
$monto = $_POST['monto'];

$sql = "INSERT INTO Gastos (descripcion, monto) VALUES (?, ?)";
$stmt = $base_de_datos->prepare($sql);
$result = $stmt->execute([$descripcion, $monto]);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al agregar el gasto."]);
}
?>
