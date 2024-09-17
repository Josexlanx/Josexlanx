<?php
if ($_SESSION["rol"] != "Administrador" && $_SESSION["rol"] != "Secretaria") {
    echo '<script>
    window.location = "inicio";
    </script>';
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instancia del controlador para manejar la asignación
    $asignar = new PacientesC();
    $asignar->AsignarPacienteDoctorC(); // Llamar al método para procesar la asignación
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Asignar Pacientes a Doctores</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Doctores</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover DT">
                    <thead>
                        <tr>
                            <th>Nombre del Doctor</th>
                            <th>Especialidad</th>
                            <th>Asignar Pacientes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $columna = null;
                        $valor = null;
                        $resultado = DoctoresC::VerDoctoresC($columna, $valor);

                        foreach ($resultado as $key => $value) {
                            $columna = "id";
                            $valor = $value["id_consultorio"];
                            $consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);
                            echo '<tr>
                                <td>'.$value["nombre"].' '.$value["apellido"].'</td>
                                <td>'.$consultorio["nombre"].'</td>
                                <td>
                                    <form method="post">
                                        <select name="id_paciente" class="miSelect" required>
                                            <option value="">Seleccionar Paciente</option>';
                                            $columna = null;
                                            $valor = null;
                                            $pacientes = PacientesC::VerPacientesNoAsignadosC($value["id"]); // Obtiene pacientes no asignados a este doctor
                                            foreach ($pacientes as $paciente) {
                                                echo '<option value="'.$paciente["id"].'">'.$paciente["nombre"].' '.$paciente["apellido"].'</option>';
                                            }
                            echo '      </select>
                                        <input type="hidden" name="id_doctor" value="'.$value["id"].'">
                                        <button type="submit" class="btn btn-primary">Asignar</button>
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
