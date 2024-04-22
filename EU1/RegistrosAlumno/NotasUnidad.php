<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se han proporcionado el código de la materia y el ID del estudiante en la URL
if(isset($_GET['codigo_materia']) && isset($_GET['id_estudiante'])) {
    // Obtener el código de la materia y el ID del estudiante desde la URL
    $codigo_materia = $_GET['codigo_materia'];
    $id_estudiante = $_GET['id_estudiante'];

    // Consulta SQL para obtener las unidades correspondientes a la materia y al estudiante
    $sql = "SELECT * FROM tbunidad WHERE codigo_materia = :codigo_materia AND id_estudiante = :id_estudiante";
    
    // Preparar la consulta SQL
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bindParam(':codigo_materia', $codigo_materia);
    $stmt->bindParam(':id_estudiante', $id_estudiante);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $unidades = $stmt->fetchAll();
} else {
    // Si no se proporcionaron los parámetros necesarios, redireccionar a la página anterior
    header("Location: MateriasAlumno.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de Unidad</title>
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

<h2>Notas de Unidad</h2>
<table>
    <tr>
        <th>Unidad</th>
        <th>Nota</th>
        <th>Editar notas de trabajo</th> <!-- Nueva columna -->
    </tr>
    <?php
    // Mostrar las notas de unidad en una tabla HTML
    foreach($unidades as $unidad) {
        echo "<tr>";
        echo "<td>" . $unidad["numero_unidad"] . "</td>";
        echo "<td>" . $unidad["nota_unidad"] . "</td>";
        echo "<td><a href='EditarNotasTrabajo.php?id_unidad=" . $unidad["id_unidad"] . "'><button>Editar</button></a></td>"; // Botón para editar las notas de trabajo
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
