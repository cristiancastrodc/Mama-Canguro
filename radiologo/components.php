<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }

  function _print_menu()
  { ?>
    <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
      <a href="/radiologo">
        <div class="banner-grid text-center" id="btn-pagina-principal">
          <span class="top-icon1"></span>
          <h3>Pagina Principal</h3>
        </div>
      </a>
      <a href="buscar-paciente.php">
        <div class="banner-grid text-center" id="btn-buscar-paciente">
          <span class="top-icon2"></span>
          <h3>Buscar Paciente</h3>
        </div>
      </a>
      <!-- a href="edit.php">
        <div class="banner-grid text-center">
          <span class="top-icon3"></span>
          <h3>Actualizar mis Datos</h3>
        </div>
      </a-->
      <a href="../logout.php">
        <div class="banner-grid text-center">
          <span class="top-icon5"></span>
          <h3>Cerrar Sesión</h3>
        </div>
      </a>
      <div class="clearfix"></div>
    </div>
  <?php }

  function _print_datos_paciente($conexion, $nro_atencion) {
    $sentencia = "CALL sp_taatencion_recuperar_paciente($nro_atencion)";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_array($resultado)) {
          $nombre = $fila["nombre"];
          $fecha_nacimiento = $fila["fechanacimiento"];
          $nacimiento = strtotime($fecha_nacimiento);
          $nacimiento = date('Y', $nacimiento);
          $hoy = date('Y');
          $edad = $hoy - $nacimiento;
          $grado_instruccion = $fila["gradoinstruccion"];
          $estado_civil = $fila["estadocivil"];

          echo "<form class='form-horizontal style-form'>";
            echo "<div class='form-group'>";
              echo "<label class='col-md-2 control-label'>Nombre</label>";
              echo "<div class='col-md-4'>";
                echo "<input readonly class='form-control' value='".utf8_encode($nombre)."'>";
              echo "</div>";
              echo "<label class='col-md-2 control-label'>Fecha Nacimiento</label>";
              echo "<div class='col-md-2'>";
                echo "<input readonly class='form-control' value='$fecha_nacimiento'>";
              echo "</div>";
              echo "<label class='col-md-1 control-label'>Edad</label>";
              echo "<div class='col-md-1'>";
                echo "<input readonly class='form-control right-align' value='$edad'>";
              echo "</div>";
            echo "</div>";
            echo "<div class='form-group'>";
              echo "<label class='col-sm-2 control-label'>Grado Instrucción</label>";
              echo "<div class='col-sm-4'>";
                echo "<input readonly class='form-control' value='".utf8_encode($grado_instruccion)."'>";
              echo "</div>";
              echo "<label class='col-sm-2 control-label'>Estado Civil</label>";
              echo "<div class='col-sm-4'>";
                echo "<input readonly class='form-control' value='$estado_civil'>";
              echo "</div>";
            echo "</div>";
          echo "</form>";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  } ?>