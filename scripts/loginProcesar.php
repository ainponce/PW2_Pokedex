<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $consulta = "SELECT id FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseña'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows == 1) {
        $_SESSION["usuario"] = $correo;
        header("location: ../home.php");
    } else {

        echo "Usuario o contraseña incorrectos. <a href='login.php'>Volver a intentar</a>";
    }
}

$conexion->close();
?>
