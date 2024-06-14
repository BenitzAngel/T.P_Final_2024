<?php
include_once("../../db/conexion.php");

$id_cliente = $_POST['id_cliente'];
$total = $_POST['total'];

$sql = "INSERT INTO Ventas (id_cliente, total) VALUES (?, ?)";
$stmt = $base_de_datos->prepare($sql);
$result = $stmt->execute([$id_cliente, $total]);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al agregar la venta."]);
}
?>