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

if (isset($_POST['id_cat'])) {
    $id_cat = $_POST['id_cat'];

    $sql = "SELECT * FROM CATEGORIA WHERE id_cat = '$id_cat'";
    $resultado = $conexion->query($sql);
    $categoria = $resultado->fetch_assoc();

    if ($categoria) {
       ?>
        <table align="center">
            <tr>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                    <input type="hidden" name="id_cat" value="<?php echo $id_cat;?>">
                    <label for="nom_art">Nombre de la categoría:</label>
                    <input type="text" id="nom_cat" name="nom_cat" value="<?php echo $categoria['nom_cat'];?>" required><br><br>
                    <input type="submit" name="actualizar" value="Actualizar registro">
                    <a href="categorias.php" class="btn btn-secondary">Regresar</a>
                    </form>
                </td>
            </tr>
        </table>            
                    <?php
    } else {
        echo '<script>alert("No se encontró la categoria con el ID seleccionado"); window.location.href = "categorias.php";</script>';
    }
} else {
   ?>
    <table>
        <tr>
            <td>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label for="id_art">Ingrese el ID de la categoría:</label>
                    <input type="number" id="id_cat" name="id_cat" required><br><br>
                    <input type="submit" value="Buscar">
                    <a href="categorias.php" class="btn btn-secondary">Regresar</a>
                </form>
            </td>
        </tr>
    </table>
    <?php
}

if (isset($_POST['actualizar'])) {
    $id_cat = $_POST['id_cat'];
    $nom_cat = $_POST['nom_cat'];

    $sql = "UPDATE CATEGORIA SET nom_cat = '$nom_cat' WHERE id_cat = '$id_cat'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Registro actualizado exitosamente"); window.location.href = "categorias.php";</script>';
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
