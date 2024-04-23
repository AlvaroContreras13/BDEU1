<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha proporcionado el ID del trabajo en la URL
if(isset($_GET['id_trabajo'])) {
    // Obtener el ID del trabajo desde la URL
    $id_trabajo = $_GET['id_trabajo'];

    // Consulta SQL para obtener los datos del trabajo
    $sql = "SELECT * FROM tbtrabajos WHERE id_trabajos = :id_trabajo";
    
    // Preparar la consulta SQL
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':id_trabajo', $id_trabajo);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $trabajo = $stmt->fetch(); // Obtener solo un resultado, ya que se espera un solo trabajo con este ID
} else {
    // Si no se proporcionó el ID del trabajo, redireccionar a la página anterior
    header("Location: EditarNotasTrabajo.php");
    exit();
}

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado todos los datos necesarios
    if (isset($_POST['ponderacion']) && isset($_POST['nota_trabajo'])) {
        // Obtener los datos del formulario
        $ponderacion = $_POST['ponderacion'];
        $nota_trabajo = $_POST['nota_trabajo'];

        try {
            // Actualizar los datos del trabajo en la tabla tbtrabajos
            $sql = "UPDATE tbtrabajos SET ponderacion = :ponderacion, nota_trabajo = :nota_trabajo WHERE id_trabajos = :id_trabajo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ponderacion', $ponderacion);
            $stmt->bindParam(':nota_trabajo', $nota_trabajo);
            $stmt->bindParam(':id_trabajo', $id_trabajo);
            $stmt->execute();

            // Redireccionar a la página anterior después de actualizar el trabajo
            header("Location: EditarNotasTrabajo.php?id_unidad=" . $trabajo['id_unidad']);
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son requeridos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Nota de Trabajo</title>
</head>
<body>

<h2>Editar Nota de Trabajo</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_trabajo=<?php echo $id_trabajo; ?>" method="post">
    <label for="ponderacion">Ponderación:</label><br>
    <input type="text" id="ponderacion" name="ponderacion" value="<?php echo $trabajo['ponderacion']; ?>" required><br><br>

    <label for="nota_trabajo">Nota del Trabajo:</label><br>
    <input type="text" id="nota_trabajo" name="nota_trabajo" value="<?php echo $trabajo['nota_trabajo']; ?>" required><br><br>

    <input type="submit" value="Actualizar Nota">
</form>

</body>
</html>

