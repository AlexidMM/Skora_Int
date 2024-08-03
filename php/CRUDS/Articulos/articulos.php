<?php
    session_start();
    require '../../../php/conexion.php';
    // Verificar si el usuario ha iniciado sesión y si es administrador
    if (!isset($_SESSION['nom_us']) || $_SESSION['tipo_us'] != '1') {
        echo '
            <script>
                alert("Acceso denegado. Solo los administradores pueden acceder a esta página.");
                window.location = "../../../login.php";
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

    $sqlArticulo = "SELECT ARTICULO.id_art, ARTICULO.nom_art, ARTICULO.cost_art, ARTICULO.prec_art, 
    MATERIAL.nom_mat, ARTICULO.desc_art, CATEGORIA.nom_cat, ARTICULO.status
    FROM ARTICULO INNER JOIN MATERIAL ON ARTICULO.id_mat = MATERIAL.id_mat 
    INNER JOIN CATEGORIA ON ARTICULO.id_cat = CATEGORIA.id_cat 
    ORDER BY id_art ASC;";
    $articulo = $conexion->query($sqlArticulo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pantalla Admin</title>
        <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../assets/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <div class="container py-3">
    <h2 class="text-center">Artículos</h2>
    <hr>
    <div class="row justify-content-center">
        <div class="col-auto">
            <a href="nuevoModal.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
        </div>
        <div class="col-auto">
            <a href="actualizaModal.php" class="btn btn-primary btn-warning" data-bs-id=" <i class="fa-solid fa-pen-to-square"></i> Editar</a>
        </div>
        <div class="col-auto">
            <a href="bajaModal.php" class="btn btn-primary btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row['id_art']; ?>"><i class="fa-solid fa-trash"></i></i> Eliminar</a>
        </div>
    </div>
        <table class="table table-sm table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th width="10%" id="id_art">id</th>
                    <th>Nombre</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Material</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Status</th>
                </tr>
            </thead>
            

            <tbody>
            <div class="row justify-content-center">
              <div class="col-auto">
                <form action="../../fpdf/prod-reporte-tablas.php">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reporteModal">Generar Reporte</button>
                </form>
              </div>
              <div class="col-auto">
                <form action="grafica.php">
                    <button type="submit" class="btn btn-warning">Generar Gráfica</button>
                </form>
              </div>
            </div>
                <?php while ($row = $articulo->fetch_assoc()) { ?>
                
                    <tr>
                        <td><?= $row['id_art']; ?></td>
                        <td><?= $row['nom_art']; ?></td>
                        <td><?= $row['cost_art']; ?></td>
                        <td><?= $row['prec_art']; ?></td>
                        <td><?= $row['nom_mat']; ?></td>
                        <td><?= $row['desc_art']; ?></td>
                        <td><?= $row['nom_cat']; ?></td>
                        <td><?= $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../../../admin.php">Regresar</a>
    </div>
    <div class="modal fade" id="reporteModal" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reporteModalLabel">Generar Reporte</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="../../fpdf/prod-reporte-tablas.php" method="post">
              <div class="row mb-3">
                <label for="articulo" class="col-sm-2 col-form-label">Artículo:</label>
              <div class="col-sm-10">
                  <select class="form-select" id="articulo" name="articulo">
                    <option value="todos">Todos los artículos</option>
                    <?php 
                      $sqlArticulos = "SELECT id_art, nom_art FROM ARTICULO";
                      $articulos = $conexion->query($sqlArticulos);
                      while ($row = $articulos->fetch_assoc()) { 
                    ?>
                      <option value="<?= $row['id_art']; ?>"><?= $row['nom_art']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
        </div>
    </footer>

 	<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
