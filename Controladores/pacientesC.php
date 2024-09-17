<?php

class PacientesC{

	//Crear Pacientes
	public function CrearPacienteC(){

		if(isset($_POST["rolP"])){
	
			// Generar usuario y contraseña
			$nombre = $_POST["nombre"];
			$documento = $_POST["documento"];
			
			// Crear usuario en el formato nombre+P
			$usuario = $nombre . 'P';
	
			// Crear contraseña en el formato usuario+4 dígitos
			$clave = $usuario . rand(1000, 9999);
	
			$tablaBD = "pacientes";
	
			$datosC = array(
				"apellido" => $_POST["apellido"], 
				"nombre" => $nombre, 
				"documento" => $documento, 
				"usuario" => $usuario, 
				"clave" => $clave, 
				"rol" => $_POST["rolP"],
				"edad" => $_POST["edad"], 
				"sexo" => $_POST["sexo"], 
				"fechanacimiento" => $_POST["fechanacimiento"], 
				"telefono" => $_POST["telefono"],
				"domicilio" => $_POST["domicilio"]
			);
	
			$resultado = PacientesM::CrearPacienteM($tablaBD, $datosC);
	
			if($resultado == true){
				echo '<script>
				window.location = "pacientes";
				</script>';
			}
		}
	}

	//Ver Pacientes
	static public function VerPacientesC($columna, $valor){

		$tablaBD = "pacientes";

		$resultado = PacientesM::VerPacientesM($tablaBD, $columna, $valor);

		return $resultado;
	}

	//Borrar Paciente
	public function BorrarPacienteC(){

		if(isset($_GET["Pid"])){

			$tablaBD = "pacientes";

			$id = $_GET["Pid"];

			if($_GET["imgP"] != ""){
				unlink($_GET["imgP"]);
			}

			$resultado = PacientesM::BorrarPacienteM($tablaBD, $id);

			if($resultado == true){
				echo '<script>
				window.location = "pacientes";
				</script>';
			}
		}
	}

	//Editar Paciente
	static public function PacienteC($columna, $valor){

		$tablaBD = "pacientes";

		$resultado = PacientesM::PacienteM($tablaBD, $columna, $valor);

		return $resultado;
	}

	//Actualizar Paciente
	public function ActualizarPacienteC(){

		if(isset($_POST["Pid"])){

			$tablaBD = "pacientes";

			$datosC = array(
				"id"=>$_POST["Pid"], 
				"apellido"=>$_POST["apellidoE"], 
				"nombre"=>$_POST["nombreE"], 
				"documento"=>$_POST["documentoE"], 
				"usuario"=>$_POST["usuarioE"], 
				"clave"=>$_POST["claveE"],
				"edad"=>$_POST["edadE"], 
				"sexo"=>$_POST["sexoE"], 
				"fechanacimiento"=>$_POST["fechanacimientoE"], 
				"telefono"=>$_POST["telefonoE"],
				"domicilio"=>$_POST["domicilioE"]
			);

			$resultado = PacientesM::ActualizarPacienteM($tablaBD, $datosC);
			
			if($resultado == true){
				echo '<script>
				window.location = "pacientes";
				</script>';
			}
		}
	}

	//Ingreso de los Pacientes
	public function IngresarPacienteC(){

		if(isset($_POST["usuario-Ing"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuario-Ing"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["clave-Ing"])){

				$tablaBD = "pacientes";

				$datosC = array("usuario"=>$_POST["usuario-Ing"], "clave"=>$_POST["clave-Ing"]);

				$resultado = PacientesM::IngresarPacienteM($tablaBD, $datosC);

				if($resultado["usuario"] == $_POST["usuario-Ing"] && $resultado["clave"] == $_POST["clave-Ing"]){

					$_SESSION["Ingresar"] = true;

					$_SESSION["id"] = $resultado["id"];
					$_SESSION["usuario"] = $resultado["usuario"];
					$_SESSION["clave"] = $resultado["clave"];
					$_SESSION["apellido"] = $resultado["apellido"];
					$_SESSION["nombre"] = $resultado["nombre"];
					$_SESSION["documento"] = $resultado["documento"];
					$_SESSION["foto"] = $resultado["foto"];
					$_SESSION["rol"] = $resultado["rol"];
					$_SESSION["edad"] = $resultado["edad"];
					$_SESSION["sexo"] = $resultado["sexo"];
					$_SESSION["fechanacimiento"] = $resultado["fechanacimiento"];
					$_SESSION["telefono"] = $resultado["telefono"];
					$_SESSION["domicilio"] = $resultado["domicilio"];

					echo '<script>
					window.location = "inicio";
					</script>';
				}else{
					echo '<br><div class="alert alert-danger">Error al Ingresar</div>';
				}
			}
		}
	}

	//Ver perfil del paciente
	public function VerPerfilPacienteC(){

		$tablaBD = "pacientes";

		$id = $_SESSION["id"];

		$resultado = PacientesM::VerPerfilPacienteM($tablaBD, $id);

		echo '<tr>
				<td>'.$resultado["usuario"].'</td>
				<td>'.$resultado["clave"].'</td>
				<td>'.$resultado["nombre"].'</td>
				<td>'.$resultado["apellido"].'</td>';

				if($resultado["foto"] == ""){
					echo '<td><img src="Vistas/img/defecto.png" width="40px"></td>';
				}else{
					echo '<td><img src="'.$resultado["foto"].'" width="40px"></td>';
				}

				echo '<td>'.$resultado["documento"].'</td>
				<td>'.$resultado["edad"].'</td>
				<td>'.$resultado["sexo"].'</td>
				<td>'.$resultado["fechanacimiento"].'</td>
				<td>'.$resultado["telefono"].'</td>
				<td>'.$resultado["domicilio"].'</td>
				<td>
					<a href="/proyectoclinica/perfil-P/'.$resultado["id"].'">
						<button class="btn btn-success"><i class="fa fa-pencil"></i></button>
					</a>
				</td>
			</tr>';
	}

	//Editar Perfil Paciente
	public function EditarPerfilPacienteC(){

		$tablaBD = "pacientes";

		$id = $_SESSION["id"];

		$resultado = PacientesM::VerPerfilPacienteM($tablaBD, $id);

		echo '<form method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6 col-xs-12">
							<h2>Nombre:</h2>
							<input type="text" class="input-lg" name="nombrePerfil" value="'.$resultado["nombre"].'">
							<input type="hidden" class="input-lg" name="Pid" value="'.$resultado["id"].'">

							<h2>Apellido:</h2>
							<input type="text" class="input-lg" name="apellidoPerfil" value="'.$resultado["apellido"].'">

							<h2>Usuario:</h2>
							<input type="text" class="input-lg" name="usuarioPerfil" value="'.$resultado["usuario"].'">

							<h2>Clave:</h2>
							<input type="text" class="input-lg" name="clavePerfil" value="'.$resultado["clave"].'">

							<h2>Documento:</h2>
							<input type="text" class="input-lg" name="documentoPerfil" value="'.$resultado["documento"].'">

							<h2>Edad:</h2>
							<input type="text" class="input-lg" name="edadPerfil" value="'.$resultado["edad"].'">

							<h2>Sexo:</h2>
							<input type="text" class="input-lg" name="sexoPerfil" value="'.$resultado["sexo"].'">

							<h2>Fecha de Nacimiento:</h2>
							<input type="date" class="input-lg" name="fechanacimientoPerfil" value="'.$resultado["fechanacimiento"].'">

							<h2>Teléfono:</h2>
							<input type="text" class="input-lg" name="telefonoPerfil" value="'.$resultado["telefono"].'">
							
							<h2>Domicilio:</h2>
							<input type="text" class="input-lg" name="domicilioPerfil" value="'.$resultado["domicilio"].'">
						</div>

						<div class="col-md-6 col-xs-12">
							<br><br>
							<input type="file" name="imgPerfil">
							<br>';

							if($resultado["foto"] != ""){
								echo '<img src="/proyectoclinica/'.$resultado["foto"].'" width="200px" class="img-responsive">';
							}else {
								echo '<img src="/proyectoclinica/Vistas/img/defecto.png" width="200px" class="img-responsive">';
							}

							echo '<input type="hidden" name="imgActual" value="'.$resultado["foto"].'">
							<br><br>
							<button type="submit" class="btn btn-success">Guardar Cambios</button>
						</div>
					</div>
				</form>';
	}

	//Actualizar Perfil del Paciente
	public function ActualizarPerfilPacienteC(){

		if(isset($_POST["Pid"])){

			$tablaBD = "pacientes";

			$datosC = array(
				"id"=>$_POST["Pid"], 
				"apellido"=>$_POST["apellidoPerfil"], 
				"nombre"=>$_POST["nombrePerfil"], 
				"documento"=>$_POST["documentoPerfil"], 
				"usuario"=>$_POST["usuarioPerfil"], 
				"clave"=>$_POST["clavePerfil"], 
				"foto"=>$_POST["imgActual"],
				"edad"=>$_POST["edadPerfil"], 
				"sexo"=>$_POST["sexoPerfil"], 
				"fechanacimiento"=>$_POST["fechanacimientoPerfil"], 
				"telefono"=>$_POST["telefonoPerfil"],
				"domicilio"=>$_POST["domicilioPerfil"]
			);

			$rutaImg = $_POST["imgActual"];

			if(isset($_FILES["imgPerfil"]["tmp_name"]) && !empty($_FILES["imgPerfil"]["tmp_name"])){

				if(!empty($_POST["imgActual"])){
					unlink($_POST["imgActual"]);
				}

				if($_FILES["imgPerfil"]["type"] == "image/png"){
					$nombre = mt_rand(100, 999);
					$rutaImg = "Vistas/img/Pacientes/Paciente".$nombre.".png";
					$foto = imagecreatefrompng($_FILES["imgPerfil"]["tmp_name"]);
					imagepng($foto, $rutaImg);
				}

				if($_FILES["imgPerfil"]["type"] == "image/jpeg"){
					$nombre = mt_rand(100, 999);
					$rutaImg = "Vistas/img/Pacientes/Paciente".$nombre.".jpg";
					$foto = imagecreatefromjpeg($_FILES["imgPerfil"]["tmp_name"]);
					imagejpeg($foto, $rutaImg);
				}
			}

			$datosC["foto"] = $rutaImg;

			$resultado = PacientesM::ActualizarPerfilPacienteM($tablaBD, $datosC);

			if($resultado == true){
				echo '<script>
				window.location = "perfil-P/'.$_SESSION["id"].'";
				</script>';
			}
		}
	}
	public function ActualizarHistorialC() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$tablaBD = "historia_clinica";
	
			// Recibir los datos enviados por AJAX
			$datosC = array(
				"cod_historia_clinica" => $_POST['cod_historia_clinica'],
				"acompanante" => $_POST['acompanante'],
				"parentesco" => $_POST['parentesco'],
				"frecuencia_cardiaca" => $_POST['frecuencia_cardiaca'],
				"frecuencia_ritmica" => $_POST['frecuencia_ritmica'],
				"presion_arterial" => $_POST['presion_arterial'],
				"temperatura" => $_POST['temperatura'],
				"peso" => $_POST['peso'],
				"talla" => $_POST['talla'],
				"saturacion" => $_POST['saturacion'],
				"anam_te" => $_POST['anam_te'],
				"anam_fi" => $_POST['anam_fi'],
				"curso" => $_POST['curso'],
				"relato" => $_POST['relato'],
				"antecedentes" => $_POST['antecedentes'],
				"alergias" => $_POST['alergias'],
				"examen_clinico" => $_POST['examen_clinico'],
				"presuncion_a" => $_POST['presuncion_a'],
				"presuncion_b" => $_POST['presuncion_b'],
				"presuncion_c" => $_POST['presuncion_c'],
				"plan" => $_POST['plan'],
				"tratamiento" => $_POST['tratamiento']
			);
	
			// Llamar al modelo para actualizar los datos en la base de datos
			$resultado = PacientesM::ActualizarHistorialM($tablaBD, $datosC);
	
			if ($resultado) {
				echo "success";  // Respuesta para el éxito de la operación
			} else {
				echo "error";  // Respuesta en caso de error
			}
		}
	}
	

	public function CrearHistorialC() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
			$tablaBD = "historia_clinica";
	
			// Verificar si el usuario tiene el rol de "Secretaria" o "Administrador"
			if ($_SESSION['rol'] == 'Secretaria' || $_SESSION['rol'] == 'Administrador') {
				// Si el rol es "Secretaria" o "Administrador", obtener el doctor del combo box
				$nombre_doctor = $_POST['nombre_doctor'];
			} else {
				// Si el rol es "Doctor", usar el nombre del doctor logueado
				$nombre_doctor = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
			}
	
			// Si el nombre del doctor sigue sin estar definido, maneja el error
			if (empty($nombre_doctor)) {
				echo "Error: No se ha seleccionado un doctor.";
				exit;
			}
	
			$datosC = array(
				"id_paciente" => $_POST['id_paciente'],
				"acompanante" => $_POST['acompanante'],
				"parentesco" => $_POST['parentesco'],
				"frecuencia_cardiaca" => $_POST['frecuencia_cardiaca'],
				"frecuencia_ritmica" => $_POST['frecuencia_ritmica'],
				"presion_arterial" => $_POST['presion_arterial'],
				"temperatura" => $_POST['temperatura'],
				"peso" => $_POST['peso'],
				"talla" => $_POST['talla'],
				"saturacion" => $_POST['saturacion'],
				"anam_te" => $_POST['anam_te'],
				"anam_fi" => $_POST['anam_fi'],
				"curso" => $_POST['curso'],
				"relato" => $_POST['relato'],
				"antecedentes" => $_POST['antecedentes'],
				"alergias" => $_POST['alergias'],
				"examen_clinico" => $_POST['examen_clinico'],
				"presuncion_a" => $_POST['presuncion_a'],
				"presuncion_b" => $_POST['presuncion_b'],
				"presuncion_c" => $_POST['presuncion_c'],
				"plan" => $_POST['plan'],
				"tratamiento" => $_POST['tratamiento'],
				"nombre_doctor" => $nombre_doctor // Usar el nombre del doctor adecuado
			);
	
			$resultado = PacientesM::CrearHistorialM($tablaBD, $datosC);
	
			if ($resultado == true) {
				echo '<script>
				window.location = "/proyectoclinica/ver-historial/' . $_POST['id_paciente'] . '";
				</script>';
			} else {
				echo "Error al guardar el historial.";
			}
		}
	}

	//Crear historial Odonto
	public function CrearHistorialOdontoC() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
			$tablaBD = "historial_odontologia";
	
			// Verificar si el usuario tiene el rol de "Secretaria" o "Administrador"
			if ($_SESSION['rol'] == 'Secretaria' || $_SESSION['rol'] == 'Administrador') {
				$nombre_doctor = $_POST['nombre_doctor'];
			} else {
				$nombre_doctor = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
			}
	
			if (empty($nombre_doctor)) {
				echo "Error: No se ha seleccionado un doctor.";
				exit;
			}
	
			// Obtener y procesar la imagen si existe
			$imagen = null;
			if (isset($_POST['imagen'])) {
				$dataURL = $_POST['imagen'];
				$imagen = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataURL));
			}
	
			// Preparar los datos
			$datosC = array(
				"id_paciente" => $_POST['id_paciente'],
				"estado_dientes" => $_POST['estado_dientes'],
				"alergias" => $_POST['alergias'],
				"intervenciones" => $_POST['intervenciones'],
				"observaciones" => $_POST['observaciones'],
				"extension" => $_POST['extension'],
				"nombre_doctor" => $nombre_doctor,
				"imagen" => $imagen
			);
	
			// Llamar al modelo para guardar el historial
			$resultado = PacientesM::CrearHistorialOdontoM($tablaBD, $datosC);
	
			if ($resultado == true) {
				echo '<script>
				window.location = "/proyectoclinica/ver-historial/' . $_POST['id_paciente'] . '";
				</script>';
			} else {
				echo "Error al guardar el historial odontologico.";
			}
		}
	}
	

	public function ObtenerPacienteHistorialC($cod_historia_clinica) {
        $resultado = PacientesM::ObtenerPacienteHistorialM($cod_historia_clinica);

        return $resultado;
    }
    public function VerPacientesPorDoctorC($id_doctor) {
        $tablaCitas = "citas"; // Nombre de la tabla de citas
        $tablaPacientes = "pacientes"; // Nombre de la tabla de pacientes
        $resultado = PacientesM::VerPacientesPorDoctorM($tablaCitas, $tablaPacientes, $id_doctor);
        return $resultado;
    }
	//ProbandoAsignacion
    public static function VerPacientesPorDoctorAsignadosC($id_doctor) {
        $tabla = "pacientes";
        return PacientesM::VerPacientesPorDoctorAsignadosM($tabla, $id_doctor);
    }

    public function AsignarPacienteDoctorC() {
        if(isset($_POST["id_paciente"]) && isset($_POST["id_doctor"])) {
            $tabla = "asignacion_pacientes";
            $datos = array("id_paciente" => $_POST["id_paciente"], "id_doctor" => $_POST["id_doctor"]);

            $respuesta = PacientesM::AsignarPacienteDoctorM($tabla, $datos);

            if($respuesta == "ok") {
                echo '<script>
                        window.location = "panel-control";
                      </script>';
            }
        }
    }
	public static function VerPacientesNoAsignadosC($id_doctor) {
		$tabla = "pacientes";
		return PacientesM::VerPacientesNoAsignadosM($tabla, $id_doctor);
	}
	public function EliminarAsignacionPacienteC() {
		if(isset($_POST["id_paciente"]) && isset($_POST["id_doctor"])) {
			$tabla = "asignacion_pacientes";
			$respuesta = PacientesM::EliminarAsignacionPacienteM($tabla, $_POST["id_paciente"], $_POST["id_doctor"]);
	
			if($respuesta == "ok") {
				echo '<script>
						window.location = "asignados-admin";
					  </script>';
			}
		}
	}
}