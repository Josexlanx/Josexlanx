<?php
class CitasC{
	//Pedir Cita Paciente
	public function EnviarCitaC(){
		if(isset($_POST["Did"])){
			$tablaBD = "citas";
			$Did = substr($_GET["url"], 7);
			$datosC = array("Did"=>$_POST["Did"],"Pid"=>$_POST["Pid"], "nyaC"=>$_POST["nyaC"], "Cid"=>$_POST["Cid"], "documentoC"=>$_POST["documentoC"], "fyhIC"=>$_POST["fyhIC"], "fyhFC"=>$_POST["fyhFC"]);
			$resultado = CitasM::EnviarCitaM($tablaBD, $datosC);
			if($resultado == true){
				echo '<script>
				window.location = "Doctor/"'.$Did.';
				</script>';
			}
		}
	}
	//Mostrar Citas
	public static function VerCitasC(){
		$tablaBD = "citas";
		$resultado = CitasM::VerCitasM($tablaBD);
		return $resultado;
	}
	//Pedir cita como doctor
	public function PedirCitaDoctorC(){
		if(isset($_POST["Did"])){
			$tablaBD = "citas";
			$Did = substr($_GET["url"], 6);
			$datosC = array("Did"=>$_POST["Did"],"Pid"=>$_POST["Pid"], "Cid"=>$_POST["Cid"], "nombreP"=>$_POST["nombreP"], "documentoP"=>$_POST["documentoP"], "fyhIC"=>$_POST["fyhIC"], "fyhFC"=>$_POST["fyhFC"]);
			$resultado = CitasM::PedirCitaDoctorM($tablaBD, $datosC);
			if($resultado == true){
				echo '<script>
				window.location = "Citas/'.$Did.'";
				</script>';
			}
		}
	}
		//Pedir cita como Secretaria
	public function PedirCitaSecretariaC() {
		if (isset($_POST["Did"])) {
			$tablaBD = "citas";
			$datosC = array(
				"Did" => $_POST["Did"],
				"Cid" => $_POST["Cid"],
				"Pid" => $_POST["Pid"],
				"nombreP" => $_POST["nombreP"],
				"documentoP" => $_POST["documentoP"],
				"fyhIC" => $_POST["fyhIC"],
				"fyhFC" => $_POST["fyhFC"]
			);
			$resultado = CitasM::PedirCitaSecretariaM($tablaBD, $datosC);
			if ($resultado == true) {
				echo '<script>
				window.location = "/proyectoclinica/Citas-S-A/'.$_POST["Did"].'";
				</script>';
			}
		}
	}

	// Eliminar cita
	public static function EliminarCitaC($id) {
		$tablaBD = "citas";
		$resultado = CitasM::EliminarCitaM($tablaBD, $id);
	
		if ($resultado == true) {
			return "ok";
		} else {
			return "error";
		}
	}
	
    public static function VerCitasPorDoctorC($doctorId) {
        $tablaBD = "citas";
        $resultado = CitasM::VerCitasPorDoctorM($tablaBD, $doctorId);
        return $resultado;
    }
    public function ReasignarCitaC() {
        if (isset($_POST["idCita"]) && isset($_POST["nuevoDoctorId"]) && isset($_POST["nuevaFechaHora"])) {
            $datosC = array(
                "idCita" => $_POST["idCita"],
                "nuevoDoctorId" => $_POST["nuevoDoctorId"],
                "nuevaFechaHora" => $_POST["nuevaFechaHora"]
            );

            $resultado = CitasM::ReasignarCitaM("citas", $datosC);
            echo json_encode(array("success" => $resultado));
        }
    }
}