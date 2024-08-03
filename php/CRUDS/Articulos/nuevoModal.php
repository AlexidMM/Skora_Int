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
?>   
<?php

if (isset($_POST['agregar'])) {
    $nom_art = $_POST['nom_art'];
    $cost_art = $_POST['cost_art'];
    $prec_art = $_POST['prec_art'];
    $id_mat = $_POST['id_mat'];
    $desc_art = $_POST['desc_art'];
    $img_art = $_POST['img_art'];
    $id_cat = $_POST['id_cat'];

    $sql = "INSERT INTO ARTICULO (nom_art, cost_art, prec_art, id_mat, desc_art, img_art, id_cat) VALUES ('$nom_art', '$cost_art', '$prec_art', '$id_mat', '$desc_art', '$img_art', '$id_cat')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro agregado exitosamente"); window.location.href = "../../../admin.php";</script>';
    } else {
        echo '<script>alert("Error al agregar registro") window.location.href = "articulos.php";</script>';
    }
}

?>
<table align="center">
    <tr>
        <td>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                <label for="nom_art">Nombre del artículo:</label>
                <input type="text" id="nom_art" name="nom_art" required><br><br>
                <label for="cost_art">Costo del artículo:</label>
                <input type="number" id="cost_art" name="cost_art" required><br><br>
                <label for="prec_art">Precio del artículo:</label>
                <input type="number" id="prec_art" name="prec_art" required><br><br>
                <label for="id_mat">Material:</label>
                <select id="id_mat" name="id_mat" required>
                <?php
                    $sql = "SELECT * FROM MATERIAL";
                    $resultado = $conexion->query($sql);
                    while ($row = $resultado->fetch_assoc()) {
                    echo "<option value='". $row['id_mat']. "'>". $row['nom_mat']. "</option>";
                }?>
                </select><br><br>
                <label for="desc_art">Descripción del artículo:</label>
                <textarea id="desc_art" name="desc_art" required></textarea><br><br>
                <label for="img_art">Imagen del artículo:</label>
                <input type="file" id="img_art" name="img_art"><br><br>
                <label for="id_cat">Categoría:</label>
                <select id="id_cat" name="id_cat" required>
                <?php
                    $sql = "SELECT * FROM CATEGORIA";
                    $resultado = $conexion->query($sql);
                    while ($row = $resultado->fetch_assoc()) {
                    echo "<option value='". $row['id_cat']. "'>". $row['nom_cat']. "</option>";
                }?>
                </select><br><br>
                <input type="submit" name="agregar" value="Agregar registro">
                <a href="articulos.php" class="btn btn-secondary">Regresar</a>
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
