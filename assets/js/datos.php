<?php
  require '../php/conexion.php';

  $sql = "SELECT * FROM articulos_vendidos";
  $result = $conexion->query($sql);

  $datos = array();
  while ($row = $result->fetch_assoc()) {
    $datos[] = $row;
  }

  $conexion->close();

  header('Content-Type: application/json');
  echo json_encode($datos);
?>