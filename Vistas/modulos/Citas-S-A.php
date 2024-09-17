<?php
if ($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Administrador") {
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
                    echo '<a href="/proyectoclinica/Historial-Citas/'.$doctorId.'" class="btn btn-primary" style="color:black;"><p>Ver Citas</p></a>';
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
                                    if ($resultado && isset($resultado["id"])) {
                                        echo '<div class="form-group">
                                                <input type="hidden" name="Did" value="'.$resultado["id"].'">
                                            </div>';

                                        $columna = "id";
                                        $valor = $resultado["id_consultorio"];
                                        $consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);

                                        echo '<div class="form-group">
                                                <input type="hidden" name="Cid" value="'.$consultorio["id"].'">
                                            </div>';
                                    } else {
                                        echo '<h2>Error: No se pudo encontrar el doctor o consultorio</h2>';
                                    }
                                    ?>

                                    <div class="form-group">
                                        <h2>Seleccionar Paciente:</h2>
                                        <?php
                                        echo '<select id="pacienteSelect" class="form-control input-lg" name="nombreP">
                                            <option>Paciente...</option>';

                                            $columna = null;
                                            $valor = null;
                                            $resultado = PacientesC::VerPacientesC($columna, $valor);

                                            if ($resultado) {
                                                foreach ($resultado as $key => $value) {
                                                    echo '<option value="'.$value["nombre"].' '.$value["apellido"].'" data-documento="'.$value["documento"].'" data-pid="'.$value["id"].'">'.$value["apellido"].' '.$value["nombre"].'</option>';
                                                }
                                            } else {
                                                echo '<option>No se encontraron pacientes</option>';
                                            }
                                        ?>
                                        </select>
                                    </div>
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
                                <button type="submit" class="btn btn-primary">Pedir Cita</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>

                            <?php
                            $enviarC = new CitasC();
                            $enviarC -> PedirCitaSecretariaC();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
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
