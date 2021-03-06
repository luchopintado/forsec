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
             <h1 class="page-header">Slides</h1>
             <div class="panel panel-primary">
                 <div class="panel-heading">Mantenimiento de Tabla: Slide</div>
                 <div class="panel-body">
                     <div class="well well-sm row clearfix">
                         <div class="col-md-4">
                             <div class="input-group input-group-sm">
                                 <input type="text" aria-controls="tabla-slide" placeholder="B&uacute;squeda" class="form-control input-sm" id="txt-filter-slide">
                                 <span class="input-group-btn">
                                     <button id="btn-buscar" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                     <button id="btn-mostrar-todo" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                 </span>
                             </div>
                         </div>
                         <div class="col-md-8">
                             <div class="pull-right">
                                 <button type="button" class="btn btn-sm btn-primary" id="btn-nuevo"><i class="glyphicon glyphicon-file"></i> Nuevo </button>
                                 <!--button type="button" class="btn btn-sm btn-default" id="btn-editar" data-loading-text="<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Cargando..."><i class="glyphicon glyphicon-pencil"></i> Editar </button-->
                                 <button type="button" class="btn btn-sm btn-default" id="btn-eliminar"><i class="glyphicon glyphicon-trash"></i> Eliminar </button>
                                 <button type="button" class="btn btn-sm btn-primary" id="btn-actualizar"><i class="glyphicon glyphicon-refresh"></i> Actualizar </button>
                             </div>
                         </div>
                     </div>
                     <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla-slide">
                        <thead>
                            <tr>
                               <th>slide_id</th>
                               <th>Name</th>
                               <th>Image</th>
                               <th>User</th>
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

        <div class="modal fade" id="modal-confirmar-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-eliminar-Slide-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="modal-confirmar-eliminar-slide-label">Confirmar eliminaci&oacute;n</h4>
                    </div>
                    <div class="modal-body">
                        <p>Estas a punto de eliminar un registro <strong>(<span class="nombre-registro"></span>)</strong>. Este proceso es irreversible.</p>
                        <p>Confirma la eliminaci&oacute;n?</p>
                        <p id="debug-url"></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hdn-modal-idxrow"/>
                        <input type="hidden" id="hdn-modal-confirmar-eliminar-valor" name="slide-id" value=""/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-danger" id="btn-confirmar-eliminar">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-nuevo-slide" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-slide-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
              <form class="form-horizontal" role="form" id="form-registrar-slide" name="form-registrar-slide" method="post" action="#">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title" id="modal-nuevo-slide-label">Registrar nuevo Slide</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-slide-section">Seccion:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" id="txt-slide-section" name="slide_section"  required>
                                            <option value="1">INICIO</option>
                                            <option value="2">SERVICIOS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-slide-name">Name:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-slide-name" name="slide_name"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-slide-image">Image:</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control input-sm" id="txt-slide-image" name="slide_image"  required>
                                    </div>
                                </div>

                                <input type="hidden" id="hdn-slide-id" name="slide_id"/>
                                <input type="hidden" id="hdn-option" name="option" value=""/>
                          </div>
                      </div>
                  </div><!-- /modal-body -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="btn-registrar" title="Registrar Slide" type="submit" class="btn btn-primary">Registrar</button>
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
                var sections = ['', 'INICIO', 'SERVICIOS'];
                var dt_options = {
                    "sPaginationType": "bs_full",
                    "bProcessing": true,
                    "aoColumns": [
                        {"mDataProp": "slide_id", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "slide_name", "bSearchable": true},
                        {"mDataProp": "slide_image", "bSearchable": true},
                        {"mDataProp": "slide_user", "bSearchable": true, "bVisible": false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "ajax_administrativo.php?option=listar_slides",
                    "aoColumnDefs" :[
                        {
                            "fnRender": function ( oObj ) {
                                console.log(oObj)
                                var name = oObj.aData["slide_name"];
                                var img = oObj.aData["slide_image"];
                                var idSection = oObj.aData["slide_section"] * 1;
                                var section = sections[idSection];
                                return  name + '<br/>[' + img + ']<br/><br/>' + section;
                            },
                            "aTargets": [1]
                        },
                        {
                            "fnRender": function ( oObj ) {
                                var img = oObj.aData["slide_image"];
                                return '<img src="../'+ img +'" class="img-responsive"/>';
                            },
                            "aTargets": [2]
                        }
                    ]
                };

                var $tabla_slide     = $("#tabla-slide");
                var $dt_tabla_slide = $tabla_slide.dataTable(dt_options);

                setTimeout(function(){
                    $("#tabla-slide_filter input:text").addClass("form-control input-sm");
                    $("#tabla-slide_length select").addClass("form-control input-sm");
                }, 500);

                $("#tabla-slide tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('info') ) {
                        $(this).removeClass('info');
                    }else {
                        $dt_tabla_slide.$('tr.info').removeClass('info');
                        $(this).addClass('info');
                    }
                });

                var $modal_nuevo_slide = $("#modal-nuevo-slide");
                var $modal_confirmar_eliminar = $("#modal-confirmar-eliminar");

                $("#btn-actualizar").click(function(evt){
                    evt.preventDefault();
                    $dt_tabla_slide.fnStandingRedraw();
                });

                $("#btn-nuevo").click(function(evt){
                    evt.preventDefault();
                    $("#hdn-option").val("registrar_slide");
                    $("#btn-registrar").html("Registrar");
                    $("#modal-nuevo-slide-label").html("Registrar nuevo Slide");
                    $("#modal-nuevo-slide").modal("show");
                    $("#form-registrar-slide").get(0).reset();
                });

                $("#btn-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_slide );
                    if ( anSelected.length !== 0 ) {
                        evt.preventDefault();
                        var descripcion = $dt_tabla_slide.fnGetData(anSelected[0], 1);
                        $modal_confirmar_eliminar.modal("show");
                        $modal_confirmar_eliminar.find("span.nombre-registro").html(descripcion);
                    }else{
                        msg_warning("Debe seleccionar un registro de la lista!");
                    }
                });

                $("#btn-confirmar-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_slide );
                    var id = $dt_tabla_slide.fnGetData(anSelected[0], 0);
                    $.post(
                        'ajax_administrativo.php',
                        {
                            'option':'eliminar_slide',
                            'slide_id':id
                        },
                        function(data){
                            if(data.success){
                                $dt_tabla_slide.fnDeleteRow( anSelected[0] );
                                $modal_confirmar_eliminar.modal("hide");
                            }else{
                                msg_error("Error al eliminar registro");
                            }
                        },
                        'json'
                    );
                });


                $("#btn-editar").click(function(){
                    var anSelected = fnGetSelected( $dt_tabla_slide );
                    if (anSelected.length !== 0) {
                        $("#modal-nuevo-slide-label").html("Actualizar Slide");
                        var id = $dt_tabla_slide.fnGetData(anSelected[0], 0);
                        $("#hdn-slide-id").val(id);
                        var $btn = $(this);
                        $btn.button("loading");
                        $.post(
                            'ajax_administrativo.php',
                            {
                                'option':'editar_slide',
                                'slide_id':id
                            },
                            function(data){
                                $btn.button("reset");
                                if(data.slide){
                                    var x = data.slide;
                                    $("#hdn-slide-id").val(x.slide_id);
                                    $("#txt-slide-name").val(x.slide_name);
                                    $("#hdn-option").val("actualizar_slide");

                                    $("#btn-registrar").html("Actualizar");
                                    $("#modal-nuevo-slide").modal("show");
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

                var $form = $("#form-registrar-slide");


                $form.submit(function(evt){
                    var $file_imagen = $(this).find('input:file');
                    var formData = new FormData();
                    var form = $(this).get(0);

                    if(formData){
                        var fileInput = $file_imagen.get(0);
                        var file = fileInput.files[0];
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
                            if($("#hdn-option").val() == "actualizar_slide"){
                                if(data.success){
                                    $modal_nuevo_slide.modal("hide");
                                    $dt_tabla_slide.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al actualizar registro");
                                }
                            }else{
                                var ojbSlide = $.parseJSON(data);
                                if(ojbSlide.slide_id){
                                    $modal_nuevo_slide.modal("hide");
                                    $dt_tabla_slide.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al registrar slide.");
                                }
                            }
                        }
                    });

                });

                /****************************************************/
                /****************************************************/
                var $txt_filter_slide = $("#txt-filter-slide");
                $txt_filter_slide.keyup(function(e){
                    if (e.which <= 90 && e.which >= 48){
                        if ( this.value.length>2 ) {
                            $dt_tabla_slide.fnFilter( this.value);
                        }
                    }
                });

                $("#btn-buscar").click(function(){
                    var valor = $txt_filter_slide.val();
                    $dt_tabla_slide.fnFilter(valor);
                });
                $("#btn-mostrar-todo").click(function(){
                    $txt_filter_slide.val("");
                    $dt_tabla_slide.fnFilter( this.value);
                });

                function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.info");
                }
            });
        </script>
    </body>
</html>
