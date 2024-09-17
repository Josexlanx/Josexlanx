<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Ingreso</title>
    <!-- Incluye Bootstrap y jQuery para el modal -->
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/stylepopup.css">
    <script src="/proyectoclinica/Vistas/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/proyectoclinica/Vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>

<section class="content">
  <center>
    <h1><i>Seleccione como desea Ingresar al Sistema</i></h1><br>
  </center>

  <!-- Container for centering the boxes -->
  <div class="row" style="display: flex; justify-content: center; align-items: center;">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box" style="background-color: #F781D8; color: white;">
        <div class="inner">
          <h3>Secretaria</h3>
          <p>Inicie Sesión</p>
        </div>
        <div class="icon">
          <i class="fa fa-female"></i>
        </div>
        <a href="ingreso-Secretaria" class="small-box-footer">Ingresar <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box" style="background-color: #67badb; color: white;">
        <div class="inner">
          <h3>Doctor</h3>
          <p>Inicie Sesión</p>
        </div>
        <div class="icon">
          <i class="fa fa-user-md"></i>
        </div>
        <a href="ingreso-Doctor" class="small-box-footer">Ingresar <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>Administrador</h3>
          <p>Inicie Sesión</p>
        </div>
        <div class="icon">
          <i class="fa fa-male"></i>
        </div>
        <a href="ingreso-Administrador" class="small-box-footer">Ingresar <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- Modal de Bloqueo (no cerrable) -->
<div class="modal fade" id="modalBloqueo" tabindex="-1" role="dialog" aria-labelledby="modalBloqueoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBloqueoLabel">El período de prueba ha expirado</h5>
      </div>
      <div class="modal-body">
        <p>Su período de prueba de 30 días ha expirado. Por favor, ingrese su clave de activación para continuar.</p>
        <input type="password" id="claveActivacionBloqueo" class="form-control" placeholder="Ingrese su clave de activación">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="activarSistema()">Activar</button>
      </div>
    </div>
  </div>
</div>

<script>
// Función para activar el sistema
function activarSistema() {
    var clave = document.getElementById('claveActivacionBloqueo').value;
    var datos = new FormData();
    datos.append("clave", clave);

    fetch('Ajax/activar.php', { 
        method: 'POST',
        body: datos
    })
    .then(response => response.text())
    .then(data => {
        console.log('Respuesta cruda del servidor:', data);
        try {
            let jsonData = JSON.parse(data);
            if (jsonData.estado === 'activado') {
                alert('Sistema activado con éxito.');
                $('#modalBloqueo').modal('hide'); 
            } else {
                alert('Clave incorrecta. Por favor, intente de nuevo.');
            }
        } catch (error) {
            console.error('Error al analizar JSON:', error);
        }
    })
    .catch(error => console.error('Error al procesar JSON:', error));
}

// Verificar el estado de activación al cargar la página
window.onload = function() {
    fetch('Ajax/verificaractivacion.php', { 
        method: 'POST', 
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
        body: 'accion=verificar' 
    })
    .then(response => response.text()) 
    .then(data => {
        console.log('Respuesta cruda del servidor (verificar):', data); 
        try {
            let jsonData = JSON.parse(data); 
            if (jsonData.activado === false && jsonData.diasRestantes <= 0) {
                $('#modalBloqueo').modal('show'); // Mostrar el modal de bloqueo si la prueba ha expirado
            }
        } catch (error) {
            console.error('Error al analizar JSON:', error);
        }
    })
    .catch(error => console.error('Error al procesar JSON:', error));
};
</script>

</body>
</html>
