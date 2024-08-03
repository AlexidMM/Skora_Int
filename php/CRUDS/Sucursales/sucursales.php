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

    $sqlSucursal = "SELECT s.no_suc, s.nom_suc, c.nom_ciud, s.call_suc, s.col_suc, s.ni_suc, s.ne_suc, s.cp_suc, s.status
FROM SUCURSAL s
INNER JOIN CIUDAD c ON s.cve_ciud = c.cve_ciud;";
    $sucursal = $conexion->query($sqlSucursal);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sucursales</title>
        <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../assets/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">

    <div class="container py-3">
    <h2 class="text-center">Sucursales</h2>
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
                    <th width="10%" id="id_art">Número</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Calle</th>
                    <th>Colonía</th>
                    <th>Número Interior</th>
                    <th>Número Exteriro</th>
                    <th>Código Postal</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                
                <?php while ($row = $sucursal->fetch_assoc()) { ?>
                
                    <tr>
                        <td><?= $row['no_suc']; ?></td>
                        <td><?= $row['nom_suc']; ?></td>
                        <td><?= $row['nom_ciud']; ?></td>
                        <td><?= $row['call_suc']; ?></td>
                        <td><?= $row['col_suc']; ?></td>
                        <td><?= $row['ni_suc']; ?></td>
                        <td><?= $row['ne_suc']; ?></td>
                        <td><?= $row['cp_suc']; ?></td>
                        <td><?= $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../../../admin.php">Regresar</a>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
        </div>
    </footer>
 	<script src="../../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
