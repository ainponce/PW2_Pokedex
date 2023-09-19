<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}

$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de inicio</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link href="./assets/favicon.ico" rel="icon" type="image/x-icon">
</head>
<body>
<h2>Bienvenido, <?php echo $usuario; ?></h2>
<p>Esta es tu página de inicio.</p>
<a href="scripts/logOut.php">Cerrar Sesión</a>
</body>
</html>
