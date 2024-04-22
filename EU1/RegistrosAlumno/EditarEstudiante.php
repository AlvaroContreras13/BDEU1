<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Inicializar variables
$id_estudiante = "";
$registro_estudiante = "";
$nombre_estudiante = "";
$apellido_estudiante = "";
$fecha_nacimiento = "";
$id_escuela = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $id_estudiante = $_POST["id_estudiante"];
    $registro_estudiante = $_POST["registro_estudiante"];
    $nombre_estudiante = $_POST["nombre_estudiante"];
    $apellido_estudiante = $_POST["apellido_estudiante"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $id_escuela = $_POST["escuela"];

    // Actualizar los datos del estudiante en la base de datos
    $sql_update = "UPDATE tbestudiante SET registro_estudiante = :registro, nombre_estudiante = :nombre, apellido_estudiante = :apellido, fecha_nacimiento = :fecha, id_escuela = :escuela WHERE id_estudiante = :id";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':registro', $registro_estudiante);
    $stmt_update->bindParam(':nombre', $nombre_estudiante);
    $stmt_update->bindParam(':apellido', $apellido_estudiante);
    $stmt_update->bindParam(':fecha', $fecha_nacimiento);
    $stmt_update->bindParam(':escuela', $id_escuela);
    $stmt_update->bindParam(':id', $id_estudiante);
    $stmt_update->execute();

    // Redirigir a la página de inicio después de la actualización
    header("Location: inicio.php");
    exit();
} else {
    // Obtener el ID del estudiante de la URL
    $id_estudiante = $_GET["id"];

    // Consultar los datos del estudiante
    $sql_select = "SELECT * FROM tbestudiante WHERE id_estudiante = :id";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bindParam(':id', $id_estudiante);
    $stmt_select->execute();

    // Verificar si se encontró el estudiante
    if ($stmt_select->rowCount() > 0) {
        // Obtener los datos del estudiante
        $estudiante = $stmt_select->fetch(PDO::FETCH_ASSOC);
        $registro_estudiante = $estudiante["registro_estudiante"];
        $nombre_estudiante = $estudiante["nombre_estudiante"];
        $apellido_estudiante = $estudiante["apellido_estudiante"];
        $fecha_nacimiento = $estudiante["fecha_nacimiento"];
        $id_escuela = $estudiante["id_escuela"];
    } else {
        // Si no se encuentra el estudiante, redirigir a la página de inicio
        header("Location: inicio.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
</head>
<body>

<h2>Editar Estudiante</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante; ?>">

    <label for="registro_estudiante">Registro del Estudiante:</label><br>
    <input type="text" id="registro_estudiante" name="registro_estudiante" value="<?php echo $registro_estudiante; ?>"><br><br>

    <label for="nombre_estudiante">Nombre:</label><br>
    <input type="text" id="nombre_estudiante" name="nombre_estudiante" value="<?php echo $nombre_estudiante; ?>"><br><br>

    <label for="apellido_estudiante">Apellido:</label><br>
    <input type="text" id="apellido_estudiante" name="apellido_estudiante" value="<?php echo $apellido_estudiante; ?>"><br><br>

    <label for="fecha_nacimiento">Fecha de Nacimiento:</label><br>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>"><br><br>

    <label for="escuela">Escuela:</label><br>
    <select id="escuela" name="escuela">
        <?php
        // Consulta SQL para obtener las escuelas
        $sql_escuelas = "SELECT id_escuela, nombre_escual FROM tbescuela";
        $stmt_escuelas = $conn->query($sql_escuelas);

        // Mostrar las escuelas como opciones en el menú desplegable
        if ($stmt_escuelas && $stmt_escuelas->rowCount() > 0) {
            foreach($stmt_escuelas as $row_escuela) {
                if ($row_escuela["id_escuela"] == $id_escuela) {
                    echo "<option value='" . $row_escuela["id_escuela"] . "' selected>" . $row_escuela["nombre_escual"] . "</option>";
                } else {
                    echo "<option value='" . $row_escuela["id_escuela"] . "'>" . $row_escuela["nombre_escual"] . "</option>";
                }
            }
        } else {
            echo "<option value=''>No hay escuelas disponibles</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" value="Guardar Cambios">
</form>

</body>
</html>

<?php
// Cerrar la conexión
$conn = null;
?>
