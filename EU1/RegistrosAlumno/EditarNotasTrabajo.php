<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha proporcionado el ID de la unidad en la URL
if (isset($_GET['id_unidad'])) {
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

// Procesar el formulario de eliminación
if (isset($_POST['eliminarNota'])) {
    // Verificar si se proporcionó el ID de la nota a eliminar
    if (isset($_POST['id_trabajo'])) {
        // Obtener el ID del trabajo a eliminar
        $id_trabajo = $_POST['id_trabajo'];

        try {
            // Consulta SQL para eliminar el trabajo de la tabla tbtrabajos
            $sql = "DELETE FROM tbtrabajos WHERE id_trabajos = :id_trabajo";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Vincular parámetros
            $stmt->bindParam(':id_trabajo', $id_trabajo);

            // Ejecutar la consulta
            $stmt->execute();

            // Redireccionar a la página actual para actualizar la vista
            header("Location: {$_SERVER['PHP_SELF']}?id_unidad=$id_unidad");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar la nota: " . $e->getMessage();
        }
    } else {
        echo "ID de trabajo no proporcionado.";
    }
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
        <th>Acciones</th>
    </tr>
    <?php
    // Mostrar las notas de trabajo en una tabla HTML
    foreach ($trabajos as $trabajo) {
        echo "<tr>";
        echo "<td>" . $trabajo["id_trabajos"] . "</td>";
        echo "<td>" . $trabajo["ponderacion"] . "</td>";
        echo "<td>" . $trabajo["nota_trabajo"] . "</td>";
        // Botones de editar y eliminar
        echo "<td>";
        echo "<a href='EditarNota.php?id_trabajo=" . $trabajo["id_trabajos"] . "'><button>Editar</button></a>";
        echo "<form method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id_trabajo' value='" . $trabajo["id_trabajos"] . "'>";
        echo "<input type='submit' value='Eliminar' name='eliminarNota' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta nota?\")'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
