<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tareas_ges");

// Verifica conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibe datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Consulta SQL (usamos prepared statements para seguridad)
$sql = "SELECT * FROM login WHERE Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();

    // Verifica la contraseña
}if ($contrasena === $fila['Password']) {
    session_start();
    $_SESSION['usuario'] = $usuario;
    header("Location: inicio.php");
    exit();
} else {
    echo "Contraseña incorrecta.";
} 

$stmt->close();
$conn->close();

?>
