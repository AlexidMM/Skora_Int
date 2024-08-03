<?php
    session_start();
    include 'conexion.php';

    $nom_us = $_POST['nom_us'];
    $pass_us = $_POST['pass_us'];

    $valid_login = mysqli_query($conexion, "SELECT tipo_us FROM USUARIO WHERE nom_us='$nom_us' AND pass_us='$pass_us'");

    // Check if user exists
    if (mysqli_num_rows($valid_login) > 0) {
        $row = mysqli_fetch_assoc($valid_login);
        $tipo_us = $row['tipo_us'];
        $_SESSION['nom_us'] = $nom_us;
        $_SESSION['tipo_us'] = $tipo_us;

    setcookie('usuario', $nom_us, time() + 84600, "/");

        // Redirect based on user type
        if ($tipo_us == '1') {
            header("location: ../admin.php");
        } elseif ($tipo_us == '2') {
            header("location: ../prod.php");
        } else {
            // Handle unexpected user type
            echo '
                <script>
                    alert("¿Quién eres tu?, no existes");
                    window.location = "../login.php";
                </script>
            ';
            
        }
        exit;
    } else {
        // Handle invalid credentials
        echo '
            <script>
                alert("Datos fallidos. Carita triste");
                window.location = "../login.php";
            </script>
        ';
        exit;
    }


