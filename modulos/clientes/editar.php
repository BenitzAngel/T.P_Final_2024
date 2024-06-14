<?php
include_once("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $altura = $_POST['altura'];

    $sql = "UPDATE clientes SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, altura = ? WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$nombre, $apellido, $email, $telefono, $direccion, $altura, $id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el cliente."]);
    }
}
?>