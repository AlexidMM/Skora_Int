<?php
session_start();

// Agregar producto al carrito
if (isset($_POST['id_art'])) {
    $id_art = $_POST['id_art'];
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    if (!in_array($id_art, $_SESSION['carrito'])) {
        $_SESSION['carrito'][] = $id_art;
    }
    header('Location: ../prod.php');
    exit;
}

// Mostrar carrito
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
    $total = 0;
    foreach ($carrito as $id_art) {
        $result = mysqli_query($conexion, "SELECT * FROM ARTICULO WHERE id_art = '$id_art'");
        $row = mysqli_fetch_assoc($result);
        $total += $row['prec_art'];
        echo "<p>$row[nom_art] - $row[prec_art] MXN</p>";
    }
    echo "<p>Total: $total MXN</p>";
} else {
    echo "<p>Carrito vacío</p>";
}