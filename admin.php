<?php
    session_start();
    require 'php/conexion.php';

    // Verificar si el usuario ha iniciado sesión y si es administrador
    if (!isset($_SESSION['nom_us']) || $_SESSION['tipo_us'] != '1') {
        echo '
            <script>
                alert("Acceso denegado. Solo los administradores pueden acceder a esta página.");
                window.location = "login.php";
            </script>
        ';
        exit;
    }

    if (isset($_COOKIE['usuario'])) {
        $nom_us = $_COOKIE['usuario'];
        echo "Bienvenidx, $nom_us";
    }else{
        echo "Usuario no reconocido";
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pantalla Admin</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100" >
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="admin.php">Pantalla Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-danger" href="php/logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-3 text-center">
        <!-- Contenido de la página -->
        <h1>Pantalla Admin</h1>
        <div>
            <a href="php/CRUDS/Articulos/Articulos.php" class="btn btn-primary mr-2">Artículos</a>
            <a href="php/CRUDS/Categorías/categorias.php" class="btn btn-primary mr-2">Categorías</a>
            <a href="php/CRUDS/Inventarios/Inventarios.php" class="btn btn-primary mr-2">Inventarios</a>
            <a href="php/CRUDS/Sucursales/sucursales.php" class="btn btn-primary mr-2">Sucursales</a>
        </div>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
        </div>
    </footer>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>