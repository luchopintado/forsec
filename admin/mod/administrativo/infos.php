 <?php
    $stylesheets = array(
        'datatables.css',
        'toastr.min.css',
        'bootstrap-datepicker.min.css'
    );
    $scripts = array(
        'jquery.dataTables.min.js',
        'datatables.js',
        'moment.min.js',
        'bootstrap-datepicker.min.js',
        'bootstrap-datepicker.es.js',
        'toastr.min.js',
        'toaster_msgs.js',
    );
    ?>

    <?php include_once 'inc/head.php'; ?>
    <body>
        <?php include_once 'inc/header.php'; ?>

        <div class="container-fluid">
          <div class="col-sm-3 col-md-2 sidebar">
            <?php include_once 'inc/menu.php'; ?>
          </div>
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
             <h1 class="page-header">Información</h1>
             <div class="panel panel-primary">
                 <div class="panel-heading">Mantenimiento de Tabla: Información</div>
                 <div class="panel-body">
                     <div class="well well-sm row clearfix">
                         <div class="col-md-4">
                             <div class="input-group input-group-sm">
                                 <input type="text" aria-controls="tabla-info" placeholder="B&uacute;squeda" class="form-control input-sm" id="txt-filter-info">
                                 <span class="input-group-btn">
                                     <button id="btn-buscar" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                     <button id="btn-mostrar-todo" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                 </span>
                             </div>
                         </div>
                         <div class="col-md-8">
                             <div class="pull-right">
                                 <button type="button" class="btn btn-sm btn-default" id="btn-editar" data-loading-text="<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Cargando..."><i class="glyphicon glyphicon-pencil"></i> Editar </button>
                             </div>
                         </div>
                     </div>
                     <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla-info">
                        <thead>
                            <tr>
                               <th>info_id</th>
                               <th>Direccion</th>
                               <th>Telefono</th>
                               <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                      </div>
                  </div>
               </div>
            </div>
          </div>
       </div>

        <div class="modal fade" id="modal-confirmar-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-eliminar-Info-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="modal-confirmar-eliminar-info-label">Confirmar eliminaci&oacute;n</h4>
                    </div>
                    <div class="modal-body">
                        <p>Estas a punto de eliminar un registro <strong>(<span class="nombre-registro"></span>)</strong>. Este proceso es irreversible.</p>
                        <p>Confirma la eliminaci&oacute;n?</p>
                        <p id="debug-url"></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hdn-modal-idxrow"/>
                        <input type="hidden" id="hdn-modal-confirmar-eliminar-valor" name="info-id" value=""/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-danger" id="btn-confirmar-eliminar">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-nuevo-info" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-info-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
              <form class="form-horizontal" role="form" id="form-registrar-info" name="form-registrar-info" method="post" action="#">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title" id="modal-nuevo-info-label">Registrar nuevo Info</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-info-direccion">Direccion:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-info-direccion" name="info_direccion"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-info-telefono">Telefono:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-info-telefono" name="info_telefono"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-info-email">Email:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-info-email" name="info_email"  required>
                                    </div>
                                </div>
                                <input type="hidden" id="hdn-info-id" name="info_id"/>
                                <input type="hidden" id="hdn-option" name="option" value=""/>
                          </div>
                      </div>
                  </div><!-- /modal-body -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="btn-registrar" title="Registrar Info" type="submit" class="btn btn-primary">Registrar</button>
                  </div>
              </div>
             </form>
          </div>
        </div>

        <?php include_once 'inc/scripts.php';?>
        <script type="text/javascript">
            $(function() {
                //Esto es para evitar que cuando den enter los mande a otra pagina
                $("form").submit(function(evt){evt.preventDefault();});
                var dt_options = {
                    "sPaginationType": "bs_full",
                    "bProcessing": true,
                    "aoColumns": [
                        {"mDataProp": "info_id", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "info_direccion", "bSearchable": true},
                        {"mDataProp": "info_telefono", "bSearchable": true},
                        {"mDataProp": "info_email", "bSearchable": true},
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "ajax_administrativo.php?option=listar_infos"
                };

                var $tabla_info     = $("#tabla-info");
                var $dt_tabla_info = $tabla_info.dataTable(dt_options);

                setTimeout(function(){
                    $("#tabla-info_filter input:text").addClass("form-control input-sm");
                    $("#tabla-info_length select").addClass("form-control input-sm");
                }, 500);

                $("#tabla-info tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('info') ) {
                        $(this).removeClass('info');
                    }else {
                        $dt_tabla_info.$('tr.info').removeClass('info');
                        $(this).addClass('info');
                    }
                });

                var $modal_nuevo_info = $("#modal-nuevo-info");
                var $modal_confirmar_eliminar = $("#modal-confirmar-eliminar");

                $("#btn-actualizar").click(function(evt){
                    evt.preventDefault();
                    $dt_tabla_info.fnStandingRedraw();
                });

                $("#btn-nuevo").click(function(evt){
                    evt.preventDefault();
                    $("#hdn-option").val("registrar_info");
                    $("#btn-registrar").html("Registrar");
                    $("#modal-nuevo-info-label").html("Registrar nuevo Info");
                    $("#modal-nuevo-info").modal("show");
                    $("#form-registrar-info").get(0).reset();
                });

                $("#btn-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_info );
                    if ( anSelected.length !== 0 ) {
                        evt.preventDefault();
                        var descripcion = $dt_tabla_info.fnGetData(anSelected[0], 1);
                        $modal_confirmar_eliminar.modal("show");
                        $modal_confirmar_eliminar.find("span.nombre-registro").html(descripcion);
                    }else{
                        msg_warning("Debe seleccionar un registro de la lista!");
                    }
                });

                $("#btn-confirmar-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_info );
                    var id = $dt_tabla_info.fnGetData(anSelected[0], 0);
                    $.post(
                        'ajax_administrativo.php',
                        {
                            'option':'eliminar_info',
                            'info_id':id
                        },
                        function(data){
                            if(data.success){
                                $dt_tabla_info.fnDeleteRow( anSelected[0] );
                                $modal_confirmar_eliminar.modal("hide");
                            }else{
                                msg_error("Error al eliminar registro");
                            }
                        },
                        'json'
                    );
                });

                $("#btn-editar").click(function(){
                    var anSelected = fnGetSelected( $dt_tabla_info );
                    if (anSelected.length !== 0) {
                        $("#modal-nuevo-info-label").html("Actualizar Info");
                        var id = $dt_tabla_info.fnGetData(anSelected[0], 0);
                        $("#hdn-info-id").val(id);
                        var $btn = $(this);
                        $btn.button("loading");
                        $.post(
                            'ajax_administrativo.php',
                            {
                                'option':'editar_info',
                                'info_id':id
                            },
                            function(data){
                                $btn.button("reset");
                                if(data.info){
                                    var x = data.info;
                                    $("#hdn-info-id").val(x.info_id);
                                    $("#txt-info-direccion").val(x.info_direccion);
                                    $("#txt-info-telefono").val(x.info_telefono);
                                    $("#txt-info-email").val(x.info_email);
                                    $("#hdn-option").val("actualizar_info");

                                    $("#btn-registrar").html("Actualizar");
                                    $("#modal-nuevo-info").modal("show");
                                }else{
                                    msg_error("Error al cargar datos del registro");
                                }
                            },
                            'json'
                        );
                    }else{
                        msg_warning("Debe seleccionar un registro de la lista!");
                    }
                });

                var $form = $("#form-registrar-info");
                $form.submit(function(evt){
                    evt.preventDefault();
                    $.post(
                        'ajax_administrativo.php',
                        $form.serialize(),
                        function(data){
                            if($("#hdn-option").val() == "actualizar_info"){
                                if(data.success){
                                    $modal_nuevo_info.modal("hide");
                                    $dt_tabla_info.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al actualizar registro");
                                }
                            }else{
                                if(data.info_id){
                                    $modal_nuevo_info.modal("hide");
                                    $dt_tabla_info.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al registrar info.");
                                }
                            }
                        },
                        'json'
                    );
                });

                /****************************************************/
                /****************************************************/
                var $txt_filter_info = $("#txt-filter-info");
                $txt_filter_info.keyup(function(e){
                    if (e.which <= 90 && e.which >= 48){
                        if ( this.value.length>2 ) {
                            $dt_tabla_info.fnFilter( this.value);
                        }
                    }
                });

                $("#btn-buscar").click(function(){
                    var valor = $txt_filter_info.val();
                    $dt_tabla_info.fnFilter(valor);
                });
                $("#btn-mostrar-todo").click(function(){
                    $txt_filter_info.val("");
                    $dt_tabla_info.fnFilter( this.value);
                });

                function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.info");
                }
            });
        </script>
    </body>
</html>
