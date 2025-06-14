<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "tareas_ges");

// Verifica conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibe datos del formulario
$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

// Consulta SQL segura
$sql = "SELECT * FROM login WHERE Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica si existe el usuario
if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();

    // Validación directa (sin hash, como dijiste)
    if ($contrasena === $fila['Password']) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id_usuario'] = $fila['Id_usuario']; // ✅ Aquí guardas el ID en la sesión
        header("Location: inicio.php");
        exit();
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$stmt->close();
$conn->close();
?>


