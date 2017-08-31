<?php

session_start();

require 'config.php';

$db = DB::getInstance();
$pdo = $db->dbh;
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");


if($_SESSION["login"] != 'ok'){
    header('Location: login.php');
    exit;
}

$_SESSION["modulo"] = "administrativo";
$option = $_GET["option"];

switch ($option) {
    case 'articulos':
        articulos();
        break;
    case 'slides':
        slides();
        break;
    case 'usuarios':
        usuarios();
        break;
    case 'servicios':
        servicios();
        break;
    case 'clientes':
        clientes();
        break;
    case 'obras':
        obras();
        break;
    case 'infos':
        infos();
        break;


    default:
        echo 'Error en la URL';
        break;
}


function articulos(){
    $titulo = "Mantenimiento de Tabla Articulos";
    $menu = 'articulos';
    require './mod/administrativo/articulos.php';
}
function slides(){
    $titulo = "Mantenimiento de Tabla Slide";
    $menu = 'slides';
    require './mod/administrativo/slides.php';
}
function usuarios(){
    $titulo = "Registrar Usuarios";
    $menu = "usuarios";
    require './mod/administrativo/usuarios.php';
}
function servicios(){
    $titulo = "Registrar Servicios";
    $menu = "servicios";
    require './mod/administrativo/servicios.php';
}
function clientes(){
    $titulo = "Registrar Clientes";
    $menu = "clientes";
    require './mod/administrativo/clientes.php';
}
function obras(){
    $titulo = "Registrar Obras";
    $menu = "obras";
    require './mod/administrativo/obras.php';
}
function infos(){
    $titulo = "Registrar Información";
    $menu = "infos";
    require './mod/administrativo/infos.php';
}
