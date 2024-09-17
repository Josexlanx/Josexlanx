<?php

// Verificación del rol
    if ($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Doctor" && $_SESSION["rol"] != "Administrador") {
        echo '<script>window.location = "inicio";</script>';
        return;
    }

    // Verificación de la URL y extracción del ID del paciente
    if (isset($_GET["url"]) && !empty($_GET["url"])) {
        $urlParts = explode("/", $_GET["url"]);
        if (isset($urlParts[1]) && is_numeric($urlParts[1])) {
            $pacienteId = $urlParts[1];
        } else {
            echo "ID de paciente no proporcionado.";
            exit;
        }
    } else {
        echo "URL no válida.";
        exit;
    }

    // Cargar el controlador para obtener los datos del paciente
    include_once("Controladores/PacientesC.php");
    include_once("Controladores/DoctoresC.php"); // Incluir controlador de doctores
    $controlador = new PacientesC();
    $doctoresControlador = new DoctoresC(); // Crear instancia del controlador de doctores

    $paciente = $controlador->PacienteC("id", $pacienteId);

    if (!$paciente) {
        echo "No se encontraron datos para el paciente proporcionado.";
        exit;
    }

    // Procesar el formulario al enviarlo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controlador->CrearHistorialOdontoC();
    }

?>

<link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/styles.css">

<title>Añadir Historial Clínico</title>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="box">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="text-center flex-grow-1 mb-0">Añadir Historia Dental</h1>
                        <div class="date-time-labels text-right">
                            <span>Fecha: <?php echo date('Y-m-d'); ?></span>
                            <br>
                            <span>Hora: <?php echo date('H:i:s'); ?></span>
                            <br>
                            <b><span>Creador del historial</span></b>
                            <?php if ($_SESSION['rol'] == 'Doctor'): ?>
                                <span>Doctor: <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="historiaClinicaForm" id="historialOdontoForm">
                            <?php if ($_SESSION["rol"] == "Secretaria" || $_SESSION["rol"] == "Administrador"): ?>
                                <div class="form-group">
                                    <label for="doctor">Seleccionar Doctor:</label>
                                    <select class="form-control selecthisto" id="doctor" name="nombre_doctor">
                                        <?php
                                        // Obtener la lista de doctores
                                        $doctores = $doctoresControlador->VerDoctoresC(null, null);
                                        foreach ($doctores as $doctor) {
                                            echo '<option value="' . $doctor['nombre'] . ' ' . $doctor['apellido'] . '">' . $doctor['nombre'] . ' ' . $doctor['apellido'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Datos Personales -->
                            <h3>Datos del Paciente</h3>
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

                            <!-- Sección del Canvas Interactivo -->
                            <h3>Interacción con Diagrama de Dientes</h3>
                            <div class="canva-container">
                                <!-- Iframe de Canva -->
                                <iframe class="canva-iframe" loading="lazy" src="https://www.canva.com/design/DAGQ9I7s73c/5iq2jYOp5xCnC0cBVxdJCA/view?embed" allowfullscreen="allowfullscreen" allow="fullscreen"></iframe>
                                <!-- Canvas superpuesto -->
                                <canvas id="canvas"></canvas>
                            </div>
                            <!-- Datos Adicionales del Historial Clínico -->
                            <h3>Datos Adicionales del Historial Clínico</h3>
                            <div class="form-group">
                                <label for="estado_dientes">Estado de los Dientes:</label>
                                <textarea class="form-control" id="estado_dientes" name="estado_dientes" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="alergias">Alergias:</label>
                                <textarea class="form-control" id="alergias" name="alergias" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="intervenciones">Intervenciones:</label>
                                <textarea class="form-control" id="intervenciones" name="intervenciones" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="observaciones">Observaciones:</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="extension">Extensión:</label>
                                <input type="text" class="form-control" id="extension" name="extension" required>
                            </div>
                            <div class="text-center mt-3">
                                <button id="guardar" class="btn btn-success">Guardar Cambios</button>
                            </div>
                            <!-- Campos adicionales continuarán aquí... -->
                            <input type="hidden" name="id_paciente" value="<?php echo $pacienteId; ?>">
                            <div class="form-group">
                        </form>
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
$(document).ready(function () {
    $('#guardar').click(function (event) {
        event.preventDefault(); // Prevenir el envío estándar del formulario

        // Recopilar datos del formulario
        var formData = new FormData(document.getElementById("historialOdontoForm"));

        // Obtener la imagen del canvas y agregarla al formData
        var canvas = document.getElementById("canvas");
        if (canvas) {
            formData.append('imagen', canvas.toDataURL());
        }

        // Verificar si el rol es 'Doctor' y agregar su nombre automáticamente
        <?php if ($_SESSION['rol'] == 'Doctor'): ?>
            formData.append('nombre_doctor', '<?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>');
        <?php endif; ?>

        // Enviar datos mediante AJAX
        $.ajax({
            url: '/proyectoclinica/Ajax/pacientesA.php', // Corrige la URL aquí
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response);
                window.location.href = "/proyectoclinica/ver-historial/<?php echo $pacienteId; ?>";
            },
            error: function (xhr, status, error) {
                alert("Error al guardar el historial: " + error);
            }
        });
    });
});
</script>

<style>
    .canva-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-top: 100%;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 2px 8px 0 rgba(63, 69, 81, 0.16);
    }

    .canva-iframe {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        border: none;
    }

    #canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        cursor: crosshair;
    }
</style>
