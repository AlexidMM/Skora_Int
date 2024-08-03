<?php
session_start();

// Incluir archivo de conexión
require_once 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION["nom_us"])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del usuario logueado
$nom_us = $_SESSION["nom_us"];

// Consulta para obtener el ID del usuario
$stmt = mysqli_prepare($conexion, "SELECT id_clie FROM CLIENTE WHERE nom_us = ?");
mysqli_stmt_bind_param($stmt, "s", $nom_us);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {
    $row = mysqli_fetch_assoc($resultado);
    $id_clie = $row["id_clie"];
    $_SESSION["id_clie"] = $id_clie; // Almacenar el ID en la sesión
} else {
    // Si no se encuentra el usuario, puedes redirigir a una página de error
    header("Location: ../login.php");
    exit;
}

// Consulta para obtener las direcciones del usuario
$stmt = mysqli_prepare($conexion, "SELECT d.* FROM DIRECCION d INNER JOIN CLIENTE c ON d.id_dir = c.id_dir WHERE c.id_clie =? AND c.nom_us =?");
mysqli_stmt_bind_param($stmt, "is", $id_clie, $nom_us);
mysqli_stmt_execute($stmt);
$direcciones = mysqli_stmt_get_result($stmt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar_dir"])) {
        $calle = $_POST["calle"];
        $col = $_POST["col"];
        $ni = $_POST["ni"];
        $ne = $_POST["ne"];
        $cp = $_POST["cp"];
        $cve_ciud = $_POST["cve_ciud"];
        $id_clie = $_SESSION["id_clie"];

        // Insertar nueva dirección en la tabla DIRECCION
        $stmt = mysqli_prepare($conexion, "INSERT INTO DIRECCION (calle, col, ni, ne, cp, cve_ciud) VALUES (?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "sssssi", $calle, $col, $ni, $ne, $cp, $cve_ciud);
        mysqli_stmt_execute($stmt);

        // Redirigir a la misma página para mostrar la nueva dirección
        header("Location: ". $_SERVER["PHP_SELF"]);
        exit;
    }
}

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php if (mysqli_num_rows($direcciones) > 0) { ?>
        <!-- Mostrar direcciones existentes -->
        <label for="id_dir">Dirección:</label>
        <select id="id_dir" name="id_dir" required>
            <?php while ($direccion = mysqli_fetch_assoc($direcciones)) { ?>
                <option value="<?php echo $direccion['id_dir']; ?>"><?php echo $direccion['calle'] . ' ' . $direccion['col'] . ' ' . $direccion['ni'] . '-' . $direccion['ne'] . ' CP: ' . $direccion['cp']; ?></option>
            <?php } ?>
        </select><br><br>
        <button type="button" id="agregar_dir" class="btn btn-primary">Agregar nueva dirección</button>
        <div id="formulario_dir" style="display:none;">
            <!-- Formulario para agregar nueva dirección -->
            <label for="calle">Calle:</label>
            <input type="text" id="calle" name="calle" required autocomplete="off"><br><br>
            <label for="col">Colonia:</label>
            <input type="text" id="col" name="col" required autocomplete="off"><br><br>
            <label for="ni">Número interior:</label>
            <input type="text" id="ni" name="ni" autocomplete="off"><br><br>
            <label for="ne">Número exterior:</label>
            <input type="text" id="ne" name="ne" required autocomplete="off"><br><br>
            <label for="cp">Código postal:</label>
            <input type="text" id="cp" name="cp" required autocomplete="off"><br><br>
            <label for="ciudad">Ciudad:</label>
            <select id="ciudad" name="ciudad" required>
                <?php
                    $stmt = mysqli_prepare($conexion, "SELECT cve_ciud, nom_ciud FROM CIUDAD");
                    mysqli_stmt_execute($stmt);
                    $ciudades = mysqli_stmt_get_result($stmt);
                    while ($ciudad = mysqli_fetch_assoc($ciudades)) {
                        echo "<option value='" . $ciudad['cve_ciud'] . "'>" . $ciudad['nom_ciud'] . "</option>";
                    }
                ?>
            </select><br><br>
            <input type="submit" name="agregar_dir" value="Agregar dirección">
        </div>
    <?php } else { ?>
        <!-- Mostrar formulario para agregar nueva dirección -->
        <h3>No tienes direcciones registradas</h3>
        <label for="calle">Calle:</label>
        <input type="text" id="calle" name="calle" required autocomplete="off"><br><br>
        <label for="col">Colonia:</label>
        <input type="text" id="col" name="col" required autocomplete="off"><br><br>
        <label for="ni">Número interior:</label>
        <input type="text" id="ni" name="ni" autocomplete="off"><br><br>
        <label for="ne">Número exterior:</label>
        <input type="text" id="ne" name="ne" required autocomplete="off"><br><br>
        <label for="cp">Código postal:</label>
        <input type="text" id="cp" name="cp" required autocomplete="off"><br><br>
        <label for="ciudad">Ciudad:</label>
            <select id="ciudad" name="ciudad" required>
                <?php
                    $stmt = mysqli_prepare($conexion, "SELECT cve_ciud, nom_ciud FROM CIUDAD");
                    mysqli_stmt_execute($stmt);
                    $ciudades = mysqli_stmt_get_result($stmt);
                    while ($ciudad = mysqli_fetch_assoc($ciudades)) {
                        echo "<option value='" . $ciudad['cve_ciud'] . "'>" . $ciudad['nom_ciud'] . "</option>";
                    }
                ?>
            </select><br><br>
        <input type="submit" name="agregar_dir" value="Agregar dirección">
    <?php } ?>

    <a type="button" class="btn btn-primary" href="compra.php">Comprar</a>
</form>

<div class="botones">
    <a href="carrito.php" class="btn btn-warning">Volver</a>
</div>

<script>
    document.getElementById('agregar_dir').addEventListener('click', function() {
        document.getElementById('formulario_dir').style.display = 'block';
    });
</script>