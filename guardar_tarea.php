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
$tarea = $_POST['tarea'];
$descripcion = $_POST['descripcion'];
$fincio = $_POST['finicio'];
$fin = $_POST['fin']; 


// Preparar y ejecutar la inserción
$sql = "INSERT INTO tareas (Titulo_tarea, Descrp_Ta, Fecha_Inic, Fecha_fin	) VALUES (?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $tarea, $descripcion, $fincio, $fin);

if ($stmt->execute()) {
    echo " Tarea guardada correctamente. <a href='inicio.html'>Volver al inicio</a>";
} else {
    echo " Error al guardar la tarea: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
