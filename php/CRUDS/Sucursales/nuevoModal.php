<?php
require '../../../php/conexion.php';

if (isset($_POST['agregar'])) {
    $nom_suc = $_POST['nom_suc'];
    $call_suc = $_POST['call_suc'];
    $col_suc = $_POST['col_suc'];
    $ni_suc = $_POST['ni_suc'];
    $ne_suc = $_POST['ne_suc'];
    $cp_suc = $_POST['cp_suc'];
    $cve_ciud = $_POST['cve_ciud'];

    $sql = "INSERT INTO sucursal (nom_suc, call_suc, col_suc, ni_suc, ne_suc, cp_suc, cve_ciud) VALUES ('$nom_suc', '$call_suc', '$col_suc', '$ni_suc', '$ne_suc', '$cp_suc', '$cve_ciud')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro agregado exitosamente"); window.location.href = "../../../admin.php";</script>';
    } else {
        echo '<script>alert("Error al agregar registro") window.location.href = "sucursales.php";</script>';
    }
}

?>
<table align="center">
    <tr>
        <td>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                <label for="nom_suc">Nombre:</label>
                <input type="text" id="nom_suc" name="nom_suc" required><br><br>
                <label>Dirección:</label> <br>
                <label for="call_suc">Calle:</label>
                <input type="text" id="call_suc" name="call_suc" required><br><br>
                <label for="col_suc">Colonia:</label>
                <input type="text" id="col_suc" name="col_suc" required><br><br>
                <label for="ni_suc">Número Interior:</label>
                <input type="number" id="ni_suc" name="nu_suc"><br><br>
                <label for="ne_suc">Número Exterior:</label>
                <input type="number" id="ne_suc" name="ne_suc" required><br><br>
                <label for="cve_ciud">Ciudad:</label>
                <select id="cve_ciud" name="cve_ciud" required>
                <?php
                $sql = "SELECT * FROM ciudad";
                $resultado = $conexion->query($sql);
                while ($row = $resultado->fetch_assoc()) {
                echo "<option value='". $row['cve_ciud']. "'>". $row['nom_ciud']. "</option>";
                }?>
                </select><br><br>

                <input type="submit" name="agregar" value="Agregar registro">
                <a href="sucursales.php" class="btn btn-secondary">Regresar</a>
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
</style>
