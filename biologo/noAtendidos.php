<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  $User = $_SESSION["UsuarioLogueado"];
  $Enlace = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  //Recuperar la informacion del usuario
  if (isset($_GET["Atencion"])) {
    $NroAte = $_GET["Atencion"];
    if (isset($NroAte)) {
      $Consulta ="CALL sp_taatencion_emuestra('$NroAte','$User');";
      mysqli_multi_query($Enlace,$Consulta);
      mysqli_next_result($Enlace);
    }
  }
  echo "
  <div class='col-lg-8 main-chart' >
    <div class='row mt'>
      <div class='panel panel-default'>
        <div class='panel-heading'>Examenes que faltan Analizar:</div>
        <div class='panel-body'>
          <div class='table-responsive'>
            <table class='table'>
              <thead>
                <tr>
                  <th>Orden</th>
                  <th>Nombre de Paciente</th>
                  <th>Examen</th>
                  <th>Aplazado desde</th>
                </tr>
              </thead>
              <tbody>";
  $sql = "CALL sp_taatencion_faltaresultado();";
  if (mysqli_multi_query($Enlace,$sql)) {
    if ($result=mysqli_store_result($Enlace)) {
      $i = 1;
      while ($row=mysqli_fetch_row($result)) {
        $Atencion = $row[0];
        $DNI=$row[1];
        $Nombres = utf8_encode($row[2]);
        $Apellidos= utf8_encode($row[3]);
        $Servicio= $row[4];
        $Servicio = utf8_encode($Servicio);
        $Fecha= $row[5];
        echo "
                <tr class='warning'>
                  <td><strong>$i</td>
                  <td>$Nombres $Apellidos</td>
                  <td class='uppercase'>$Servicio</td>
                  <td>$Fecha</td>
                </tr>";
        $i++;
      }
      mysqli_free_result($result);
    }
    mysqli_next_result($Enlace);
  }
  echo"
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> <!--fin de rowmt-->
  </div> <!-- Fin de col6-->";
  echo "
  <div class='col-lg-4 ds'>
    <div  class='row mt'>
      <h3>NOTIFICACIONES</h3>";
  $sql= 'CALL sp_taatencion_noatendidoL();';
  if (mysqli_multi_query($Enlace,$sql)) {
    if ($result=mysqli_store_result($Enlace)) {
      while ($row=mysqli_fetch_row($result)) {
        $NroAtencion=$row[0];
        $Nombres = utf8_encode($row[1]);
        $Apellidos = utf8_encode($row[2]);
        $Servicio= $row[3];
        $Servicio = utf8_encode($Servicio);
        echo "
      <div class='desc'>
        <div class='thumb'>
          <img class='img-circle' src='../assets/img/paciente.jpg' width='35px' height='35px' align=''>
        </div>
        <div class='details'>
          <input type='hidden' value='$NroAtencion' id='Atencion'>
          <p><b>$Nombres $Apellidos</b><br/></p>
          <p><h4><strong>'$Servicio'</strong></h4></p>
        </div>
        <div class='thumb'>
          <a class='btn btn-theme04' onclick='actualizaratenciones($NroAtencion)' role='button'>Recibir Muestra</a>
        </div>
      </div>";
      }
      mysqli_free_result($result);
    }
    mysqli_next_result($Enlace);
  }
  echo "
    </div>
  </div><!-- /col-lg-3 -->";
?>