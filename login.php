
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="sytlesheet" href="assets/css/styles_log.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles_log.css">
</head>

<body>
        <main>
            <div class="contenedor__todo">
                <div class="caja__trasera">
                    <div class="caja__trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesión para entrar en la página</p>
                        <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                    </div>
                    <div class="caja__trasera-register">
                        <h3>¿Aún no tienes una cuenta?</h3>
                        <p>Regístrate para que puedas iniciar sesión</p>
                        <button id="btn__registrarse">Regístrarse</button>
                    </div>
                </div>

                <div class="contenedor__login-register">
                    <!--Login-->
                    <form action="php/login_us.php" class="formulario__login" method="post" autocomplete="off">
                        <h2>Iniciar Sesión</h2>
                        <input type="text" placeholder="Usuario" name="nom_us">
                        <input type="password" placeholder="Contraseña" name="pass_us">
                        <button type="submit">Entrar</button>
                    </form>

                    <!--Register-->
                    <form action="php/registro_user.php" class="formulario__register" method="post" autocomplete="off">
                        <h2>Regístrarse</h2>
                        <input type="text" placeholder="Nombre" name="nom_clie">
                        <input type="text" placeholder="Apellido Paterno" name="ap_clie">
                        <input type="text" placeholder="Apellido Materno" name="am_clie">
                        <input type="email" placeholder="correo electronico" name="email_clie">
                        <input type="text" placeholder="Usuario" name="nom_us">
                        <input type="password" placeholder="Contraseña" name="pass_us">
                        <button type="submit">Regístrarse</button>
                    </form>
                </div>
            </div>

        </main>

        <script src="assets/js/script.js"></script>
</body>
</html>
