<?php
include_once("database.php");

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
} else {
    $pokemonSolicitado = $_GET["id"];

    $stmt = $conexion->prepare("SELECT * FROM pokemons WHERE id=?");
    $stmt->bind_param("s", $pokemonSolicitado);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
}

?>

<head>
    <meta charset="UTF-8">
    <title>Pokedex</title>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
</head>

<body>

    <div class="pokemon-detalle">
        <?php
        echo '<div class="pokemon-nombre">' . $row["nombre"] . '</div>';
        ?>
        <?php
        echo '<img class="pokemon-tipo" width="50" height="50" src="../assets/' . $row["tipo"] . '.png">';
        ?>
        <?php
        echo   '<img class="pokemon-imagen" src="../assets/' . $row["imagen"] . '">';
        ?>
        <?php
        echo '<p class="pokemon-descripcion">' . $row["descripcion"] . '</p>';
        ?>
    </div>

</body>

</html>
