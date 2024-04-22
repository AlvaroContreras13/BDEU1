<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se proporcionó el código de materia en la URL
if(isset($_GET['codigo_materia'])) {
    // Obtener el código de la materia desde la URL
    $codigo_materia = $_GET['codigo_materia'];

    // Consulta SQL para seleccionar todos los estudiantes inscritos en la materia proporcionada
    // Consulta SQL para seleccionar solo estudiantes únicos inscritos en la materia proporcionada
$sql = "SELECT DISTINCT tbestudiante.id_estudiante, tbestudiante.registro_estudiante, tbestudiante.nombre_estudiante, tbestudiante.apellido_estudiante
        FROM tbestudiante
        INNER JOIN tbunidad ON tbestudiante.id_estudiante = tbunidad.id_estudiante
        WHERE tbunidad.codigo_materia = :codigo_materia";

    
    // Preparar la consulta SQL
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':codigo_materia', $codigo_materia);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $estudiantes = $stmt->fetchAll();
} else {
    // Si no se proporcionó el código de materia, redireccionar a la página de inicio de materias
    header("Location: InicioMaterias.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes Inscritos en la Materia</title>
    <style>
        table {
            border-collapse: collapse;
            width: 75%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Estudiantes Inscritos en la Materia</h2>
<table>
    <tr>
        <th>ID de Estudiante</th>
        <th>Registro de Estudiante</th>
        <th>Nombre</th>
        <th>Apellido</th>
    </tr>
    <?php
    // Mostrar los estudiantes inscritos en una tabla HTML
    foreach($estudiantes as $estudiante) {
        echo "<tr>";
        echo "<td>" . $estudiante["id_estudiante"] . "</td>";
        echo "<td>" . $estudiante["registro_estudiante"] . "</td>";
        echo "<td>" . $estudiante["nombre_estudiante"] . "</td>";
        echo "<td>" . $estudiante["apellido_estudiante"] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
