<?php

class Fecha {

    var $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Novimbre', 'Diciembre');

    public static function Date2BD($fecha) {
        if (strpos($fecha, '/') !== false) {
            list($d, $m, $a) = explode("/", $fecha);
        }
        if (strpos($fecha, '-') !== false) {
            list($d, $m, $a) = explode("-", $fecha);
        }
        return $a . "-" . $m . "-" . $d;
    }

    public static function BD2date($fecha) {
        list($a, $m, $d) = explode("-", $fecha);
        return $d . "-" . $m . "-" . $a;
    }

    public static function getMeses(){
        return array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Novimbre', 'Diciembre');
    }

    public static function number2Month($mes){
        $meses = Fecha::getMeses();
        return $meses[$mes];
    }

}
