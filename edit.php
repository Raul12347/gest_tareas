<?php 
session_start();
include ("conexion.php");
if (!isset($_SESSION['id_usuario'])) {
    die ("Acesso no permitido");

}
$id_tarea = $_GET['id'] ?? null;
if (!$id_tarea) {
    die("ID no valido");

}
//obtener la tarea 
$sql = "SELECT * FROM tareas WHERE Id_tarea = ? AND Fkusuario =? ";
$stmt = $conn->prepare($sql);
$stmt-> bind_param ("ii",$id_tarea, $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
$tarea=$result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
     <h2>Editar Tarea</h2>
    <form action="actualizar_tarea.php" method="POST">
        <input type="hidden" name="id_tarea" value="<?php echo $tarea['Id_tarea']; ?>">

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="<?php echo $tarea['Titulo_tarea']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"><?php echo $tarea['Descrp_Ta']; ?></textarea>
        </div>

        <div class="mb-3">
            <label>Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" value="<?php echo $tarea['Fecha_Inic']; ?>">
        </div>

        <div class="mb-3">
            <label>Fecha de Fin</label>
            <input type="date" name="fecha_fin" class="form-control" value="<?php echo $tarea['Fecha_fin']; ?>">
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="inicio.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>