<?php
// Verificar rol del usuario
if ($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Doctor" && $_SESSION["rol"] != "Administrador") {
    $rolUsuario = $_SESSION["rol"];

    echo '<script>window.location = "inicio";</script>';
    return;
}

// Verificar si se ha especificado la URL
if (isset($_GET["url"])) {
    $urlParts = explode("/", $_GET["url"]);
    if (count($urlParts) == 2) { // Cambiado a 2 para recibir solo el ID del doctor
        $doctorId = $urlParts[1];
        
        // Verificar si el ID es numérico
        if (!is_numeric($doctorId)) {
            echo '<p>Error: ID no válido.</p>';
            return;
        }
    } else {
        echo '<p>Error: URL no válida.</p>';
        return;
    }
} else {
    echo '<p>No se especificó una URL.</p>';
    return;
}

// Obtener datos del doctor
$columna = "id";
$valor = $doctorId;
$doctor = DoctoresC::DoctorC($columna, $valor);

// Obtener datos del consultorio
$columna = "id";
$valor = $doctor["id_consultorio"];
$consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Historial de Citas</h1><br>
        <h1>Doctor: <?php echo $doctor["nombre"] . ' ' . $doctor["apellido"]; ?></h1>
        <h1>Consultorio: <?php echo $consultorio["nombre"]; ?></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-hover table-striped DT">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Doctor</th>
                            <th>Consultorio</th>
                            <th>Paciente</th>
                            <th>Documento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = CitasC::VerCitasPorDoctorC($doctorId);

                        foreach ($resultado as $key => $value) {
                            echo '<tr>
                                <td>'.$value["inicio"].'</td>';

                            $columna = "id";
                            $valor = $value["id_doctor"];
                            $doctor = DoctoresC::DoctorC($columna, $valor);
                            echo '<td>'.$doctor["apellido"].' '.$doctor["nombre"].'</td>';

                            $columna = "id";
                            $valor = $value["id_consultorio"];
                            $consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);
                            echo '<td>'.$consultorio["nombre"].'</td>';

                            echo '<td>'.$value["nyaP"].'</td>';
                            echo '<td>'.$value["documento"].'</td>';

                            echo '<td>
								<button class="btn btn-danger EliminarCita" idCita="'.$value["id"].'" ><i class="fa fa-times"></i> Borrar</button>
                                </td>';

                            echo '</tr>';
                        }
                        ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal para reasignar cita -->
<!-- Modal para reasignar cita -->
<div class="modal fade" rol="dialog" id="ReasignarCita">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" rol="form">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <h2>Seleccionar Nuevo Doctor:</h2>
                            <select id="doctorSelect" class="form-control input-lg" name="nuevoDoctorId" required>
                                <!-- Aquí se cargan los doctores disponibles -->
                                <?php
                                $columna = null;
                                $valor = null;
                                $resultado = DoctoresC::VerDoctoresC($columna, $valor);

                                if ($resultado) {
                                    foreach ($resultado as $key => $value) {
                                        echo '<option value="'.$value["id"].'">'.$value["nombre"].' '.$value["apellido"].'</option>';
                                    }
                                } else {
                                    echo '<option>No se encontraron doctores</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <h2>Nueva Fecha y Hora:</h2>
                            <input type="datetime-local" class="form-control input-lg" name="nuevaFechaHora" id="nuevaFechaHora" required>
                        </div>

                        <div class="form-group">
                            <h2>Paciente:</h2>
                            <input type="text" class="form-control input-lg" name="nombrePaciente" id="nombrePaciente" readonly>
                        </div>

                        <div class="form-group">
                            <h2>Fecha y Hora Anterior:</h2>
                            <input type="text" class="form-control input-lg" name="fechaHoraAnterior" id="fechaHoraAnterior" readonly>
                        </div>

                        <input type="hidden" name="idCita" id="idCita">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>

                <?php
                // Código para manejar la reasignación de la cita aquí
                // $reasignar = new CitasC();
                // $reasignar -> ReasignarCitaC();
                ?>
            </form>
        </div>
    </div>
</div>

