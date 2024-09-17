<?php

class AdminC{

	//Ingreso Admin
	public function IngresarAdminC(){

		if(isset($_POST["usuario-Ing"])){
	
			if(preg_match('/^[A-Za-zÀ-ÿÑñ0-9\s]+$/', $_POST["usuario-Ing"]) && preg_match('/^[A-Za-zÀ-ÿÑñ0-9\s]+$/', $_POST["clave-Ing"])){
	
				$tablaBD = "administradores";
	
				$datosC = array("usuario" => $_POST["usuario-Ing"], "clave" => $_POST["clave-Ing"]);
	
				$resultado = AdminM::IngresarAdminM($tablaBD, $datosC);
	
				if($resultado && $resultado["usuario"] == $_POST["usuario-Ing"] && $resultado["clave"] == $_POST["clave-Ing"]){
	
					$_SESSION["Ingresar"] = true;
	
					$_SESSION["id"] = $resultado["id"];
					$_SESSION["usuario"] = $resultado["usuario"];
					$_SESSION["clave"] = $resultado["clave"];
					$_SESSION["nombre"] = $resultado["nombre"];
					$_SESSION["apellido"] = $resultado["apellido"];
					$_SESSION["foto"] = $resultado["foto"];
					$_SESSION["rol"] = $resultado["rol"];
	
					echo '<script> window.location = "inicio"; </script>';
	
				} else {
	
					echo '<br><div class="alert alert-danger">Error al Ingresar: Usuario o contraseña incorrectos</div>';
	
				}
	
			} else {
	
				echo '<br><div class="alert alert-danger">Error al Ingresar: Formato de usuario o contraseña no válido</div>';
	
			}
	
		}
	
	}


	//Ver Perfil Admin
	public function VerPerfilAdminC(){

		$tablaBD = "administradores";

		$id = $_SESSION["id"];

		$resultado = AdminM::VerPerfilAdminM($tablaBD, $id);

		echo '<tr>
							
				<td>'.$resultado["usuario"].'</td>
				<td>'.$resultado["clave"].'</td>
				<td>'.$resultado["nombre"].'</td>
				<td>'.$resultado["apellido"].'</td>';

				

				echo '<td><img src="/proyectoclinica/Vistas/img/defecto.png" class="img-responsive" width="40px"></td>';

				

				echo '<td>
					<a href="/proyectoclinica/perfil-A/'.$resultado["id"].'">
						<button class="btn btn-success"><i class="fa fa-pencil"></i></button>
					</a>
				</td>

			</tr>';

	}



	//Editar Perfil
	public function EditarPerfilAdminC(){

		$tablaBD = "administradores";

		$id = $_SESSION["id"];

		$resultado = AdminM::VerPerfilAdminM($tablaBD, $id);

		echo '<form method="post" enctype="multipart/form-data">
					
				<div class="row">
					
					<div class="col-md-6 col-xs-12">
						
						<h2>Nombre:</h2>
						<input type="text" class="input-lg" name="nombreP" value="'.$resultado["nombre"].'">
						<input type="hidden" class="input-lg" name="Aid" value="'.$resultado["id"].'">

						<h2>Apellido:</h2>
						<input type="text" class="input-lg" name="apellidoP" value="'.$resultado["apellido"].'">

						<h2>Usuario:</h2>
						<input type="text" class="input-lg" name="usuarioP" value="'.$resultado["usuario"].'">

						<h2>Contraseña:</h2>
						<input type="text" class="input-lg" name="claveP" value="'.$resultado["clave"].'">
						<br>
						<br>
						<button type="submit" class="btn btn-success">Guardar Cambios</button>
					</div>

					

				</div>

			</form>';

	}



	//Actualizar Perfil
	public function ActualizarPerfilAdminC(){

		if(isset($_POST["Aid"])){

			$rutaImg = $_POST["imgActual"];

			if(isset($_FILES["imgP"]["tmp_name"]) && !empty($_FILES["imgP"]["tmp_name"])){

				if(!empty($_POST["imgActual"])){

					unlink($_POST["imgActual"]);

				}

				if($_FILES["imgP"]["type"] == "image/jpeg"){

					$nombre = mt_rand(10, 999);

					$rutaImg = "Vistas/img/Usuarios/A-".$nombre.".jpg";

					$foto = imagecreatefromjpeg($_FILES["imgP"]["tmp_name"]);

					imagejpeg($foto, $rutaImg);

				}

				if($_FILES["imgP"]["type"] == "image/png"){

					$nombre = mt_rand(10, 999);

					$rutaImg = "Vistas/img/Usuarios/A-".$nombre.".png";

					$foto = imagecreatefrompng($_FILES["imgP"]["tmp_name"]);

					imagepng($foto, $rutaImg);

				}

			}

			$tablaBD = "administradores";

			$datosC = array("id"=>$_POST["Aid"], "usuario"=>$_POST["usuarioP"], "clave"=>$_POST["claveP"], "nombre"=>$_POST["nombreP"], "apellido"=>$_POST["apellidoP"], "foto"=>$rutaImg);

			$resultado = AdminM::ActualizarPerfilAdminM($tablaBD, $datosC);

			if($resultado == true){

				echo '<script>

				window.location = "/proyectoclinica/perfil-A/'.$resultado["id"].'";
				</script>';

			}

		}

	}


}