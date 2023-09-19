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
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link href="./assets/favicon.ico" rel="icon" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="./assets/pokdex-logo.png" class="pokelogo" href="home.php">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link active" aria-current="page" href="#">Editar Pokemones</a>';
                    echo '</li>';
                }
                ?>
            </ul>
            <form method="post" action="scripts/logOut.php">
                <button class="btn btn-danger" type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h2>Bienvenido, <?php echo $usuario; ?></h2>
    <p>Esta es tu página de inicio.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
