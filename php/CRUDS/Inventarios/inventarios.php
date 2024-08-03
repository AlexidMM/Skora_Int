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
    $sqlInventario = "SELECT i.no_inv, i.exist_inv,
    s.nom_suc,
    a.nom_art
    FROM INVENTARIO i
    INNER JOIN SUCURSAL s ON i.no_suc = s.no_suc
    INNER JOIN ARTICULO a ON i.id_art = a.id_art
    GROUP BY i.no_inv";
    $Inventario = $conexion->query($sqlInventario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventarios</title>
        <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../assets/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
	<div class="container py-3">

        <h2 class="text-center">Inventarios</h2>
        <hr>
        <div class="row justify-content-end">
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
                    <th width="10%">Número</th>
                    <th width="10%">Existencia</th>
                    <th width="10%">Sucursal</th>
                    <th width="10%">Artículo</th>
                </tr>
            </thead>

            <tbody>
                <form action="../../fpdf/inv-reporte-tablas.php">
                    <button type="submit" class="btn btn-warning">Generar Reporte</button>
                </form>
                <?php while ($row = $Inventario->fetch_assoc()) { ?>
                
                    <tr>
                        <td width="5%"><?= $row['no_inv']; ?></td>
                        <td width="20%"><?= $row['exist_inv']; ?></td>
                        <td width="20%"><?= $row['nom_suc']; ?></td>
                        <td width="20%"><?= $row['nom_art']; ?></td> 
                        <td width="5%">
                            
                        </td>
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