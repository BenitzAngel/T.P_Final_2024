<?php
include_once("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock_nuevo = $_POST['stock'];
    $unidad = $_POST['unidad'];
    
    // Obtener el stock actual del producto antes de la actualización
    $sql_stock_actual = "SELECT stock FROM Productos WHERE id = ?";
    $stmt_stock_actual = $base_de_datos->prepare($sql_stock_actual);
    $stmt_stock_actual->execute([$id]);
    $producto = $stmt_stock_actual->fetch(PDO::FETCH_OBJ);
    $stock_actual = $producto->stock;
    
    // Calcular la diferencia en stock
    $diferencia_stock = $stock_nuevo - $stock_actual;
    
    $sql = "UPDATE Productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, unidad = ? WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $resultado = $stmt->execute([$nombre, $descripcion, $precio, $stock_nuevo, $unidad, $id]);
    
    if ($resultado) {
        // Obtener los ingredientes y sus cantidades de la receta
        $sql_ingredientes = "SELECT id_ingrediente, cantidad_ingrediente FROM ProductosIngredientes WHERE id_producto = ?";
        $stmt_ingredientes = $base_de_datos->prepare($sql_ingredientes);
        $stmt_ingredientes->execute([$id]);
        $ingredientes = $stmt_ingredientes->fetchAll(PDO::FETCH_OBJ);
        
        // Actualizar el stock de los ingredientes
        foreach ($ingredientes as $ingrediente) {
            $cantidad_total = $ingrediente->cantidad_ingrediente * $diferencia_stock;
            $sql_actualizar_stock = "UPDATE Ingredientes SET stock = stock - ? WHERE id = ?";
            $stmt_actualizar_stock = $base_de_datos->prepare($sql_actualizar_stock);
            $stmt_actualizar_stock->execute([$cantidad_total, $ingrediente->id_ingrediente]);
        }
        
        $response = array("status" => "success");
    } else {
        $response = array("status" => "error", "message" => $stmt->errorInfo());
    }
    
    echo json_encode($response);
}
?>