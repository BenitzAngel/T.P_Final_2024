<?php
function actualizarStockIngredientes($id_producto, $cantidad_producto, $base_de_datos) {
    // Obtener los ingredientes necesarios para el producto
    $sql = "SELECT id_ingrediente, cantidad_ingrediente FROM ProductosIngredientes WHERE id_producto = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id_producto]);
    $ingredientes = $stmt->fetchAll(PDO::FETCH_OBJ);

    $faltantes = [];

    foreach ($ingredientes as $ingrediente) {
        // Calcular la cantidad de ingrediente necesario
        $cantidad_necesaria = $ingrediente->cantidad_ingrediente * $cantidad_producto;

        // Obtener el stock actual del ingrediente
        $sql = "SELECT stock FROM Ingredientes WHERE id = ?";
        $stmt = $base_de_datos->prepare($sql);
        $stmt->execute([$ingrediente->id_ingrediente]);
        $stock_actual = $stmt->fetchColumn();

        if ($stock_actual < $cantidad_necesaria) {
            $faltantes[] = $ingrediente->id_ingrediente;
        }
    }

    if (count($faltantes) > 0) {
        return [
            'status' => 'error',
            'message' => 'Faltan ingredientes: ' . implode(', ', $faltantes)
        ];
    } else {
        foreach ($ingredientes as $ingrediente) {
            // Calcular la cantidad de ingrediente necesario
            $cantidad_necesaria = $ingrediente->cantidad_ingrediente * $cantidad_producto;

            // Actualizar el stock del ingrediente
            $sql = "UPDATE Ingredientes SET stock = stock - ? WHERE id = ?";
            $stmt = $base_de_datos->prepare($sql);
            $stmt->execute([$cantidad_necesaria, $ingrediente->id_ingrediente]);
        }

        return ['status' => 'success'];
    }
}
?>