<?php

date_default_timezone_set('America/Lima');

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
    $controlador->CrearHistorialC();
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
                        <h1 class="text-center flex-grow-1 mb-0">Añadir Historial Clínico</h1>
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
                        <form method="POST" class="historiaClinicaForm">
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

                            <!-- Datos del Historial Clínico -->
                            <h3>Datos del Historial Clínico</h3>
                            <input type="hidden" name="id_paciente" value="<?php echo $pacienteId; ?>">
                            <div class="form-group">
                                <label for="acompanante">Acompañante:</label>
                                <input type="text" class="form-control" id="acompanante" name="acompanante" required>
                            </div>
                            <div class="form-group">
                                <label for="parentesco">Parentesco:</label>
                                <input type="text" class="form-control" id="parentesco" name="parentesco" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="fc">Frecuencia Cardiaca:</label>
                                    <input type="text" class="form-control" id="fc" name="frecuencia_cardiaca" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fr">Frecuencia Ritmica:</label>
                                    <input type="text" class="form-control" id="fr" name="frecuencia_ritmica" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="pa">Presión Arterial:</label>
                                    <input type="text" class="form-control" id="pa" name="presion_arterial" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="t">Temperatura:</label>
                                    <input type="text" class="form-control" id="t" name="temperatura" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="peso">Peso:</label>
                                    <input type="text" class="form-control" id="peso" name="peso" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="talla">Talla:</label>
                                    <input type="text" class="form-control" id="talla" name="talla" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="spo2">Saturación (spO2):</label>
                                <input type="text" class="form-control" id="spo2" name="saturacion" required>
                            </div>
                            <div class="form-group">
                                <label for="te">T.E:</label>
                                <input type="text" class="form-control" id="te" name="anam_te" required>
                            </div>
                            <div class="form-group">
                                <label for="fi">F.I:</label>
                                <input type="text" class="form-control" id="fi" name="anam_fi" required>
                            </div>
                            <div class="form-group">
                                <label for="curso">Curso:</label>
                                <input type="text" class="form-control" id="curso" name="curso" required>
                            </div>
                            <div class="form-group">
                                <label for="relato">Relato:</label>
                                <textarea class="form-control" id="relato" name="relato" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="antecedentes">Antecedentes:</label>
                                <textarea class="form-control" id="antecedentes" name="antecedentes" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="alergias">Alergias:</label>
                                <textarea class="form-control" id="alergias" name="alergias" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="examen_clinico">Examen Clínico:</label>
                                <textarea class="form-control" id="examen_clinico" name="examen_clinico" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="presuncion_a">Presunción A:</label>
                                    <input type="text" class="form-control" id="presuncion_a" name="presuncion_a" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="presuncion_b">Presunción B:</label>
                                    <input type="text" class="form-control" id="presuncion_b" name="presuncion_b" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="presuncion_c">Presunción C:</label>
                                    <input type="text" class="form-control" id="presuncion_c" name="presuncion_c" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="plan">Plan:</label>
                                <textarea class="form-control" id="plan" name="plan" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tratamiento">Tratamiento:</label>
                                <textarea class="form-control" id="tratamiento" name="tratamiento" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Guardar Historial</button>
                                <a href="/proyectoclinica/ver-historial/<?php echo $pacienteId; ?>" class="btn btn-secondary">Volver Atrás</a>
                            </div>
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
<style >
    select.form-control {
        height: 45px; /* Ajusta la altura */
        border: 1px solid #ced4da; /* Color del borde */
        border-radius: 4px; /* Bordes redondeados */
        padding: 6px 12px; /* Espaciado interno */
        font-size: 16px; /* Tamaño de fuente */
        background-color: #fff; /* Fondo blanco */
        appearance: none; /* Eliminar la apariencia predeterminada en algunos navegadores */
    }
</style>
