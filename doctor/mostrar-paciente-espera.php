<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
  // Recuperar el DNI del Usuario
  $User = $_SESSION["UsuarioLogueado"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $sql = "CALL sp_taatencion_servicios_usuario('$User');";
  $servicios = array();
  if (mysqli_multi_query($conexion, $sql)) {
    if($result = mysqli_store_result($conexion)) {
      while ($row = mysqli_fetch_row($result)) {
        array_push($servicios, $row[0]);
      }
    }
    mysqli_free_result($result);
  }
  mysqli_next_result($conexion);
  //-- Sgte Paciente
  $cuenta = count($servicios);
  $servicio1 = $servicios[0];
  if ($cuenta==1) {
    $servicio2 = 0;
  }else{
    $servicio2 = $servicios[1];
  }
  $sql = "CALL sp_taatencion_sgte_paciente(".$servicio1.",".$servicio2.");";
  if (mysqli_multi_query($conexion,$sql)) {
    if($result = mysqli_store_result($conexion)){
      if ($row = mysqli_fetch_row($result)) {
        $id_paciente = $row[0];
        $nombres = utf8_encode($row[1]);
        $nro_atencion = $row[2];
        $idservicio = $row[3];
        $orden = $row[4];
        $dni_paciente = $row[5];
        $denominacion = utf8_encode($row[6]);
        echo "<a href='atender-paciente.php?nroatencion=$nro_atencion&idservicio=$idservicio&idpaciente=$id_paciente'>";
        echo "<div class='col-lg-10'>";
          echo "<div class='darkblue-panel pn'>";
            echo "<div class='darkblue-header'>";
              echo "<h1>$nombres</h1>";
              echo "<h4>$denominacion</h4>";
            echo "</div>";
            echo "<h1><i class='fa fa-user-md fa-2x'></i></h1>";
            echo "<footer>";
              echo "<div class='centered'>";
                echo "<h5>$dni_paciente</h5>";
              echo "</div>";
            echo "</footer>";
          echo "</div>";
        echo "</div>";
        echo "</a>";
        echo "<div class='row'>";
          echo "<div class='col-lg-10'>";
            echo "<a href='postergar-atencion.php?nro_atencion=$nro_atencion&id_servicio=$idservicio' role='button' class='btn btn-round btn-theme03 btn-block btn-lg'>Postergar Atención</button>";
          echo "</div>";
        echo "</div>";
      }
    }
    mysqli_free_result($result);
  }
  mysqli_next_result($conexion);
?>