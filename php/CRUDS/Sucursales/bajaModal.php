<?php
require '../../../php/conexion.php';

if (isset($_POST['no_suc'])) {
    $id_art = $_POST['no_suc'];

    $sql = "SELECT * FROM sucursal WHERE no_suc = '$no_suc'";
    $resultado = $conexion->query($sql);
    $sucursal = $resultado->fetch_assoc();

    if ($sucursal) {
      ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="hidden" name="no_suc" value="<?php echo $no_suc;?>">

            <p>¿Estás seguro de dar de baja el artículo con ID <?php echo $no_suc;?>?</p>

            <input type="submit" name="baja" value="Dar de baja">
            <a href="sucursales.php" class="btn btn-secondary">Regresar</a>
        </form>
        <?php
    } else {
        echo '<script>alert("No se encontró el artículo con el ID seleccionado"); window.location.href = "articulos.php";</script>';
    }
} else {
  ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="no_suc">Ingrese el ID del artículo:</label>
        <input type="number" id="no_suc" name="no_suc" required><br><br>
        <input type="submit" value="Buscar">
        <a href="sucursales.php" class="btn btn-secondary">Regresar</a>
    </form>
    <?php
}

if (isset($_POST['baja'])) {
    $no_suc = $_POST['no_suc'];

    $sql = "UPDATE sucursal SET Status = 'Inactivo' WHERE no_suc = '$no_suc'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Artículo dado de baja exitosamente"); window.location.href = "articulos.php";</script>';
    } else {
        echo '<script>alert("Error al dar de baja el artículo"); window.location.href = "bajaModal.php";</script>';
    }
}