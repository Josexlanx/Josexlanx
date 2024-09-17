<?php

if ($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Doctor" && $_SESSION["rol"] != "Administrador") {
    echo '<script>window.location = "inicio";</script>';
    return;
}

if (isset($_GET["url"]) && !empty($_GET["url"])) {
    $urlParts = explode("/", $_GET["url"]);
    $pacienteId = $urlParts[1];

    if (is_numeric($pacienteId)) {
        $columna = "id";
        $valor = $pacienteId;
        
        // Obtener información del paciente
        $pacienteInfo = PacientesC::VerPacientesC($columna, $valor);

        if (!empty($pacienteInfo)) {
            $nombrePaciente = $pacienteInfo[0]["nombre"];
            $apellidoPaciente = $pacienteInfo[0]["apellido"];

            // Obtener historiales clínicos del paciente
            $historiales = PacientesM::ObtenerHistorialesM("historia_clinica", $pacienteId);
            $historialesOdonto = PacientesM::ObtenerHistorialesM("historial_odontologia", $pacienteId); // Obtener historiales odontológicos
        }
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Historiales de: <?php echo $nombrePaciente . " " . $apellidoPaciente; ?></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <h3>Historiales Médicos</h3>
                <table class="table table-bordered table-hover table-striped dt-responsive DT">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Fecha</th>
                            <th>Ver Historial</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historiales)): ?>
                            <?php foreach ($historiales as $key => $historial): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($historial["fecha"])); ?></td>
                                    <td>
                                        <a href="/proyectoclinica/ver-historial-detalle/<?php echo $historial['cod_historia_clinica']; ?>" class="btn btn-info">
                                            <i class="fa fa-eye"></i> Ver Historial Médico
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No hay historial médico de este paciente.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h3>Historiales Odontológicos</h3>
                <table class="table table-bordered table-hover table-striped dt-responsive DT">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Fecha</th>
                            <th>Ver Historial</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historialesOdonto)): ?>
                            <?php foreach ($historialesOdonto as $key => $historialOdonto): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($historialOdonto["fecha"])); ?></td>
                                    <td>
                                        <a href="/proyectoclinica/ver-historial-odontologia/<?php echo $historialOdonto['cod_hist_odontologia']; ?>" class="btn btn-info">
                                            <i class="fa fa-eye"></i> Ver Historial Odontológico
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No hay historial odontológico de este paciente.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <a href="/proyectoclinica/agregar-historial/<?php echo $pacienteId; ?>" class="btn btn-primary">Añadir Historial Médico</a>
                <a href="/proyectoclinica/agregar-historial-odontologia/<?php echo $pacienteId; ?>" class="btn btn-primary">Añadir Historial Odontológico</a>

            </div>
        </div>
    </section>
</div>

<?php
        }
    }

?>
