<?php

require_once "ConexionBD.php";

class InicioM extends ConexionBD{

	static public function MostrarInicioM($tablaBD, $id){

		$pdo = ConexionBD::cBD()->prepare("SELECT id, intro, horaE, horaS, direccion, telefono, correo, logo, favicon FROM $tablaBD WHERE id = :id");

		$pdo -> bindParam(":id", $id, PDO::PARAM_INT);

		$pdo -> execute();

		return $pdo-> fetch();

		$pdo->close();
		$pdo = null;

	}


	static public function ActualizarInicioM($tablaBD, $datosC){

		$pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET intro = :intro, direccion = :direccion, horaE = :horaE, horaS = :horaS, telefono = :telefono, correo = :correo, logo = :logo, favicon = :favicon WHERE id = :id");

		$pdo -> bindParam(":id", $datosC["id"], PDO::PARAM_INT);
		$pdo -> bindParam(":intro", $datosC["intro"], PDO::PARAM_STR);
		$pdo -> bindParam(":direccion", $datosC["direccion"], PDO::PARAM_STR);
		$pdo -> bindParam(":horaE", $datosC["horaE"], PDO::PARAM_STR);
		$pdo -> bindParam(":horaS", $datosC["horaS"], PDO::PARAM_STR);
		$pdo -> bindParam(":telefono", $datosC["telefono"], PDO::PARAM_STR);
		$pdo -> bindParam(":correo", $datosC["correo"], PDO::PARAM_STR);
		$pdo -> bindParam(":logo", $datosC["logo"], PDO::PARAM_STR);
		$pdo -> bindParam(":favicon", $datosC["favicon"], PDO::PARAM_STR);


		if($pdo -> execute()){
			return true;
		}

		$pdo->close();
		$pdo = null;

	}
	//ACTIVACION
	static public function obtenerEstadoActivacion($tablaBD) {
		$pdo = ConexionBD::cBD()->prepare("SELECT activado, fecha_inicio_prueba FROM $tablaBD WHERE id = 1");
		$pdo->execute();
		return $pdo->fetch();
	}

    // Activa el sistema
	static public function activarSistemaM($tablaBD) {
		$pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET activado = 1 WHERE id = 1");
		if ($pdo->execute()) {
			return true;
		} else {
			return false;
		}
	}
	public static function establecerFechaPruebaM($tablaBD, $fecha) {
		$pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET fecha_inicio_prueba = :fecha WHERE id = 1");
		$pdo->bindParam(":fecha", $fecha, PDO::PARAM_STR);
		return $pdo->execute();
	}
	public static function actualizarFechaInicioPrueba($tablaBD, $fecha) {
        $pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET fecha_inicio_prueba = :fecha WHERE id = 1");
        $pdo->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        return $pdo->execute();
    }
}