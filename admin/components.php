<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  setlocale(LC_ALL, '');
  // Asignamos la zona horaria, para cálculos con fechas
  date_default_timezone_set('America/Lima');
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');

  function _print_header(){
    echo "<header class='header black-bg'>";
      echo "<div class='sidebar-toggle-box'>";
        echo "<div class='fa fa-bars tooltips' data-placement='right' data-original-title='Ocultar Menú'></div>";
      echo "</div>";
      echo "<a href='index.php' class='logo'><b>CLÍNICA MAMÁ CANGURO</b></a>";
      echo "<div class='top-menu'>";
        echo "<ul class='nav pull-right top-menu'>";
          echo "<li><a class='logout mc' href='../logout.php'>Cerrar Sesión</a></li>";
        echo "</ul>";
      echo "</div>";
    echo "</header>";
  }

  function _print_menu($conexion){
    // Recuperamos el id/dni del usuario
    $User = $_SESSION["UsuarioLogueado"];
    // Sentencia para recuperar los datos del usuario
    $sentencia = "CALL sp_tausuario_existe_new('$User')";
    $nombre = '';
    $apellidos = '';
    if (mysqli_multi_query($conexion, $sentencia)) {
      // echo "query";
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_array($resultado)) {
          $nombre = $fila["vch_nombres"];
          $apellidos = $fila["vch_apellidos"];
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    } else {
      echo mysqli_error($conexion);
    }

    echo "<aside>";
      echo "<div id='sidebar'  class='nav-collapse'>";
        echo "<ul class='sidebar-menu' id='nav-accordion'>";
          echo "<p class='centered'><a href='edit.php?chr_dni_usuario=$User'><img src='../assets/img/logo_canguro.png' class='img-circle' width='60'></a></p>";
          echo "<h5 class='centered'>$nombre $apellidos</h5>";
          echo "<li>";
            echo "<a href='index.php' id='a_inicio'>";
              echo "<i class='fa fa-flag'></i>";
              echo "<span>Inicio</span>";
            echo "</a>";
          echo "</li>";
          echo "<li class='sub-menu'>";
            echo "<a href='javascript:;' id='a_administrador'>";
              echo "<i class='fa fa-gear'></i>";
              echo "<span>Administrador - Opciones</span>";
            echo "</a>";
            echo "<ul class='sub'>";
              echo "<li><a href='administrar-servicios.php'>Administrar servicios</a></li>";
              echo "<li><a href='administrar-usuarios.php'>Administrar usuarios</a></li>";
              echo "<li><a href='reportes.php'>Reportes</a></li>";
              echo "<li><a href='restaurar-base-datos.php'>Restaurar la Base de Datos</a></li>";
            echo "</ul>";
          echo "</li>";
          echo "<li class='sub-menu'>";
            echo "<a href='javascript:;' id='a_biologo'>";
              echo "<i class='fa fa-flask'></i>";
              echo "<span>Biólogo - Opciones</span>";
            echo "</a>";
            echo "<ul class='sub'>";
              echo "<li><a href='ingresar-resultado-examen.php' id='a_resultado'>Ingresar resultado de Ex.</a></li>";
              echo "<li><a href='recepcionar-muestra.php' id='a_muestra'>Recepcionar muestra</a></li>";
            echo "</ul>";
          echo "</li>";
          echo "<li class='sub-menu'>";
            echo "<a href='javascript:;' id='a_doctor'>";
              echo "<i class='fa fa-stethoscope'></i>";
              echo "<span>Doctor - Opciones</span>";
            echo "</a>";
            echo "<ul class='sub'>";
              echo "<li><a href='llenar-historia.php' id='a_hsitora'>Atender Pacientes</a></li>";
            echo "</ul>";
          echo "</li>";
          echo "<li class='sub-menu'>";
            echo "<a href='javascript:;' id='a_secretaria'>";
              echo "<i class='fa fa-desktop'></i>";
              echo "<span>Secretaria - Opciones</span>";
            echo "</a>";
            echo "<ul class='sub'>";
              echo "<li><a href='administrar-filiacion.php' id='a_filiacion'>Administrar Filiación</a></li>";
              echo "<li><a href='registrar-atencion.php'  id='a_consulta'>Registrar Atención</a></li>";
            echo "</ul>";
          echo "</li>";
        echo "</ul>";
      echo "</div>";
    echo "</aside>";
  }

  function _print_usuarios_activos($conexion){
    echo "<h3>Usuarios Activos</h3>";
    $sentencia = 'CALL sp_tausuario_listar()';
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($fila = mysqli_fetch_row($resultado)) {
          $tipo = $fila[1];
          $nombre = $fila[0];
          $especialidad1 = $fila[2];
          $especialidad2 = $fila[3];
          $estado = $fila[4];
          if ($estado == 'En Sesion') {
            echo "<div class='desc'>";
              echo "<div class='thumb'>";
                echo "<img class='img-circle' src='../assets/img/logo_canguro.png' width='35px' height='35px' align=''>";
              echo "</div>";
              echo "<div class='details'>";
                echo "<p><a href='#'>";
                echo utf8_encode($nombre)."</a><br/>";
                echo "<muted>";
                  if ($tipo == 'doctor') {
                    if ($especialidad2) {
                      echo $especialidad1.' - '.$especialidad2;
                    }
                    else{
                      echo $especialidad1;
                    }
                  }
                  else{
                    echo $tipo;
                  }
                echo "</muted>";
                echo "</p>";
              echo "</div>";
            echo "</div>";
          }
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
  function _print_lista_usuarios($conexion){
    echo "<section id='no-more-tables' class='ml'>";
      echo "<table class='table table-advance table-striped table-condensed cf table-hover'>";
        echo "<thead>";
          echo "<tr>";
            echo "<th><i class='fa fa-bookmark'></i>DNI</th>";
            echo "<th><i class='fa fa-bookmark'></i>Nombres</th>";
            echo "<th><i class='fa fa-bookmark'></i>Apellidos</th>";
            echo "<th><i class='fa fa-bookmark'></i>Rol</th>";
            echo "<th><i class='fa fa-edit'></i>Estado</th>";
            echo "<th><i class='fa fa-edit'></i>Acción</th>";
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $sql = "CALL sp_tausuario_listar_all();";
        if (mysqli_multi_query($conexion,$sql)){
          if ($result=mysqli_store_result($conexion)){
            while ($row=mysqli_fetch_row($result)){
              $DNI = $row[0];
              $Nombres = $row[1];
              $Nombres = utf8_encode($Nombres);
              $Apellidos = $row[2];
              $Apellidos = utf8_encode($Apellidos);
              $Rol = $row[9];
              $Estado = $row[12];
              echo "<tr>";
                echo "<td data-title='DNI'><a href='list-usuario.php?chr_dni_usuario=$DNI'>$DNI</a></td>";
                echo "<td data-title='Nombres'>$Nombres</td>";
                echo "<td data-title='Apellidos'>$Apellidos</td>";
                echo "<td data-title='Rol'>$Rol</td>";
                if ($Estado=='Habilitado') {
                  echo "<td data-title='Estado'><span class='label label-success label-mini'>$Estado</td>";
                }elseif ($Estado=='Deshabilitado'){
                  echo "<td data-title='Estado'><span class='label label-warning label-mini'>$Estado</td>";
                }elseif ($Estado=='En Sesion'){
                  echo "<td data-title='Estado'><span class='label label-info label-mini'>$Estado</td>";
                }
                echo "<td data-title='Accion'><a href='edit.php?chr_dni_usuario=$DNI' role='button' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> Modificar</a></td>";
              echo "</tr>";
            }
            mysqli_free_result($result);
          }
          mysqli_next_result($conexion);
        }
        echo "</tbody>";
      echo "</table>";
    echo "</section>";
  }

  function _reporte_seis_ultimas_atenciones($conexion, $inicio, $fin){
    echo "<div class='custom-bar-chart'>";
    // Sentencia de consulta a la Base de Datos
    $sentencia = "CALL sp_taatencion_cuenta_atenciones_por_fecha('$inicio', '$fin')";
    // Array de los valores de las atenciones de los ultimos días
    $valores = array();
    // Realizar la consulta
    if (mysqli_multi_query($conexion, $sentencia)) {
      // Guardar el resultado de la consulta
      if ($resultado = mysqli_store_result($conexion)) {
        // Extraer una por una las filas
        while ($fila = mysqli_fetch_row($resultado)) {
            // Almacenar el valor del número de atenciones
            $valor = $fila[1];
            // Almacenar el día correspondiente al valor
            $dia = $fila[0];
            // Guardar el valor en el array de valores
            $valores[$dia] = $valor;
        }
        // Liberar el resultado de la consulta
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }

    //Seccion que grafica los valores del eje Y

    if (count($valores) > 0) {
      $maximo = max($valores);
      $temp = $maximo;
      echo "<ul class='y-axis'>";
      for ($i = 0; $i < 5; $i++) {
        echo "<li><span>".$temp."</span></li>";
        $temp -= ($maximo / 5);
      }
        echo "<li><span>0</span></li>";
      echo "</ul>";
      //Fin de la seccion que grafica los valores del eje Y
      //Seccion para generar el gráfico de barras
      $inicio = strtotime($inicio);
      $fin = strtotime($fin);
      while ($inicio <= $fin) {
        echo "<div class='bar'>";
        echo "<div class='title'>".utf8_encode(strftime('%a, %d-%m-%y', $inicio))."</div>";
        echo "<div class='value tooltips' data-original-title='";
        $fecha_temp = date('Y-m-d', $inicio);
        if ($valores[$fecha_temp]) {
          echo $valores[$fecha_temp];
          echo "' data-toggle='tooltip' data-placement='top'>";
          echo (($valores[$fecha_temp] / $maximo) * 100)."%</div>";
        }
        else{
          echo "0";
          echo "' data-toggle='tooltip' data-placement='top'>0%</div>";
        }
        echo "</div>";
        if (date('l', $inicio) == 'Saturday') {
          $inicio = strtotime('+2 day', $inicio);
        }
        else{
          $inicio = strtotime('+1 day', $inicio);
        }
      }
      echo "</div><!--custom chart end-->";
    } else{
      echo "<div class='alert alert-warning'>No hay resultados para mostrar</div>";
    }
  }

  function _print_biologo_recepcionar($conexion) {
    $sentencia = "CALL sp_taatencion_noatendidoL()";
    echo "<section id='no-more-tables' class='ml'>";
      echo "<table class='table table-hover table-striped' id='tabla-examenes-sin-entregar'>";
        echo "<thead>";
          echo "<tr>";
            echo "<th>Nro. Atención</th>";
            echo "<th>Paciente</th>";
            echo "<th>Examen</th>";
            echo "<th>Acción</th>";
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($fila = mysqli_fetch_row($resultado)) {
          echo "<tr>";
          $nro_atencion = $fila[0];
          $nombres = $fila[1];
          $apellidos = $fila[2];
          $nombre_completo = utf8_encode($nombres." ".$apellidos);
          $examen = $fila[3];
          $examen = utf8_encode($examen);
            echo "<td>$nro_atencion</td>";
            echo "<td>$nombre_completo</td>";
            echo "<td class='uppercase'>$examen</td>";
            echo "<td><a href='atender-recepcion-muestra.php?atencion=$nro_atencion' role='button' class='btn btn-xs btn-success'><i class='fa fa-check'></i> Recibir muestra</a></td>";
          echo "</tr>";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
        echo "</tbody>";
      echo "</table>";
    echo "</section>";
  }

  function _print_examenes_sin_resultado($conexion) {
    $sentencia = "CALL sp_taatencion_faltaresultado()";
    echo "<section id='no-more-tables' class='ml'>";
      echo "<table class='table table-striped table-condensed table-hover' id='tabla-ex-sin-res'>";
        echo "<thead>";
          echo "<tr>";
            echo "<th>Fecha de entrega</th>";
            echo "<th>Examen</th>";
            echo "<th>DNI</th>";
            echo "<th>Nombre Completo</th>";
            echo "<th>Acción</th>";
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($fila = mysqli_fetch_array($resultado)) {
          $nroatencion = $fila["int_nro_atencion"];
          $dni = $fila["chr_doc_id"];
          $nombres = $fila["vch_nombres"];
          $apellidos = $fila["vch_apellidos"];
          $nombre = utf8_encode($nombres." ".$apellidos);
          $servicio = $fila["vch_denominacion"];
          $servicio = utf8_encode($servicio);
          $fecha_entrega = $fila["dat_fecha_emuestra"];
          echo "<tr>";
            echo "<td class='black' data-title='Fecha de entrega'>$fecha_entrega</td>";
            echo "<td data-title='Examen' class='uppercase'>$servicio</td>";
            echo "<td data-title='DNI'>$dni</td>";
            echo "<td data-title='Nombre completo'>$nombre</td>";
            echo "<td data-title='Acción'><a role='button' class='btn btn-success btn-xs' href='atender-resultado-examen.php?nroatencion=$nroatencion'><i class='fa fa-check'></i> Atender</a></td>";
          echo "</tr>";
        }
      }
    }
        echo "<tbody>";
      echo "</table>";
    echo "</section>";
  }

  function _print_lista_pacientes($conexion) {
    $titulos = array('DNI','Nombres', 'Apellidos', 'Fecha de nacimiento', 'Teléfono', 'Sexo', 'Fecha de filiación','Acción');
    $sentencia = "CALL sp_tapaciente_listar_todos_pacientes();";
    echo "<section id='no-more-tables'>";
      echo "<table class='table table-striped table-condensed table-hover' id='tabla-lista-pacientes'>";
        echo "<thead>";
          echo "<tr>";
    for ($i=0; $i < 8; $i++) {
      echo "<th>$titulos[$i]</th>";
    }
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($paciente = mysqli_fetch_row($resultado)) {
          echo "<tr>";
          for ($j=0; $j < 7; $j++) {
            echo "<td data-title='$titulos[$j]'>".utf8_encode($paciente[$j])."</td>";
          }
          $id_paciente = $paciente[7];
          echo "<td data-title='Acción'><a href='modificar-paciente.php?idpaciente=$id_paciente' role='button' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> Modificar</a></td>";
          echo "</tr>";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
        echo "<tbody>";
      echo "</table>";
    echo "</section>";
  }

  function _print_lista_servicios($conexion, $tipo) {
    echo "<h4><i class='fa fa-angle-double-right'></i> Servicios <i class='fa fa-minus pull-right' id='toggleServicios'></i></h4>";
    $titulos = array('Tipo','Denominación', 'Descripción', 'Precio', 'Acción');
    $sentencia = "CALL sp_taservicio_listar_todos();";
    echo "<section id='no-more-tables'>";
      echo "<table class='table table-striped table-condensed table-hover' id='tabla-lista-servicios'>";
        echo "<thead>";
          echo "<tr>";
    for ($i=0; $i < 5; $i++) {
      echo "<th>$titulos[$i]</th>";
    }
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($fila = mysqli_fetch_row($resultado)) {
          echo "<tr>";
          for ($j=0; $j < 4; $j++) {
            echo "<td class='uppercase";
            if ($j == 3) {
              echo " right-align";
            }
            echo "' data-title='$titulos[$j]'>".utf8_encode($fila[$j])."</td>";
          }
          $id_servicio = $fila[4];
          if ($tipo == 1) {
            echo "<td data-title='Acción'><a onclick='recuperarServicio($id_servicio)' role='button' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Seleccionar</a></td>";
          } elseif ($tipo == 2) {
            echo "<td data-title='Acción'><a href='modificar-servicio.php?idservicio=$id_servicio' role='button' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> Modificar</a></td>";
          } elseif ($tipo == 3) {
            echo "<td data-title='Acción'><a role='button' class='btn btn-success btn-xs sel' onclick='seleccionar($id_servicio)'><i class='fa fa-check'></i> Seleccionar</a></td>";
          }
          echo "</tr>";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
        echo "<tbody>";
      echo "</table>";
    echo "</section>";
  }
?>