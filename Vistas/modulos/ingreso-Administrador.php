<div class="login-box">
  <div class="login-logo">
    <a href="/proyectoclinica/seleccionar"><b>Clínica Médica</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingresar como Administrador</p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="usuario-Ing" placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="clave-Ing" name="clave-Ing" placeholder="Contraseña">
          <button type="button" id="togglePassword" class="btn btn-link">
              <span class="glyphicon glyphicon-eye-open"></span>
          </button>
      </div>


      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
          <a href="/proyectoclinica/seleccionar" class="btn btn-warning btn-block btn-flat">Regresar</a>
        </div>
        <!-- /.col -->
      </div>

      <?php
      $ingreso = new AdminC();
      $ingreso->IngresarAdminC();
      ?>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<style>
  #togglePassword {
    cursor: pointer;
    position: absolute;
    right: 1px; /* Ajusta según sea necesario */
    top: 50%; /* Ajusta según sea necesario */
    transform: translateY(-50%);
}
.form-group {
    position: relative;
}
</style>
<!-- Incluir el archivo JavaScript -->