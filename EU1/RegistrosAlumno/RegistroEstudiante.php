<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante</title>
</head>
<body>

<h2>Registro de Nuevo Estudiante</h2>

<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Inicializar variables para los mensajes de error y éxito
$error = "";
$success = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $registro_estudiante = htmlspecialchars($_POST['registro_estudiante']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $fecha_nacimiento = htmlspecialchars($_POST['fecha_nacimiento']);
    $id_escuela = htmlspecialchars($_POST['escuela']);
    $materias = $_POST['materias'];

    // Verificar si todos los campos obligatorios están llenos
    if (!empty($registro_estudiante) && !empty($nombre) && !empty($apellido) && !empty($fecha_nacimiento) && !empty($id_escuela) && !empty($materias)) {
        // Preparar la consulta SQL para insertar el nuevo estudiante
        $sql_insert_estudiante = "INSERT INTO tbestudiante (registro_estudiante, nombre_estudiante, apellido_estudiante, fecha_nacimiento, id_escuela) VALUES (:registro, :nombre, :apellido, :fecha_nacimiento, :id_escuela)";
        $stmt_insert_estudiante = $conn->prepare($sql_insert_estudiante);
        $stmt_insert_estudiante->bindParam(':registro', $registro_estudiante);
        $stmt_insert_estudiante->bindParam(':nombre', $nombre);
        $stmt_insert_estudiante->bindParam(':apellido', $apellido);
        $stmt_insert_estudiante->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt_insert_estudiante->bindParam(':id_escuela', $id_escuela);

        // Ejecutar la consulta para insertar el estudiante
        // Ejecutar la consulta para insertar el estudiante
if ($stmt_insert_estudiante->execute()) {
    $success = "Estudiante registrado exitosamente.";

    // Insertar las materias inscritas por el estudiante en la tabla de relaciones tbunidad
    $id_estudiante = $conn->lastInsertId(); // Obtener el ID del estudiante recién insertado
    foreach ($materias as $codigo_materia) {
        // Insertar tres registros en tbunidad por cada materia
        for ($i = 1; $i <= 3; $i++) {
            $sql_insert_unidad = "INSERT INTO tbunidad (id_estudiante, codigo_materia, numero_unidad) VALUES (:id_estudiante, :codigo_materia, :numero_unidad)";
            $stmt_insert_unidad = $conn->prepare($sql_insert_unidad);
            $stmt_insert_unidad->bindParam(':id_estudiante', $id_estudiante);
            $stmt_insert_unidad->bindParam(':codigo_materia', $codigo_materia);
            $stmt_insert_unidad->bindParam(':numero_unidad', $i);
            $stmt_insert_unidad->execute();
        }
    }
} else {
    $error = "Error al registrar el estudiante. Por favor, inténtalo de nuevo.";
}

    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="registro_estudiante">Registro del Estudiante:</label><br>
    <input type="text" id="registro_estudiante" name="registro_estudiante" required><br><br>

    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="apellido">Apellido:</label><br>
    <input type="text" id="apellido" name="apellido" required><br><br>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label><br>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>

    <label for="escuela">Escuela:</label><br>
    <select id="escuela" name="escuela" required>
        <option value="">Seleccione una escuela</option>
        <?php
        // Consulta SQL para obtener las escuelas
        $sql_escuelas = "SELECT id_escuela, nombre_escual FROM tbescuela";
        $stmt_escuelas = $conn->query($sql_escuelas);

        // Mostrar las escuelas como opciones en el menú desplegable
        if ($stmt_escuelas && $stmt_escuelas->rowCount() > 0) {
            foreach ($stmt_escuelas as $row_escuela) {
                echo "<option value='" . $row_escuela["id_escuela"] . "'>" . $row_escuela["nombre_escual"] . "</option>";
            }
        } else {
            echo "<option value=''>No hay escuelas disponibles</option>";
        }
        ?>
    </select><br><br>

    <label for="materias">Materias:</label><br>
    <?php
    // Consulta SQL para obtener todas las materias con sus créditos
    $sql_materias = "SELECT codigo_materia, nombre_materia, creditos FROM tbmateria";
    $stmt_materias = $conn->query($sql_materias);

    // Mostrar las materias como opciones en el formulario
    if ($stmt_materias && $stmt_materias->rowCount() > 0) {
        foreach ($stmt_materias as $row_materia) {
            echo "<input type='checkbox' name='materias[]' value='" . $row_materia["codigo_materia"] . "'>";
            echo "<label for='" . $row_materia["codigo_materia"] . "'>" . $row_materia["nombre_materia"] . " - Créditos: " . $row_materia["creditos"] . "</label><br>";
        }
    } else {
        echo "No hay materias disponibles.";
    }
    ?>
    <br><br>
    <input type="submit" value="Registrar">
</form>

<?php
// Mostrar mensajes de error o éxito
if (!empty($error)) {
    echo "<p style='color: red;'>Error: $error</p>";
}
if (!empty($success)) {
    echo "<p style='color: green;'>$success</p>";
}
?>

</body>
</html>
