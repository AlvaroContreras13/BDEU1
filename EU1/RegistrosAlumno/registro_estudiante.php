<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener los datos del formulario
$registro_estudiante = $_POST['registro_estudiante'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$escuela = $_POST['escuela'];
$materias = $_POST['materias'];

// Verificar si el número de registro del estudiante ya existe en la base de datos
$sql_verificar = "SELECT id_estudiante FROM tbestudiante WHERE registro_estudiante = :registro_estudiante";
$stmt = $conn->prepare($sql_verificar);
$stmt->bindParam(':registro_estudiante', $registro_estudiante);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // El número de registro ya existe, mostrar un mensaje de error y redirigir
    echo "El número de registro de estudiante ya existe.";
    exit; // Detener la ejecución del script
}

// Si el número de registro no existe, proceder con el registro del estudiante

// Aquí deberías realizar la inserción en la base de datos, pero por simplicidad, solo mostraremos los datos recibidos
echo "Registro exitoso: <br>";
echo "Nombre: " . $nombre . "<br>";
echo "Apellido: " . $apellido . "<br>";
echo "Fecha de Nacimiento: " . $fecha_nacimiento . "<br>";
echo "Escuela: " . $escuela . "<br>";
echo "Materias: ";
foreach ($materias as $materia) {
    echo $materia . ", ";
}

// Cerrar la conexión
$conn = null;
?>
