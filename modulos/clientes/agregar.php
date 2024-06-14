<?php
include_once("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $altura = $_POST['altura'];

    $sql = "INSERT INTO clientes (nombre, apellido, email, telefono, direccion, altura) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$nombre, $apellido, $email, $telefono, $direccion, $altura])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar el cliente."]);
    }
}
?>