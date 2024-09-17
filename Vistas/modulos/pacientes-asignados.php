<?php
if ($_SESSION["rol"] != "Doctor") {
    echo '<script>window.location = "inicio";</script>';
    return;
}

// Obtener los pacientes asignados por el administrador para este doctor
$id_doctor = $_SESSION["id"];
$pacientesAsignados = PacientesC::VerPacientesAsignadosPorAdminC($id_doctor);

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Pacientes Asignados por el Administrador</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Documento</th>
                            <th>Teléfono</th>
                            <th>Domicilio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pacientesAsignados as $paciente) {
                            echo '<tr>
                                <td>'.$paciente["nombre"].'</td>
                                <td>'.$paciente["apellido"].'</td>
                                <td>'.$paciente["documento"].'</td>
                                <td>'.$paciente["telefono"].'</td>
                                <td>'.$paciente["domicilio"].'</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
