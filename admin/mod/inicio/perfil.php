<?php
$stylesheets = array(
    'datatables.css',
    'bootstrap-datepicker.min.css',
    'toastr.min.css'
);
$scripts = array(
    'jquery.dataTables.min.js',
    'datatables.js',
    'moment.min.js',
    'bootstrap-datepicker.min.js',
    'bootstrap-datepicker.es.js',
    'toastr.min.js',
    'toaster_msgs.js'
);
?>

<?php include_once './inc/head.php'; ?>

<?php

$user = User::getById($_SESSION["user"]["id"]);
?>

<body>

    <?php include_once 'inc/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <?php include_once 'inc/menu.php'; ?>
            </div>

            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <h1 class="page-header">Perfil</h1>


                <div class="col-md-6">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="img/ironman-profile.jpg" class="img-thumbnail">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <h4><strong><?php echo $user->usuario_email; ?></strong></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-6">
                    <div class="well">
                        <form method="post" id="profileForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="" class="input-sm form-control" name="usuario_email" id="txt-usuario-email" placeholder="E-mail" value="<?php echo $user->user_email; ?>" autocomplete="off">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="password" class="input-sm form-control" name="usuario_pass_old" placeholder="Old Password" autocomplete="off">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="password" class="input-sm form-control" name="usuario_pass" placeholder="New Password" autocomplete="off">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="password" class="input-sm form-control" name="usuario_pass_confirm" placeholder="Confirm Password" autocomplete="off">
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <br/>
                            <input type="hidden" name="option" value="actualizar_perfil" />
                            <button type="submit" class="btn btn-sm btn-primary">Actualizar Datos</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <?php include_once 'inc/scripts.php'; ?>

    <script type="text/javascript">
        $(function(){

            $("#profileForm").submit(function(evt){
                evt.preventDefault();
                var $form = $(this);

                $.post(
                    'ajax_inicio.php',
                    $form.serialize(),
                    function(data){
                        if(data.success){
                            msg_success("Se actualizaron los datos correctamente");
                            $form.get(0).reset();
                        }else{
                            msg_error("Error: " + data.error);
                        }
                    },
                    'json'
                );
            });
        });
    </script>
</body>
</html>
