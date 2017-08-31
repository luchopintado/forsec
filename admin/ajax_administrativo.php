<?php

session_start();

require './config.php';

$db = DB::getInstance();
$pdo = $db->dbh;
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");


$option = isset($_POST["option"]) ? $_POST["option"] : $_GET["option"];

// var_dump($_POST);var_dump($_FILES);exit;

switch($option){

	case "registrar_article":
        registrar_article();
        break;
    case "editar_article":
        editar_article();
        break;
    case "eliminar_article":
        eliminar_article();
        break;
    case "actualizar_article":
        actualizar_article();
        break;
    case "listar_articles":
        listar_articles();
        break;



    case "registrar_slide":
        registrar_slide();
        break;
    case "editar_slide":
        editar_slide();
        break;
    case "eliminar_slide":
        eliminar_slide();
        break;
    case "actualizar_slide":
        actualizar_slide();
        break;
    case "listar_slides":
        listar_slides();
        break;


    case "registrar_cliente":
        registrar_cliente();
        break;
    case "editar_cliente":
        editar_cliente();
        break;
    case "eliminar_cliente":
        eliminar_cliente();
        break;
    case "actualizar_cliente":
        actualizar_cliente();
        break;
    case "listar_clientes":
        listar_clientes();
        break;

    case "registrar_servicio":
        registrar_servicio();
        break;
    case "editar_servicio":
        editar_servicio();
        break;
    case "eliminar_servicio":
        eliminar_servicio();
        break;
    case "actualizar_servicio":
        actualizar_servicio();
        break;
    case "listar_servicios":
        listar_servicios();
        break;


    case "registrar_obra":
        registrar_obra();
        break;
    case "editar_obra":
        editar_obra();
        break;
    case "eliminar_obra":
        eliminar_obra();
        break;
    case "actualizar_obra":
        actualizar_obra();
        break;
    case "listar_obras":
        listar_obras();
        break;



    case "registrar_user":
        registrar_user();
        break;
    case "editar_user":
        editar_user();
        break;
    case "eliminar_user":
        eliminar_user();
        break;
    case "actualizar_user":
        actualizar_user();
        break;
    case "listar_users":
        listar_users();
        break;


    default:
        exit;
}



/*************************************************************************************************************/
/*************************************************************************************************************/
function registrar_article(){
    $article = new Article;
    $article->storeFormValues($_POST);
    $article->article_user = $_SESSION["user"]["id"];
    $idarticle = $article->insert();
    echo json_encode(array("article_id"=>$idarticle));
}
function eliminar_article(){
    $article = new Article;
    $article->storeFormValues($_POST);
    echo json_encode(array("success"=>$article->delete()));
}
function editar_article(){
    $idarticle = $_POST["article_id"];
    $article = Article::getById($idarticle);
    echo json_encode(array("article"=>$article));
}
function actualizar_article(){
    $article = Article::getById($_POST["article_id"]);
    $article->storeFormValues($_POST);
    $article->article_user = $_SESSION["user"]["id"];
    $article->article_description = nl2br($_POST["article_description"]);
    echo json_encode(array("success"=>$article->update()));
}
function listar_articles(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("article_id", "article_title", "article_description", "article_user");
    $whereParams = array();
    $orderParams = array();
    if ( isset( $_GET['iSortCol_0'] ) ){
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                $orderParams[] = array(
                    "field"=>$aColumns[ intval( $_GET['iSortCol_'.$i] ) ],
                    "order"=> $_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'
                );
            }
        }
    }

    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ){
                $whereParams[] = array(
                    "field"=>$aColumns[$i],
                    "operator"=>"LIKE",
                    "value"=>$_GET['sSearch'],
                    "conjunction"=>"OR"
                );
            }
        }
    }

    $articles = Article::getByFields($whereParams, $orderParams, $start, $limit);

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $articles["totalCount"]*1,
        "iTotalDisplayRecords" => $articles["totalCount"]*1,
        "aaData" => $articles["articles"]
    ));
}



/*************************************************************************************************************/
/*************************************************************************************************************/
function registrar_slide(){
    include_once './extras/class.upload.php';
    $error_documento = "";
    $dir_dest = '../img/slides/';

    if($_FILES["slide_image"]){
        $uploadedFile = new Upload($_FILES['slide_image']);

        if ($uploadedFile->uploaded) {
            $uploadedFile->Process($dir_dest);

            if(!$uploadedFile->processed){
                $error_documento = $uploadedFile->error;
            }else{
                $ruta_documento = $uploadedFile->file_dst_name;
            }
        }else{
            $error_documento = "Error al cargar archivo al servidor";
        }
    }

    // echo json_encode(array("slide_id"=>0, "file_dst_path"=>$uploadedFile->file_dst_path ));return;

    $ruta_documento = $dir_dest . $ruta_documento;

    $slide = new Slide;
    $slide->storeFormValues($_POST);
    $slide->slide_image = substr($ruta_documento, 3);
    $slide->slide_user = $_SESSION["user"]["id"];

    $idslide = $slide->insert();
    echo json_encode(array("slide_id"=>$idslide, "error_documento"=>$error_documento));
}
function eliminar_slide(){
    $slide = new Slide;
    $slide->storeFormValues($_POST);
    echo json_encode(array("success"=>$slide->delete()));
}
function editar_slide(){
    $idslide = $_POST["slide_id"];
    $slide = Slide::getById($idslide);
    echo json_encode(array("slide"=>$slide));
}
function actualizar_slide(){
    $slide = Slide::getById($_POST["slide_id"]);
    $slide->storeFormValues($_POST);
    echo json_encode(array("success"=>$slide->update()));
}
function listar_slides(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("slide_id", "slide_name", "slide_image", "slide_user");
    $whereParams = array();
    $orderParams = array();
    if ( isset( $_GET['iSortCol_0'] ) ){
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                $orderParams[] = array(
                    "field"=>$aColumns[ intval( $_GET['iSortCol_'.$i] ) ],
                    "order"=> $_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'
                );
            }
        }
    }

    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ){
                $whereParams[] = array(
                    "field"=>$aColumns[$i],
                    "operator"=>"LIKE",
                    "value"=>$_GET['sSearch'],
                    "conjunction"=>"OR"
                );
            }
        }
    }

    $section = isset($_POST["slide_section"]) ? $_POST["slide_section"] : 1;

    $whereParams[] = array("field"=>"slide_section", "operator"=>"=", "value"=>$section);

    $slides = Slide::getByFields($whereParams, $orderParams, $start, $limit);

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $slides["totalCount"]*1,
        "iTotalDisplayRecords" => $slides["totalCount"]*1,
        "aaData" => $slides["slides"]
    ));
}



/*************************************************************************************************************/
/*************************************************************************************************************/
function registrar_user(){
    $user = new User;
    $user->storeFormValues($_POST);
    $iduser = $user->insert();
    echo json_encode(array("user_id"=>$iduser));
}
function eliminar_user(){
    $user = new User;
    $user->storeFormValues($_POST);
    echo json_encode(array("success"=>$user->delete()));
}
function editar_user(){
    $iduser = $_POST["user_id"];
    $user = User::getById($iduser);
    echo json_encode(array("user"=>$user));
}
function actualizar_user(){
    $user = User::getById($_POST["user_id"]);
    $user->storeFormValues($_POST);
    echo json_encode(array("success"=>$user->update()));
}
function listar_users(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("user_id", "user_nick", "user_pass", "user_email");
    $whereParams = array();
    $orderParams = array();
    if ( isset( $_GET['iSortCol_0'] ) ){
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                $orderParams[] = array(
                    "field"=>$aColumns[ intval( $_GET['iSortCol_'.$i] ) ],
                    "order"=> $_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'
                );
            }
        }
    }

    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ){
                $whereParams[] = array(
                    "field"=>$aColumns[$i],
                    "operator"=>"LIKE",
                    "value"=>$_GET['sSearch'],
                    "conjunction"=>"OR"
                );
            }
        }
    }

    $users = User::getByFields($whereParams, $orderParams, $start, $limit);
    //echo json_encode($users);return;

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $users["totalCount"]*1,
        "iTotalDisplayRecords" => $users["totalCount"]*1,
        "aaData" => $users["useres"]
    ));
}

/*************************************************************************************************************/
/*************************************************************************************************************/
function registrar_cliente(){
    $cliente = new Cliente;
    $cliente->storeFormValues($_POST);
    $idcliente = $cliente->insert();
    echo json_encode(array("cliente_id"=>$idcliente));
}
function eliminar_cliente(){
    $cliente = new Cliente;
    $cliente->storeFormValues($_POST);
    echo json_encode(array("success"=>$cliente->delete()));
}
function editar_cliente(){
    $idcliente = $_POST["cliente_id"];
    $cliente = Cliente::getById($idcliente);
    echo json_encode(array("cliente"=>$cliente));
}
function actualizar_cliente(){
    $idcliente = $_POST["cliente_id"];
    $cliente = Cliente::getById($idcliente);
    $cliente->storeFormValues($_POST);
    echo json_encode(array("success"=>$cliente->update()));
}
function listar_clientes(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("cliente_id", "cliente_razon", "cliente_fechareg", "cliente_user");
    $whereParams = array();
    $orderParams = array();
    if ( isset( $_GET['iSortCol_0'] ) ){
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                $orderParams[] = array(
                    "field"=>$aColumns[ intval( $_GET['iSortCol_'.$i] ) ],
                    "order"=> $_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'
                );
            }
        }
    }

    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ){
                $whereParams[] = array(
                    "field"=>$aColumns[$i],
                    "operator"=>"LIKE",
                    "value"=>$_GET['sSearch'],
                    "conjunction"=>"OR"
                );
            }
        }
    }

    $clientes = Cliente::getByFields($whereParams, $orderParams, $start, $limit);

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $clientes["totalCount"]*1,
        "iTotalDisplayRecords" => $clientes["totalCount"]*1,
        "aaData" => $clientes["clientes"]
    ));
}


/*************************************************************************************************************/
/*************************************************************************************************************/
function registrar_servicio(){
    $servicio = new Servicio;
    $servicio->storeFormValues($_POST);
    $idservicio = $servicio->insert();
    echo json_encode(array("servicio_id"=>$idservicio));
}
function eliminar_servicio(){
    $servicio = new Servicio;
    $servicio->storeFormValues($_POST);
    echo json_encode(array("success"=>$servicio->delete()));
}
function editar_servicio(){
    $idservicio = $_POST["servicio_id"];
    $servicio = Servicio::getById($idservicio);
    echo json_encode(array("servicio"=>$servicio));
}
function actualizar_servicio(){
    $idservicio = $_POST["servicio_id"];
    $servicio = Servicio::getById($idservicio);
    $servicio->storeFormValues($_POST);
    echo json_encode(array("success"=>$servicio->update()));
}
function listar_servicios(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("servicio_id", "servicio_nombre", "servicio_descripcion", "servicio_fechareg", "servicio_user");
    $whereParams = array();
    $orderParams = array();
    if ( isset( $_GET['iSortCol_0'] ) ){
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                $orderParams[] = array(
                    "field"=>$aColumns[ intval( $_GET['iSortCol_'.$i] ) ],
                    "order"=> $_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'
                );
            }
        }
    }

    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ){
                $whereParams[] = array(
                    "field"=>$aColumns[$i],
                    "operator"=>"LIKE",
                    "value"=>$_GET['sSearch'],
                    "conjunction"=>"OR"
                );
            }
        }
    }

    $servicios = Servicio::getByFields($whereParams, $orderParams, $start, $limit);

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $servicios["totalCount"]*1,
        "iTotalDisplayRecords" => $servicios["totalCount"]*1,
        "aaData" => $servicios["servicios"]
    ));
}


/*************************************************************************************************************/
/*************************************************************************************************************/
function registrar_obra(){
        include_once './extras/class.upload.php';
    $error_documento = "";
    $dir_dest = '../img/';

    if($_FILES["obra_imagen"]){
        $uploadedFile = new Upload($_FILES['obra_imagen']);

        if ($uploadedFile->uploaded) {
            $uploadedFile->Process($dir_dest);

            if(!$uploadedFile->processed){
                $error_documento = $uploadedFile->error;
            }else{
                $ruta_documento = $uploadedFile->file_dst_name;
            }
        }else{
            $error_documento = "Error al cargar archivo al servidor";
        }
    }

    // echo json_encode(array("slide_id"=>0, "file_dst_path"=>$uploadedFile->file_dst_path ));return;

    $ruta_documento = $dir_dest . $ruta_documento;

    $obra = new Obra;
    $obra->storeFormValues($_POST);
    $obra->obra_imagen = substr($ruta_documento, 3);
    $obra->obra_user = $_SESSION["user"]["id"];

    $idobra = $obra->insert();
    echo json_encode(array("obra_id"=>$idobra, "error_documento"=>$error_documento));
}
function eliminar_obra(){
    $obra = new Obra;
    $obra->storeFormValues($_POST);
    echo json_encode(array("success"=>$obra->delete()));
}
function editar_obra(){
    $idobra = $_POST["obra_id"];
    $obra = Obra::getById($idobra);
    echo json_encode(array("obra"=>$obra));
}
function actualizar_obra(){
    $idobra = $_POST["obra_id"];
    $obra = Obra::getById($idobra);
    $obra->storeFormValues($_POST);
    echo json_encode(array("success"=>$obra->update()));
}
function listar_obras(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("obra_id", "obra_nombre", "obra_descripcion", "obra_plazo", "obra_cliente", "obra_participacion", "obra_fechareg", "obra_tipo", "obra_periodo", "obra_user");
    $whereParams = array();
    $orderParams = array();
    if ( isset( $_GET['iSortCol_0'] ) ){
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                $orderParams[] = array(
                    "field"=>$aColumns[ intval( $_GET['iSortCol_'.$i] ) ],
                    "order"=> $_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc'
                );
            }
        }
    }

    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ){
        for ( $i=0 ; $i<count($aColumns) ; $i++ ){
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ){
                $whereParams[] = array(
                    "field"=>$aColumns[$i],
                    "operator"=>"LIKE",
                    "value"=>$_GET['sSearch'],
                    "conjunction"=>"OR"
                );
            }
        }
    }

    $tipo = isset($_POST["obra_tipo"]) ? $_POST["obra_tipo"] * 1 : 0;
    if ($tipo) {
        $whereParams[] = array("field"=>"obra_tipo", "operator"=>"=", "value"=>$tipo);
    }
    $obras = Obra::getByFields($whereParams, $orderParams, $start, $limit);

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $obras["totalCount"]*1,
        "iTotalDisplayRecords" => $obras["totalCount"]*1,
        "aaData" => $obras["obras"]
    ));
}
