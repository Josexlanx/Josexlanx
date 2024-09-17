<?php

if($_SESSION["rol"] != "Doctor"){

	echo '<script>

	window.location = "inicio";
	</script>';

	return;

}

// Verificar si el ID de la sesión coincide con el de la URL y si es un número válido.
if (isset($_GET["url"]) && !empty($_GET["url"])) {
    $urlParts = explode("/", $_GET["url"]);
    $doctorId = $urlParts[1];  // Asumiendo que el ID del doctor es el segundo segmento en la URL
    
    if (is_numeric($doctorId) && $_SESSION["id"] == $doctorId) {
        $columna = "id";
        $valor = $doctorId;
        $resultado = DoctoresC::DoctorC($columna, $valor);

        if ($resultado && isset($resultado["sexo"])) {
            ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <?php
                    if ($resultado["sexo"] == "Femenino") {
                        echo '<h1>Doctora: ' . $resultado["apellido"] . ' ' . $resultado["nombre"] . '</h1>';
                    } else {
                        echo '<h1>Doctor: ' . $resultado["apellido"] . ' ' . $resultado["nombre"] . '</h1>';
                    }

                    $columna = "id";
                    $valor = $resultado["id_consultorio"];
                    $consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);

                    echo '<br>
                    <h1>Consultorio de: ' . $consultorio["nombre"] . '</h1>';
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

            <!-- Modal para crear citas -->
            <div class="modal fade" rol="dialog" id="CitaModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post">
                            <div class="modal-body">
                                <div class="box-body">
                                    <?php
                                    echo '<div class="form-group">
                                            <input type="hidden" name="Did" value="' . $resultado["id"] . '">
                                          </div>';

                                    echo '<div class="form-group">
                                            <input type="hidden" name="Cid" value="' . $consultorio["id"] . '">
                                          </div>';
                                    ?>

                                    <div class="form-group">
                                        <h2>Seleccionar Paciente:</h2>
                                        <?php
                                        $pacientesConCitas = (new PacientesC())->VerPacientesPorDoctorC($resultado["id"]);

                                        echo '<select id="pacienteSelect" class="form-control input-lg" name="nombreP">
                                                <option>Seleccione un paciente...</option>';

                                        foreach ($pacientesConCitas as $paciente) {
                                            echo '<option value="' . $paciente["nombre"] . ' ' . $paciente["apellido"] . '" data-documento="' . $paciente["documento"] . '" data-pid="' . $paciente["id"] . '">' . $paciente["apellido"] . ' ' . $paciente["nombre"] . '</option>';
                                        }

                                        echo '</select>';
                                        ?>
                                    </div>

                                    <!-- Campo oculto para almacenar el Pid -->
                                    <input type="hidden" name="Pid" value="">

                                    <div class="form-group">
                                        <h2>Documento:</h2>
                                        <input type="text" class="form-control input-lg" name="documentoP" value="" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <h2>Fecha:</h2>
                                        <input type="text" class="form-control input-lg" id="fechaC" value="" readonly>
                                    </div>

                                    <div class="form-group">
                                        <h2>Hora:</h2>
                                        <input type="text" class="form-control input-lg" id="horaC" value="" readonly>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control input-lg" name="fyhIC" id="fyhIC" value="" readonly>
                                        <input type="hidden" class="form-control input-lg" name="fyhFC" id="fyhFC" value="" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Programar Cita</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>

                            <?php
                            $enviarC = new CitasC();
                            $enviarC->PedirCitaDoctorC();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo '<p>Error: No se pudo encontrar al doctor o el doctor no tiene definido su género.</p>';
        }
    } else {
        echo '<p>ID de doctor no válido o no coincide con la sesión actual.</p>';
    }
} else {
    echo '<p>No se especificó un ID de doctor en la URL.</p>';
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#pacienteSelect').on('change', function() {
        var documento = $(this).find(':selected').data('documento');
        var pid = $(this).find(':selected').data('pid');
        
        $('input[name="documentoP"]').val(documento);
        $('input[name="Pid"]').val(pid);
    });
});
</script>

