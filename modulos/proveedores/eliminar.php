<?php
include_once("../../db/conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM proveedores WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar el cliente."]);
    }
}
?>