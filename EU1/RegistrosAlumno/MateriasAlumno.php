<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha proporcionado el ID del estudiante en la URL
if(isset($_GET['id'])) {
    // Obtener el ID del estudiante desde la URL
    $id_estudiante = $_GET['id'];

    // Consulta SQL para obtener las materias en las que está inscrito el estudiante
    $sql = "SELECT tbmateria.codigo_materia, tbmateria.nombre_materia, tbmateria.creditos, tbunidad.nota_unidad
            FROM tbunidad
            INNER JOIN tbmateria ON tbunidad.codigo_materia = tbmateria.codigo_materia
            WHERE tbunidad.id_estudiante = :id_estudiante";
    
    // Preparar la consulta SQL
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':id_estudiante', $id_estudiante);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $materias = $stmt->fetchAll();

    // Array para almacenar los promedios de notas por materia
    $promedios_notas = [];

    // Calcular el promedio de notas para cada materia
    foreach($materias as $materia) {
        $codigo_materia = $materia["codigo_materia"];
        $nota_unidad = $materia["nota_unidad"];

        // Si es la primera unidad que encontramos para esta materia, creamos una entrada en el array
        if(!isset($promedios_notas[$codigo_materia])) {
            $promedios_notas[$codigo_materia] = [
                'suma_notas' => 0,
                'cantidad_unidades' => 0
            ];
        }

        // Sumar la nota de la unidad al total
        $promedios_notas[$codigo_materia]['suma_notas'] += $nota_unidad;
        $promedios_notas[$codigo_materia]['cantidad_unidades']++;
    }

    // Calcular el promedio de notas para cada materia
    foreach($promedios_notas as $codigo_materia => $datos) {
        $promedio = $datos['suma_notas'] / $datos['cantidad_unidades'];
        $promedios_notas[$codigo_materia]['promedio_notas'] = $promedio;
    }
} else {
    // Si no se proporcionó el ID del estudiante, redireccionar a la página de inicio de estudiantes
    header("Location: InicioEstudiante.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias del Estudiante</title>
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

<h2>Materias del Estudiante</h2>
<table>
    <tr>
        <th>Código de Materia</th>
        <th>Nombre de Materia</th>
        <th>Créditos</th>
        <th>Promedio de Notas</th>
        <th>Acciones</th>
    </tr>
    <?php
    // Mostrar las materias en una tabla HTML
    foreach($promedios_notas as $codigo_materia => $datos) {
        $nombre_materia = $materias[0]["nombre_materia"]; // El nombre de la materia es el mismo para todas las unidades
        $creditos = $materias[0]["creditos"]; // Los créditos son los mismos para todas las unidades
        $promedio_notas = round($datos['promedio_notas'], 2); // Redondear el promedio de notas a dos decimales
        echo "<tr>";
        echo "<td>" . $codigo_materia . "</td>";
        echo "<td>" . $nombre_materia . "</td>";
        echo "<td>" . $creditos . "</td>";
        echo "<td>" . $promedio_notas . "</td>";
        echo "<td><a href='NotasUnidad.php?codigo_materia=" . $codigo_materia . "&id_estudiante=" . $id_estudiante . "'><button>Ver Notas de Unidad</button></a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>

