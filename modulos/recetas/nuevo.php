<?php  
if (!isset($_POST['producto'], $_POST['ingredientes'], $_POST['cantidades'], $_POST['unidades'])) {
    exit(json_encode(["status" => "error", "message" => "Datos incompletos"]));
}

include_once("../../db/conexion.php");

$id_producto = $_POST["producto"];
$ingredientes = $_POST["ingredientes"];
$cantidades = $_POST["cantidades"];
$unidades = $_POST["unidades"];

try {
    $base_de_datos->beginTransaction();

    for ($i = 0; $i < count($ingredientes); $i++) {
        $id_ingrediente = $ingredientes[$i];
        $cantidad = $cantidades[$i];
        $unidad = $unidades[$i];

        // Verificar si el producto existe en la tabla Productos
        $stmt = $base_de_datos->prepare("SELECT COUNT(*) FROM Productos WHERE id = ?");
        $stmt->execute([$id_producto]);
        $producto_existente = $stmt->fetchColumn();

        if ($producto_existente) {
            // Insertar en la tabla ProductosIngredientes
            $sentencia = $base_de_datos->prepare("INSERT INTO ProductosIngredientes (id_producto, id_ingrediente, cantidad_ingrediente, unidad) VALUES (?, ?, ?, ?)");
            $resultado = $sentencia->execute([$id_producto, $id_ingrediente, $cantidad, $unidad]);

            if (!$resultado) {
                throw new Exception("Error al insertar en la tabla ProductosIngredientes");
            }
        } else {
            throw new Exception("El producto con ID $id_producto no existe");
        }
    }

    $base_de_datos->commit();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    $base_de_datos->rollBack();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>