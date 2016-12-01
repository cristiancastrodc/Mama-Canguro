<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('radiologo');
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $dni = $_GET["dni"];
  $consulta = "CALL sp_radiologo_atenciones_paciente('$dni');";
  if (mysqli_multi_query($conexion, $consulta)) {
    if ($result = mysqli_store_result($conexion)) {
      ?>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>Servicio</th>
            <th>Fecha de Atención</th>
            <th>Fecha de Resultado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
      <?php
      while ($fila = mysqli_fetch_row($result)) {
        $nro_atencion = $fila[0];
        $servicio = utf8_encode($fila[1]);
        $fecha_atencion = $fila[2];
        $fecha_resultado = $fila[3];
        $estado = $fila[4]; ?>
        <tr>
          <td class='text-uppercase'><?=$servicio?></td>
          <td><?=$fecha_atencion?></td>
          <td><?=$fecha_resultado?></td>";
          <td>
          <?php
          if ($estado == 'no atendido') { ?>
            <a class='btn btn-theme04 btn-atender-paciente' role='button' data-nro-atencion="<?=$nro_atencion?>">Atender</a><?php
          } elseif ($estado == 'radio_atendida') { ?>
            <a class='btn btn-success btn-llenar-resultado' role='button' href="llenar-resultado.php?nro_atencion=<?=$nro_atencion?>">Llenar Resultado</a><?php
          } elseif ($estado == 'atendido') {
            echo "Atendido";
          } ?>
          </td>
        </tr><?php
      }
      mysqli_free_result($result);
    }
    mysqli_next_result($conexion);
  }
?>
