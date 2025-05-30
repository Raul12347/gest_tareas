<?php 
$servidor="localhots";
$base = "tareas_ges";
$username = "root";
$pass = "";
$conn = mysqli_connect($servidor,$username,$pass) or die ("No se a podido conectar el servidor");
$db = mysqli_select_db($conn,$base) or die("UPPS!  Error a conectar a la base de datos");
//verificar la conexin


?>