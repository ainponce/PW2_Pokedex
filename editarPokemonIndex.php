<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}


$servername = "localhost:3336";
$username = "root";
$password = '';
$database = "pokedex";
$id = $_GET['id'];
$conn = new mysqli($servername, $username, $password, $database) or die();

$sql = "SELECT * FROM pokemon WHERE id= $id";
$result = $conn->query($sql);
$resultado = $result->fetch_assoc();
$conn->close();
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
        <img src="./assets/pokdex-logo.png" class="pokelogo" href="home.php">
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
</header>
<main>
    <form class="form-add-pokemon" action="./scripts/editarPokemon.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($resultado["imagen"]); ?>" class="imagen-pokemon mx-auto" alt="<?php echo $resultado["nombre"]; ?>">
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>
        <div>
            <label for="nombrePokemon">Nombre:</label>
            <?php
            echo '<input type="text" id="nombrePokemon" name="nombrePokemon" value=" ' . $resultado['nombre'] . '">';
            ?>
        </div>
        <div>
            <label for="alturaPokemon">Altura:</label>
            <?php
            echo '<input type="text" id="alturaPokemon" name="alturaPokemon" value=" ' . $resultado['altura'] . '">';
            ?>
        </div>
        <div>
            <label for="pesoPokemon">Peso:</label>
            <?php
            echo '<input type="text" id="pesoPokemon" name="pesoPokemon" value=" ' . $resultado['peso'] . '">';
            ?>
        </div>
        <!--
        <div>
            <label for="tipoPokemon">Tipo:</label>
            <div>
                <select style="width: 100%; height: 40px; border: none; border-radius: 6px; padding: 10px; font-size: 16px" id="tipoPokemon" name="tipoPokemon">
                    <?php
                    echo '<option id="tipoPokemon" name="tipoPokemon" value=" ' . $resultado['tipo_id'] . '">' . $resultado['tipo'] . '</option>';
                    ?>
                    <option id="tipoPokemon" name="tipoPokemon" value="Electrico">Electrico</option>
                    <option id="tipoPokemon" name="tipoPokemon" value="Agua">Agua</option>
                    <option id="tipoPokemon" name="tipoPokemon" value="Fuego">Fuego</option>
                    <option id="tipoPokemon" name="tipoPokemon" value="Planta">Planta</option>
                </select>
            </div>
            -->
        </div>
        </div>
        <button class="button-add-pokemon" name="editButton" type="submit">Editar</button>
    </form>
</main>
</body>
</html>