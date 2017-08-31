<div class="panel-group nav-sidebar" id="accordion" role="tablist" aria-multiselectable="true">

    <?php
        $administrativo_open = $_SESSION["modulo"] == "administrativo";
    ?>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="<?php echo $administrativo_open?'true':'false'; ?>" aria-controls="collapseOne">
                    <span class="glyphicon glyphicon-book"></span> Administrativo <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse <?php echo $administrativo_open?'in':''; ?>" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav nav-sidebar">
                    <li <?php echo $menu=='usuarios'?'class="active"':'';?>><a href="administrativo.php?option=usuarios">Usuarios</a></li>
                    <li <?php echo $menu=='infos'?'class="active"':'';?>><a href="administrativo.php?option=infos">Información</a></li>
                    <li <?php echo $menu=='slides'?'class="active"':'';?>><a href="administrativo.php?option=slides">Slides</a></li>
                    <li <?php echo $menu=='articulos'?'class="active"':'';?>><a href="administrativo.php?option=articulos">Nosotros</a></li>
                    <li <?php echo $menu=='servicios'?'class="active"':'';?>><a href="administrativo.php?option=servicios">Servicios</a></li>
                    <li <?php echo $menu=='clientes'?'class="active"':'';?>><a href="administrativo.php?option=clientes">Clientes</a></li>
                    <li <?php echo $menu=='obras'?'class="active"':'';?>><a href="administrativo.php?option=obras">Trabajos Realizados</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>
