<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion_aux = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);

  $tipo = $_GET["tipo"];
  $id_paciente = $_GET["id"];
  if ($tipo == 1) {
    $val1 = $_GET["val1"];
    $val2 = $_GET["val2"];
    $val3 = $_GET["val3"];
    $val4 = $_GET["val4"];
    $val5 = $_GET["val5"];
    $val6 = $_GET["val6"];
    $val7 = $_GET["val7"];
    $val8 = $_GET["val8"];
    $val9 = $_GET["val9"];
    $val10 = $_GET["val10"];
    $val11 = $_GET["val11"];
    $val12 = $_GET["val12"];
    $val13 = $_GET["val13"];
    $val14 = $_GET["val14"];
    $val15 = $_GET["val15"];
    $val16 = $_GET["val16"];
    $val17 = $_GET["val17"];
    $val18 = $_GET["val18"];

    $sentencia = "CALL sp_taantecedente_medicina_general_actualizar('$id_paciente','$val1','$val2','$val3','$val4','$val5','$val6','$val7','$val8','$val9','$val10','$val11','$val12','$val13','$val14','$val15','$val16','$val17','$val18')";
  } elseif ($tipo == 2) {
    $val1 = $_GET["val1"];
    $val2 = $_GET["val2"];
    $val3 = $_GET["val3"];
    $val4 = $_GET["val4"];
    $val5 = $_GET["val5"];
    $val6 = $_GET["val6"];
    $val7 = $_GET["val7"];
    $val8 = $_GET["val8"];
    $val9 = $_GET["val9"];
    $val10 = $_GET["val10"];
    $sentencia = "CALL sp_taantecedente_ginecologico_actualizar('$id_paciente','$val1','$val2','$val3','$val4','$val5','$val6','$val7','$val8','$val9')";
  } elseif ($tipo == 3) {
    $val1 = $_GET["val1"];
    $val2 = $_GET["val2"];
    $val3 = $_GET["val3"];
    $val4 = $_GET["val4"];
    $val5 = $_GET["val5"];
    $val6 = $_GET["val6"];
    $val7 = $_GET["val7"];
    $val8 = $_GET["val8"];
    $val9 = $_GET["val9"];
    $val10 = $_GET["val10"];
    $val11 = $_GET["val11"];
    $val12 = $_GET["val12"];
    $val13 = $_GET["val13"];
    $val14 = $_GET["val14"];

    $sentencia = "CALL sp_taantecedente_pediatricos_actualizar('$id_paciente','$val1','$val2','$val3','$val4','$val5','$val6','$val7','$val8','$val9','$val10','$val11','$val12','$val13','$val14')";
  }

  if (mysqli_multi_query($conexion_aux, $sentencia)) {
    mysqli_next_result($conexion_aux);
    echo "ÉXITO: Antecedentes actualizados.";
  } else {
    mysqli_next_result($conexion_aux);
    echo "ERROR: Hubo un error. Intente de nuevo en un momento.";
  }
?>