<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="#"><?php echo PAGE_TITLE; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="inicio.php"><span class="glyphicon glyphicon-bookmark"></span> Escritorio</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-cog"></span> Ajustes</a></li>

            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="glyphicon glyphicon-user"></span> Cuenta
              <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li>
                  <div class="navbar-content">
                    <div class="row">
                      <div class="col-md-5">
                          <img src="img/ironman-profile.jpg" alt="Alternate Text" class="img-responsive" />
                        <p class="text-center small">
                          <a href="#">Cambiar Foto</a></p>
                        </div>
                        <div class="col-md-7">
                          <span><?php echo $_SESSION["user"]["nombres"] . ' ' . $_SESSION["user"]["apellidos"]; ?></span>
                          <p class="text-muted small"><?php echo $_SESSION["user"]["email"];?></p>
                          <div class="divider"></div>
                          <a href="inicio.php?option=perfil" class="btn btn-primary btn-sm active">Ver Perfil</a>

                        </div>
                      </div>
                    </div>
                    <div class="navbar-footer">
                      <div class="navbar-footer-content">
                        <div class="row">
                          <div class="col-md-6">
                            <a href="#" class="btn btn-default btn-sm">Cambiar Contraseña</a>
                          </div>
                          <div class="col-md-6">
                            <a href="logout.php" class="btn btn-default btn-sm pull-right">Cerrar Sesión</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
          </ul>
          <!--
          <form class="navbar-form navbar-right">
              <div id="typeahead-menu">
                    <input type="text"  id="txt-filter-menu" class="form-control input-sm typeahead" placeholder="Buscar...">
                </div>
          </form>
          -->
        </div>
      </div>
    </nav>
