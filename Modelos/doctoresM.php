<?php

require_once "ConexionBD.php";

class DoctoresM extends ConexionBD{

	static public function CrearDoctorM($tablaBD, $datosC) {
		$pdo = ConexionBD::cBD()->prepare("INSERT INTO $tablaBD(apellido, nombre, sexo, id_consultorio, usuario, clave, rol, horarioE, horarioS) VALUES(:apellido, :nombre, :sexo, :id_consultorio, :usuario, :clave, :rol, :horarioE, :horarioS)");
	
		$pdo->bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
		$pdo->bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
		$pdo->bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
		$pdo->bindParam(":id_consultorio", $datosC["id_consultorio"], PDO::PARAM_INT);
		$pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
		$pdo->bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
		$pdo->bindParam(":rol", $datosC["rol"], PDO::PARAM_STR);
		$pdo->bindParam(":horarioE", $datosC["horarioE"], PDO::PARAM_STR);
		$pdo->bindParam(":horarioS", $datosC["horarioS"], PDO::PARAM_STR);
	
		if ($pdo->execute()) {
			return true;
		} else {
			// Agregar manejo de errores
			print_r($pdo->errorInfo());
		}
	
		$pdo->close();
		$pdo = null;
	}
	
	//Verificar User existente.
	static public function VerificarUsuarioExistente($tablaBD, $usuario, $idActual = null) {
		if ($idActual) {
			// Verificación para edición: excluye el usuario con el ID actual
			$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE usuario = :usuario AND id != :id");
			$pdo->bindParam(":usuario", $usuario, PDO::PARAM_STR);
			$pdo->bindParam(":id", $idActual, PDO::PARAM_INT);
		} else {
			// Verificación para creación: solo verifica el nombre de usuario
			$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE usuario = :usuario");
			$pdo->bindParam(":usuario", $usuario, PDO::PARAM_STR);
		}
	
		$pdo->execute();
		return $pdo->fetch(); // Retorna true si el usuario existe, false si no
	}
	


	//Mostrar Doctores
	static public function VerDoctoresM($tablaBD, $columna, $valor){

		if($columna != null){

			$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna");

			$pdo -> bindParam(":".$columna, $valor, PDO::PARAM_STR);

			$pdo->execute();

			return $pdo -> fetchAll();

		}else{

			$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD");

			$pdo->execute();

			return $pdo -> fetchAll();

		}

		$pdo -> close();
		$pdo = null;

	}


	//Editar Doctor
	static public function DoctorM($tablaBD, $columna, $valor){

		if($columna != null){

			$pdo = ConexionBD::cBD()->prepare("SELECT * FROM $tablaBD WHERE $columna = :$columna");

			$pdo -> bindParam(":".$columna, $valor, PDO::PARAM_STR);

			$pdo->execute();

			return $pdo -> fetch();

		}

		$pdo -> close();
		$pdo = null;

	}



	//Actualizar Doctores
	static public function ActualizarDoctorM($tablaBD, $datosC) {

		$pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET apellido = :apellido, nombre = :nombre, sexo = :sexo, usuario = :usuario, clave = :clave, id_consultorio = :id_consultorio WHERE id = :id");
	
		$pdo->bindParam(":id", $datosC["id"], PDO::PARAM_INT);
		$pdo->bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
		$pdo->bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
		$pdo->bindParam(":sexo", $datosC["sexo"], PDO::PARAM_STR);
		$pdo->bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
		$pdo->bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
		$pdo->bindParam(":id_consultorio", $datosC["id_consultorio"], PDO::PARAM_INT); // Cambiado de "consultorio" a "id_consultorio"
	
		if ($pdo->execute()) {
			return true;
		} else {
			// Manejo de errores para debugging
			print_r($pdo->errorInfo());
		}
	
		$pdo->close();
		$pdo = null;
	}



	//Eliminar Doctor
	static public function BorrarDoctorM($tablaBD, $id){

		$pdo = ConexionBD::cBD()->prepare("DELETE FROM $tablaBD WHERE id = :id");

		$pdo -> bindParam(":id", $id, pdo::PARAM_INT);

		if($pdo -> execute()){
			return true;
		}

		$pdo -> close();
		$pdo = null;

	}


	//Iniciar sesión doctor
	static public function IngresarDoctorM($tablaBD, $datosC){

		$pdo = ConexionBD::cBD()->prepare("SELECT usuario, clave, apellido, nombre, sexo, foto, rol, id FROM $tablaBD WHERE usuario = :usuario");

		$pdo -> bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);

		$pdo -> execute();

		return $pdo -> fetch();

		$pdo -> close();
		$pdo = null;

	}


	//Ver Perfil Doctor
	static public function VerPerfilDoctorM($tablaBD, $id){

		$pdo = ConexionBD::cBD()->prepare("SELECT usuario, clave, apellido, nombre, sexo, foto, rol, id, horarioE, horarioS, id_consultorio FROM $tablaBD WHERE id = :id");

		$pdo -> bindParam(":id", $id, PDO::PARAM_STR);

		$pdo -> execute();

		return $pdo -> fetch();

		$pdo -> close();
		$pdo = null;

	}



	//Actualizar Perfil Doctor
	static public function ActualizarPerfilDoctorM($tablaBD, $datosC){

		$pdo = ConexionBD::cBD()->prepare("UPDATE $tablaBD SET id_consultorio = :id_consultorio, apellido = :apellido, nombre = :nombre, foto = :foto, usuario = :usuario, clave = :clave, horarioE = :horarioE, horarioS = :horarioS WHERE id = :id");

		$pdo -> bindParam(":id", $datosC["id"], PDO::PARAM_INT);
		$pdo -> bindParam(":id_consultorio", $datosC["consultorio"], PDO::PARAM_INT);
		$pdo -> bindParam(":apellido", $datosC["apellido"], PDO::PARAM_STR);
		$pdo -> bindParam(":nombre", $datosC["nombre"], PDO::PARAM_STR);
		$pdo -> bindParam(":usuario", $datosC["usuario"], PDO::PARAM_STR);
		$pdo -> bindParam(":clave", $datosC["clave"], PDO::PARAM_STR);
		$pdo -> bindParam(":foto", $datosC["foto"], PDO::PARAM_STR);
		$pdo -> bindParam(":horarioE", $datosC["horarioE"], PDO::PARAM_STR);
		$pdo -> bindParam(":horarioS", $datosC["horarioS"], PDO::PARAM_STR);

		if($pdo -> execute()){
			return true;
		}

		$pdo -> close();
		$pdo = null;

	}



}