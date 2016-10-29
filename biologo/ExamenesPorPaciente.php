<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  $Enlace = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  //Recuperar la informacion del usuario
  $NroAte = $_GET["Atencion"];
  $DNI = $_GET["DNI"];
  if($NroAte!=0){
    $Consulta ="CALL sp_taatencion_llenar_resultado('$NroAte');";
    mysqli_multi_query($Enlace,$Consulta);
    mysqli_next_result($Enlace);
  }
?>
<?php
  echo "
  <div class='row mt'>
    <div class='panel panel-default'> ";
  $sql = "Call sp_tapaciente_listar_id('$DNI');";
  if (mysqli_multi_query($Enlace,$sql)) {
    if ($result=mysqli_store_result($Enlace)) {
      $row=mysqli_fetch_row($result);
      $Nombre = utf8_encode($row[1]);
      $Apellidos = utf8_encode($row[2]);
      echo "
      <div class='panel-heading'>Examenes Realizados al Paciente:</br><strong>$Nombre $Apellidos</strong></div>";
      mysqli_free_result($result);
    }
    mysqli_next_result($Enlace);
  }
  echo "
      <div class='panel-body'>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover tabla-pers' id='dataTables-example2'>
            <thead>
              <tr>
                <th>Nro</th>
                <th>Examen</th>
                <th>Recepción de Muestra</th>
                <th>Llenado de Resultado</th>
                <th>Opción</th>
              </tr>
            </thead>
            <tbody>";
  $sql = "CALL sp_taatencion_listar_examenes('$DNI');";
  if (mysqli_multi_query($Enlace,$sql)) {
    if ($result=mysqli_store_result($Enlace)) {
      $i=1;
      while ($row=mysqli_fetch_row($result)) {
        $Atencion=$row[0];
        $Examen = $row[1];
        $Examen = utf8_encode($Examen);
        $FechaMuestra = $row[2];
        $FechaResultado=$row[3];
        $Estado=$row[4];
        echo "
              <tr>
                <td>$i</td>
                <td class='uppercase'>$Examen</td>
                <td>$FechaMuestra</td>
                <td>$FechaResultado</td>";
        if ($Estado =='EMuestra') {
          echo "<td><a onclick='llenarexamen(".'"'.$Atencion.'"'.")' role='button' class='btn btn-round btn-success'>Llenar Resultado</a></td>";
        } elseif ($Estado == 'atendido') {
          echo "<td><a onclick='imprimirexamen(".'"'.$Atencion.'"'.")' role='button' class='btn btn-round btn-primary'>Imprimir Resultado</a></td>";
        } elseif ($Estado == 'no atendido'){
          echo "<td><a onclick='recibirMuestra($Atencion)' role='button' class='btn btn-round btn-danger'>Recibir Muestra</a></td>";
        }
        echo "
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
  </div>";
?>