<?php 
// esto valida la secion es decir si esta logeado o no el usuario
session_start();
if (empty($_SESSION['usuario'])) {
    header("location: index.php");
}

define('BASE_URL', '/panaderia/');



?>

    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>

    <!-- jqueri -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <!-- Otros enlaces y metadatos -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    

        <script src="js/validarProductos.js"></script>

        <link rel="stylesheet" href="css/nav_bar.css">

        
<!-- botones del nav-bar -->



</head>






