<?php
require_once "ConexionBD.php";
class CitasM extends ConexionBD{
	//Pedir Cita Paciente
	static public function EnviarCitaM($tablaBD, $datosC){
		$pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD (id_doctor, id_consultorio, id_paciente, nyaP, documento, inicio, fin) VALUES (:id_doctor, :id_consultorio, :id_paciente, :nyaP, :documento, :inicio, :fin)");
		$pdo -> bindParam(":id_doctor", $datosC["Did"], PDO::PARAM_INT);
		$pdo -> bindParam(":id_consultorio", $datosC["Cid"], PDO::PARAM_INT);
		$pdo -> bindParam(":id_paciente", $datosC["Pid"], PDO::PARAM_INT);
		$pdo -> bindParam(":nyaP", $datosC["nyaC"], PDO::PARAM_STR);
		$pdo -> bindParam(":documento", $datosC["documentoC"], PDO::PARAM_STR);
		$pdo -> bindParam(":inicio", $datosC["fyhIC"], PDO::PARAM_STR);
		$pdo -> bindParam(":fin", $datosC["fyhFC"], PDO::PARAM_STR);
		if($pdo->execute()){
			return true;
		}
		$pdo -> close();
		$pdo = null;
	}
	//Mostrar Citas
	static public function VerCitasM($tablaBD){
		$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD");
		$pdo -> execute();
		return $pdo -> fetchAll();
		$pdo -> close();
		$pdo = null;
	}
	//Pedir cita como doctor
	static public function PedirCitaDoctorM($tablaBD, $datosC){
		$pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD (id_doctor, id_consultorio,id_paciente, nyaP, documento, inicio, fin) VALUES (:id_doctor, :id_consultorio,:id_paciente,:nyaP, :documento, :inicio, :fin)");
		$pdo -> bindParam(":id_doctor", $datosC["Did"], PDO::PARAM_INT);
		$pdo -> bindParam(":id_consultorio", $datosC["Cid"], PDO::PARAM_INT);
		$pdo -> bindParam(":id_paciente", $datosC["Pid"], PDO::PARAM_INT);
		$pdo -> bindParam(":nyaP", $datosC["nombreP"], PDO::PARAM_STR);
		$pdo -> bindParam(":documento", $datosC["documentoP"], PDO::PARAM_STR);
		$pdo -> bindParam(":inicio", $datosC["fyhIC"], PDO::PARAM_STR);
		$pdo -> bindParam(":fin", $datosC["fyhFC"], PDO::PARAM_STR);
		if($pdo->execute()){
			return true;
		}
		$pdo -> close();
		$pdo = null;
	}
	//Pedir cita secretaria
    static public function PedirCitaSecretariaM($tablaBD, $datosC) {
        $pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD (id_doctor, id_consultorio, id_paciente, nyaP, documento, inicio, fin) VALUES (:id_doctor, :id_consultorio, :id_paciente, :nyaP, :documento, :inicio, :fin)");
        $pdo->bindParam(":id_doctor", $datosC["Did"], PDO::PARAM_INT);
        $pdo->bindParam(":id_consultorio", $datosC["Cid"], PDO::PARAM_INT);
        $pdo->bindParam(":id_paciente", $datosC["Pid"], PDO::PARAM_INT);
        $pdo->bindParam(":nyaP", $datosC["nombreP"], PDO::PARAM_STR);
        $pdo->bindParam(":documento", $datosC["documentoP"], PDO::PARAM_STR);
        $pdo->bindParam(":inicio", $datosC["fyhIC"], PDO::PARAM_STR);
        $pdo->bindParam(":fin", $datosC["fyhFC"], PDO::PARAM_STR);
        if ($pdo->execute()) {
            return true;
        }
        $pdo->close();
        $pdo = null;
    }
    static public function EliminarCitaM($tablaBD, $id) {
        $pdo = ConexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id = :id");
        $pdo->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($pdo->execute()) {
            return true;
        } else {
            return false;
        }
    
        $pdo->close();
        $pdo = null;
    }
    static public function VerCitasPorDoctorM($tablaBD, $doctorId) {
        $pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE id_doctor = :id_doctor");
        $pdo->bindParam(":id_doctor", $doctorId, PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetchAll();
        $pdo->close();
        $pdo = null;
    }
    static public function ReasignarCitaM($tablaBD, $datosC) {
        // Obtener detalles de la cita original
        $pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE id = :idCita");
        $pdo->bindParam(":idCita", $datosC["idCita"], PDO::PARAM_INT);
        $pdo->execute();
        $citaOriginal = $pdo->fetch();

        if ($citaOriginal) {
            // Eliminar cita original
            $pdo = ConexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id = :idCita");
            $pdo->bindParam(":idCita", $datosC["idCita"], PDO::PARAM_INT);
            $pdo->execute();

            // Crear nueva cita con los datos originales y la nueva fecha/hora y doctor
            $pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD (id_doctor, id_consultorio, id_paciente, nyaP, documento, inicio, fin) VALUES (:id_doctor, :id_consultorio, :id_paciente, :nyaP, :documento, :inicio, :fin)");
            $pdo->bindParam(":id_doctor", $datosC["nuevoDoctorId"], PDO::PARAM_INT);
            $pdo->bindParam(":id_consultorio", $citaOriginal["id_consultorio"], PDO::PARAM_INT);
            $pdo->bindParam(":id_paciente", $citaOriginal["id_paciente"], PDO::PARAM_INT);
            $pdo->bindParam(":nyaP", $citaOriginal["nyaP"], PDO::PARAM_STR);
            $pdo->bindParam(":documento", $citaOriginal["documento"], PDO::PARAM_STR);
            $pdo->bindParam(":inicio", $datosC["nuevaFechaHora"], PDO::PARAM_STR);
            $pdo->bindParam(":fin", $datosC["nuevaFechaHora"], PDO::PARAM_STR); // Suponiendo que la cita dura una hora por defecto

            if ($pdo->execute()) {
                return true;
            }
        }
        return false;
    }
	static public function ObtenerCitaPorIdM($tablaBD, $idCita) {
		$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE id = :idCita");
		$pdo -> bindParam(":idCita", $idCita, PDO::PARAM_INT);
		$pdo -> execute();
		return $pdo -> fetch();
	}
}