<?php
include_once("../../db/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $empresa = $_POST['empresa'];
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $altura = $_POST['altura'];

    $sql = "INSERT INTO proveedores (nombre, apellido,empresa, direccion, altura, email, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $base_de_datos->prepare($sql);
    if ($stmt->execute([$nombre, $apellido,$empresa, $direccion, $altura, $email, $telefono])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar el cliente."]);
    }
}
?>