<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('radiologo');
  $usuario = $_SESSION["UsuarioLogueado"];
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperar los pacientes en espera
  ?>
  <div class="col-md-4 ds" id="no-atendidos">
    <h3>Por Atender</h3>
    <?php
    $consulta = 'CALL sp_radiologo_no_atendidos();';
    if (mysqli_multi_query($conexion, $consulta)) {
      if ($result = mysqli_store_result($conexion)) {
        while ($row = mysqli_fetch_row($result)) {
          $nro_atencion = $row[0];
          $nombres = utf8_encode($row[1]);
          $apellidos = utf8_encode($row[2]);
          $denominacion = utf8_encode($row[3]);
          ?>
          <div class="desc">
            <div class="details">
              <p><b><?=$nombres?> <?=$apellidos?></b></p>
              <h4><?=$denominacion?></h4>
            </div>
            <div class='actions'>
              <a class='btn btn-theme04 btn-atender-paciente' role='button' data-nro-atencion="<?=$nro_atencion?>">Atender</a>
            </div>
          </div>
          <?php
        }
        mysqli_free_result($result);
      }
      mysqli_next_result($conexion);
    }
    ?>
  </div><!-- col-md-4 -->
  <div class="col-md-8" id="pendientes-resultado">
    <div class='panel panel-default m-t-15'>
      <div class='panel-heading'>Pendientes de Resultado</div>
        <div class='panel-body'>
          <div class='table-responsive'>
            <table class='table'>
              <thead>
                <tr>
                  <th>Paciente</th>
                  <th>Servicio</th>
                  <th>Aplazado desde</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $consulta = 'CALL sp_radiologo_sin_resultado();';
                if (mysqli_multi_query($conexion, $consulta)) {
                  if ($result = mysqli_store_result($conexion)) {
                    while ($row = mysqli_fetch_row($result)) {
                      $nombres = utf8_encode($row[2]);
                      $apellidos = utf8_encode($row[3]);
                      $denominacion = utf8_encode($row[4]);
                      $fecha_entrega_muestra = $row[5];
                      ?>
                <tr>
                  <td><?=$nombres?> <?=$apellidos?></td>
                  <td><?=$denominacion?></td>
                  <td><?=$fecha_entrega_muestra?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
          <?php
        }
        mysqli_free_result($result);
      }
      mysqli_next_result($conexion);
    }
    ?>
  </div>
