<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    
      <ul class="sidebar-menu">
        
        <li>
          <a href="/proyectoclinica/inicio">
            <i class="fa fa-home"></i>
            <span>Inicio</span>
          </a>
        </li>
        <li>
          <?php
          echo '<a href="/proyectoclinica/Citas/'.$_SESSION["id"].'">';
          ?>
          
            <i class="fa fa-medkit"></i>
            <span>Citas</span>
          </a>
        </li>
        <li>
          
       <a href="/proyectoclinica/pacientes-doctor">
            <i class="fa fa-calendar-check-o"></i>
            <span>Pacientes</span>
          </a>
        </li>

        <li>
          <a href="/proyectoclinica/asignados-admin">
            <i class="fa fa-pencil-square-o"></i>
            <span>PacienteAdmin</span>
          </a>
        </li>
        <li>
      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>