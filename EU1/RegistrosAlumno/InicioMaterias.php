<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha enviado el código de materia a eliminar
if(isset($_GET['eliminar_materia'])) {
    $codigo_materia = $_GET['eliminar_materia'];

    // Consulta SQL para eliminar la materia con el código proporcionado
    $sql = "DELETE FROM tbMateria WHERE codigo_materia = :codigo_materia";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo_materia', $codigo_materia);

    // Ejecutar la consulta
    if($stmt->execute()) {
        // Redireccionar a la página de inicio de materias después de eliminar
        header("Location: InicioMaterias.php");
        exit();
    } else {
        echo "Error al intentar eliminar la materia.";
    }
}

// Consulta SQL para seleccionar todas las materias registradas
$sql = "SELECT * FROM tbMateria";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias Registradas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 45%;
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

<h2>Materias Registradas</h2>
<a href="RegistroMateria.php"><button>Registrar una materia</button></a>

<?php
// Mostrar las materias en una tabla HTML
if ($resultado && $resultado->rowCount() > 0) {
    echo "<table>";
    echo "<tr><th>Código de Materia</th><th>Nombre de Materia</th><th>Creditos</th><th>Acciones</th><th>Estudiantes Inscritos</th></tr>";
    foreach($resultado as $row) {
        echo "<tr>";
        echo "<td>" . $row["codigo_materia"] . "</td>";
        echo "<td>" . $row["nombre_materia"] . "</td>";
        echo "<td>" . $row["creditos"] . "</td>";
        echo "<td><a href='EditarMateria.php?codigo_materia=" . $row["codigo_materia"] . "'><button>Editar</button></a> | <a href='?eliminar_materia=" . $row["codigo_materia"] . "'><button>Eliminar</button></a></td>";
        echo "<td><a href='EstudiantesInscritos.php?codigo_materia=" . $row["codigo_materia"] . "'><button>Ver Estudiantes</button></a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron materias registradas.";
}

// Cerrar la conexión
$conn = null;
?>
</body>
</html>
