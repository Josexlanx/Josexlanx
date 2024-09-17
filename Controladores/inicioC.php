<?php

class InicioC{

	public function MostrarInicioC(){

		$tablaBD = "inicio";

		$id = "1";

		$resultado = InicioM::MostrarInicioM($tablaBD, $id);

		echo '<div class="box-body">
         
	          <div class="col-md-6 bg-primary" style="margin-top: 1%">
	            
	            <h2>Bienvenidos</h2>

	            <h4><b>'.$resultado["intro"].'</b></h4>

	            <hr>

	            <h3>Horario:</h3>
	            <h4><b>Desde: '.$resultado["horaE"].'</b></h4>
	            <h4><b>Hasta: '.$resultado["horaS"].'</b></h4>

	            <hr>

	            <h3>Dirección:</h3>
	            <h4><b>'.$resultado["direccion"].'</b></h4>

	            <hr>

	            <h3>Contactos:</h3>
	            <h4><b>Teléfono: '.$resultado["telefono"].' <br>
	            Correo: '.$resultado["correo"].'</b></h4>

	          </div>

	          <div class="col-md-6">
	            
	            <img src="'.$resultado["logo"].'" class="img-responsive">

	          </div>

	        </div>';

	}



	//Editar Perfil
	public function EditarInicioC(){

		$tablaBD = "inicio";

		$id = "1";

		$resultado = InicioM::MostrarInicioM($tablaBD, $id);

		echo '<form method="post" enctype="multipart/form-data">
					
				<div class="row">
					
					<div class="col-md-6 col-xs-12">
						
						<h2>Introducción:</h2>
						<input type="text" class="input-lg" name="intro" value="'.$resultado["intro"].'">
						<input type="hidden" class="input-lg" name="Iid" value="'.$resultado["id"].'">

						<div class=form-group>
							<h2>Horario:</h2>
							Desde:<input type="time" class="input-lg" name="horaE" value="'.$resultado["horaE"].'">
							Hasta:<input type="time" class="input-lg" name="horaS" value="'.$resultado["horaS"].'">

						</div>

						<h2>Dirección:</h2>
						<input type="text" class="input-lg" name="direccion" value="'.$resultado["direccion"].'">

						<h2>Teléfono:</h2>
						<input type="text" class="input-lg" name="telefono" value="'.$resultado["telefono"].'">

						<h2>Correo:</h2>
						<input type="text" class="input-lg" name="correo" value="'.$resultado["correo"].'">
						<br>
						<br>
						<button type="submit" class="btn btn-success">Guardar Cambios</button>
						</div>

					

					

					

				</div>

			</form>';

	}



	public function ActualizarInicioC(){

		if(isset($_POST["Iid"])){

			$rutaLogo = $_POST["logoActual"];

			if(isset($_FILES["logo"]["tmp_name"]) && !empty($_FILES["logo"]["tmp_name"])){

				if(!empty($_POST["logoActual"])){

					unlink($_POST["logoActual"]);

				}

				if($_FILES["logo"]["type"] == "image/jpeg"){

					$rutaLogo = "Vistas/img/logo.jpeg";

					$logo = imagecreatefromjpeg($_FILES["logo"]["tmp_name"]);
					
					imagejpeg($logo, $rutaLogo);

				}

				if($_FILES["logo"]["type"] == "image/png"){

					$rutaLogo = "Vistas/img/logo.png";

					$logo = imagecreatefrompng($_FILES["logo"]["tmp_name"]);
					
					imagepng($logo, $rutaLogo);

				}

			}



			$rutaFavicon = $_POST["faviconActual"];

			if(isset($_FILES["favicon"]["tmp_name"]) && !empty($_FILES["favicon"]["tmp_name"])){

				if(!empty($_POST["faviconActual"])){

					unlink($_POST["faviconActual"]);

				}

				if($_FILES["favicon"]["type"] == "image/jpeg"){

					$rutaFavicon = "Vistas/img/favicon.jpeg";

					$favicon = imagecreatefromjpeg($_FILES["favicon"]["tmp_name"]);
					
					imagejpeg($favicon, $rutaFavicon);

				}

				if($_FILES["favicon"]["type"] == "image/png"){

					$rutaFavicon = "Vistas/img/favicon.png";

					$favicon = imagecreatefrompng($_FILES["favicon"]["tmp_name"]);
					
					imagepng($favicon, $rutaFavicon);

				}

			}


			$tablaBD = "inicio";

			$datosC = array("id"=>$_POST["Iid"], "intro"=>$_POST["intro"], "horaE"=>$_POST["horaE"], "horaS"=>$_POST["horaS"], "telefono"=>$_POST["telefono"], "correo"=>$_POST["correo"], "direccion"=>$_POST["direccion"], "logo"=>$rutaLogo, "favicon"=>$rutaFavicon);

			$resultado = InicioM::ActualizarInicioM($tablaBD, $datosC);

			if($resultado == true){

				echo '<script>

				window.location = "inicio-editar";
				</script>';

			}


		}

	}
	//Activar(Lo coloco aqui porque ya van 10 veces que lo borro sin querer)
	public function activarSistema($clave) {
		$claveCorrecta = "Ei--zMbCkz:IxZF"; // Cambia esto por la clave real que desees usar
	
		if ($clave === $claveCorrecta) {
			$tablaBD = "inicio";
			return InicioM::activarSistemaM($tablaBD);
		} else {
			return false; // Clave incorrecta
		}
	}
	//ACTIVACION
	public function verificarActivacion() {
		$tablaBD = "inicio";
		$resultado = InicioM::obtenerEstadoActivacion($tablaBD);
	
		if (!$resultado) {
			return null; // No hay fecha de prueba establecida
		}
	
		$fechaInicioPrueba = new DateTime($resultado["fecha_inicio_prueba"] ?? ''); // Manejar el caso de una fecha nula
		$fechaActual = new DateTime();
		$diasDiferencia = $fechaInicioPrueba->diff($fechaActual)->days;
	
		if ($resultado["activado"] == 1) {
			return ['activado' => true]; // El sistema está activado
		} elseif ($diasDiferencia <= 30) {
			$diasRestantes = 30 - $diasDiferencia;
			return ['activado' => false, 'diasRestantes' => $diasRestantes]; // Aún dentro del periodo de prueba
		} else {
			return ['activado' => false, 'diasRestantes' => 0]; // Período de prueba terminado y no activado
		}
	}
    // Método para obtener la fecha de inicio de la prueba
    public function obtenerFechaInicioPrueba() {
        $tablaBD = "inicio";
        $resultado = InicioM::obtenerEstadoActivacion($tablaBD);
        return $resultado ? $resultado["fecha_inicio_prueba"] : null;
    }

    // Método para establecer la fecha de prueba
    public function establecerFechaPrueba($fecha) {
        $tablaBD = "inicio";
        return InicioM::actualizarFechaInicioPrueba($tablaBD, $fecha);
    }

	public function FaviconC(){
		$tablaBD = "inicio";
		$id = "1";
		$resultado = InicioM::MostrarInicioM($tablaBD, $id);
		echo '<link rel="icon" type="" href="'.$resultado["favicon"].'">';
	}
}