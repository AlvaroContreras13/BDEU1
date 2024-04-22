<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Declarar variables para almacenar los valores del formulario
$codigo_materia = $nombre_materia = $creditos = "";
$error_message = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $codigo_materia = htmlspecialchars($_POST['codigo_materia']);
    $nombre_materia = htmlspecialchars($_POST['nombre_materia']);
    $creditos = htmlspecialchars($_POST['creditos']);

    // Validar que los campos no estén vacíos
    if (empty($codigo_materia) || empty($nombre_materia) || empty($creditos)) {
        $error_message = "Por favor, completa todos los campos.";
    } else {
        // Consultar si el código de materia ya existe en la base de datos
        $sql_check = "SELECT codigo_materia FROM tbMateria WHERE codigo_materia = :codigo_materia";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':codigo_materia', $codigo_materia);
        $stmt_check->execute();

        // Verificar si se encontró alguna fila (si el código de materia ya existe)
        if ($stmt_check->rowCount() > 0) {
            $error_message = "El código de materia ya está registrado. Por favor, elige otro código.";
        } else {
            // Si el código de materia no existe, insertar los datos en la base de datos
            $sql_insert = "INSERT INTO tbMateria (codigo_materia, nombre_materia, creditos) VALUES (:codigo_materia, :nombre_materia, :creditos)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bindParam(':codigo_materia', $codigo_materia);
            $stmt_insert->bindParam(':nombre_materia', $nombre_materia);
            $stmt_insert->bindParam(':creditos', $creditos);
            $stmt_insert->execute();

            // Redirigir a la página de inicio o mostrar un mensaje de éxito
            header("Location: InicioMaterias.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Materia</title>
</head>
<body>

<h2>Registro de Nueva Materia</h2>

<!-- Mostrar mensaje de error si existe -->
<?php if (!empty($error_message)) { ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php } ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="codigo_materia">Código de Materia:</label><br>
    <input type="text" id="codigo_materia" name="codigo_materia"><br><br>

    <label for="nombre_materia">Nombre de Materia:</label><br>
    <input type="text" id="nombre_materia" name="nombre_materia"><br><br>

    <label for="creditos">Créditos:</label><br>
    <input type="text" id="creditos" name="creditos"><br><br>

    <input type="submit" value="Registrar">
</form>

</body>
</html>

<?php
// Cerrar la conexión
$conn = null;
?>
