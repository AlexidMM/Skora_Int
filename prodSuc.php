<?php
session_start();
include 'php/conexion.php';

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['nom_us']) || $_SESSION['tipo_us']!= '2') {
    echo '
        <script>
            alert("Se tiene que ingresar Sesión primero.");
            window.location = "login.php";
        </script>
    ';
    exit;
}

if (isset($_POST['salir'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

$query = "SELECT * FROM CLIENTE WHERE nom_us = '".$_SESSION['nom_us']."'";
$result = mysqli_query($conexion, $query);
$cliente = mysqli_fetch_assoc($result);
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Obtener categorías y productos
$categorias = array();
if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
    $resultBus = mysqli_query($conexion, "SELECT c.id_cat, c.nom_cat, a.id_art, a.nom_art, a.prec_art, a.desc_art, a.img_art FROM ARTICULO a JOIN CATEGORIA c ON a.id_cat = c.id_cat WHERE a.nom_art LIKE '%$buscar%' OR c.nom_cat LIKE '%$buscar%' OR a.desc_art LIKE '%$buscar%'");
} else {
    $resultBus = mysqli_query($conexion, "SELECT c.id_cat, c.nom_cat, a.id_art, a.nom_art, a.prec_art, a.desc_art, a.img_art FROM ARTICULO a JOIN CATEGORIA c ON a.id_cat = c.id_cat WHERE a.Status = 'Activo'");
}
while ($row = mysqli_fetch_assoc($resultBus)) {
    $categorias[$row['nom_cat']][] = $row;
}

if (isset($_POST['id_art'])) {
    $id_art = $_POST['id_art'];
    $producto = mysqli_query($conexion, "SELECT * FROM ARTICULO WHERE id_art = '$id_art'");
    $producto = mysqli_fetch_assoc($producto);

    // Verificar si el producto ya está en el carrito
    $found = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id_art'] == $id_art) {
            $item['cantidad']++; // Incrementar cantidad en 1
            $found = true;
            break;
        }
    }

    // Agregar producto al carrito si no existe
    if (!$found) {
        $_SESSION['carrito'][] = array(
            'id_art' => $id_art,
            'nom_art' => $producto['nom_art'],
            'prec_art' => $producto['prec_art'],
            'cantidad' => 1
        );
    }

    // Actualizar contador de carrito
    $_SESSION['carrito_count'] = count($_SESSION['carrito']);

    header('Location: prod.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $ap_clie = $_POST["ap_clie"];
    $am_clie = $_POST["am_clie"];
    $nom_clie = $_POST["nom_clie"];
    $email_clie = $_POST["email_clie"];
    $rfc_clie = $_POST["rfc_clie"];
    $tel_clie = $_POST["tel_clie"];
    $id_clie = $_POST["id_clie"]; // Obtiene el id_clie del form

    // Actualizar la base de datos
    $stmt = mysqli_prepare($conexion, "UPDATE CLIENTE SET ap_clie =?, am_clie =?, nom_clie =?, email_clie =?, rfc_clie =?, tel_clie =? WHERE id_clie =?");
    mysqli_stmt_bind_param($stmt, "ssssssi", $ap_clie, $am_clie, $nom_clie, $email_clie, $rfc_clie, $tel_clie, $id_clie);
    mysqli_stmt_execute($stmt);
}

// Obtener las sucursales
$sucursales = mysqli_query($conexion, "SELECT * FROM SUCURSAL");
$sucursales_array = array();
while ($sucursal = mysqli_fetch_assoc($sucursales)) {
    $sucursales_array[] = $sucursal;
}

// Obtener los productos según la sucursal seleccionada
if (isset($_GET['sucursal'])) {
    $sucursal_id = $_GET['sucursal'];
    $productos = mysqli_query($conexion, "SELECT a.id_art, a.nom_art, a.prec_art, i.exist_inv 
                                        FROM ARTICULO a 
                                        JOIN INVENTARIO i ON a.id_art = i.id_art 
                                        WHERE i.no_suc = '$sucursal_id' AND a.Status = 'Activo'");
} else {
    $productos = mysqli_query($conexion, "SELECT * FROM ARTICULO WHERE Status = 'Activo'");
}

$no_suc = $_GET['no_suc'];

$stmt = $conexion->prepare("SELECT * FROM VistaSucursal WHERE no_suc = ?");
$stmt->bind_param("i", $no_suc);
$stmt->execute();

$result = $stmt->get_result();

$articulos = array();
while ($row = $result->fetch_assoc()) {
    $articulos[] = $row;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styleC.css">
    <link rel="stylesheet" href="assets/css/styleMod.css">
    <title>Productos</title>
    </head>
<body>
    <nav>
        <a href="index.html" class="logo">Skora</a>
        <div class="links">
            <a href="index.php">Inicio</a>
            <a href="prod.php">Categorias</a>
            <a href="contacto.html">Sobre Nosotros</a>
        </div>    
        <div class="links">
            <a href="php/carrito.php" id="cart-link">Carrito de compras <span id="cart-count">(<?php echo count($_SESSION['carrito']);?>)</span></a>
        </div>
        
        <form class="form-inline my-2 my-lg-0" action="prod.php" method="GET">
            <input class="form-control mr-sm-2" type="search" name="buscar" placeholder="Buscar" aria-label="Buscar" autocomplete="off">
            <button id="btn-search" class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <button type="button" id="btn-cliente" onclick="openDialog()">
            <img src="images/profile.png" alt="Perfil" class="profile-img">
        </button>
    </nav>
    <div class="nft-shop">
            <?php foreach ($articulos as $articulo) {?>
                <div class="item">
                    <div class="info">
                        <div>
                            <h5><?php echo $articulo['nom_art'];?></h5>
                            <div class="btc">
                                <i class='bx bxl-bitcoin'></i>
                                <p><?php echo number_format(isset($articulo['prec_art']) ? $articulo['prec_art'] : 0, 2);?> MXN</p>
                            </div>
                            <p><?php echo $articulo['desc_art'];?></p>
                            <p>Existencia: <?php echo $articulo['exist_inv'];?></p>
                        </div>
                        <p> </p>
                    </div>
                    <a href="prod.php">
                        <i class='bx bx-basket'></i>
                        <span>Compra</span>
                    </a>
                </div>
            <?php }?>
    </div>
    <dialog id="clienteDialog">
        <h2>Información del cliente</h2>
            <form method="POST">
                <input type="hidden" name="id_clie" value="<?php echo $cliente['id_clie']; ?>">
                <p>Apellido Paterno: <br> <input type="text" name="ap_clie" value="<?php echo $cliente['ap_clie'];?>" autocomplete="off"></p>
                <p>Apellido Materno: <br> <input type="text" name="am_clie" value="<?php echo $cliente['am_clie'];?>" autocomplete="off"></p>
                <p>Nombre: <br> <input type="text" name="nom_clie" value="<?php echo $cliente['nom_clie'];?>" autocomplete="off"></p>
                <p>Email: <br> <input type="email" name="email_clie" value="<?php echo $cliente['email_clie'];?>" autocomplete="off"></p>
                <p>RFC: <br> <input type="text" name="rfc_clie" value="<?php echo $cliente['rfc_clie'];?>" autocomplete="off"></p>
                <p>Teléfono: <br> <input type="tel" name="tel_clie" value="<?php echo $cliente['tel_clie'];?>" autocomplete="off"></p>
                <input type="submit" value="Guardar cambios" class="btn btn-warning">
            </form>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <input type="submit" class="btn btn-danger" name="salir" value="Salir">
            </form>
            <button class="btn btn-secondary" onclick="closeDialog()">Regresar</button>
    </dialog>

    <script>
        function openDialog() {
            document.getElementById('clienteDialog').showModal();
        }

        function closeDialog() {
            document.getElementById('clienteDialog').close();
        }
    </script>

</body>

</html>