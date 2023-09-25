<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}

include("scripts/database.php");

$id = $_GET['id'];

$sql = "SELECT * FROM pokemon WHERE id= $id";
$result = $conexion->query($sql);
$resultado = $result->fetch_assoc();
$conexion->close();
?>


<!doctype html>
<html>
<head>
    <title>Página de inicio</title>
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link href="./assets/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="./assets/pokdex-logo.png" class="pokelogo" href="home.php" alt="logo">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<li class="nav-item">';
                    echo '<button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#nuevoPokemonModal">Nuevo Pokemon<i class="bi bi-plus" style="margin-left: 5px"></i></button>';
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
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-12 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <form class="form-add-pokemon" action="./scripts/editarPokemon.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                        <div class="text-center">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($resultado["imagen"]); ?>" class="imagen-pokemon" alt="<?php echo $resultado["nombre"]; ?>">
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombrePokemon" class="form-label">Nombre:</label>
                            <?php
                            echo '<input type="text" class="form-control" id="nombrePokemon" name="nombrePokemon" value="' . $resultado['nombre'] . '">';
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="alturaPokemon" class="form-label">Altura:</label>
                            <?php
                            echo '<input type="text" class="form-control" id="alturaPokemon" name="alturaPokemon" value="' . $resultado['altura'] . '">';
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="pesoPokemon" class="form-label">Peso:</label>
                            <?php
                            echo '<input type="text" class="form-control" id="pesoPokemon" name="pesoPokemon" value="' . $resultado['peso'] . '">';
                            ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-danger" href="home.php"><i class="bi bi-arrow-left"></i> Volver</a>
                            <button class="btn btn-primary" name="editButton" type="submit">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>