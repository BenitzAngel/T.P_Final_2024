<?php
include_once("../../db/conexion.php");

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Eliminar todas las entradas en ProductosIngredientes para el producto específico
    $sql = "DELETE FROM ProductosIngredientes WHERE id_producto = ?";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$id_producto])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al eliminar la receta."]);
    }
}
?>