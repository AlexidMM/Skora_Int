<?php
require_once 'php/conexion.php';

$stmt = $conexion->prepare('SELECT * FROM articulos_vendidos LIMIT 4');
$stmt->execute();

$result = $stmt->get_result();

$articulos_vendidos = array();
while ($row = $result->fetch_assoc()) {
    $articulos_vendidos[] = $row;
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/styleC.css">
    <title>SKORA</title>
</head>

<body>

    <nav>
        <a href="index.php" class="logo">Skora</a>
        <div class="links">
            <a href="index.php">Inicio</a>
            <a href="prod.php">Categorias</a>
            <a href="contacto.html">Sobre Nosotros</a>
        </div>
        <div class="login">
            <a href="login.php">Inicio de Sesión</a>
        </div>
    </nav>

    <header>
        <div class="left">
            <h1>Es hora de <span>comprar algo para el resto de tu vida!</span></h1>
            <p>Funcionabilidad, diseño e innovación
            </p>
            <a href="prod.php">
                <i class='bx bx-basket'></i>
                <span>Compra</span>
            </a>
        </div>
        <img id="header-img" src="images/header.jpg">
    </header>

    <h2 class="separator">
        Sucursales
    </h2>

    <div class="sell-nft">
        <div class="item" onclick="window.location.href='prodSuc.php?no_suc=1';" style="cursor: pointer;">
            <div class="header">
                <i class='bx bx-wallet-alt'></i>
                <h5>Sucursal Queretaro</h5>
            </div>
            <p></p>
        </div>
    
        <div class="item" onclick="window.location.href='prodSuc.php?no_suc=2';" style="cursor: pointer;">
            <div class="header">
                <i class='bx bx-grid-alt'></i>
                <h5>Sucursal Chiapas</h5>
            </div>
            <p></p>
        </div>
        <div class="item" onclick="window.location.href='prodSuc.php?no_suc=3';" style="cursor: pointer;">
            <div class="header">
                <i class='bx bx-cart-alt'></i>
                <h5>Sucursal Monterrey</h5>
            </div>
            <p></p>
        </div>
</div>

    <h2 class="separator">
        Nuestros mejores Productos!
    </h2>

    <div class="nft-shop">
        <div class="nft-list">
            <?php foreach ($articulos_vendidos as $articulo) {?>
                <div class="item">
                    <div class="info">
                        <div>
                            <h5><?php echo $articulo['nom_art'];?></h5>
                            <div class="btc">
                                <i class='bx bxl-bitcoin'></i>
                                <p><?php echo number_format(isset($articulo['prec_art']) ? $articulo['prec_art'] : 0, 2);?> MXN</p>
                            </div>
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
    </div>

    <div class="view-more">
        <a href="prod.php"><button>Ver Más</button></a>
    </div>

    <h2 class="separator">
        Nosotros
    </h2>

    <div class="sellers">
        <div class="item">
            <img src="images/profile-1.png">
            <div class="info">
                <h4>Alejandro Macias </h4>
                <p>Gestor de Base de Datos.</p>
            </div>
        </div>
        <div class="item">
            <img src="images/profile-2.png">
            <div class="info">
                <h4>Luis Abraham </h4>
                <p>Front-end, prompt Enginer.</p>
            </div>
        </div>
        <div class="item">
            <img src="images/profile-3.png">
            <div class="info">
                <h4>Edson Gabriel</h4>
                <p>Gestor de redes.</p>
            </div>
        </div>
        <div class="item">
            <img src="images/profile-4.png">
            <div class="info">
                <h4>Karla Sosa</h4>
                <p>Maestra de Aplicaciones web</p>
            </div>
        </div>
    </div>

    <footer>
        <h3>Crea, Explora y collecta cuero</h3>
        <div class="right">
            <div class="links">
                <a href="#">Politicas de Privacidad</a>
                <a href="#">Cooperacion</a>
                <a href="#">Sponsors</a>
                <a href="#">Contactanos </a>
            </div>
            <p>Copyright © 2024 Skora, Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>