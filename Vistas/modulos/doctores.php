<?php

if($_SESSION["rol"] != "Secretaria" && $_SESSION["rol"] != "Administrador"){
	echo '<script>

	window.location = "inicio";
	</script>';

	return;

}


?>

<div class="content-wrapper">	
	
	<section class="content-header">
		
		<h1>Gestor de Doctores</h1>

	</section>

	<section class="content">
		
		<div class="box">
			
			<div class="box-header">
				
				<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CrearDoctor">Crear Doctor</button>
				
			</div>


			<div class="box-body">
				
				<table class="table table-bordered table-hover table-striped DT dt-responsive DT" >
					
					<thead>
						
						<tr>
							
							<th>N°</th>
							<th>Apellido</th>
							<th>Nombre</th>
							<th>Foto</th>
							<th>Consultorio</th>
							<th>Usuario</th>
							<th>Contraseña</th>
							<th>Editar / Borrar</th>

						</tr>

					</thead>

					<tbody>

						<?php

						$columna = null;
						$valor = null;

						$resultado = DoctoresC::VerDoctoresC($columna, $valor);

						foreach ($resultado as $key => $value) {
							
							echo '<tr>
							
									<td>'.($key+1).'</td>
									<td>'.$value["apellido"].'</td>
									<td>'.$value["nombre"].'</td>';

									if($value["foto"] == ""){

										echo '<td><img src="Vistas/img/defecto.png" width="40px"></td>';

									}else{

										echo '<td><img src="'.$value["foto"].'" width="40px"></td>';

									}


									$columna = "id";
									$valor = $value["id_consultorio"];

									$consultorio = ConsultoriosC::VerConsultoriosC($columna, $valor);

									echo '<td>'.$consultorio["nombre"].'</td>

									<td>'.$value["usuario"].'</td>

									<td>'.$value["clave"].'</td>

									<td>
										
										<div class="btn-group">
											
											
											<button class="btn btn-success EditarDoctor" Did="'.$value["id"].'" data-toggle="modal" data-target="#EditarDoctor"><i class="fa fa-pencil"></i> Editar</button>
											
											<button class="btn btn-danger EliminarDoctor" Did="'.$value["id"].'" imgD="'.$value["foto"].'"><i class="fa fa-times"></i> Borrar</button>
											

										</div>

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



<div class="modal fade" rol="dialog" id="CrearDoctor">
	
	<div class="modal-dialog">
		
		<div class="modal-content">
			
			<form method="post" role="form" onsubmit="return validarFormulario()">
				
				<div class="modal-body">
					
					<div class="box-body">
						
						<div class="form-group">
							
							<h2>Apellido:</h2>

							<input type="text" class="form-control input-lg" name="apellido" required pattern="[A-Za-zÀ-ÿÑñ\s]+" title="Solo letras y espacios permitidos">

							<input type="hidden" name="rolD" value="Doctor">

						</div>

						<div class="form-group">
							
							<h2>Nombre:</h2>

							<input type="text" class="form-control input-lg" name="nombre" required pattern="[A-Za-zÀ-ÿÑñ\s]+" title="Solo letras y espacios permitidos">

						</div>


						<div class="form-group">
							
							<h2>Sexo:</h2>

							<select class="form-control input-lg" name="sexo" required>
								
								<option value="" disabled>Seleccionar...</option>

								<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>

							</select>

						</div>


						<div class="form-group">
							
							<h2>Consultorio:</h2>

							<select class="form-control input-lg" name="consultorio" required>
								
								<option value="" disabled>Seleccionar...</option>

								<?php

								$columna = null;
								$valor = null;

								$resultado = ConsultoriosC::VerConsultoriosC($columna, $valor);

								foreach ($resultado as $key => $value) {
									
									echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';

								}

								?>

							</select>

						</div>


                        <div class="form-group">
                            <h2>Usuario:</h2>
                            <div class="d-flex">
                                <input type="text" class="form-control input-lg me-2" name="usuario" required>
                                <button type="button" class="btn btn-secondary" onclick="generarUsuario()">Generar Usuario</button>
                            </div>
                        </div>

                        <!-- Campo de Contraseña -->
                        <div class="form-group">
                            <h2>Contraseña:</h2>
                            <div class="d-flex">
                                <input type="text" class="form-control input-lg me-2" name="clave" required>
                                <button type="button" class="btn btn-secondary" onclick="generarContraseña()">Generar Contraseña</button>
                            </div>
                        </div>
					</div>

				</div>


				<div class="modal-footer">
					
					<button type="submit" class="btn btn-primary">Crear</button>

					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

				</div>

				<?php

				$crear = new DoctoresC();
				$crear -> CrearDoctorC();

				?>

			</form>

		</div>

	</div>

</div>


<div class="modal fade" rol="dialog" id="EditarDoctor">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" role="form" onsubmit="return validarFormularioEditar()">
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Apellido -->
                        <div class="form-group">
                            <h2>Apellido:</h2>
                            <input type="text" class="form-control input-lg" id="apellidoE" name="apellidoE" required pattern="[A-Za-zÀ-ÿÑñ\s]+" title="Solo letras y espacios permitidos">
                            <input type="hidden" id="Did" name="Did">
                        </div>

                        <!-- Nombre -->
                        <div class="form-group">
                            <h2>Nombre:</h2>
                            <input type="text" class="form-control input-lg" id="nombreE" name="nombreE" required pattern="[A-Za-zÀ-ÿÑñ\s]+" title="Solo letras y espacios permitidos">
                        </div>

                        <!-- Sexo -->
                        <div class="form-group">
                            <h2>Sexo:</h2>
                            <select class="form-control input-lg" name="sexoE" id="sexoE" required>
                                <option value="" disabled>Seleccionar...</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>

                        <!-- Consultorio -->
                        <div class="form-group">
                            <h2>Consultorio:</h2>
                            <select class="form-control input-lg" name="consultorioE" id="consultorioE" required>
                                <option value="" disabled>Seleccionar...</option>
                                <?php
                                $columna = null;
                                $valor = null;
                                $resultado = ConsultoriosC::VerConsultoriosC($columna, $valor);
                                foreach ($resultado as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Usuario -->
                        <div class="form-group">
                            <h2>Usuario:</h2>
                            <input type="text" class="form-control input-lg" id="usuarioE" name="usuarioE" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group">
                            <h2>Contraseña:</h2>
                            <input type="text" class="form-control input-lg" id="claveE" name="claveE" required>
                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>

                <?php
                $actualizar = new DoctoresC();
                $actualizar->ActualizarDoctorC();
                ?>

            </form>
        </div>
    </div>
</div>




<?php

$borrarD = new DoctoresC();
$borrarD -> BorrarDoctorC();