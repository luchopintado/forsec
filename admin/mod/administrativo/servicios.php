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
             <h1 class="page-header">Servicios</h1>
             <div class="panel panel-primary">
                 <div class="panel-heading">Mantenimiento de Tabla: Servicio</div>
                 <div class="panel-body">
                     <div class="well well-sm row clearfix">
                         <div class="col-md-4">
                             <div class="input-group input-group-sm">
                                 <input type="text" aria-controls="tabla-servicio" placeholder="B&uacute;squeda" class="form-control input-sm" id="txt-filter-servicio">
                                 <span class="input-group-btn">
                                     <button id="btn-buscar" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                     <button id="btn-mostrar-todo" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                 </span>
                             </div>
                         </div>
                         <div class="col-md-8">
                             <div class="pull-right">
                                 <button type="button" class="btn btn-sm btn-primary" id="btn-nuevo"><i class="glyphicon glyphicon-file"></i> Nuevo </button>
                                 <button type="button" class="btn btn-sm btn-default" id="btn-editar" data-loading-text="<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Cargando..."><i class="glyphicon glyphicon-pencil"></i> Editar </button>
                                 <button type="button" class="btn btn-sm btn-default" id="btn-eliminar"><i class="glyphicon glyphicon-trash"></i> Eliminar </button>
                                 <button type="button" class="btn btn-sm btn-primary" id="btn-actualizar"><i class="glyphicon glyphicon-refresh"></i> Actualizar </button>
                             </div>
                         </div>
                     </div>
                     <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla-servicio">
                        <thead>
                            <tr>
                               <th>servicio_id</th>
                               <th>Nombre</th>
                               <th>Descripcion</th>
                               <th>Fechareg</th>
                               <th>User</th>
                               <th>Imagen</th>
                               <th>Imagen</th>
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

        <div class="modal fade" id="modal-confirmar-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-eliminar-Servicio-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="modal-confirmar-eliminar-servicio-label">Confirmar eliminaci&oacute;n</h4>
                    </div>
                    <div class="modal-body">
                        <p>Estas a punto de eliminar un registro <strong>(<span class="nombre-registro"></span>)</strong>. Este proceso es irreversible.</p>
                        <p>Confirma la eliminaci&oacute;n?</p>
                        <p id="debug-url"></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hdn-modal-idxrow"/>
                        <input type="hidden" id="hdn-modal-confirmar-eliminar-valor" name="servicio-id" value=""/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-danger" id="btn-confirmar-eliminar">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-nuevo-servicio" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-servicio-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
              <form class="form-horizontal" role="form" id="form-registrar-servicio" name="form-registrar-servicio" method="post" action="#">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title" id="modal-nuevo-servicio-label">Registrar nuevo Servicio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-servicio-descripcion">Descripcion:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-servicio-descripcion" name="servicio_descripcion"  required>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="file-servicio-image">Image:</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control input-sm" id="file-servicio-image" name="servicio_image" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="file-servicio-thumb">Thumb:</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control input-sm" id="file-servicio-thumb" name="servicio_thumb" >
                                    </div>
                                </div>
                                <input type="hidden" id="hdn-servicio-id" name="servicio_id"/>
                                <input type="hidden" id="hdn-option" name="option" value=""/>
                          </div>
                      </div>
                  </div><!-- /modal-body -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="btn-registrar" title="Registrar Servicio" type="submit" class="btn btn-primary">Registrar</button>
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
                        {"mDataProp": "servicio_id", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "servicio_nombre", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "servicio_descripcion", "bSearchable": true},
                        {"mDataProp": "servicio_fechareg", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "servicio_user", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "servicio_image", "bSearchable": true, "bVisible": false},
                        {"mDataProp": "servicio_thumb", "bSearchable": false},
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "ajax_administrativo.php?option=listar_servicios",
                    "aoColumnDefs" :[
                        {
                            "fnRender": function ( oObj ) {                                
                                var img = oObj.aData["servicio_thumb"];
                                if (img) {
                                    return '<img src="../'+ img +'" class="img-responsive"/>';
                                } else {
                                    return 'No tiene imagen';
                                }
                            },
                            "aTargets": [6]
                        }
                    ]
                };

                var $tabla_servicio     = $("#tabla-servicio");
                var $dt_tabla_servicio = $tabla_servicio.dataTable(dt_options);

                setTimeout(function(){
                    $("#tabla-servicio_filter input:text").addClass("form-control input-sm");
                    $("#tabla-servicio_length select").addClass("form-control input-sm");
                }, 500);

                $("#tabla-servicio tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('info') ) {
                        $(this).removeClass('info');
                    }else {
                        $dt_tabla_servicio.$('tr.info').removeClass('info');
                        $(this).addClass('info');
                    }
                });

                var $modal_nuevo_servicio = $("#modal-nuevo-servicio");
                var $modal_confirmar_eliminar = $("#modal-confirmar-eliminar");

                $("#btn-actualizar").click(function(evt){
                    evt.preventDefault();
                    $dt_tabla_servicio.fnStandingRedraw();
                });

                $("#btn-nuevo").click(function(evt){
                    evt.preventDefault();
                    $("#hdn-option").val("registrar_servicio");
                    $("#btn-registrar").html("Registrar");
                    $("#modal-nuevo-servicio-label").html("Registrar nuevo Servicio");
                    $("#modal-nuevo-servicio").modal("show");
                    $("#form-registrar-servicio").get(0).reset();
                });

                $("#btn-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_servicio );
                    if ( anSelected.length !== 0 ) {
                        evt.preventDefault();
                        var descripcion = $dt_tabla_servicio.fnGetData(anSelected[0], 1);
                        $modal_confirmar_eliminar.modal("show");
                        $modal_confirmar_eliminar.find("span.nombre-registro").html(descripcion);
                    }else{
                        msg_warning("Debe seleccionar un registro de la lista!");
                    }
                });

                $("#btn-confirmar-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_servicio );
                    var id = $dt_tabla_servicio.fnGetData(anSelected[0], 0);
                    $.post(
                        'ajax_administrativo.php',
                        {
                            'option':'eliminar_servicio',
                            'servicio_id':id
                        },
                        function(data){
                            if(data.success){
                                $dt_tabla_servicio.fnDeleteRow( anSelected[0] );
                                $modal_confirmar_eliminar.modal("hide");
                            }else{
                                msg_error("Error al eliminar registro");
                            }
                        },
                        'json'
                    );
                });

                $("#btn-editar").click(function(){
                    var anSelected = fnGetSelected( $dt_tabla_servicio );
                    if (anSelected.length !== 0) {
                        $("#modal-nuevo-servicio-label").html("Actualizar Servicio");
                        var id = $dt_tabla_servicio.fnGetData(anSelected[0], 0);
                        $("#hdn-servicio-id").val(id);
                        var $btn = $(this);
                        $btn.button("loading");
                        $.post(
                            'ajax_administrativo.php',
                            {
                                'option':'editar_servicio',
                                'servicio_id':id
                            },
                            function(data){
                                $btn.button("reset");
                                if(data.servicio){
                                    var x = data.servicio;
                                    $("#hdn-servicio-id").val(x.servicio_id);
                                    $("#txt-servicio-nombre").val(x.servicio_nombre);
                                    $("#txt-servicio-descripcion").val(x.servicio_descripcion);
                                    $("#txt-servicio-fechareg").val(x.servicio_fechareg);
                                    $("#txt-servicio-user").val(x.servicio_user);
                                    $("#txt-servicio-image").val(x.servicio_image);
                                    $("#txt-servicio-thumb").val(x.servicio_thumb);
                                    $("#hdn-option").val("actualizar_servicio");

                                    $("#btn-registrar").html("Actualizar");
                                    $("#modal-nuevo-servicio").modal("show");
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

                var $form = $("#form-registrar-servicio");
                $form.submit(function(evt){

                    var $file_imagen = $("#file-servicio-image");
                    var $file_thumb = $("#file-servicio-thumb");
                    var formData = new FormData();
                    var form = $(this).get(0);
                    var fileInput, file;

                    if(formData){
                        fileInput = $file_imagen.get(0);
                        file = fileInput.files[0];
                        formData.append(fileInput.name, file);

                        fileInput = $file_thumb.get(0);
                        file = fileInput.files[0];
                        formData.append(fileInput.name, file);
                    }


                    for (i=0;i<form.elements.length;i++){
                        formData.append(form.elements[i].name, form.elements[i].value);
                    }

                    evt.preventDefault();

                    jQuery.ajax({
                        url: 'ajax_administrativo.php',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function(data){
                            if($("#hdn-option").val() == "actualizar_servicio"){
                                if(data.success){
                                    $modal_nuevo_servicio.modal("hide");
                                    $dt_tabla_servicio.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al actualizar registro");
                                }
                            }else{
                                var ojbSlide = $.parseJSON(data);
                                if(ojbSlide.slide_id){
                                    $modal_nuevo_servicio.modal("hide");
                                    $dt_tabla_servicio.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al guardar registro.");
                                }
                            }
                        }
                    });

                    
                });

                /****************************************************/
                /****************************************************/
                var $txt_filter_servicio = $("#txt-filter-servicio");
                $txt_filter_servicio.keyup(function(e){
                    if (e.which <= 90 && e.which >= 48){
                        if ( this.value.length>2 ) {
                            $dt_tabla_servicio.fnFilter( this.value);
                        }
                    }
                });

                $("#btn-buscar").click(function(){
                    var valor = $txt_filter_servicio.val();
                    $dt_tabla_servicio.fnFilter(valor);
                });
                $("#btn-mostrar-todo").click(function(){
                    $txt_filter_servicio.val("");
                    $dt_tabla_servicio.fnFilter( this.value);
                });

                function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.info");
                }
            });
        </script>
    </body>
</html>