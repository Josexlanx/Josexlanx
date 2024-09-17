<?php

require_once "ConexionBD.php";

class PacientesM extends ConexionBD{

    // Crear Pacientes
    static public function CrearPacienteM($tablaBD, $datosC){

        $pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD(apellido, nombre, documento, sexo, fechanacimiento, edad, telefono,domicilio, usuario, clave, rol) VALUES (:apellido, :nombre, :documento, :sexo, :fechanacimiento, :edad, :telefono,:domicilio,:usuario, :clave, :rol)");

        $pdo -> bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo -> bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo -> bindParam(":documento", $datosC["documento"], PDO::PARAM_STR);
        $pdo -> bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
        $pdo -> bindParam(":fechanacimiento", $datosC["fechanacimiento"], PDO::PARAM_STR);
        $pdo -> bindParam(":edad", $datosC["edad"], PDO::PARAM_STR);
        $pdo -> bindParam(":telefono", $datosC["telefono"], PDO::PARAM_STR);
        $pdo -> bindParam(":domicilio", $datosC["domicilio"], PDO::PARAM_STR);
        $pdo -> bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo -> bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
        $pdo -> bindParam(":rol", $datosC["rol"], PDO::PARAM_STR);

        if($pdo -> execute()){
            return true;
        }

        $pdo -> close();
        $pdo = null;

    }

    // Editar Paciente
    static public function PacienteM($tablaBD, $columna, $valor){

        if($columna != null){

            $pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna");

            $pdo -> bindParam(":".$columna, $valor, PDO::PARAM_STR);

            $pdo->execute();

            return $pdo -> fetch();

        }

        $pdo -> close();
        $pdo = null;

    }

    // Ver Pacientes
    static public function VerPacientesM($tablaBD, $columna, $valor){

        if($columna == null){

            $pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD ORDER BY apellido ASC");

            $pdo -> execute();

            return $pdo -> fetchAll();

        }else{

            $pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna ORDER BY apellido ASC");

            $pdo -> bindParam(":".$columna, $valor, PDO::PARAM_STR);

            $pdo -> execute();

            return $pdo -> fetchAll();

        }

        $pdo -> close();
        $pdo = null;

    }

    // Borrar Paciente
    static public function BorrarPacienteM($tablaBD, $id){

        $pdo = ConexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id = :id");

        $pdo -> bindParam(":id", $id, PDO::PARAM_INT);

        if($pdo -> execute()){
            return true;
        }

        $pdo -> close();
        $pdo = null;

    }

    // Actualizar Paciente
    static public function ActualizarPacienteM($tablaBD, $datosC){

        $pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET apellido = :apellido, nombre = :nombre, documento = :documento, sexo = :sexo, fechanacimiento = :fechanacimiento, edad = :edad, telefono = :telefono, domicilio = :domicilio, usuario = :usuario, clave = :clave, rol = :rol WHERE id = :id");

        $pdo -> bindParam(":id", $datosC["id"], PDO::PARAM_INT);
        $pdo -> bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo -> bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo -> bindParam(":documento", $datosC["documento"], PDO::PARAM_STR);
        $pdo -> bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
        $pdo -> bindParam(":fechanacimiento", $datosC["fechanacimiento"], PDO::PARAM_STR);
        $pdo -> bindParam(":edad", $datosC["edad"], PDO::PARAM_STR);
        $pdo -> bindParam(":telefono", $datosC["telefono"], PDO::PARAM_STR);
        $pdo -> bindParam(":domicilio", $datosC["domicilio"], PDO::PARAM_STR);
        $pdo -> bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo -> bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
        $pdo -> bindParam(":rol", $datosC["rol"], PDO::PARAM_STR);

        if($pdo -> execute()){
            return true;
        }

        $pdo -> close();
        $pdo = null;

    }

    // Ingreso de los Pacientes
    static public function IngresarPacienteM($tablaBD, $datosC){

        $pdo = ConexionBD::cBD()->prepare("SELECT usuario, clave, apellido, nombre, documento, sexo, fechanacimiento, edad, telefono,domicilio, foto, rol, id FROM $tablaBD WHERE usuario = :usuario");

        $pdo -> bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);

        $pdo -> execute();

        return $pdo -> fetch();

        $pdo -> close();
        $pdo = null;

    }

    // Ver Perfil del Paciente
    static public function VerPerfilPacienteM($tablaBD, $id){

        $pdo = ConexionBD::cBD()->prepare("SELECT usuario, clave, apellido, nombre, documento, sexo, fechanacimiento, edad, telefono,domicilio, foto, rol, id FROM $tablaBD WHERE id = :id");

        $pdo -> bindParam(":id", $id, PDO::PARAM_INT);

        $pdo -> execute();

        return $pdo -> fetch();

        $pdo -> close();
        $pdo = null;

    }

    // Actualizar perfil del Paciente
    static public function ActualizarPerfilPacienteM($tablaBD, $datosC){

        $pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET usuario = :usuario, clave = :clave, nombre = :nombre, apellido = :apellido, documento = :documento, sexo = :sexo, fechanacimiento = :fechanacimiento, edad = :edad, telefono = :telefono, domicilio = :domicilio, foto = :foto WHERE id = :id");

        $pdo -> bindParam(":id", $datosC["id"], PDO::PARAM_INT);
        $pdo -> bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
        $pdo -> bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
        $pdo -> bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
        $pdo -> bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
        $pdo -> bindParam(":documento", $datosC["documento"], PDO::PARAM_STR);
        $pdo -> bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
        $pdo -> bindParam(":fechanacimiento", $datosC["fechanacimiento"], PDO::PARAM_STR);
        $pdo -> bindParam(":edad", $datosC["edad"], PDO::PARAM_STR);
        $pdo -> bindParam(":telefono", $datosC["telefono"], PDO::PARAM_STR);
        $pdo -> bindParam(":domicilio", $datosC["domicilio"], PDO::PARAM_STR);
        $pdo -> bindParam(":foto", $datosC["foto"], PDO::PARAM_STR);

        if($pdo -> execute()){
            return true;
        }

        $pdo -> close();
        $pdo = null;

    }

    // Obtener los historiales clínicos de un paciente
    static public function ObtenerHistorialesM($tablaBD, $id_paciente) {

        $pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE id_paciente = :id_paciente ORDER BY fecha DESC");

        $pdo -> bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);

        $pdo -> execute();

        return $pdo -> fetchAll();

        $pdo -> close();
        $pdo = null;

    }

    

    // Crear Historial Clínico
    static public function CrearHistorialM($tablaBD, $datosC) {

        $pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD (fecha, hora, id_paciente, acompanante, parentesco, frecuencia_cardiaca, frecuencia_ritmica, presion_arterial, temperatura, peso, talla, saturacion, anam_te, anam_fi, curso, relato, antecedentes, alergias, examen_clinico, presuncion_a, presuncion_b, presuncion_c, plan, tratamiento, nombre_doctor) VALUES (NOW(), NOW(), :id_paciente, :acompanante, :parentesco, :frecuencia_cardiaca, :frecuencia_ritmica, :presion_arterial, :temperatura, :peso, :talla, :saturacion, :anam_te, :anam_fi, :curso, :relato, :antecedentes, :alergias, :examen_clinico, :presuncion_a, :presuncion_b, :presuncion_c, :plan, :tratamiento, :nombre_doctor)");

        $pdo->bindParam(":id_paciente", $datosC["id_paciente"], PDO::PARAM_INT);
        $pdo->bindParam(":acompanante", $datosC["acompanante"], PDO::PARAM_STR);
        $pdo->bindParam(":parentesco", $datosC["parentesco"], PDO::PARAM_STR);
        $pdo->bindParam(":frecuencia_cardiaca", $datosC["frecuencia_cardiaca"], PDO::PARAM_INT);
        $pdo->bindParam(":frecuencia_ritmica", $datosC["frecuencia_ritmica"], PDO::PARAM_STR);
        $pdo->bindParam(":presion_arterial", $datosC["presion_arterial"], PDO::PARAM_STR);
        $pdo->bindParam(":temperatura", $datosC["temperatura"], PDO::PARAM_STR);
        $pdo->bindParam(":peso", $datosC["peso"], PDO::PARAM_STR);
        $pdo->bindParam(":talla", $datosC["talla"], PDO::PARAM_STR);
        $pdo->bindParam(":saturacion", $datosC["saturacion"], PDO::PARAM_STR);
        $pdo->bindParam(":anam_te", $datosC["anam_te"], PDO::PARAM_STR);
        $pdo->bindParam(":anam_fi", $datosC["anam_fi"], PDO::PARAM_STR);
        $pdo->bindParam(":curso", $datosC["curso"], PDO::PARAM_STR);
        $pdo->bindParam(":relato", $datosC["relato"], PDO::PARAM_STR);
        $pdo->bindParam(":antecedentes", $datosC["antecedentes"], PDO::PARAM_STR);
        $pdo->bindParam(":alergias", $datosC["alergias"], PDO::PARAM_STR);
        $pdo->bindParam(":examen_clinico", $datosC["examen_clinico"], PDO::PARAM_STR);
        $pdo->bindParam(":presuncion_a", $datosC["presuncion_a"], PDO::PARAM_STR);
        $pdo->bindParam(":presuncion_b", $datosC["presuncion_b"], PDO::PARAM_STR);
        $pdo->bindParam(":presuncion_c", $datosC["presuncion_c"], PDO::PARAM_STR);
        $pdo->bindParam(":plan", $datosC["plan"], PDO::PARAM_STR);
        $pdo->bindParam(":tratamiento", $datosC["tratamiento"], PDO::PARAM_STR);
        $pdo->bindParam(":nombre_doctor", $datosC["nombre_doctor"], PDO::PARAM_STR);  // Agregar el nombre del doctor


        if ($pdo->execute()) {
            return true;
        } else {
            return false;
        }

        $pdo->close();
        $pdo = null;
    }

    //CrearhistorialOdonto
    public static function CrearHistorialOdontoM($tablaBD, $datosC) {
        $pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD (fecha, hora, id_paciente, estado_dientes, alergias, intervenciones, observaciones, extension, nombre_doctor, imagen) VALUES ( NOW(), NOW(), :id_paciente, :estado_dientes, :alergias, :intervenciones, :observaciones, :extension, :nombre_doctor, :imagen)");
    
        $pdo->bindParam(":id_paciente", $datosC["id_paciente"], PDO::PARAM_INT);
        $pdo->bindParam(":estado_dientes", $datosC["estado_dientes"], PDO::PARAM_STR);
        $pdo->bindParam(":alergias", $datosC["alergias"], PDO::PARAM_STR);
        $pdo->bindParam(":intervenciones", $datosC["intervenciones"], PDO::PARAM_STR);
        $pdo->bindParam(":observaciones", $datosC["observaciones"], PDO::PARAM_STR);
        $pdo->bindParam(":extension", $datosC["extension"], PDO::PARAM_STR);
        $pdo->bindParam(":nombre_doctor", $datosC["nombre_doctor"], PDO::PARAM_STR);
        $pdo->bindParam(":imagen", $datosC["imagen"], PDO::PARAM_LOB); // Usar LOB para almacenar datos binarios grandes
    
        if ($pdo->execute()) {
            return true;
        } else {
            return false;
        }
    
        $pdo->close();
        $pdo = null;
    }

    static public function ObtenerPacienteHistorialM($cod_historia_clinica) {

        // Variable para almacenar el resultado final
        $resultado = false;
    
        // Verificar si el código corresponde a un historial clínico médico
        $pdo = ConexionBD::cBD()->prepare("SELECT * FROM historia_clinica WHERE cod_historia_clinica = :cod_historia_clinica");
        $pdo->bindParam(":cod_historia_clinica", $cod_historia_clinica, PDO::PARAM_INT);
        $pdo->execute();
        $historial = $pdo->fetch(PDO::FETCH_ASSOC);
    
        if ($historial) {
            // Obtener los datos del paciente correspondiente al historial clínico
            $pdo = ConexionBD::cBD()->prepare("SELECT * FROM pacientes WHERE id = :id_paciente");
            $pdo->bindParam(":id_paciente", $historial['id_paciente'], PDO::PARAM_INT);
            $pdo->execute();
            $paciente = $pdo->fetch(PDO::FETCH_ASSOC);
    
            if ($paciente) {
                $resultado = array(
                    "paciente" => $paciente,
                    "historial" => $historial,
                    "tipo" => "medico"  // Indicador de tipo de historial
                );
            }
        } else {
            // Si no es un historial médico, verificar si es un historial odontológico
            $pdo = ConexionBD::cBD()->prepare("SELECT * FROM historia_clinica_odontologica WHERE cod_hist_odontologia = :cod_hist_odontologia");
            $pdo->bindParam(":cod_hist_odontologia", $cod_historia_clinica, PDO::PARAM_INT);
            $pdo->execute();
            $historialOdonto = $pdo->fetch(PDO::FETCH_ASSOC);
    
            if ($historialOdonto) {
                // Obtener los datos del paciente correspondiente al historial odontológico
                $pdo = ConexionBD::cBD()->prepare("SELECT * FROM pacientes WHERE id = :id_paciente");
                $pdo->bindParam(":id_paciente", $historialOdonto['id_paciente'], PDO::PARAM_INT);
                $pdo->execute();
                $paciente = $pdo->fetch(PDO::FETCH_ASSOC);
    
                if ($paciente) {
                    $resultado = array(
                        "paciente" => $paciente,
                        "historial" => $historialOdonto,
                        "tipo" => "odontologico"  // Indicador de tipo de historial
                    );
                }
            }
        }
    
        return $resultado;
    }
    static public function VerPacientesPorDoctorM($tablaCitas, $tablaPacientes, $id_doctor) {
        $pdo = ConexionBD::cBD()->prepare(
            "SELECT p.*, c.inicio AS inicio
            FROM $tablaCitas c
            INNER JOIN $tablaPacientes p ON c.id_paciente = p.id
            WHERE c.id_doctor = :id_doctor
            AND YEARWEEK(c.inicio, 1) >= YEARWEEK(CURDATE(), 1)"
        );
        $pdo->bindParam(":id_doctor", $id_doctor, PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetchAll();
    }
    static public function ActualizarHistorialM($tablaBD, $datosC) {
        $pdo = ConexionBD::cBD()->prepare(
            "UPDATE $tablaBD SET 
            acompanante = :acompanante,
            parentesco = :parentesco,
            frecuencia_cardiaca = :frecuencia_cardiaca,
            frecuencia_ritmica = :frecuencia_ritmica,
            presion_arterial = :presion_arterial,
            temperatura = :temperatura,
            peso = :peso,
            talla = :talla,
            saturacion = :saturacion,
            anam_te = :anam_te,
            anam_fi = :anam_fi,
            curso = :curso,
            relato = :relato,
            antecedentes = :antecedentes,
            alergias = :alergias,
            examen_clinico = :examen_clinico,
            presuncion_a = :presuncion_a,
            presuncion_b = :presuncion_b,
            presuncion_c = :presuncion_c,
            plan = :plan,
            tratamiento = :tratamiento
            WHERE cod_historia_clinica = :cod_historia_clinica"
        );
    
        $pdo->bindParam(":cod_historia_clinica", $datosC["cod_historia_clinica"], PDO::PARAM_INT);
        $pdo->bindParam(":acompanante", $datosC["acompanante"], PDO::PARAM_STR);
        $pdo->bindParam(":parentesco", $datosC["parentesco"], PDO::PARAM_STR);
        $pdo->bindParam(":frecuencia_cardiaca", $datosC["frecuencia_cardiaca"], PDO::PARAM_INT);
        $pdo->bindParam(":frecuencia_ritmica", $datosC["frecuencia_ritmica"], PDO::PARAM_STR);
        $pdo->bindParam(":presion_arterial", $datosC["presion_arterial"], PDO::PARAM_STR);
        $pdo->bindParam(":temperatura", $datosC["temperatura"], PDO::PARAM_STR);
        $pdo->bindParam(":peso", $datosC["peso"], PDO::PARAM_STR);
        $pdo->bindParam(":talla", $datosC["talla"], PDO::PARAM_STR);
        $pdo->bindParam(":saturacion", $datosC["saturacion"], PDO::PARAM_STR);
        $pdo->bindParam(":anam_te", $datosC["anam_te"], PDO::PARAM_STR);
        $pdo->bindParam(":anam_fi", $datosC["anam_fi"], PDO::PARAM_STR);
        $pdo->bindParam(":curso", $datosC["curso"], PDO::PARAM_STR);
        $pdo->bindParam(":relato", $datosC["relato"], PDO::PARAM_STR);
        $pdo->bindParam(":antecedentes", $datosC["antecedentes"], PDO::PARAM_STR);
        $pdo->bindParam(":alergias", $datosC["alergias"], PDO::PARAM_STR);
        $pdo->bindParam(":examen_clinico", $datosC["examen_clinico"], PDO::PARAM_STR);
        $pdo->bindParam(":presuncion_a", $datosC["presuncion_a"], PDO::PARAM_STR);
        $pdo->bindParam(":presuncion_b", $datosC["presuncion_b"], PDO::PARAM_STR);
        $pdo->bindParam(":presuncion_c", $datosC["presuncion_c"], PDO::PARAM_STR);
        $pdo->bindParam(":plan", $datosC["plan"], PDO::PARAM_STR);
        $pdo->bindParam(":tratamiento", $datosC["tratamiento"], PDO::PARAM_STR);
    
        if ($pdo->execute()) {
            return true;
        } else {
            return false;
        }
    
        $pdo->close();
        $pdo = null;
    }
    
    //PROBANDOASIGNACION
    public static function AsignarPacienteDoctorM($tabla, $datos) {
        $pdo = ConexionBD::cBD()->prepare("INSERT INTO $tabla(id_paciente, id_doctor) VALUES (:id_paciente, :id_doctor)");

        $pdo->bindParam(":id_paciente", $datos["id_paciente"], PDO::PARAM_INT);
        $pdo->bindParam(":id_doctor", $datos["id_doctor"], PDO::PARAM_INT);

        if($pdo->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $pdo->close();
        $pdo = null;
    }

    public static function VerPacientesPorDoctorAsignadosM($tabla, $id_doctor) {
        $pdo = ConexionBD::cBD()->prepare("SELECT p.* FROM pacientes p 
                                               JOIN asignacion_pacientes ap ON p.id = ap.id_paciente 
                                               WHERE ap.id_doctor = :id_doctor");

        $pdo->bindParam(":id_doctor", $id_doctor, PDO::PARAM_INT);

        $pdo->execute();

        return $pdo->fetchAll();
    }
    public static function VerPacientesNoAsignadosM($tabla, $id_doctor) {
        $pdo = ConexionBD::cBD()->prepare("SELECT p.* FROM $tabla p 
                                           LEFT JOIN asignacion_pacientes ap 
                                           ON p.id = ap.id_paciente AND ap.id_doctor = :id_doctor 
                                           WHERE ap.id_doctor IS NULL");
    
        $pdo->bindParam(":id_doctor", $id_doctor, PDO::PARAM_INT);
    
        $pdo->execute();
    
        return $pdo->fetchAll();
    }
    public static function EliminarAsignacionPacienteM($tabla, $id_paciente, $id_doctor) {
        $pdo = ConexionBD::cBD()->prepare("DELETE FROM $tabla WHERE id_paciente = :id_paciente AND id_doctor = :id_doctor");
    
        $pdo->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $pdo->bindParam(":id_doctor", $id_doctor, PDO::PARAM_INT);
    
        if($pdo->execute()) {
            return "ok";
        } else {
            return "error";
        }
    
        $pdo->close();
        $pdo = null;
    }

}
