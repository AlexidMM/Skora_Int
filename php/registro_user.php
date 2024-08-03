<?php
include 'conexion.php';

$nom_clie = $_POST['nom_clie'];
$ap_clie = $_POST['ap_clie'];
$am_clie = $_POST['am_clie'];
$email_clie = $_POST['email_clie'];
$nom_us = $_POST['nom_us'];
$pass_us = $_POST['pass_us'];

// Insertar datos en la tabla USUARIO
$queryUS = "INSERT INTO USUARIO(nom_us, pass_us)
             VALUES('$nom_us', '$pass_us')";
if (mysqli_query($conexion, $queryUS)) {
    // Insertar datos en la tabla CLIENTE
    $queryCli = "INSERT INTO CLIENTE(ap_clie, am_clie, nom_clie, email_clie, nom_us)
                 VALUES('$ap_clie', '$am_clie', '$nom_clie', '$email_clie', '$nom_us')";
    if (mysqli_query($conexion, $queryCli)) {
        echo '
            <script>
                alert("Usuario almacenado exitosamente");
                window.location = "../prod.php"
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Intento de almacenamiento fallido :(");
                window.location = "../login.php";
            </script>
        ';
    }
} else {
    echo '
        <script>
            alert("Error al insertar datos en la tabla USUARIO");
            window.location = "../login.php";
        </script>
    ';
}

// Cerrar conexión
mysqli_close($conexion);
?>