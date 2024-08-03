<?php
require '../../../php/conexion.php';

if (isset($_POST['no_inv'])) {
    $no_inv = $_POST['no_inv'];

    $sql = "SELECT * FROM inventario WHERE no_inv = '$no_inv'";
    $resultado = $conexion->query($sql);
    $inventario = $resultado->fetch_assoc();

    if ($inventario) {
      ?>
       <table align="center">
            <tr>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                    <input type="hidden" name="no_inv" value="<?php echo $no_inv;?>">
                    <label for="exist_inv">Existencia de Inventario:</label>
                    <input type="number" id="exist_inv" name="exist_inv" value="<?php echo $inventario['exist_inv'];?>" required><br><br>
                    <label for="no_suc">Sucursal:</label>
                    <select id="no_suc" name="no_suc" required>
                    <?php
                        $sql = "SELECT * FROM SUCURSAL";
                        $resultado = $conexion->query($sql);
                        while ($row = $resultado->fetch_assoc()) {
                            $selected = ($inventario['no_suc'] == $row['no_suc'])? 'elected' : '';
                            echo "<option value='". $row['no_suc']. "' $selected>". $row['nom_suc']. "</option>";
                        }
                        ?>
                    </select><br><br>
                    <label for="id_art">Artículo:</label>
                    <select id="id_art" name="id_art" required>
                    <?php
                        $sql = "SELECT * FROM ARTICULO";
                        $resultado = $conexion->query($sql);
                        while ($row = $resultado->fetch_assoc()) {
                            $selected = ($inventario['id_art'] == $row['id_art'])? 'elected' : '';
                            echo "<option value='". $row['id_art']. "' $selected>". $row['nom_art']. "</option>";
                        }?>
                    </select><br><br>
                    <input type="submit" name="actualizar" value="Actualizar registro">
                    <a href="inventarios.php" class="btn btn-secondary">Regresar</a>
                    </form>
                </td>
            </tr>
        </table>
                    
    <?php
    } else {
        echo '<script>alert("No se encontró el inventario con el ID seleccionado"); window.location.href = "inventarios.php";</script>';
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

if (isset($_POST['actualizar'])) {
    $no_inv = $_POST['no_inv'];
    $exist_inv = $_POST['exist_inv'];
    $no_suc = $_POST['no_suc'];
    $id_art = $_POST['id_art'];

    $sql = "UPDATE inventario SET no_inv = '$no_inv', exist_inv = '$exist_inv', no_suc = '$no_suc', id_art = '$id_art' WHERE no_inv = '$no_inv'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro actualizado exitosamente"); window.location.href = "inventarios.php";</script>';
    }  else {
        echo '<script>alert("Error al actualizar registro"); window.location.href = "actualizaModal.php";</script>';
    }
}
?>
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
