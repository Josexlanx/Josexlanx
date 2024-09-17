<?php

if($_SESSION["rol"] != "Administrador"){
	$rolUsuario = $_SESSION["rol"];

    echo '<script>
    window.location = "inicio";
    </script>';

    return;
}

?>

<div class="content-wrapper">
    
    <section class="content-header">
        
        <h1>Gestor de Secretarias</h1>

    </section>

    <section class="content">
        
        <div class="box">
            
            <div class="box-header">
                
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CrearSecretaria">Crear Secretaria</button>
                
            </div>


            <div class="box-body">
                
                <table class="table table-bordered table-hover table-striped DT">
                    
                    <thead>
                        
                        <tr>
                            
                            <th>N°</th>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>Foto</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Editar / Borrar</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $resultado = SecretariasC::VerSecretariasC();

						foreach ($resultado as $key => $value) {
							echo '<tr>
									<td>'.($key+1).'</td>
									<td>'.$value["apellido"].'</td>
									<td>'.$value["nombre"].'</td>';
						
									if($value["foto"] == "") {
										echo '<td><img src="Vistas/img/defecto.png" width="40px"></td>';
									} else {
										echo '<td><img src="'.$value["foto"].'" width="40px"></td>';
									}
						
									echo '<td>'.$value["usuario"].'</td>
									<td>'.$value["clave"].'</td>
									<td>
										<div class="btn-group">
											<button class="btn btn-success EditarSecretaria" 
												data-id="'.$value["id"].'" 
												data-apellido="'.$value["apellido"].'" 
												data-nombre="'.$value["nombre"].'" 
												data-usuario="'.$value["usuario"].'" 
												data-clave="'.$value["clave"].'"
												data-toggle="modal" data-target="#EditarSecretaria">
												<i class="fa fa-pencil"></i> Editar
											</button>
											<button class="btn btn-danger EliminarSecretaria" id="'.$value["id"].'" imgS="'.$value["foto"].'"><i class="fa fa-times"></i> Borrar</button>
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



<div class="modal fade" rol="dialog" id="CrearSecretaria">
    
    <div class="modal-dialog">
        
        <div class="modal-content">
            
            <form method="post" role="form" onsubmit="return validarFormulario()">
                
                <div class="modal-body">
                    
                    <div class="box-body">
                        
                        <div class="form-group">
                            
                            <h2>Apellido:</h2>

                            <input type="text" class="form-control input-lg" name="apellido" required pattern="[A-Za-zÀ-ÿÑñ\s]+" title="Solo letras y espacios permitidos">

                            <input type="hidden" name="rolS" value="Secretaria">

                        </div>

                        <div class="form-group">
                            
                            <h2>Nombre:</h2>

                            <input type="text" class="form-control input-lg" name="nombre"  required pattern="[A-Za-zÀ-ÿÑñ\s]+" title="Solo letras y espacios permitidos">

                        </div>



                        <div class="form-group">
                            
                            <h2>Usuario:</h2>

                            <input type="text" class="form-control input-lg" name="usuario" required>

                        </div>

                        <div class="form-group">
                            
                            <h2>Contraseña:</h2>

                            <input type="text" class="form-control input-lg" name="clave" required>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">
                    
                    <button type="submit" class="btn btn-primary">Crear</button>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

                </div>

                <?php

                $crear = new SecretariasC();
                $crear -> CrearSecretariaC();

                ?>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" rol="dialog" id="EditarSecretaria">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" role="form">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <h2>Apellido:</h2>
                            <input type="text" class="form-control input-lg" id="apellidoE" name="apellidoE" required>
                            <input type="hidden" id="Sid" name="Sid">
                        </div>

                        <div class="form-group">
                            <h2>Nombre:</h2>
                            <input type="text" class="form-control input-lg" id="nombreE" name="nombreE" required>
                        </div>

                        <div class="form-group">
                            <h2>Usuario:</h2>
                            <input type="text" class="form-control input-lg" id="usuarioE" name="usuarioE" required>
                        </div>

                        <div class="form-group">
                            <h2>Contraseña:</h2>
                            <input type="text" class="form-control input-lg" id="claveE" name="claveE" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>

                <?php
                $actualizar = new SecretariasC();
                $actualizar->EditarSecretariaC();
                ?>
            </form>
        </div>
    </div>
</div>




<?php

$borrarS = new SecretariasC();
$borrarS -> BorrarSecretariaC();
?>


