<?php
if($_SESSION["rol"] == "Doctor") {
    $id_doctor = $_SESSION["id"];
    // Asegúrate de que el método que estás llamando existe en el controlador
    $pacientes = PacientesC::VerPacientesPorDoctorAsignadosC($id_doctor);
} else {
    // Otras lógicas para otros roles, si es necesario
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Verifica los datos recibidos
    $eliminarAsignacion = new PacientesC();
    $eliminarAsignacion->EliminarAsignacionPacienteC();
}
?>
<div class="content-wrapper">
    
    <section class="content-header">
        <h1>Mis Pacientes</h1>
    </section>

    <section class="content">
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Lista de Pacientes Asignados</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-hover DT">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Documento</th>
                            <th>Teléfono</th>
                            <th>Domicilio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pacientes as $paciente) {
                            echo '<tr>
                                <td>'.$paciente["nombre"].'</td>
                                <td>'.$paciente["apellido"].'</td>
                                <td>'.$paciente["documento"].'</td>
                                <td>'.$paciente["telefono"].'</td>
                                <td>'.$paciente["domicilio"].'</td>
                                <td>
                                    <a href="ver-historial/'.$paciente["id"].'" class="btn btn-info"><i class="fa fa-eye"></i> Ver historial</a>
                                    <form method="post" style="display:inline;" onsubmit="return confirmarEliminacion();">
                                        <input type="hidden" name="id_paciente" value="'.$paciente["id"].'">
                                        <input type="hidden" name="id_doctor" value="'.$id_doctor.'">
                                        <button type="submit" name="eliminar_asignacion" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar Asignación</button>
                                    </form>
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>