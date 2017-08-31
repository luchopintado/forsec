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
             <h1 class="page-header">Obras</h1>
             <div class="panel panel-primary">
                 <div class="panel-heading">Mantenimiento de Tabla: Obra</div>
                 <div class="panel-body">
                     <div class="well well-sm row clearfix">
                         <div class="col-md-4">
                             <div class="input-group input-group-sm">
                                 <input type="text" aria-controls="tabla-obra" placeholder="B&uacute;squeda" class="form-control input-sm" id="txt-filter-obra">
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
                     <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla-obra">
                        <thead>
                            <tr>
                               <th>obra_id</th>
                               <th>Nombre</th>
                               <th>Descripcion</th>
                               <th>Fechareg</th>
                               <th>User</th>
                               <th>Imagen</th>
                               <th>Layout</th>
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

        <div class="modal fade" id="modal-confirmar-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-eliminar-Obra-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="modal-confirmar-eliminar-obra-label">Confirmar eliminaci&oacute;n</h4>
                    </div>
                    <div class="modal-body">
                        <p>Estas a punto de eliminar un registro <strong>(<span class="nombre-registro"></span>)</strong>. Este proceso es irreversible.</p>
                        <p>Confirma la eliminaci&oacute;n?</p>
                        <p id="debug-url"></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hdn-modal-idxrow"/>
                        <input type="hidden" id="hdn-modal-confirmar-eliminar-valor" name="obra-id" value=""/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-danger" id="btn-confirmar-eliminar">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-nuevo-obra" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-obra-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
              <form class="form-horizontal" role="form" id="form-registrar-obra" name="form-registrar-obra" method="post" action="#">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title" id="modal-nuevo-obra-label">Registrar nuevo Obra</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-obra-descripcion">Descripcion:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-obra-descripcion" name="obra_descripcion" >
                                    </div>
                                </div>
                              
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="file-obra-imagen">Imagen:</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control input-sm" id="file-obra-imagen" name="obra_imagen"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="cmb-obra-layout">Layout:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" id="cmb-obra-layout" name="obra_layout"  required></select>
                                    </div>
                                </div>
                                <input type="hidden" id="hdn-obra-id" name="obra_id"/>
                                <input type="hidden" id="hdn-option" name="option" value=""/>
                          </div>
                      </div>
                  </div><!-- /modal-body -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="btn-registrar" title="Registrar Obra" type="submit" class="btn btn-primary">Registrar</button>
                  </div>
              </div>
             </form>
          </div>
        </div>

        <?php include_once 'inc/scripts.php';?>
        <script type="text/javascript">
            $(function() {
                var LAYOUTS = ['', 'Cuadrado', 'Vertical', 'Horizontal'];
                //Esto es para evitar que cuando den enter los mande a otra pagina
                $("form").submit(function(evt){evt.preventDefault();});

                $.each(LAYOUTS, function(idx, el){
                    if (idx > 0) {
                        $("#cmb-obra-layout").append('<option value="'+ idx +'">'+ el +'</option>');
                    }
                });

                var dt_options = {
                    "sPaginationType": "bs_full",
                    "bProcessing": true,
                    "aoColumns": [
                        {"mDataProp": "obra_id", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "obra_nombre", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "obra_descripcion", "bSearchable": true},
                        {"mDataProp": "obra_fechareg", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "obra_user", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "obra_layout", "bSearchable": true},
                        {"mDataProp": "obra_imagen", "bSearchable": true}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "ajax_administrativo.php?option=listar_obras",
                    "aoColumnDefs" :[
                        {
                            "fnRender": function ( oObj ) {                                
                                var img = oObj.aData["obra_imagen"];
                                if (img) {
                                    return '<img src="../'+ img +'" class="img-responsive"/>';
                                } else {
                                    return 'No tiene imagen';
                                }
                            },
                            "aTargets": [6]
                        },
                        {
                            "fnRender": function ( oObj ) {                                
                                var layout = oObj.aData["obra_layout"] * 1 || 0;                                
                                return LAYOUTS[layout];
                            },
                            "aTargets": [5]
                        }
                    ]

                };

                var $tabla_obra     = $("#tabla-obra");
                var $dt_tabla_obra = $tabla_obra.dataTable(dt_options);

                setTimeout(function(){
                    $("#tabla-obra_filter input:text").addClass("form-control input-sm");
                    $("#tabla-obra_length select").addClass("form-control input-sm");
                }, 500);

                $("#tabla-obra tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('info') ) {
                        $(this).removeClass('info');
                    }else {
                        $dt_tabla_obra.$('tr.info').removeClass('info');
                        $(this).addClass('info');
                    }
                });

                var $modal_nuevo_obra = $("#modal-nuevo-obra");
                var $modal_confirmar_eliminar = $("#modal-confirmar-eliminar");

                $("#btn-actualizar").click(function(evt){
                    evt.preventDefault();
                    $dt_tabla_obra.fnStandingRedraw();
                });

                $("#btn-nuevo").click(function(evt){
                    evt.preventDefault();
                    $("#hdn-option").val("registrar_obra");
                    $("#btn-registrar").html("Registrar");
                    $("#modal-nuevo-obra-label").html("Registrar nuevo Obra");
                    $("#modal-nuevo-obra").modal("show");
                    $("#form-registrar-obra").get(0).reset();
                });

                $("#btn-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_obra );
                    if ( anSelected.length !== 0 ) {
                        evt.preventDefault();
                        var descripcion = $dt_tabla_obra.fnGetData(anSelected[0], 1);
                        $modal_confirmar_eliminar.modal("show");
                        $modal_confirmar_eliminar.find("span.nombre-registro").html(descripcion);
                    }else{
                        msg_warning("Debe seleccionar un registro de la lista!");
                    }
                });

                $("#btn-confirmar-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_obra );
                    var id = $dt_tabla_obra.fnGetData(anSelected[0], 0);
                    $.post(
                        'ajax_administrativo.php',
                        {
                            'option':'eliminar_obra',
                            'obra_id':id
                        },
                        function(data){
                            if(data.success){
                                $dt_tabla_obra.fnDeleteRow( anSelected[0] );
                                $modal_confirmar_eliminar.modal("hide");
                            }else{
                                msg_error("Error al eliminar registro");
                            }
                        },
                        'json'
                    );
                });

                $("#btn-editar").click(function(){
                    var anSelected = fnGetSelected( $dt_tabla_obra );
                    if (anSelected.length !== 0) {
                        $("#modal-nuevo-obra-label").html("Actualizar Obra");
                        var id = $dt_tabla_obra.fnGetData(anSelected[0], 0);
                        $("#hdn-obra-id").val(id);
                        var $btn = $(this);
                        $btn.button("loading");
                        $.post(
                            'ajax_administrativo.php',
                            {
                                'option':'editar_obra',
                                'obra_id':id
                            },
                            function(data){
                                $btn.button("reset");
                                if(data.obra){
                                    var x = data.obra;
                                    $("#hdn-obra-id").val(x.obra_id);
                                    $("#txt-obra-descripcion").val(x.obra_descripcion);
                                    $("#txt-obra-imagen").val(x.obra_imagen);
                                    $("#cmb-obra-layout").val(x.obra_layout);
                                    $("#hdn-option").val("actualizar_obra");

                                    $("#btn-registrar").html("Actualizar");
                                    $("#modal-nuevo-obra").modal("show");
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

                var $form = $("#form-registrar-obra");
                $form.submit(function(evt){
                    evt.preventDefault();
                    $.post(
                        'ajax_administrativo.php',
                        $form.serialize(),
                        function(data){
                            if($("#hdn-option").val() == "actualizar_obra"){
                                if(data.success){
                                    $modal_nuevo_obra.modal("hide");
                                    $dt_tabla_obra.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al actualizar registro");
                                }
                            }else{
                                if(data.obra_id){
                                    $modal_nuevo_obra.modal("hide");
                                    $dt_tabla_obra.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al registrar obra.");
                                }
                            }
                        },
                        'json'
                    );
                });

                /****************************************************/
                /****************************************************/
                var $txt_filter_obra = $("#txt-filter-obra");
                $txt_filter_obra.keyup(function(e){
                    if (e.which <= 90 && e.which >= 48){
                        if ( this.value.length>2 ) {
                            $dt_tabla_obra.fnFilter( this.value);
                        }
                    }
                });

                $("#btn-buscar").click(function(){
                    var valor = $txt_filter_obra.val();
                    $dt_tabla_obra.fnFilter(valor);
                });
                $("#btn-mostrar-todo").click(function(){
                    $txt_filter_obra.val("");
                    $dt_tabla_obra.fnFilter( this.value);
                });

                function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.info");
                }
            });
        </script>
    </body>
</html>
