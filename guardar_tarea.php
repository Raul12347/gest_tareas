<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "tareas_ges";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$tarea = $_POST['Titulo_tarea'];
$descripcion = $_POST['Descrip_Ta'];
$fincio = $_POST['Fecha_Inic'];
$fin = $_POST['Fecha_fin']; 

// Preparar y ejecutar la inserción
$sql = "INSERT INTO tareas (tarea, descripcion, fecha_creacion) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $tarea, $descripcion, $fincio, $fin);

if ($stmt->execute()) {
    echo " Tarea guardada correctamente. <a href='inicio.html'>Volver al inicio</a>";
} else {
    echo " Error al guardar la tarea: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
