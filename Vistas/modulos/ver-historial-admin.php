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
        $historiales = PacientesM::ObtenerHistorialesM("historia_clinica", $pacienteId);
?>
<div class="content-wrapper">
    <section class="content">
            <div class="box">
                <?php if (count($historiales) > 0): ?>
                    <!-- Si hay historiales clínicos, mostrar esta sección -->
                    <h2>Historial Clínico</h2>
                    <ul>
                        <?php foreach ($historiales as $historial): ?>
                            <li>
                            <a href="/proyectoclinica/ver-historial-detalle/<?php echo $historial['cod_historia_clinica']; ?>" class="btn btn-info"><i class="fa fa-eye"></i> Ver historial <?php echo date("d/m", strtotime($historial['fecha'])); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <!-- Si no hay historiales, mostrar esta sección -->
                    <p>No hay historial clínico de este paciente.</p>
                <?php endif; ?>
                
                <!-- Botón para añadir un nuevo historial -->
                <a href="/proyectoclinica/agregar-historial/<?php echo $pacienteId; ?>" class="btn btn-primary">Añadir</a>

                <!-- Mostrar botón "Volver" a pacientes-doctor solo si el usuario es Doctor -->
                <?php if ($_SESSION["rol"] == "Doctor"): ?>
                    <a href="/proyectoclinica/asignados-admin" class="btn btn-primary">Volver</a>
                <?php else: ?>
                    <!-- Mostrar botón "Volver" a pacientes para todos los roles excepto Doctor -->
                    <a href="/proyectoclinica/pacientes" class="btn btn-primary">Volver</a>
                <?php endif; ?>
            </div>
    </section>
</div>
<?php
    }
}
?>
