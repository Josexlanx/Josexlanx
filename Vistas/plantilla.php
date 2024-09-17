  <?php
  session_start();
  
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Clínica Médica</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
    $favicon = new InicioC();
    $favicon -> FaviconC();
    ?>
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/stylepopup.css">
    <link rel="icon" type="image/png" href="/proyectoclinica/Vistas/img/faviconp.png">
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/styleshis.css">
      <!-- select2 -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/select2/dist/css/select2.min.css">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- PDF -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/dist/css/AdminLTE.min.css">
      

    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/dist/css/skins/_all-skins.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- FullCalendar -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>

  <body class="hold-transition skin-blue sidebar-mini login-page">
  <!-- Site wrapper -->
    <?php
    if(isset($_SESSION["Ingresar"]) && $_SESSION["Ingresar"] == true){
      echo '<div class="wrapper">';
      include "modulos/cabecera.php";
      if($_SESSION["rol"] == "Secretaria"){
        include "modulos/menuSecretaria.php";
      }else if($_SESSION["rol"] == "Paciente"){
        include "modulos/menuPaciente.php";
      }else if($_SESSION["rol"] == "Doctor"){
        include "modulos/menuDoctor.php";
      }else if($_SESSION["rol"] == "Administrador"){
        include "modulos/menuAdmin.php";
      }
      $url = array();
      if(isset($_GET["url"])){
        $url = explode("/", $_GET["url"]);
        if($url[0] == "inicio" || $url[0] == "salir" || $url[0] == "perfil-Secretaria" || $url[0] == "perfil-S" || $url[0] == "consultorios" || $url[0] == "E-C" || $url[0] == "doctores" || $url[0] == "pacientes" || $url[0] == "perfil-Paciente" || $url[0] == "perfil-P" || $url[0] == "Ver-consultorios" || $url[0] == "Doctor" || $url[0] == "historial" || $url[0] == "perfil-Doctor" || $url[0] == "perfil-D" || $url[0] == "Citas" || $url[0] == "perfil-Administrador" || $url[0] == "perfil-A" || $url[0] == "secretarias" || $url[0] == "inicio-editar" || $url[0] == "Ver-consultorio-S-A" || $url[0] == "Citas2" || $url[0] == "Citas-S-A" || $url[0] == "ver-historial" || $url[0] == "ver-historial-detalle" || $url[0] == "agregar-historial" || $url[0] == "Historial-Citas" || $url[0] == "pacientes-doctor" || $url[0] == "panel-control" || $url[0] == "asignados-admin" || $url[0] == "ver-historial-admin" || $url[0] == "agregar-historial-odontologia" || $url[0] == "sekeer"){
          include "modulos/".$url[0].".php";
        }
      }else{
          include "modulos/inicio.php";
      }
        echo '</div>';
      }else if(isset($_GET["url"])){
        if($_GET["url"] == "seleccionar"){
          include "modulos/seleccionar.php";
        }else if($_GET["url"] == "ingreso-Secretaria"){
          include "modulos/ingreso-Secretaria.php";
        }else if($_GET["url"] == "ingreso-Paciente"){
          include "modulos/ingreso-Paciente.php";
        }else if($_GET["url"] == "ingreso-Doctor"){
          include "modulos/ingreso-Doctor.php";
        }else if($_GET["url"] == "ingreso-Administrador"){
          include "modulos/ingreso-Administrador.php";
        }
      }else {
        include "modulos/seleccionar.php";
      }
    ?>
  <!-- jQuery 3 -->
  <script src="/proyectoclinica/Vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- ./select -->
  <script src="/proyectoclinica/Vistas/bower_components/select2/dist/js/select2.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="/proyectoclinica/Vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="/proyectoclinica/Vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="/proyectoclinica/Vistas/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="/proyectoclinica/Vistas/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/proyectoclinica/Vistas/dist/js/demo.js"></script>
  <!-- DataTables -->
  <script src="/proyectoclinica/Vistas/bower_components/datatables.net/js/jquery.dataTables.js"></script>
  <script src="/proyectoclinica/Vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="/proyectoclinica/Vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="/proyectoclinica/Vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <!-- fullCalendar -->
  <script src="/proyectoclinica/Vistas/bower_components/moment/moment.js"></script>
  <script src="/proyectoclinica/Vistas/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="/proyectoclinica/Vistas/bower_components/fullcalendar/dist/locale/es.js"></script>
  <script src="/proyectoclinica/Vistas/js/doctores.js"></script>
  <script src="/proyectoclinica/Vistas/js/pacientes.js"></script>
  <script src="/proyectoclinica/Vistas/js/secretarias.js"></script>
  <script src="/proyectoclinica/Vistas/js/citas.js"></script>
  <script src="/proyectoclinica/Vistas/js/validaciones.js"></script>

  <script>
  $(document).ready(function () {
      $('.sidebar-menu').tree()
  });

  var date = new Date();
  var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

  $('#calendar').fullCalendar({
      hiddenDays: [0, 6],
      defaultView: 'agendaWeek',
      events: [
          <?php
          $resultado = CitasC::VerCitasC();
          foreach ($resultado as $key => $value) {
              $doctorId = isset($_GET["url"]) ? explode("/", $_GET["url"])[1] : null;
              if ($_SESSION["rol"] == "Paciente" && $value["id_doctor"] == $doctorId) {
                  echo '{
                      id: ' . $value["id"] . ',
                      title: "' . $value["nyaP"] . '",
                      start: "' . $resultado["horarioE"] . '",
                      end: "' . $resultado["horarioS"] . '"
                  },';
              } else if ($_SESSION["rol"] == "Doctor" && $value["id_doctor"] == $doctorId) {
                  echo '{
                      id: ' . $value["id"] . ',
                      title: "' . $value["nyaP"] . '",
                      start: "' . $value["inicio"] . '",
                      end: "' . $value["fin"] . '"
                  },';
              } else if ($_SESSION["rol"] == "Secretaria" && $value["id_doctor"] == $doctorId) {
                  echo '{
                      id: ' . $value["id"] . ',
                      title: "' . $value["nyaP"] . '",
                      start: "' . $value["inicio"] . '",
                      end: "' . $value["fin"] . '"
                  },';
              } else if ($_SESSION["rol"] == "Administrador" && $value["id_doctor"] == $doctorId) {
                echo '{
                    id: ' . $value["id"] . ',
                    title: "' . $value["nyaP"] . '",
                    start: "' . $value["inicio"] . '",
                    end: "' . $value["fin"] . '"
                },';
            }
          }
          ?>
      ],
      <?php
      if ($_SESSION["rol"] == "Paciente" || $_SESSION["rol"] == "Doctor") {
          $columna = "id";
          $valor = $doctorId;  // Usar el doctorId extraído de la URL
          $resultado = DoctoresC::DoctorC($columna, $valor);
          echo 'scrollTime: "' . $resultado["horarioE"] . '",
                  minTime: "' . $resultado["horarioE"] . '",
                  maxTime: "' . $resultado["horarioS"] . '",';
      } else if ($_SESSION["rol"] == "Secretaria" || $_SESSION["rol"] == "Administrador") {
          $columna = "id";
          $valor = $doctorId;  // Usar el doctorId extraído de la URL
          $resultado = DoctoresC::DoctorC($columna, $valor);
          echo 'scrollTime: "' . $resultado["horarioE"] . '",
                  minTime: "' . $resultado["horarioE"] . '",
                  maxTime: "' . $resultado["horarioS"] . '",';
      }
      ?>
          dayClick:function(date,jsEvent,view){
            $('#CitaModal').modal();
            var fecha = date.format();
            fecha = fecha.split("T");
            var dia = fecha[0];
            var hora = (fecha[1].split(":"));
            var h1 = parseFloat(hora[0]);
            var m1 = parseFloat(hora[1]);
            
            // Calculamos la hora y los minutos de finalización
            var m2 = m1 + 30;
            if (m2 >= 60) {
                h1 += 1;
                m2 -= 60;
            }
            
            // Formateamos los minutos con dos dígitos
            var minFinal = m2 < 10 ? "0" + m2 : m2;

            $('#fechaC').val(dia);
            $('#horaC').val(hora[0] + ":" + hora[1] + ":00");
            $('#fyhIC').val(fecha[0] + " " + hora[0] + ":" + hora[1] + ":00");
            $('#fyhFC').val(fecha[0] + " " + h1 + ":" + minFinal + ":00");
          }
      })
  </script>
  <script>
    $(document).ready(function() {
        // Mostrar el tab "Datos Personales" por defecto
        $('#datos-personales-tab').tab('show');

        // Escuchar el clic en "Diagnóstico y Plan"
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const passwordField = document.getElementById('clave-Ing');
    const togglePassword = document.getElementById('togglePassword');

    if (!passwordField || !togglePassword) return;

    const showPasswordIcon = 'glyphicon-eye-open';
    const hidePasswordIcon = 'glyphicon-eye-close';

    togglePassword.addEventListener('click', () => {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            togglePassword.querySelector('span').classList.remove(showPasswordIcon);
            togglePassword.querySelector('span').classList.add(hidePasswordIcon);
        } else {
            passwordField.type = 'password';
            togglePassword.querySelector('span').classList.remove(hidePasswordIcon);
            togglePassword.querySelector('span').classList.add(showPasswordIcon);
        }
    });
});
</script>
<script>
  //select asignacion
    $(document).ready(function() {
        $('.miSelect').select2({
            placeholder: "Seleccionar Paciente",
            allowClear: true,
            width: 'resolve' // Hace que el select ocupe el ancho adecuado
        });
    });
</script>
<script>
  //select Citas-S-A
  $(document).ready(function() {
      $('#pacienteSelect').select2({
          placeholder: "Seleccionar Paciente",
          allowClear: true,
          width: '100%' // Asegura que el select ocupe el ancho completo del contenedor
          
      });
  });
</script>

<?php
$rolUsuario = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null; // Asigna null si no hay rol definido

if (!empty($rolUsuario)) : // Verifica si $rolUsuario no está vacío
?>
<!-- Botón flotante para abrir el popup -->
<!-- Botón flotante para abrir el popup -->
<button id="botonFlotante" class="btn-flotante boton-animado" onclick="mostrarPopup()">
  <i class="fa fa-book"></i>
</button>

<!-- Pop-up -->
<div id="popup" class="popup" data-role="<?php echo $rolUsuario; ?>">
  <div id="popup-contenido" class="popup-contenido">
    <span class="cerrar" onclick="cerrarPopup()">&times;</span>
    
    <h2>Manual de Usuario</h2>
    
    <!-- Páginas del manual -->
    <div id="manualContenido">
      <div class="pagina" id="pagina1" data-visible-roles="Administrador">
        <h3>Menú Secretaria</h3>
        <p>En el menú "Secretaria", puedes gestionar todas las secretarias de la clínica, permitiendo su creación, edición y eliminación.</p>
        <ul>
          <li><strong>Crear Secretaria:</strong> Añade un nuevo registro para una secretaria, ingresando datos como nombre, usuario y contraseña.</li>
          <li><strong>Editar Secretaria:</strong> Modifica la información existente de una secretaria, incluyendo su rol y detalles de contacto.</li>
          <li><strong>Borrar Secretaria:</strong> Elimina el registro de una secretaria que ya no trabaja en la clínica.</li>
          <li><strong>Simbolo ➕ :</strong>Expande las opciones disponibles extras si la pantalla es muy pequeña</li>
        </ul>
      </div>

      <div class="pagina" id="pagina2" data-visible-roles="Administrador,Secretaria">
        <h3>Menú Consultorios</h3>
        <p>El menú "Consultorios" permite administrar los espacios físicos de la clínica. Puedes crear, editar o eliminar consultorios según las necesidades.</p>
        <ul>
          <li><strong>Crear Consultorio:</strong> Añade un nuevo consultorio a la lista, especificando su nombre y ubicación.</li>
          <li><strong>Editar Consultorio:</strong> Modifica los detalles de un consultorio existente, como su nombre o estado de disponibilidad.</li>
          <li><strong>Borrar Consultorio:</strong> Elimina un consultorio que ya no esté disponible o en uso.</li>
        </ul>
      </div>

      <div class="pagina" id="pagina3" data-visible-roles="Secretaria,Administrador">
        <h3>Panel de Control</h3>
        <p>El "Panel de Control" es la herramienta central de gestión. Permite asignar pacientes a doctores y revisar su historial médico de manera eficiente.</p>
        <ul>
          <li><strong>Asignar Pacientes:</strong> Asigna un paciente a un doctor específico para asegurar un seguimiento continuo de su tratamiento.</li>
          <li><strong>Seleccionar Paciente:</strong> Selecciona el paciente a asignar al doctor por medio de una lista o buscandolo por el buscador.</li>
        </ul>
      </div>

      <div class="pagina" id="pagina4" data-visible-roles="Secretaria,Administrador">
        <h3>Menú Doctores</h3>
        <p>Desde el menú "Doctores", puedes manejar toda la información relacionada con los doctores de la clínica.</p>
        <ul>
          <li><strong>Crear Doctor:</strong> Añade un nuevo doctor, especificando detalles como nombre, especialidad, usuario y contraseña.</li>
          <li><strong>Editar Doctor:</strong> Modifica la información de un doctor, incluyendo su especialidad, consultorio asignado, y datos de contacto.</li>
          <li><strong>Borrar Doctor:</strong> Elimina el registro de un doctor que ya no forma parte del equipo.</li>
        </ul>
      </div>

      <div class="pagina" id="pagina5" data-visible-roles="Doctor,Administrador,Secretaria">
        <h3>Menú Pacientes</h3>
        <p>El menú "Pacientes" permite gestionar toda la información de los pacientes, asegurando un control eficiente de sus datos y citas médicas.</p>
        <ul>
          <li><strong>Crear paciente:</strong> Añade un nuevo paciente al sistema, incluyendo sus datos personales básicos.</li>
          <li><strong>Editar Paciente:</strong> Actualiza la información de un paciente, como su dirección, contacto, o historial médico.</li>
          <li><strong>Borrar Paciente:</strong> Elimina el registro de un paciente que ya no forma parte de la clinica  </li>
          <li><strong>Ver Historial Médico:</strong> Accede al historial completo del paciente para revisar diagnósticos, tratamientos y resultados previos.</li>
        </ul>
      </div>

      <div class="pagina" id="pagina6" data-visible-roles="Administrador,Secretaria">
        <h3>Menú Citas</h3>
        <p>El menú "Citas" permite gestionar toda la información de las citas de los diferentes doctores.</p>
        <ul>
          <li><strong>Seleccionar Doctor:</strong>Se detallan los diferentes consultorios con sus respectivos doctores para seleccionar el doctor que se sacara la cita.</li>
          <li><strong>Ver Citas: </strong> Se detallan las citas de el doctor y se pueden borrar las citas programadas</li>
          <li><strong>Calendario: </strong> Se selecciona en el calendario la hora que se desea para sacar la cita.</li>
        </ul>
      </div>
      <div class="pagina" id="pagina7" data-visible-roles="Doctor">
        <h3>Menú Citas Doctor</h3>
        <p>El menú "Citas" permite gestionar toda la información de las citas de los diferentes pacientes</p>
        <ul>
          <li><strong>Calendario: </strong> Se selecciona en el calendario la hora y el paciente que se desea para sacar la cita.</li>
        </ul>
      </div>
      <div class="pagina" id="pagina8" data-visible-roles="Doctor">
        <h3>Menú Paciente Admin</h3>
        <p>El menú "Paciente Admin" permite gestionar toda la información de las pacientes que han sido asignados a un doctor por medio del administrador.</p>
        <ul>
        <li><strong>Ver Historial Médico:</strong> Accede al historial completo del paciente para revisar diagnósticos, tratamientos y resultados previos.</li>
        <li><strong>Eliminar Asignacion:</strong> Elimina la asignacion de un paciente echa por el administrador.</li>
        </ul>
      </div>
    </div>
    
    
    
    <!-- Paginación -->
    <div class="paginacion">
      <button onclick="cambiarPagina(-1)" class="boton-paginacion">&laquo; Anterior</button>
      <span id="numeroPagina">1</span> / <span id="totalPaginas">8</span>
      <button onclick="cambiarPagina(1)" class="boton-paginacion">Siguiente &raquo;</button>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Script para el Popup y la Paginación -->
<script>
  let paginaActual = 1;

  function mostrarPopup() {
    document.getElementById('popup').style.display = 'block';

    const rolUsuario = document.getElementById('popup').getAttribute('data-role');
    const paginas = document.querySelectorAll('.pagina');

    let totalPaginas = 0;

    // Filtrar las páginas por rol y contar las visibles
    paginas.forEach((pagina) => {
      const rolesVisibles = pagina.getAttribute('data-visible-roles').split(',');
      if (rolesVisibles.includes(rolUsuario)) {
        pagina.classList.add('visible');
        totalPaginas++;
      } else {
        pagina.classList.remove('visible');
      }
    });

    actualizarPaginacion(totalPaginas);
  }

  function cerrarPopup() {
    document.getElementById('popup').style.display = 'none';
  }

  function actualizarPaginacion(totalPaginas) {
    if (totalPaginas === 0) {
      document.getElementById('totalPaginas').textContent = '0';
      document.getElementById('numeroPagina').textContent = '0';
      return;
    }

    document.getElementById('totalPaginas').textContent = totalPaginas;
    paginaActual = 1;
    mostrarPagina(paginaActual, totalPaginas);
  }

  function cambiarPagina(n) {
    const paginas = document.querySelectorAll('.pagina.visible');
    mostrarPagina(paginaActual += n, paginas.length);
  }

  function mostrarPagina(n, totalPaginas) {
    const paginas = document.querySelectorAll('.pagina.visible');

    if (n > totalPaginas) paginaActual = totalPaginas;
    if (n < 1) paginaActual = 1;

    paginas.forEach((pagina, index) => {
      pagina.style.display = (index + 1 === paginaActual) ? 'block' : 'none';
    });

    document.getElementById('numeroPagina').textContent = paginaActual;

    document.querySelector('.boton-paginacion[onclick="cambiarPagina(-1)"]').disabled = (paginaActual === 1);
    document.querySelector('.boton-paginacion[onclick="cambiarPagina(1)"]').disabled = (paginaActual === totalPaginas);
  }

  // Inicialización de la animación del botón
  function activarReboteBoton() {
    const boton = document.getElementById('botonFlotante');
    if (boton) {
      boton.classList.add('boton-animado');
      setTimeout(() => {
        boton.classList.remove('boton-animado');
      }, 1000);
    }
  }

  setInterval(activarReboteBoton, 5000);
</script>
</body>
</html>
