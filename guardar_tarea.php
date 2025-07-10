<?php
session_start();
include("conexion.php");

// Asegura que la sesión contiene el id del usuario
if (!isset($_SESSION['id_usuario'])) {
    die("Error: sesión no iniciada o usuario no autenticado.");
}

$titulo = $_POST['tarea'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['finicio'];
$fecha_fin = $_POST['fin'];
$fkusuario = $_SESSION['id_usuario']; // 👈 CORRECTO: esto sí existe

// Prepara la consulta con el campo correcto
$sql = "INSERT INTO tareas (Titulo_tarea, Descrp_Ta, Fecha_Inic, Fecha_fin, Fkusuario) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en prepare: " . $conn->error);
}

// Vincula los parámetros
$stmt->bind_param("ssssi", $titulo, $descripcion, $fecha_inicio, $fecha_fin, $fkusuario);

// Ejecuta la consulta
if ($stmt->execute()) {
    header("Location: inicio.php");
    exit();
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
