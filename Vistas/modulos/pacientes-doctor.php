<?php
if($_SESSION["rol"] == "Doctor") {
    $id_doctor = $_SESSION["id"];
    $pacientes = (new PacientesC())->VerPacientesPorDoctorC($id_doctor); // Llamada al método del controlador
} else {
    // Otras lógicas para otros roles, si es necesario
}
?>
<div class="content-wrapper">
    
    <section class="content-header">
        
        <h1>Gestor de Pacientes</h1>

    </section>

    <section class="content">
        
        <div class="box">
        
            <div class="box-body">
                <table class="table table-bordered table-hover DT">
                    <thead>
                        <tr>
                            <th>Fecha de Cita</th>  <!-- Añadir esta línea -->
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Documento</th>
                            <th>Sexo</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Edad</th>
                            <th>Teléfono</th>
                            <th>Domicilio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pacientesMostrados = array(); // Array para almacenar los IDs de pacientes mostrados
                        
                        foreach ($pacientes as $value) {
                            // Verificar si el paciente ya fue mostrado
                            if (!in_array($value["id"], $pacientesMostrados)) {
                                // Mostrar la fila del paciente
                                echo '<tr>
                                    <td>'.$value["inicio"].'</td>
                                    <td>'.$value["nombre"].'</td>
                                    <td>'.$value["apellido"].'</td>
                                    <td>'.$value["usuario"].'</td>
                                    <td>'.$value["documento"].'</td>
                                    <td>'.$value["sexo"].'</td>
                                    <td>'.$value["fechanacimiento"].'</td>
                                    <td>'.$value["edad"].'</td>
                                    <td>'.$value["telefono"].'</td>
                                    <td>'.$value["domicilio"].'</td>
                                    <td>
                                        <a href="ver-historial/'.$value["id"].'" class="btn btn-info" ><i class="fa fa-eye"></i> Ver historial</a>
                                    </td>
                                </tr>';
                                
                                // Agregar el ID del paciente al array
                                $pacientesMostrados[] = $value["id"];
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div style="display:none;">
                    <?php
                    foreach ($pacientesMostrados as $paciente_id) {
                        echo '<input type="hidden" name="id_paciente[]" value="'.$paciente_id.'">';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
