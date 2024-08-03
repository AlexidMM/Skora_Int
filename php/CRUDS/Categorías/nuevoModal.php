<?php
require '../../../php/conexion.php';

if (isset($_POST['agregar'])) {
    $nom_cat = $_POST['nom_cat'];
    $sql = "INSERT INTO CATEGORIA (nom_cat) VALUES ('$nom_cat')";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro agregado exitosamente"); window.location.href = "../../../admin.php";</script>';
    } else {
        echo '<script>alert("Error al agregar registro") window.location.href = "categorias.php";</script>';
    }
}

?>
<table align="center">
    <tr>
        <td>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                <label for="nom_art">Nombre de la categoría:</label>
                <input type="text" id="nom_cat" name="nom_cat" required><br><br>
                <input type="submit" name="agregar" value="Agregar registro">
                <a href="categorias.php" class="btn btn-secondary">Regresar</a>
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