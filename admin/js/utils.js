function getFormAsObject($el) {
    var paramObj = {};
    $.each($el.serializeArray(), function (_, kv) {
        if (paramObj.hasOwnProperty(kv.name)) {
            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
            paramObj[kv.name].push(kv.value);
        }
        else {
            paramObj[kv.name] = kv.value;
        }
    });
    return paramObj;
}

function collectObjects() {
    var ret = {};
    for (var i = 0; i < arguments.length; i++) {
        for (p in arguments[i]) {
            if (arguments[i].hasOwnProperty(p)) {
                ret[p] = arguments[i][p];
            }
        }
    }
    return ret;
}

function formatCurrency(num) {
    return parseFloat(Math.round(num * 100) / 100).toFixed(2);
}

function formatSerie(numero, numceros) {
    var str = "" + numero;
    var pad = '';
    for (i = 0; i < numceros; i++) {
        pad += '0';
    }
    return pad.substring(0, pad.length - str.length) + str;
}


function popup(url, ancho, alto) {
    console.log("popup");
    var posicion_x;
    var posicion_y;
    posicion_x = (screen.width / 2) - (ancho / 2);
    posicion_y = (screen.height / 2) - (alto / 2);
    window.open(url, "IEP PESTALOZZI", "width=" + ancho + ",height=" + alto + ",menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left=" + posicion_x + ",top=" + posicion_y + "");
}


var PARENTEZCOS = [
    {id: 1, parentezco: 'Padre'},
    {id: 2, parentezco: 'Madre'},
    {id: 3, parentezco: 'Hermano'},
    {id: 4, parentezco: 'Tio'},
    {id: 5, parentezco: 'Abuelo'},
    {id: 6, parentezco: 'Apoderado'}
];
function getParentezco(id) {
    for (i = 0; i < PARENTEZCOS.length; i++) {
        if (PARENTEZCOS[i].id == id) {
            return PARENTEZCOS[i].parentezco;
        }
    }
}