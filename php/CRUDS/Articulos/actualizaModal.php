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

if (isset($_POST['id_art'])) {
    $id_art = $_POST['id_art'];

    $sql = "SELECT * FROM ARTICULO WHERE id_art = '$id_art'";
    $resultado = $conexion->query($sql);
    $articulo = $resultado->fetch_assoc();

    if ($articulo) {
      ?>
        <table align="center">
            <tr>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" autocomplete='off'>
                        <input type="hidden" name="id_art" value="<?php echo $id_art;?>">
                        <label for="nom_art">Nombre del artículo:</label>
                        <input type="text" id="nom_art" name="nom_art" value="<?php echo $articulo['nom_art'];?>" required><br><br>
                        <label for="cost_art">Costo ddel artículo:</label>
                        <input type="number" id="cost_art" name="cost_art" value="<?php echo $articulo['cost_art'];?>" required><br><br>
                        <label for="prec_art">Precio del artículo:</label>
                        <input type="number" id="prec_art" name="prec_art" value="<?php echo $articulo['prec_art'];?>" required><br><br>
                        <label for="id_mat">Material:</label>
                        <select id="id_mat" name="id_mat" required>
                            <?php
                                $sql = "SELECT * FROM MATERIAL";
                                $resultado = $conexion->query($sql);
                                while ($row = $resultado->fetch_assoc()) {
                                    $selected = ($articulo['id_mat'] == $row['id_mat'])? 'elected' : '';
                                    echo "<option value='". $row['id_mat']. "' $selected>". $row['nom_mat']. "</option>";
                                }
                            ?>
                        </select><br><br>
                        <label for="desc_art">Descripción del artículo:</label>
                        <textarea id="desc_art" name="desc_art" required><?php echo $articulo['desc_art'];?></textarea><br><br>
                        <label for="img_art">Imagen del artículo:</label>
                        <input type="file" id="img_art" name="img_art" value="<?php echo $articulo['img_art'];?>"><br><br>
                        <label for="id_cat">Categoría:</label>
                        <select id="id_cat" name="id_cat" required>
                        <?php
                        $sql = "SELECT * FROM CATEGORIA";
                        $resultado = $conexion->query($sql);
                        while ($row = $resultado->fetch_assoc()) {
                            $selected = ($articulo['id_cat'] == $row['id_cat'])? 'elected' : '';
                            echo "<option value='". $row['id_cat']. "' $selected>". $row['nom_cat']. "</option>";
                        }
                        ?>
                        </select><br><br>

                        <input type="submit" name="actualizar" value="Actualizar registro">
                        <a href="articulos.php" class="btn btn-secondary">Regresar</a>
                    </form>
                </td>
            </tr>
        </table>
        <?php
    } else {
        echo '<script>alert("No se encontró el artículo con el ID seleccionado"); window.location.href = "articulos.php";</script>';
    }
} else {
  ?>
        <table align="center">
            <tr>
                <td>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <label for="id_art">Ingrese el ID del artículo:</label>
                        <input type="number" id="id_art" name="id_art" required><br><br>
                        <input type="submit" value="Buscar">
                        <a href="articulos.php" class="btn btn-secondary">Regresar</a>
                    </form>
                </td>
            </tr>
        </table>

    <?php
}

if (isset($_POST['actualizar'])) {
    $id_art = $_POST['id_art'];
    $nom_art = $_POST['nom_art'];
    $cost_art = $_POST['cost_art'];
    $prec_art = $_POST['prec_art'];
    $id_mat = $_POST['id_mat'];
    $desc_art = $_POST['desc_art'];
    $img_art = $_POST['img_art'];
    $id_cat = $_POST['id_cat'];

   $sql = "UPDATE ARTICULO SET nom_art = '$nom_art', cost_art = '$cost_art', prec_art = '$prec_art', id_mat = '$id_mat', desc_art = '$desc_art', img_art = '$img_art', id_cat = '$id_cat' WHERE id_art = '$id_art'";
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
        }
            </style>