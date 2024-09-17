<?php

// Verificación del rol
if ($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Doctor" && $_SESSION["rol"] != "Administrador") {
    echo '<script>window.location = "inicio";</script>';
    return;
}

// Verificación de la URL y extracción del código de historia clínica
if (isset($_GET["url"]) && !empty($_GET["url"])) {
    $urlParts = explode("/", $_GET["url"]);
    if (isset($urlParts[1]) && is_numeric($urlParts[1])) {
        $cod_historia_clinica = $urlParts[1];
    } else {
        echo "Código de historia clínica no proporcionado.";
        exit;
    }
} else {
    echo "URL no válida.";
    exit;
}

// Cargar el controlador y obtener los datos del historial clínico
include_once("Controladores/PacientesC.php");
$controlador = new PacientesC();

$datos = $controlador->ObtenerPacienteHistorialC($cod_historia_clinica);

if ($datos) {
    $paciente = $datos['paciente'];
    $historial = $datos['historial'];
    $fecha = date('Y-m-d', strtotime($historial['fecha']));
    $hora = date('H:i:s', strtotime($historial['hora']));
    $doctor = $historial['nombre_doctor']; // Asegurar que se toma del historial, no de la sesión
} else {
    echo "No se encontraron datos para el historial clínico proporcionado.";
    exit;
}
?>
    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/styles.css">

<div class="content-wrapper">
    <section class="content-header">
		
		<h1>Detalles del Historial</h1>
	</section>
    <section class="content" >
        <div class="container-fluid">
            <div class="box">
                <div class="box-body">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="text-center">Historia Clínica</h1>
                            <div class="date-time-labels">
                                <span>Fecha: <?php echo $fecha; ?></span>
                                <span>Hora: <?php echo $hora; ?></span>
                                <span>Doctor: <?php echo htmlspecialchars($doctor); ?></span> <!-- Mostrar el nombre del doctor del historial -->
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="datos-personales-tab" data-toggle="tab" href="#datos-personales" role="tab" aria-controls="datos-personales" aria-selected="true">Datos Personales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="funciones-vitales-tab" data-toggle="tab" href="#funciones-vitales" role="tab" aria-controls="funciones-vitales" aria-selected="false"> Funciones Vitales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="anamnesis-tab" data-toggle="tab" href="#anamnesis" role="tab" aria-controls="anamnesis" aria-selected="false"> Anamnesis</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="diagnostico-plan-tab" data-toggle="tab" href="#diagnostico-plan" role="tab" aria-controls="diagnostico-plan" aria-selected="false"> Diagnóstico y Plan</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <!-- Datos Personales -->
                                <div class="tab-pane fade show active" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab">
                                    <form class="historiaClinicaForm" id="formDatosPersonales">
                                        <div class="form-group">
                                            <label for="nombre">Apellidos y nombres:</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $paciente['apellido'] . ' ' . $paciente['nombre']; ?>" readonly>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="edad">Edad:</label>
                                                <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $paciente['edad']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="sexo">Sexo:</label>
                                                <input type="text" class="form-control" id="sexo" name="sexo" value="<?php echo $paciente['sexo']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $paciente['fechanacimiento']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">Teléfono:</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $paciente['telefono']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="domicilio">Domicilio:</label>
                                            <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo $paciente['domicilio']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="acompanante">Acompañante:</label>
                                            <input type="text" class="form-control" id="acompanante" name="acompanante" value="<?php echo $historial['acompanante']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="parentesco">Parentesco:</label>
                                            <input type="text" class="form-control" id="parentesco" name="parentesco" value="<?php echo $historial['parentesco']; ?>" readonly>
                                        </div>
                                    </form>
                                </div>
                                <!-- Funciones Vitales -->
                                <div class="tab-pane fade" id="funciones-vitales" role="tabpanel" aria-labelledby="funciones-vitales-tab">
                                    <form class="historiaClinicaForm">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="fc">Frecuencia Cardiaca:</label>
                                                <input type="text" class="form-control" id="fc" name="fc" value="<?php echo $historial['frecuencia_cardiaca']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="fr">Frecuencia Ritmica:</label>
                                                <input type="text" class="form-control" id="fr" name="fr" value="<?php echo $historial['frecuencia_ritmica']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="pa">Presión Arterial:</label>
                                                <input type="text" class="form-control" id="pa" name="pa" value="<?php echo $historial['presion_arterial']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="t">Temperatura:</label>
                                                <input type="text" class="form-control" id="t" name="t" value="<?php echo $historial['temperatura']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="peso">Peso:</label>
                                                <input type="text" class="form-control" id="peso" name="peso" value="<?php echo $historial['peso']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="talla">Talla:</label>
                                                <input type="text" class="form-control" id="talla" name="talla" value="<?php echo $historial['talla']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="spo2">Saturación (spO2):</label>
                                            <input type="text" class="form-control" id="spo2" name="spo2" value="<?php echo $historial['saturacion']; ?>" readonly>
                                        </div>
                                    </form>
                                </div>
                                <!-- Anamnesis -->
                                <div class="tab-pane fade" id="anamnesis" role="tabpanel" aria-labelledby="anamnesis-tab">
                                    <form class="historiaClinicaForm">
                                        <div class="form-group">
                                            <label>Enfermedad Actual:</label>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="te">T.E:</label>
                                                <input type="text" class="form-control" id="te" name="te" value="<?php echo $historial['anam_te']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="fi">F.I:</label>
                                                <input type="text" class="form-control" id="fi" name="fi" value="<?php echo $historial['anam_fi']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="curso">Curso:</label>
                                                <input type="text" class="form-control" id="curso" name="curso" value="<?php echo $historial['curso']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="relato">Relato:</label>
                                            <textarea class="form-control" id="relato" name="relato" readonly><?php echo $historial['relato']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="antecedentes">Antecedentes:</label>
                                            <textarea class="form-control" id="antecedentes" name="antecedentes" readonly><?php echo $historial['antecedentes']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="alergias">Alergias:</label>
                                            <textarea class="form-control" id="alergias" name="alergias" readonly><?php echo $historial['alergias']; ?></textarea>
                                        </div>
                                    </form>
                                </div>
                                <!-- Diagnóstico y Plan -->
                                <div class="tab-pane fade" id="diagnostico-plan" role="tabpanel" aria-labelledby="diagnostico-plan-tab">
                                    <form class="historiaClinicaForm">
                                        <div class="form-group">
                                            <label for="examen_clinico">Examen Clínico:</label>
                                            <textarea class="form-control" id="examen_clinico" name="examen_clinico" readonly><?php echo $historial['examen_clinico']; ?></textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="presuncion_a">A:</label>
                                                <input type="text" class="form-control" id="presuncion_a" name="presuncion_a" value="<?php echo $historial['presuncion_a']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="presuncion_b">B:</label>
                                                <input type="text" class="form-control" id="presuncion_b" name="presuncion_b" value="<?php echo $historial['presuncion_b']; ?>" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="presuncion_c">C:</label>
                                                <input type="text" class="form-control" id="presuncion_c" name="presuncion_c" value="<?php echo $historial['presuncion_c']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="plan">Plan:</label>
                                            <textarea class="form-control" id="plan" name="plan" readonly><?php echo $historial['plan']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="tratamiento">Tratamiento:</label>
                                            <textarea class="form-control" id="tratamiento" target="_blank" name="tratamiento" readonly><?php echo $historial['tratamiento']; ?></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                            <a href="/proyectoclinica/ver-historial/<?php echo $paciente['id']; ?>" class="btn btn-secondary">Volver Atrás</a>
                            <a href="/proyectoclinica/Vistas/modulos/PDF.php?codigo=<?php echo $cod_historia_clinica; ?>" class="btn btn-primary" target="_blank">Imprimir</a>
                            <button id="guardarHistorial" class="btn btn-success">Editar</button> <!-- Botón Editar/Guardar -->
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Estado de edición (false por defecto)
        let editMode = false;
        let originalValues = {};

        // Al hacer clic en el botón Editar/Guardar
        $('#guardarHistorial').click(function(e) {
            e.preventDefault(); // Prevenir el envío estándar del formulario

            // Alternar el modo de edición
            if (!editMode) {
                // Entrar en modo edición
                editMode = true;
                $(this).text('Guardar');

                // Añadir botón de cancelar al lado de "Guardar"
                if (!$('#cancelarEdicion').length) {
                    $(this).after('<button id="cancelarEdicion" class="btn btn-danger ml-2">Cancelar</button>');
                }

                // Guardar los valores originales antes de editar
                $('#datos-personales input, #datos-personales textarea, #funciones-vitales input, #funciones-vitales textarea, #anamnesis input, #anamnesis textarea, #diagnostico-plan input, #diagnostico-plan textarea').each(function() {
                    let id = $(this).attr('id');
                    originalValues[id] = $(this).val(); // Guardar el valor original en el objeto originalValues
                });

                // Habilitar los campos que se pueden editar
                $('#datos-personales input, #datos-personales textarea').each(function() {
                    // Habilitar desde "acompanante" hacia abajo
                    if ($(this).attr('id') === 'acompanante' || $(this).attr('id') === 'parentesco') {
                        $(this).prop('readonly', false);
                    }
                });

                // Habilitar los campos fuera de "Datos Personales"
                $('#funciones-vitales input, #funciones-vitales textarea, #anamnesis input, #anamnesis textarea, #diagnostico-plan input, #diagnostico-plan textarea').prop('readonly', false);

            } else {
                // Mostrar confirmación antes de guardar los cambios
                let confirmacion = confirm("¿Estás seguro de que deseas guardar los cambios?");
                
                if (confirmacion) {
                    $(this).text('Editar');

                    // Recopilar los datos del formulario
                    var datos = {
                        cod_historia_clinica: <?php echo $historial['cod_historia_clinica']; ?>, // Asegúrate de que esta variable esté definida en tu PHP
                        acompanante: $('#acompanante').val(),
                        parentesco: $('#parentesco').val(),
                        frecuencia_cardiaca: $('#fc').val(),
                        frecuencia_ritmica: $('#fr').val(),
                        presion_arterial: $('#pa').val(),
                        temperatura: $('#t').val(),
                        peso: $('#peso').val(),
                        talla: $('#talla').val(),
                        saturacion: $('#spo2').val(),
                        anam_te: $('#te').val(),
                        anam_fi: $('#fi').val(),
                        curso: $('#curso').val(),
                        relato: $('#relato').val(),
                        antecedentes: $('#antecedentes').val(),
                        alergias: $('#alergias').val(),
                        examen_clinico: $('#examen_clinico').val(),
                        presuncion_a: $('#presuncion_a').val(),
                        presuncion_b: $('#presuncion_b').val(),
                        presuncion_c: $('#presuncion_c').val(),
                        plan: $('#plan').val(),
                        tratamiento: $('#tratamiento').val()
                    };

                    // Enviar los datos usando AJAX solo cuando se guarda
                    $.ajax({
                        type: 'POST',
                        url: '/proyectoclinica/ajax/historialA.php',  // Asegúrate de que la ruta sea correcta
                        data: datos,
                        success: function(response) {
                            alert("Historial actualizado correctamente");
                            // Recargar la página para reflejar los cambios
                            window.location.reload();
                        },
                        error: function() {
                            alert("Error al actualizar el historial");
                        }
                    });

                    // Deshabilitar los campos nuevamente
                    $('#datos-personales input, #datos-personales textarea').each(function() {
                        if ($(this).attr('id') === 'acompanante' || $(this).attr('id') === 'parentesco') {
                            $(this).prop('readonly', true);
                        }
                    });

                    $('#funciones-vitales input, #funciones-vitales textarea, #anamnesis input, #anamnesis textarea, #diagnostico-plan input, #diagnostico-plan textarea').prop('readonly', true);

                    // Eliminar el botón cancelar después de guardar
                    $('#cancelarEdicion').remove();
                }
            }
        });

        // Funcionalidad del botón Cancelar
        $(document).on('click', '#cancelarEdicion', function(e) {
            e.preventDefault();

            // Restaurar los valores originales y deshabilitar los campos
            $('#datos-personales input, #datos-personales textarea, #funciones-vitales input, #funciones-vitales textarea, #anamnesis input, #anamnesis textarea, #diagnostico-plan input, #diagnostico-plan textarea').each(function() {
                let id = $(this).attr('id');
                if (originalValues.hasOwnProperty(id)) {
                    $(this).val(originalValues[id]); // Restaurar el valor original
                }
                $(this).prop('readonly', true); // Volver a deshabilitar el campo
            });

            // Volver al estado original del botón "Guardar" y eliminar el botón "Cancelar"
            $('#guardarHistorial').text('Editar');
            $('#cancelarEdicion').remove();
            editMode = false;
        });
    });
</script>

