<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha proporcionado el ID de la unidad en la URL
if(isset($_GET['id_unidad'])) {
    // Obtener el ID de la unidad desde la URL
    $id_unidad = $_GET['id_unidad'];
} else {
    // Si no se proporcionó el ID de la unidad, redireccionar a la página anterior
    // Puedes manejar esta redirección de acuerdo a tus necesidades
    header("Location: index.php");
    exit();
}
// Imprimir el ID de la unidad para verificar
echo "ID de la unidad: " . $id_unidad;
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado todos los datos necesarios
    if (isset($_POST['ponderacion']) && isset($_POST['nota_trabajo'])) {
        // Obtener los datos del formulario
        $ponderacion = $_POST['ponderacion'];
        $nota_trabajo = $_POST['nota_trabajo'];

        try {
            // Insertar los datos en la tabla de trabajos
            $sql = "INSERT INTO tbtrabajos (ponderacion, nota_trabajo, id_unidad) VALUES (:ponderacion, :nota_trabajo, :id_unidad)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ponderacion', $ponderacion);
            $stmt->bindParam(':nota_trabajo', $nota_trabajo);
            $stmt->bindParam(':id_unidad', $id_unidad);
            $stmt->execute();

            // Redireccionar a la página anterior después de registrar el trabajo
            header("Location: EditarNotasTrabajo.php?id_unidad=$id_unidad");
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
    <title>Registrar Notas de Trabajo</title>
</head>
<body>

<h2>Registrar Notas de Trabajo</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="id_unidad" value="<?php echo $id_unidad; ?>">
    
    <label for="ponderacion">Ponderación:</label><br>
    <input type="text" id="ponderacion" name="ponderacion" required><br><br>

    <label for="nota_trabajo">Nota del Trabajo:</label><br>
    <input type="text" id="nota_trabajo" name="nota_trabajo" required><br><br>

    <input type="submit" value="Registrar Nota">
</form>


</body>
</html>
