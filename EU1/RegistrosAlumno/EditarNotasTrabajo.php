<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha proporcionado el ID de la unidad en la URL
if(isset($_GET['id_unidad'])) {
    // Obtener el ID de la unidad desde la URL
    $id_unidad = $_GET['id_unidad'];

    // Consulta SQL para obtener las notas de trabajo correspondientes a la unidad
    $sql = "SELECT * FROM tbtrabajos WHERE id_unidad = :id_unidad";
    
    // Preparar la consulta SQL
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':id_unidad', $id_unidad);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $trabajos = $stmt->fetchAll();
} else {
    // Si no se proporcionó el ID de la unidad, redireccionar a la página anterior
    header("Location: MateriasAlumno.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notas de Trabajo</title>
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

<h2>Editar Notas de Trabajo</h2>
<a href="RegistroNotasTrabajo.php?id_unidad=<?php echo $id_unidad; ?>"><button>Registrar notas trabajo</button></a>

<table>
    <tr>
        <th>ID de Trabajo</th>
        <th>Ponderación</th>
        <th>Nota de Trabajo</th>
    </tr>
    <?php
    // Mostrar las notas de trabajo en una tabla HTML
    foreach($trabajos as $trabajo) {
        echo "<tr>";
        echo "<td>" . $trabajo["id_trabajos"] . "</td>";
        echo "<td>" . $trabajo["ponderacion"] . "</td>";
        echo "<td>" . $trabajo["nota_trabajo"] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
