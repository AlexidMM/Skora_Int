<?php
require '../../../php/conexion.php';

if (isset($_POST['no_suc'])) {
    $no_suc = $_POST['no_suc'];

    $sql = "SELECT * FROM SUCURSAL WHERE no_suc = '$no_suc'";
    $resultado = $conexion->query($sql);
    $sucursal = $resultado->fetch_assoc();

    if ($sucursal) {
       ?>
       <table align="center">
            <tr>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                    <input type="hidden" name="no_suc" value="<?php echo $no_suc;?>">
                    <label for="nom_suc">Nombre de la sucursal:</label>
                    <input type="text" id="nom_suc" name="nom_suc" value="<?php echo $sucursal['nom_suc'];?>" required><br><br>
                    <label>Dirección de Sucursal:</label> <br>
                    <label for="call_suc">Calle:</label>
                    <input type="text" id="call_suc" name="call_suc" value="<?php echo $sucursal['call_suc'];?>" required><br><br>
                    <label for="col_suc">Colonia:</label>
                    <input type="text" id="col_suc" name="col_suc" value="<?php echo $sucursal['col_suc'];?>" required><br><br>
                    <label for="ni_suc">Número Interno:</label>
                    <input type="number" id="ni_suc" name="ni_suc" value="<?php echo $sucursal['ni_suc'];?>"><br><br>
                    <label for="ne_suc">Número Externo:</label>
                    <input type="number" id="ne_suc" name="ne_suc" value="<?php echo $sucursal['ne_suc'];?>"required><br><br>
                    <label for="cp_suc">Código Postal:</label>
                    <input type="text" id="cp_suc" name="cp_suc" value="<?php echo $sucursal['cp_suc'];?>"required><br><br>
                    <label for="cve_ciud">Ciudad:</label>
                    <select id="cve_ciud" name="cve_ciud" required>
                    <?php
                        $sql = "SELECT * FROM CIUDAD";
                        $resultado = $conexion->query($sql);
                        while ($row = $resultado->fetch_assoc()) {
                        $selected = ($sucursal['cve_ciud'] == $row['cve_ciud'])? 'elected' : '';
                        echo "<option value='". $row['cve_ciud']. "' $selected>". $row['nom_ciud']. "</option>";
                    }?>
                    </select><br><br>

                    <input type="submit" name="actualizar" value="Actualizar registro">
                    <a href="sucursales.php" class="btn btn-secondary">Regresar</a>
                    </form>
                </td>
            </tr>
        </table>
    <?php
    } else {
        echo '<script>alert("No se encontró el artículo con el ID seleccionado"); window.location.href = "actualizaModal.php";</script>';
    }
} else {
   ?>
    <table align="center">
        <tr>
            <td>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="no_suc">Ingrese el ID del inventario:</label>
                <input type="number" id="no_suc" name="no_suc" required><br><br>
                <input type="submit" value="Buscar">
                <a href="sucursales.php" class="btn btn-secondary">Regresar</a>
                </form>
            </td>
        </tr>
    </table>
    <?php
}

if (isset($_POST['actualizar'])) {
    $no_suc = $_POST['no_suc'];
    $nom_suc = $_POST['nom_suc'];
    $call_suc = $_POST['call_suc'];
    $col_suc = $_POST['col_suc'];
    $ni_suc = $_POST['ni_suc'];
    $ne_suc = $_POST['ne_suc'];
    $cp_suc = $_POST['cp_suc'];
    $cve_ciud = $_POST['cve_ciud'];

    $sql = "UPDATE SUCURSAL SET nom_suc = '$nom_suc', call_suc = '$call_suc', col_suc = '$col_suc', ni_suc = '$ni_suc', ne_suc = '$ne_suc', cp_suc = '$cp_suc', cve_ciud = '$cve_ciud' WHERE no_suc = '$no_suc'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro actualizado exitosamente"); window.location.href = "sucursales.php";</script>';
    }  else {
        echo '<script>alert("Error al actualizar registro"); window.location.href = "actualizaModal.php";</script>';
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

