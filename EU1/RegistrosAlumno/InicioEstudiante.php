<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para seleccionar todos los estudiantes con información de la escuela
$sql = "SELECT tbestudiante.id_estudiante, tbestudiante.registro_estudiante, tbestudiante.nombre_estudiante, tbestudiante.apellido_estudiante, tbestudiante.fecha_nacimiento, tbescuela.nombre_escual 
        FROM tbestudiante 
        LEFT JOIN tbescuela ON tbestudiante.id_escuela = tbescuela.id_escuela";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
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

<h2>Lista de Estudiantes</h2>
<a href="RegistroEstudiante.php"><button>Registrar un estudiante</button></a>
<?php
// Mostrar los resultados en una tabla HTML
if ($resultado && $resultado->rowCount() > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Registro</th><th>Nombre</th><th>Apellido</th><th>Fecha de Nacimiento</th><th>Escuela</th><th>Acciones</th><th>Ver Materias</th></tr>";
    foreach($resultado as $row) {
        echo "<tr>";
        echo "<td>" . $row["id_estudiante"] . "</td>";
        echo "<td>" . $row["registro_estudiante"] . "</td>"; // Mostrar el registro del estudiante
        echo "<td>" . $row["nombre_estudiante"] . "</td>";
        echo "<td>" . $row["apellido_estudiante"] . "</td>";
        echo "<td>" . $row["fecha_nacimiento"] . "</td>";
        echo "<td>" . $row["nombre_escual"] . "</td>"; // Mostrar el nombre de la escuela
        echo "<td>";
        echo "<a href='EditarEstudiante.php?id=" . $row["id_estudiante"] . "'><button>Editar</button></a>"; // Enlace para editar
        echo "<a href='EliminarEstudiante.php?id=" . $row["id_estudiante"] . "'><button>Eliminar</button></a>"; // Enlace para eliminar
        echo "</td>";
        echo "<td>";
        // Agregar enlace para ver las materias del estudiante
        echo "<a href='MateriasAlumno.php?id=" . $row["id_estudiante"] . "'><button>Ver Materias</button></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron estudiantes.";
}

// Cerrar la conexión
$conn = null;
?>
</body>
</html>
