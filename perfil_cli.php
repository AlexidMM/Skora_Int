<?php
session_start();
include 'php/conexion.php';

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['nom_us']) || $_SESSION['tipo_us'] != '2') {
    echo '
        <script>
            alert("Acceso denegado.");
            window.location = "login.php";
        </script>
    ';
    exit;
}

// Verificar si la cookie 'Cliente' está definida
if (isset($_COOKIE['Usuario'])) {
    $nom_us = $_COOKIE['Usuario'];

    // Preparar la consulta para obtener los datos del cliente basado en nom_us
    $query = $conexion->prepare("SELECT ap_clie, am_clie, nom_clie FROM CLIENTE WHERE nom_us = ?");
    $query->bind_param("s", $nom_us);
    $query->execute();
    $result = $query->get_result();

    // Verificar si se encontró algún cliente
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ap_clie = $row['ap_clie'];
        $am_clie = $row['am_clie'];
        $nom_clie = $row['nom_clie'];

        echo "Bienvenidx, $nom_us<br>";
        echo "Tu nombre completo es, $nom_clie $ap_clie $am_clie";
    } else {
        echo "Usuario no reconocido :)";
    }
} else {
    echo "Usuario no reconocido :(";
}
?>
