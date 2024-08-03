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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type="hidden" name="id_art" value="<?php echo $id_art;?>">

                    <p>¿Estás seguro de dar de baja el artículo con ID <?php echo $id_art;?>?</p>

                    <input type="submit" name="baja" value="Dar de baja"> <br>
                    <a href="bajaModal.php" class="btn btn-secondary">Atrás</a>            
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
        <table align="cent">
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

if (isset($_POST['baja'])) {
    $id_art = $_POST['id_art'];

    $sql = "UPDATE ARTICULO SET Status = 'Inactivo' WHERE id_art = '$id_art'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        echo '<script>alert("Artículo dado de baja exitosamente"); window.location.href = "articulos.php";</script>';
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
        }
</style>