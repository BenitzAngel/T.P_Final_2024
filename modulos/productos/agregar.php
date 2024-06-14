<?php
include_once("../../db/conexion.php");

// Recuperar los datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$unidad = $_POST['unidad'];

// Empezar una transacción
$base_de_datos->beginTransaction();

try {
    // Insertar el nuevo producto
    $sqlProducto = "INSERT INTO Productos (nombre, descripcion, precio, stock, unidad) VALUES (?, ?, ?, ?, ?)";
    $stmtProducto = $base_de_datos->prepare($sqlProducto);
    $stmtProducto->execute([$nombre, $descripcion, $precio, $stock, $unidad]);

    // Obtener el ID del producto insertado
    $id_producto = $base_de_datos->lastInsertId();

    // Verificar si hay suficiente stock de ingredientes para el producto
    $sqlIngredientes = "SELECT pi.id_ingrediente, i.stock, pi.cantidad_ingrediente 
                        FROM ProductosIngredientes pi 
                        JOIN Ingredientes i ON pi.id_ingrediente = i.id 
                        WHERE pi.id_producto = ?";
    $stmtIngredientes = $base_de_datos->prepare($sqlIngredientes);
    $stmtIngredientes->execute([$id_producto]);
    $ingredientes = $stmtIngredientes->fetchAll(PDO::FETCH_ASSOC);

    foreach ($ingredientes as $ingrediente) {
        $cantidadNecesaria = $ingrediente['cantidad_ingrediente'] * $stock;
        if ($ingrediente['stock'] < $cantidadNecesaria) {
            throw new Exception('No hay suficiente stock del ingrediente ID: ' . $ingrediente['id_ingrediente']);
        }
    }

    // Actualizar el stock de ingredientes
    foreach ($ingredientes as $ingrediente) {
        $cantidadNecesaria = $ingrediente['cantidad_ingrediente'] * $stock;
        $nuevoStock = $ingrediente['stock'] - $cantidadNecesaria;

        $sqlActualizarIngrediente = "UPDATE Ingredientes SET stock = ? WHERE id = ?";
        $stmtActualizarIngrediente = $base_de_datos->prepare($sqlActualizarIngrediente);
        $stmtActualizarIngrediente->execute([$nuevoStock, $ingrediente['id_ingrediente']]);
    }

    // Confirmar la transacción
    $base_de_datos->commit();

    // Respuesta de éxito en JSON
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $base_de_datos->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
