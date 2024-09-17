<?php
if ($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Doctor" && $_SESSION["rol"] != "Administrador") {
    echo '<script>window.location = "inicio";</script>';
    return;
}

if (isset($_GET["url"]) && !empty($_GET["url"])) {
    $urlParts = explode("/", $_GET["url"]);
    $doctorId = $urlParts[1];  // Asumiendo que el ID del doctor es el segundo segmento en la URL
    if (is_numeric($doctorId)) {
        $columna = "id";
        $valor = $doctorId;
        $resultado = DoctoresC::DoctorC($columna, $valor);

        if ($resultado && isset($resultado["sexo"])) {
            ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <?php
                    if ($resultado["sexo"] == "Femenino") {
                        echo '<h1>Doctora: '.$resultado["apellido"].' '.$resultado["nombre"].'</h1>';
                    } else {
                        echo '<h1>Doctor: '.$resultado["apellido"].' '.$resultado["nombre"].'</h1>';
                    }

                    $columna = "id";
                    $valor = $resultado["id_consultorio"];
                    $consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);

                    echo '<br><h1>Consultorio de: '.$consultorio["nombre"].'</h1>';
                    ?>

                    <!-- Botón para ver citas -->
                    <?php
                    echo '<a href="/proyectoclinica/Historial-Citas/'.$doctorId.'/'.$resultado['id_consultorio'].'" class="btn btn-primary" style="color:black;"><p>Ver Citas</p></a>';
                    ?>

                </section>
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Modal para reasignar cita -->
            <div id="modalConfirmarCita" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmar Nueva Cita</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="idCita" id="idCita" value="<?php echo $_SESSION['citaReasignada']['idCita']; ?>">
                                <input type="hidden" name="nuevoDoctorId" id="nuevoDoctorId" value="<?php echo $_SESSION['citaReasignada']['nuevoDoctorId']; ?>">
                                <input type="hidden" name="nuevaFechaHora" id="nuevaFechaHora">
                                <input type="hidden" name="nombrePaciente" id="nombrePaciente" value="<?php echo $_SESSION['citaReasignada']['nombrePaciente']; ?>">
                                <input type="hidden" name="documento" id="documento" value="<?php echo $_SESSION['citaReasignada']['documento']; ?>">

                                <div class="form-group">
                                    <h2>Paciente:</h2>
                                    <input type="text" class="form-control input-lg" value="<?php echo $_SESSION['citaReasignada']['nombrePaciente']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <h2>Documento:</h2>
                                    <input type="text" class="form-control input-lg" value="<?php echo $_SESSION['citaReasignada']['documento']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <h2>Fecha y Hora Anterior:</h2>
                                    <input type="text" class="form-control input-lg" value="<?php echo $_SESSION['citaReasignada']['nuevaFechaHora']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <h2>Fecha y Hora Nueva:</h2>
                                    <input type="text" class="form-control input-lg" id="nuevaFechaHoraConfirmada" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Confirmar Cita</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        selectable: true,
                        select: function(info) {
                            var nuevaFechaHora = info.startStr + 'T' + info.jsEvent.clientY; // Ajusta esta línea según cómo desees manejar la hora
                            $('#nuevaFechaHora').val(nuevaFechaHora);
                            $('#nuevaFechaHoraConfirmada').val(nuevaFechaHora);
                            $('#modalConfirmarCita').modal('show');
                        }
                    });
                    calendar.render();
                });
            </script>

            <?php
        } else {
            echo '<p>Error: No se pudo encontrar al doctor con ID ' . $doctorId . '</p>';
        }
    } else {
        echo '<p>ID de doctor no válido.</p>';
    }
} else {
    echo '<p>No se especificó un ID de doctor en la URL.</p>';
}
?>
