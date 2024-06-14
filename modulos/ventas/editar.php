<?php
include_once("../../db/conexion.php");

$id = $_POST['id'];
$id_cliente = $_POST['id_cliente'];
$total = $_POST['total'];

$sql = "UPDATE Ventas SET id_cliente = ?, total = ? WHERE id = ?";
$stmt = $base_de_datos->prepare($sql);
$result = $stmt->execute([$id_cliente, $total, $id]);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al actualizar la venta."]);
}
?>