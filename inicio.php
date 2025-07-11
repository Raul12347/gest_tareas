<?php
include("conexion.php");
session_start();
//LINEA DE CODIGO PARA VERIFICAR SI EXISTE UNA SESION INICIADA MOSTRARA EL CONTENIDO DE LA PAGINA

if(isset( $_SESSION['usuario'])){
    $id_usu = $_SESSION['id_usuario'];
    $usu = $_SESSION['usuario'];
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="../Tareas/Css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <!-- jQuery (requerido por DataTables) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  

</head>
<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Gestor de Tareas</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="../Tareas/inicio.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <form action="guardar_tarea.php" method="post">
      <div class="mb-3">
        <label for="tareaNombre" class="form-label">Tarea</label>
        <input type="text" class="form-control" id="tareaNombre" name="tarea" placeholder="Nombre de la tarea" required>
      </div>
      <div class="mb-3">
        <label for="tareaDescripcion" class="form-label">Descripción de la tarea</label>
        <textarea class="form-control" id="tareaDescripcion" name="descripcion" rows="3" required></textarea>
      </div>
      <div class="row mb-3">
  <div class="col-md-6">
    <label for="finicio" class="form-label">Fecha de inicio</label>
    <input type="date" class="form-control" name="finicio" id="finicio">
  </div>
  <div class="col-md-6">
    <label for="fin" class="form-label">Fecha de final</label>
    <input type="date" class="form-control" name="fin" id="fin">
      </div>
      </div>
      <button type="submit" class="btn btn-primary">Guardar tarea</button>
    </form>
  </div>
  <table id="tablaTareas" class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Título</th>
      <th>Descripción</th>
      <th>Inicio</th>
      <th>Fin</th>
      <th>Acciones</th> <!-- Nueva columna -->
    </tr>
  </thead>
  <tbody>
    <?php

//ESTA PARTE DEL CODIGO TALVEZ PODRIAMOS MEJORARLA PARA QUE NO SE REPITA EL CODIGO DE CONEXION A LA BASE DE DATOS
// --------------------------------------------------------------------------------------------------------------------

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
    $servername = "localhost";
$username = "root";
$password = "";
$database = "tareas_ges";

// Conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verifica conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Asegura que el usuario está en sesión
$id_usuario = $_SESSION['id_usuario'];

// Prepara consulta solo para tareas del usuario actual
$stmt = $conn->prepare("SELECT * FROM tareas WHERE Fkusuario = ? ORDER BY Id_tarea DESC");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Mostrar las tareas
while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($fila['Titulo_tarea']) . "</td>";
    echo "<td>" . htmlspecialchars($fila['Descrp_Ta']) . "</td>";
    echo "<td>" . $fila['Fecha_Inic'] . "</td>";
    echo "<td>" . $fila['Fecha_fin'] . "</td>";
    echo "<td>
            <a href='edit.php?id=" . $fila['Id_tarea'] . "' class='btn btn-sm btn-warning me-1'>Editar</a>
            <a href='borar_tarea.php?id=" . $fila['Id_tarea'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('¿Estás seguro de eliminar esta tarea?');\">Eliminar</a>
          </td>";
    echo "</tr>";
}

$stmt->close();
$conn->close();
    ?>
  </tbody>
</table>

<script src="../Tareas/scripts/script.js"></script>
</body>
</html>
<?php
//LINEA DE CODIGO PARA CERRAR EL IF DEL INICIO Y EN CASO DE NO EXISTIR UNA SESION  ACTIVA TE VA A REDIRIJIR AL LOGIN
} else{
    header("location:login.html");
}
?>
