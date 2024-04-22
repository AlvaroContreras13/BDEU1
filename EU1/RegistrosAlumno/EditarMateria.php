<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Inicializar las variables de los datos de la materia
$codigo_materia = "";
$nombre_materia = "";
$creditos = "";

// Verificar si se ha enviado el código de la materia a editar
if(isset($_GET['codigo_materia'])) {
    $codigo_materia = $_GET['codigo_materia'];

    // Consulta SQL para obtener la información de la materia correspondiente al código
    $sql = "SELECT * FROM tbMateria WHERE codigo_materia = :codigo_materia";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo_materia', $codigo_materia);
    $stmt->execute();

    // Obtener los datos de la materia
    $materia = $stmt->fetch();

    // Verificar si se encontró la materia
    if($materia) {
        $nombre_materia = $materia['nombre_materia'];
        $creditos = $materia['creditos'];
    } else {
        echo "La materia no existe.";
        exit();
    }
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
    $codigo_materia = $_POST['codigo_materia'];
    $nombre_materia = $_POST['nombre_materia'];
    $creditos = $_POST['creditos'];

    // Consulta SQL para actualizar los datos de la materia en la base de datos
    $sql_update = "UPDATE tbMateria SET nombre_materia = :nombre_materia, creditos = :creditos, codigo_materia = :codigo_materia WHERE codigo_materia = :codigo_materia";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':nombre_materia', $nombre_materia);
    $stmt_update->bindParam(':creditos', $creditos);
    $stmt_update->bindParam(':codigo_materia', $codigo_materia);

    // Ejecutar la consulta de actualización
    if ($stmt_update->execute()) {
        // Redireccionar a la página de inicio de materias después de guardar los cambios
        header("Location: InicioMaterias.php");
        exit();
    } else {
        echo "Error al intentar guardar los cambios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Materia</title>
</head>
<body>

<h2>Editar Materia</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="hidden" name="codigo_materia" value="<?php echo $codigo_materia; ?>">
    <label for="codigo_materia">Código de la Materia:</label><br>
    <input type="text" id="codigo_materia" name="codigo_materia" value="<?php echo $codigo_materia; ?>" readonly><br><br>

    <label for="nombre_materia">Nombre de la Materia:</label><br>
    <input type="text" id="nombre_materia" name="nombre_materia" value="<?php echo $nombre_materia; ?>"><br><br>

    <label for="creditos">Créditos:</label><br>
    <input type="text" id="creditos" name="creditos" value="<?php echo $creditos; ?>"><br><br>

    <input type="submit" value="Guardar Cambios">
</form>

</body>
</html>
