<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "mi_base_de_datos");

// Verifica conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibe datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Consulta SQL (usamos prepared statements para seguridad)
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();

    // Verifica la contraseña
    if (password_verify($contrasena, $fila['contrasena'])) {
        // Iniciar sesión y redirigir
        session_start();
        $_SESSION['usuario'] = $usuario;
        header("Location: pagina_principal.html");
        exit();
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$stmt->close();
$conexion->close();
?>
