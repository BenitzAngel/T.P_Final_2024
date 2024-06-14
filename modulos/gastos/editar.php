<?php
include_once("../../db/conexion.php");

$id = $_POST['id'];
$descripcion = $_POST['descripcion'];
$monto = $_POST['monto'];

$sql = "UPDATE Gastos SET descripcion = ?, monto = ? WHERE id = ?";
$stmt = $base_de_datos->prepare($sql);
$result = $stmt->execute([$descripcion, $monto, $id]);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al actualizar el gasto."]);
}
?>
