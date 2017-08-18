<?php

session_start();

require './config.php';

$db = DB::getInstance();
$pdo = $db->dbh;
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");


$option = isset($_POST["option"]) ? $_POST["option"] : $_GET["option"];


switch($option){
    case "registrar_configuracion":
        registrar_configuracion();
        break;
    case "editar_configuracion":
        editar_configuracion();
        break;
    case "eliminar_configuracion":
        eliminar_configuracion();
        break;
    case "actualizar_configuracion":
        actualizar_configuracion();
        break;
    case "listar_configuracions":
        listar_configuracions();
        break;
    
    default:
        exit;
}

/*************************************************************************************************************/
/*  C   O   N   F   I   G   U   R   A   C   I  O   N
/*************************************************************************************************************/
function registrar_configuracion(){
    $configuracion = new Configuracion;
    $configuracion->storeFormValues($_POST);
    $idconfiguracion = $configuracion->insert();
    echo json_encode(array("configuracion_id"=>$idconfiguracion));
}
function eliminar_configuracion(){
    $configuracion = new Configuracion;
    $configuracion->storeFormValues($_POST);
    echo json_encode(array("success"=>$configuracion->delete()));
}
function editar_configuracion(){
    $idconfiguracion = $_POST["configuracion_id"];
    $configuracion = Configuracion::getById($idconfiguracion);
    echo json_encode(array("configuracion"=>$configuracion));
}
function actualizar_configuracion(){
    $configuracion = Configuracion::getById($_POST["configuracion_id"]);
    $configuracion->storeFormValues($_POST);
    echo json_encode(array("success"=>$configuracion->update()));
}
function listar_configuracions(){
    $start = $_GET['iDisplayStart']*1;
    $limit = $_GET['iDisplayLength']*1;
    $aColumns = array("id", "tipoCambio", "igv", "fecha");
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

    $configuraciones = Configuracion::getByFields($whereParams, $orderParams, $start, $limit);

    echo json_encode(array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $configuraciones["totalCount"]*1,
        "iTotalDisplayRecords" => $configuraciones["totalCount"]*1,
        "aaData" => $configuraciones["configuraciones"]
    ));
}

