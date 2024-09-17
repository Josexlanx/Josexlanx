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
          <a href="/proyectoclinica/Ver-consultorios">
            <i class="fa fa-medkit"></i>
            <span>Consultorios</span>
          </a>
        </li>
        <li>
          <?php
          echo '  <a href="/proyectoclinica/historial/'.$_SESSION["id"].'">';
          ?>
              <i class="fa fa-calendar-check-o"></i>
              <span>Historial</span>
            </a>
        </li>

      </ul>

    </section>
    <!-- /.sidebar -->
  </aside>