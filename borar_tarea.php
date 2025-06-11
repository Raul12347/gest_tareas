<?php
session_start();
include("conexion.php");

// Validar que el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Acceso no autorizado");
}

$id_tarea = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id_tarea) {
    $sql = "DELETE FROM tareas WHERE Id_tarea = ? AND Fkusuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_tarea, $_SESSION['id_usuario']);

    if ($stmt->execute()) {
        header("Location: inicio.php");
        exit();
    } else {
        echo "Error al eliminar la tarea: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID de tarea inválido.";
}

$conn->close();
?>


