<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <?php
            $inicio = new InicioC();
            $inicio->MostrarInicioC();

            if ($_SESSION["rol"] == "Administrador") {
                $rolUsuario = $_SESSION["rol"];
                echo '
                <div class="box-footer">
                    <a href="inicio-editar">
                        <button class="btn btn-success btn-lg">Editar</button>
                    </a>
                </div>';
                
                // Contenido de prueba de 30 días, solo visible para el administrador
                echo '
                <div class="modal fade" id="modalFechaEstablecida" tabindex="-1" role="dialog" aria-labelledby="modalFechaEstablecidaLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalFechaEstablecidaLabel">Fecha de Prueba Ya Establecida</h5>
                    </div>
                    <div class="modal-body">
                      <p>La fecha de inicio del período de prueba ya está establecida. Puede continuar utilizando el sistema.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" onclick="cerrarModalFechaEstablecida()">Aceptar</button>
                    </div>    
                  </div>
                </div>
              </div>
                
                <!-- Modal de activación (no cerrable inicialmente) -->
                <div class="modal fade" id="modalActivacion" tabindex="-1" role="dialog" aria-labelledby="modalActivacionLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalActivacionLabel">Activación del Sistema</h5>
                            </div>
                            <div class="modal-body">
                                <p>Esta es una prueba de 30 días, active el producto una vez y utilícelo para siempre.</p>
                                <input type="password" id="claveActivacion" class="form-control" placeholder="Ingrese su clave de activación">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="continuarPrueba()">Seguir con prueba de 30 días</button>
                                <button type="button" class="btn btn-primary" onclick="activarSistema()">Activar</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </section>
</div>


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
function activarSistema() {
    var clave = document.getElementById('claveActivacion').value || document.getElementById('claveActivacionBloqueo').value;
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
                $('#modalActivacion').modal('hide');
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

function continuarPrueba() {
    fetch('Ajax/verificaractivacion.php', { 
        method: 'POST', 
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
        body: 'accion=iniciar_prueba' 
    })
    .then(response => response.text())
    .then(data => {
        console.log('Respuesta cruda del servidor (iniciar prueba):', data);
        try {
            let jsonData = JSON.parse(data);
            if (jsonData.exito) {
                $('#modalActivacion').modal('hide'); // Cierra el modal de activación

            } else {
                alert(jsonData.mensaje || 'No se pudo iniciar el período de prueba.');
                $('#modalActivacion').modal('hide'); // Cierra el modal de activación si la fecha ya está establecida

            }
        } catch (error) {
            console.error('Error al analizar JSON:', error);
        }
    })
    .catch(error => console.error('Error al procesar JSON:', error));
}

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
            if (jsonData.activado === false) {
                if (jsonData.diasRestantes > 0) {
                    $('#modalActivacion').modal('show');
                } else if (jsonData.diasRestantes === 0) {
                    $('#modalBloqueo').modal('show');
                    cerrarSesion();
                } else {
                    // Periodo de prueba expirado, cerrar sesión
                    
                }
            } else {
                // El sistema está activado, continuar normalmente
            }
        } catch (error) {
            console.error('Error al analizar JSON:', error);
        }
    })
    .catch(error => console.error('Error al procesar JSON:', error));
};

// Función para cerrar la sesión
function cerrarSesion() {
    fetch('Ajax/cerrar_sesion.php', { // Endpoint para cerrar la sesión
        method: 'POST'
    })
    .then(response => response.text())
    .then(data => {
        console.log('Respuesta del servidor al cerrar sesión:', data);
        // Redirigir al usuario a la página de inicio de sesión u otra página adecuada
        window.location.href = 'seleccionar';
    })
    .catch(error => console.error('Error al intentar cerrar sesión:', error));
}

function cerrarModalFechaEstablecida() {
    $('#modalFechaEstablecida').modal('hide');
}
</script>

<!-- Carga de jQuery y Bootstrap -->

