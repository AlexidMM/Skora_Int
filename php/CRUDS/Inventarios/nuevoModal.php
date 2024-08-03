<?php
require '../../../php/conexion.php';

if (isset($_POST['agregar'])) {
    $exist_inv = $_POST['exist_inv'];
    $no_suc = $_POST['no_suc'];
    $id_art = $_POST['id_art'];

    $sql = "INSERT INTO INVENTARIO (exist_inv, no_suc, id_art) VALUES ('$exist_inv', '$no_suc', '$id_art')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro agregado exitosamente"); window.location.href = "../../../admin.php";</script>';
    } else {
        echo '<script>alert("Error al agregar registro") window.location.href = "inventarios.php";</script>';
    }
}

?>
<table align="center">
    <tr>
        <td>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                <label for="exist_inv">Existencia de Inventario:</label>
                <input type="text" id="exist_inv" name="exist_inv" required><br><br>
                <label for="no_suc">Sucursal:</label>
                <select id="no_suc" name="no_suc" required>
                <?php
                    $sql = "SELECT * FROM Sucursal";
                    $resultado = $conexion->query($sql);
                    while ($row = $resultado->fetch_assoc()) {
                    echo "<option value='". $row['no_suc']. "'>". $row['nom_suc']. "</option>";
                }?>
                </select><br><br>
                <label for="id_art">Artículo:</label>
                <select id="id_art" name="id_art" required>
                <?php
                    $sql = "SELECT * FROM Articulo";
                    $resultado = $conexion->query($sql);
                    while ($row = $resultado->fetch_assoc()) {
                    echo "<option value='". $row['id_art']. "'>". $row['nom_art']. "</option>";
                }?>
                </select><br><br>
                <input type="submit" name="agregar" value="Agregar registro">
                <a href="inventarios.php" class="btn btn-secondary">Regresar</a>
                <script src="../../../../assets/js/bootstrap.bundle.min.js"></script>
            </form>
        </td>
    </tr>
</table>
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
        }
</style>