<?php
require '../../../php/conexion.php';

if (isset($_POST['no_inv'])) {
    $no_inv = $_POST['no_inv'];

    $sql = "SELECT * FROM ARTICULO WHERE no_inv = '$no_inv'";
    $resultado = $conexion->query($sql);
    $inventario = $resultado->fetch_assoc();

    if ($inventario) {
      ?>
      <table align="center">
        <tr>
            <td>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type="hidden" name="no_inv" value="<?php echo $no_inv;?>">
                    <p>¿Estás seguro de dar de baja el artículo con ID <?php echo $no_inv;?>?</p>
                    <input type="submit" name="baja" value="Dar de baja">
                    <a href="inventarios.php" class="btn btn-secondary">Regresar</a>
                </form>
            </td>
        </tr>
      </table>
        <?php
    } else {
        echo '<script>alert("No se encontró el artículo con el ID seleccionado"); window.location.href = "inventarios.php";</script>';
    }
} else {
  ?>
    <table align="center">
      <tr>
          <td>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="no_inv">Ingrese el ID del inventario:</label>
                <input type="number" id="no_inv" name="no_inv" required><br><br>
                <input type="submit" value="Buscar">
            </form>   
          </td>
      </tr>
    </table>
    <?php
}

if (isset($_POST['baja'])) {
    $no_inv = $_POST['no_inv'];

    $sql = "UPDATE inventario SET Status = 'Inactivo' WHERE no_inv = '$no_inv'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Artículo dado de baja exitosamente"); window.location.href = "inventarios.php";</script>';
    } else {
        echo '<script>alert("Error al dar de baja el artículo"); window.location.href = "bajaModal.php";</script>';
    }
}?>
<style>
    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
  
    table {
        border-collapse: separate;
        border-spacing: 10px;
        border: 2px solid;
        text-align: center;
    }
    th, td {
        border: 2px solid #333;
        padding: 10px;
        text-align: center;
</style>