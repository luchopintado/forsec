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
             <h1 class="page-header">Articulos</h1>
             <div class="panel panel-primary">
                 <div class="panel-heading">Mantenimiento de Tabla: Articulos</div>
                 <div class="panel-body">
                     <div class="well well-sm row clearfix">
                         <div class="col-md-4">
                             <div class="input-group input-group-sm">
                                 <input type="text" aria-controls="tabla-article" placeholder="B&uacute;squeda" class="form-control input-sm" id="txt-filter-article">
                                 <span class="input-group-btn">
                                     <button id="btn-buscar" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                     <button id="btn-mostrar-todo" class="btn btn-sm btn-default" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                 </span>
                             </div>
                         </div>
                         <div class="col-md-8">
                             <div class="pull-right">
                                 <!--button type="button" class="btn btn-sm btn-primary" id="btn-nuevo"><i class="glyphicon glyphicon-file"></i> Nuevo </button-->
                                 <button type="button" class="btn btn-sm btn-default" id="btn-editar" data-loading-text="<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Cargando..."><i class="glyphicon glyphicon-pencil"></i> Editar </button>
                                 <!--button type="button" class="btn btn-sm btn-default" id="btn-eliminar"><i class="glyphicon glyphicon-trash"></i> Eliminar </button-->
                                 <button type="button" class="btn btn-sm btn-primary" id="btn-actualizar"><i class="glyphicon glyphicon-refresh"></i> Actualizar </button>
                             </div>
                         </div>
                     </div>
                     <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-condensed" id="tabla-article">
                        <thead>
                            <tr>
                               <th>article_id</th>
                               <th>Title</th>
                               <th>Description</th>
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

        <div class="modal fade" id="modal-confirmar-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-confirmar-eliminar-Article-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="modal-confirmar-eliminar-article-label">Confirmar eliminaci&oacute;n</h4>
                    </div>
                    <div class="modal-body">
                        <p>Estas a punto de eliminar un registro <strong>(<span class="nombre-registro"></span>)</strong>. Este proceso es irreversible.</p>
                        <p>Confirma la eliminaci&oacute;n?</p>
                        <p id="debug-url"></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hdn-modal-idxrow"/>
                        <input type="hidden" id="hdn-modal-confirmar-eliminar-valor" name="article-id" value=""/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="#" class="btn btn-danger" id="btn-confirmar-eliminar">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-nuevo-article" tabindex="-1" role="dialog" aria-labelledby="modal-nuevo-article-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
              <form class="form-horizontal" role="form" id="form-registrar-article" name="form-registrar-article" method="post" action="#">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title" id="modal-nuevo-article-label">Registrar nuevo Article</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-article-title">Title:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm" id="txt-article-title" name="article_title"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="txt-article-description">Description:</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control input-sm" id="txt-article-description" name="article_description" rows="10" required></textarea>
                                    </div>
                                </div>
                                <input type="hidden" id="hdn-article-id" name="article_id"/>
                                <input type="hidden" id="hdn-option" name="option" value=""/>
                          </div>
                      </div>
                  </div><!-- /modal-body -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button id="btn-registrar" title="Registrar Article" type="submit" class="btn btn-primary">Registrar</button>
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
                        {"mDataProp": "article_id", "bSearchable": false, "bVisible": false},
                        {"mDataProp": "article_title", "bSearchable": true},
                        {"mDataProp": "article_description", "bSearchable": true},
                        {"mDataProp": "article_user", "bSearchable": true, "bVisible": false}
                    ],
                    "bServerSide": true,
                    "sAjaxSource": "ajax_administrativo.php?option=listar_articles",
                };

                var $tabla_article     = $("#tabla-article");
                var $dt_tabla_article = $tabla_article.dataTable(dt_options);

                setTimeout(function(){
                    $("#tabla-article_filter input:text").addClass("form-control input-sm");
                    $("#tabla-article_length select").addClass("form-control input-sm");
                }, 500);

                $("#tabla-article tbody").on("click", "tr", function( e ) {
                    if ( $(this).hasClass('info') ) {
                        $(this).removeClass('info');
                    }else {
                        $dt_tabla_article.$('tr.info').removeClass('info');
                        $(this).addClass('info');
                    }
                });

                var $modal_nuevo_article = $("#modal-nuevo-article");
                var $modal_confirmar_eliminar = $("#modal-confirmar-eliminar");

                $("#btn-actualizar").click(function(evt){
                    evt.preventDefault();
                    $dt_tabla_article.fnStandingRedraw();
                });

                $("#btn-nuevo").click(function(evt){
                    evt.preventDefault();
                    $("#hdn-option").val("registrar_article");
                    $("#btn-registrar").html("Registrar");
                    $("#modal-nuevo-article-label").html("Registrar nuevo Article");
                    $("#modal-nuevo-article").modal("show");
                    $("#form-registrar-article").get(0).reset();
                });

                $("#btn-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_article );
                    if ( anSelected.length !== 0 ) {
                        evt.preventDefault();
                        var descripcion = $dt_tabla_article.fnGetData(anSelected[0], 1);
                        $modal_confirmar_eliminar.modal("show");
                        $modal_confirmar_eliminar.find("span.nombre-registro").html(descripcion);
                    }else{
                        msg_warning("Debe seleccionar un registro de la lista!");
                    }
                });

                $("#btn-confirmar-eliminar").click(function(evt){
                    var anSelected = fnGetSelected( $dt_tabla_article );
                    var id = $dt_tabla_article.fnGetData(anSelected[0], 0);
                    $.post(
                        'ajax_administrativo.php',
                        {
                            'option':'eliminar_article',
                            'article_id':id
                        },
                        function(data){
                            if(data.success){
                                $dt_tabla_article.fnDeleteRow( anSelected[0] );
                                $modal_confirmar_eliminar.modal("hide");
                            }else{
                                msg_error("Error al eliminar registro");
                            }
                        },
                        'json'
                    );
                });

                $("#btn-editar").click(function(){
                    var anSelected = fnGetSelected( $dt_tabla_article );
                    if (anSelected.length !== 0) {
                        $("#modal-nuevo-article-label").html("Actualizar Article");
                        var id = $dt_tabla_article.fnGetData(anSelected[0], 0);
                        $("#hdn-article-id").val(id);
                        var $btn = $(this);
                        $btn.button("loading");
                        $.post(
                            'ajax_administrativo.php',
                            {
                                'option':'editar_article',
                                'article_id':id
                            },
                            function(data){
                                $btn.button("reset");
                                if(data.article){
                                    var x = data.article;
                                    $("#hdn-article-id").val(x.article_id);
                                    $("#txt-article-title").val(x.article_title);
                                    var regex = /<br\s*[\/]?>/gi;
                                    var description = x.article_description.replace(regex, "\n")
                                    $("#txt-article-description").val(description);
                                    $("#hdn-option").val("actualizar_article");

                                    $("#btn-registrar").html("Actualizar");
                                    $("#modal-nuevo-article").modal("show");
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

                var $form = $("#form-registrar-article");
                $form.submit(function(evt){
                    evt.preventDefault();
                    $.post(
                        'ajax_administrativo.php',
                        $form.serialize(),
                        function(data){
                            if($("#hdn-option").val() == "actualizar_article"){
                                if(data.success){
                                    $modal_nuevo_article.modal("hide");
                                    $dt_tabla_article.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al actualizar registro");
                                }
                            }else{
                                if(data.article_id){
                                    $modal_nuevo_article.modal("hide");
                                    $dt_tabla_article.fnStandingRedraw();
                                    $form.get(0).reset();
                                }else{
                                    msg_error("Error al registrar article.");
                                }
                            }
                        },
                        'json'
                    );
                });

                /****************************************************/
                /****************************************************/
                var $txt_filter_article = $("#txt-filter-article");
                $txt_filter_article.keyup(function(e){
                    if (e.which <= 90 && e.which >= 48){
                        if ( this.value.length>2 ) {
                            $dt_tabla_article.fnFilter( this.value);
                        }
                    }
                });

                $("#btn-buscar").click(function(){
                    var valor = $txt_filter_article.val();
                    $dt_tabla_article.fnFilter(valor);
                });
                $("#btn-mostrar-todo").click(function(){
                    $txt_filter_article.val("");
                    $dt_tabla_article.fnFilter( this.value);
                });

                function fnGetSelected( oTableLocal ){
                    return oTableLocal.$("tr.info");
                }
            });
        </script>
    </body>
</html>
