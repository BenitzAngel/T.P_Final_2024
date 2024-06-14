<?php
include_once("../../db/conexion.php");

$id_producto = $_POST['id_producto'];
$cantidades = $_POST['cantidades'];
$unidades = $_POST['unidades'];
$ingredientes = $_POST['ingredientes'];
$id_ingredientes = $_POST['id_ingredientes'];

try {
    // Iniciar una transacción
    $base_de_datos->beginTransaction();

    // Eliminar las entradas existentes para el producto dado
    $eliminarRecetas = $base_de_datos->prepare("DELETE FROM ProductosIngredientes WHERE id_producto = :id_producto");
    $eliminarRecetas->bindParam(':id_producto', $id_producto);
    $eliminarRecetas->execute();

    // Insertar las nuevas recetas
    foreach ($ingredientes as $index => $ingrediente_id) {
        $cantidad = $cantidades[$index];
        $unidad = $unidades[$index];

        $insertarReceta = $base_de_datos->prepare("INSERT INTO ProductosIngredientes (id_producto, id_ingrediente, cantidad_ingrediente, unidad) VALUES (:id_producto, :id_ingrediente, :cantidad, :unidad)");
        $insertarReceta->bindParam(':id_producto', $id_producto);
        $insertarReceta->bindParam(':id_ingrediente', $ingrediente_id);
        $insertarReceta->bindParam(':cantidad', $cantidad);
        $insertarReceta->bindParam(':unidad', $unidad);
        $insertarReceta->execute();
    }

    // Confirmar la transacción
    $base_de_datos->commit();

    // Devolver una respuesta JSON con estado de éxito
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $base_de_datos->rollBack();

    // Devolver una respuesta JSON con estado de error y mensaje de error
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
