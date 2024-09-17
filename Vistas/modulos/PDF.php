<?php
// Verificación del parámetro 'codigo'
if (isset($_GET["codigo"]) && is_numeric($_GET["codigo"])) {
    $cod_historia_clinica = intval($_GET["codigo"]); // Asegúrate de que sea un entero
} else {
    echo "Código de historia clínica no proporcionado o inválido.";
    exit;
}

// Ajustar la ruta para incluir el controlador
include_once(__DIR__ . "/../../Modelos/PacientesM.php"); // Ajusta la ruta según sea necesario
include_once(__DIR__ . "/../../Controladores/pacientesC.php"); // Ajusta la ruta según sea necesario

// Verificación de rol y código de historia clínica...

// Crear instancia de PacientesC
$controlador = new PacientesC();

// Obtener datos
$datos = $controlador->ObtenerPacienteHistorialC($cod_historia_clinica);

if ($datos) {
    $paciente = $datos['paciente'];
    $historial = $datos['historial'];
    $fecha = date('Y-m-d', strtotime($historial['fecha']));
    $hora = date('H:i:s', strtotime($historial['hora']));
} else {
    echo "No se encontraron datos para el historial clínico proporcionado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión de Historia Clínica</title>
    <link rel="icon" type="image/png" href="/proyectoclinica/Vistas/img/faviconp.png">

    <link rel="stylesheet" href="/proyectoclinica/Vistas/bower_components/bootstrap/dist/css/stylespdf.css">
    <style>
        /* Aquí puedes agregar estilos específicos para la impresión */
        @media print {
            .no-print { display: none; }
        }
    </style>
    <script>
        function imprimir() {
            window.print();
        }
        window.onload = imprimir;
    </script>
</head>
<body>
    <div class="document">
        <!-- Datos Personales -->
        <div class="section" id="datos-personales">
            <h2>Datos Personales</h2>
            <form class="historiaClinicaForm">
                <div class="form-group form-group-inline">
                    <label for="edad">Edad:</label>
                    <input type="text" id="edad" name="edad" value="<?php echo htmlspecialchars($paciente['edad']); ?>" readonly>
                </div>
                <div class="form-group form-group-inline">
                    <label for="sexo">Sexo:</label>
                    <input type="text" id="sexo" name="sexo" value="<?php echo htmlspecialchars($paciente['sexo']); ?>" readonly>
                </div>
                <div class="form-group form-group-inline">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($paciente['fechanacimiento']); ?>" readonly>
                </div>
                <div class="form-group form-group-half">
                    <label for="nombre">Apellidos y nombres:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($paciente['apellido'] . ' ' . $paciente['nombre']); ?>" readonly>
                </div>
                <div class="form-group form-group-half">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>" readonly>
                </div>
                <div class="form-group form-group-half">
                    <label for="domicilio">Domicilio:</label>
                    <input type="text" id="domicilio" name="domicilio" value="<?php echo htmlspecialchars($paciente['domicilio']); ?>" readonly>
                </div>
                <div class="form-group form-group-half">
                    <label for="acompanante">Acompañante:</label>
                    <input type="text" id="acompanante" name="acompanante" value="<?php echo htmlspecialchars($historial['acompanante']); ?>" readonly>
                </div>
                <div class="form-group form-group-half">
                    <label for="parentesco">Parentesco:</label>
                    <input type="text" id="parentesco" name="parentesco" value="<?php echo htmlspecialchars($historial['parentesco']); ?>" readonly>
                </div>
            </form>
        </div>
        
        <!-- Funciones Vitales -->
        <div class="section" id="funciones-vitales">
            <h2>Funciones Vitales</h2>
            <form class="historiaClinicaForm">
                <div class="form-group form-group-third">
                    <label for="fc">FC:</label>
                    <input type="text" id="fc" name="fc" value="<?php echo htmlspecialchars($historial['frecuencia_cardiaca']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="fr">FR:</label>
                    <input type="text" id="fr" name="fr" value="<?php echo htmlspecialchars($historial['frecuencia_ritmica']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="pa">PA:</label>
                    <input type="text" id="pa" name="pa" value="<?php echo htmlspecialchars($historial['presion_arterial']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="t">T°:</label>
                    <input type="text" id="t" name="t" value="<?php echo htmlspecialchars($historial['temperatura']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="peso">Peso:</label>
                    <input type="text" id="peso" name="peso" value="<?php echo htmlspecialchars($historial['peso']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="talla">Talla:</label>
                    <input type="text" id="talla" name="talla" value="<?php echo htmlspecialchars($historial['talla']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="spo2">Saturación (spO2):</label>
                    <input type="text" id="spo2" name="spo2" value="<?php echo htmlspecialchars($historial['saturacion']); ?>" readonly>
                </div>
            </form>
        </div>
        
        <!-- Anamnesis -->
        <div class="section" id="anamnesis">
            <h2>Anamnesis</h2>
            <form class="historiaClinicaForm">
                <div class="form-group form-group-third">
                    <label for="te">T.E:</label>
                    <input type="text" id="te" name="te" value="<?php echo htmlspecialchars($historial['anam_te']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="fi">F.I:</label>
                    <input type="text" id="fi" name="fi" value="<?php echo htmlspecialchars($historial['anam_fi']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="curso">Curso:</label>
                    <input type="text" id="curso" name="curso" value="<?php echo htmlspecialchars($historial['curso']); ?>" readonly>
                </div>
                <div class="form-group form-group-half">
                    <label for="sgs_sintomas">Síntomas principales:</label>
                    <textarea id="sgs_sintomas" name="sgs_sintomas" readonly><?php echo htmlspecialchars($historial['relato']); ?></textarea>
                </div>
                <div class="form-group form-group-half">
                    <label for="relato">Relato:</label>
                    <textarea id="relato" name="relato" readonly><?php echo htmlspecialchars($historial['relato']); ?></textarea>
                </div>
                <div class="form-group form-group-half">
                    <label for="antecedentes">Antecedentes:</label>
                    <textarea id="antecedentes" name="antecedentes" readonly><?php echo htmlspecialchars($historial['antecedentes']); ?></textarea>
                </div>
                <div class="form-group form-group-half">
                    <label for="alergias">Alergias:</label>
                    <textarea id="alergias" name="alergias" readonly><?php echo htmlspecialchars($historial['alergias']); ?></textarea>
                </div>
            </form>
        </div>
        
        <!-- Diagnóstico y Plan -->
        <div class="section" id="diagnostico-plan">
            <h2>Diagnóstico y Plan</h2>
            <form class="historiaClinicaForm">
                <div class="form-group form-group-full">
                    <label for="examen_clinico">Examen Clínico:</label>
                    <textarea id="examen_clinico" name="examen_clinico" readonly><?php echo htmlspecialchars($historial['examen_clinico']); ?></textarea>
                </div>
                <div class="form-group form-group-third">
                    <label for="presuncion_a">A:</label>
                    <input type="text" id="presuncion_a" name="presuncion_a" value="<?php echo htmlspecialchars($historial['presuncion_a']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="presuncion_b">B:</label>
                    <input type="text" id="presuncion_b" name="presuncion_b" value="<?php echo htmlspecialchars($historial['presuncion_b']); ?>" readonly>
                </div>
                <div class="form-group form-group-third">
                    <label for="presuncion_c">C:</label>
                    <input type="text" id="presuncion_c" name="presuncion_c" value="<?php echo htmlspecialchars($historial['presuncion_c']); ?>" readonly>
                </div>
                <div class="form-group form-group-full">
                    <label for="plan">Plan:</label>
                    <textarea id="plan" name="plan" readonly><?php echo htmlspecialchars($historial['plan']); ?></textarea>
                </div>
                <div class="form-group form-group-full">
                    <label for="tratamiento">Tratamiento:</label>
                    <textarea id="tratamiento" name="tratamiento" readonly><?php echo htmlspecialchars($historial['tratamiento']); ?></textarea>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
