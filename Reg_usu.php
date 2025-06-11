<?php
include("conexion.php");

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Verificar si el usuario ya existe
$verificar = $conn->prepare("SELECT * FROM login WHERE usuario = ?");
$verificar->bind_param("s", $usuario);
$verificar->execute();
$verificar->store_result();

if ($verificar->num_rows > 0) {
    echo "Este usuario ya está registrado.";
    exit();
}

// Insertar sin hash
$consulta = "INSERT INTO login (usuario, Password) VALUES (?, ?)";
$stmt = $conn->prepare($consulta);
$stmt->bind_param("ss", $usuario, $password);

if ($stmt->execute()) {
    header("Location: login.html");
    exit();
} else {
    echo "Error al registrar el usuario: " . $conn->error;
}

$stmt->close();
$verificar->close();
$conn->close();
?>
