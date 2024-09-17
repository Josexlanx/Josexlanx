<?php
if ($_SESSION["rol"] != "Administrador" && $_SESSION["rol"] != "Secretaria") {
    echo '<script>
    window.location = "inicio";
    </script>';
    return;
}

$resultado = null; // Inicializar variable para almacenar resultados

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $tipoBusqueda = $_POST['tipo_busqueda'];
    $valorBusqueda = $_POST['valor_busqueda'];

    // Definir el endpoint de la API basado en el tipo de búsqueda
    if ($tipoBusqueda == "dni") {
        $url = "https://seeker-api-v1.onrender.com/consultar/dni?dni=" . urlencode($valorBusqueda);
    } else {
        $url = "https://seeker-api-v1.onrender.com/consultar/numero?num=" . urlencode($valorBusqueda);
    }

    // Hacer la solicitud GET a la API
    $response = file_get_contents($url);

    if ($response) {
        $resultado = json_decode($response, true); // Decodificar respuesta JSON a un array
    } else {
        echo "<p>Error al obtener los datos de la API.</p>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Buscar Información</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Buscar por DNI o Número de Teléfono</h3>
            </div>
            <div class="box-body">
                <!-- Formulario de búsqueda -->
                <form method="post">
                    <div class="form-group">
                        <label for="tipo_busqueda">Tipo de Búsqueda:</label>
                        <select name="tipo_busqueda" class="form-control" required>
                            <option value="dni">DNI</option>
                            <option value="numero">Número de Teléfono</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="valor_busqueda">Ingrese el DNI o Número:</label>
                        <input type="text" name="valor_busqueda" class="form-control" required>
                    </div>
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </form>

                <!-- Mostrar resultados de la búsqueda -->
                <?php if ($resultado && $resultado['Status']): ?>
                    <h3>Resultados:</h3>
                    <?php
                    // Extraer información del array de resultados
                    $datosPersona = $resultado['SeekerData']['datosPersona']['data'] ?? [];
                    $telefonos = $resultado['SeekerData']['Telefonos']['data'] ?? [];
                    $trabajos = $resultado['SeekerData']['Trabajos']['data'] ?? [];

                    // Mostrar información personal
                    if ($datosPersona): ?>
                        <p><strong>Nombre Completo:</strong> <?php echo htmlspecialchars($datosPersona['nombreCompleto']); ?></p>
                        <p><strong>DNI:</strong> <?php echo htmlspecialchars($datosPersona['nuDni']); ?></p>
                        <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($datosPersona['fechaNacimiento']); ?></p>
                        <p><strong>Edad:</strong> <?php echo htmlspecialchars($datosPersona['edad']); ?></p>
                        <p><strong>Sexo:</strong> <?php echo htmlspecialchars($datosPersona['sexo']); ?></p>
                        <p><strong>Padre:</strong> <?php echo htmlspecialchars($datosPersona['padre']); ?></p>
                        <p><strong>Madre:</strong> <?php echo htmlspecialchars($datosPersona['madre']); ?></p>
                        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($datosPersona['ubicacion']); ?></p>
                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($datosPersona['direccion']); ?></p>
                        <p><strong>Ubigeo de Nacimiento:</strong> <?php echo htmlspecialchars($datosPersona['ubigeoNacimiento']); ?></p>
                    <?php endif; ?>

                    <!-- Mostrar información de teléfonos -->
                    <?php if (!empty($telefonos)): ?>
                        <h4>Teléfonos:</h4>
                        <?php foreach ($telefonos as $telefono): ?>
                            <p><strong>Número:</strong> <?php echo htmlspecialchars($telefono['telefono']); ?></p>
                            <p><strong>Operador:</strong> <?php echo htmlspecialchars($telefono['operador']); ?></p>
                            <p><strong>Período:</strong> <?php echo htmlspecialchars($telefono['periodo']); ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Mostrar información de trabajos -->
                    <?php if (!empty($trabajos)): ?>
                        <h4>Trabajos:</h4>
                        <?php foreach ($trabajos as $trabajo): ?>
                            <p><strong>Empresa:</strong> <?php echo htmlspecialchars($trabajo['nomEmpresa']); ?></p>
                            <p><strong>RUC:</strong> <?php echo htmlspecialchars($trabajo['ruc']); ?></p>
                            <p><strong>Sueldo:</strong> <?php echo htmlspecialchars($trabajo['sueldo']); ?></p>
                            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($trabajo['fecha']); ?></p>
                            <hr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <p>No se encontraron resultados o hubo un error en la búsqueda.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
