<?php 
session_start();
include("conexion.php");
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso no autorizado");
}

// Recibir datos
$id_tarea = $_POST['id_tarea'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "UPDATE tareas SET Titulo_tarea = ?, Descrp_Ta = ?, Fecha_Inic = ?, Fecha_fin = ? WHERE Id_tarea = ? AND Fkusuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $titulo, $descripcion, $fecha_inicio, $fecha_fin, $id_tarea, $_SESSION['id_usuario']);

if ($stmt->execute()) {
    header("Location: inicio.php");
} else {
    echo "Error al actualizar: " . $conn->error;
}

$stmt->close();
$conn->close();
?>