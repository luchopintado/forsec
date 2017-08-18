function listar_clasepagos(cmbs, callback){
    $.post(
        'ajax_administrativo.php',
        {
            option: 'listar_simple_clasepagos'
        },
        function (data) {
            if (data.clasepagos) {
                var tpl = '<option value="">Seleccionar clase de pago</option>';
                $.each(data.clasepagos, function (i, e) {
                    tpl += '<option value="' + e.clasepago_id + '">' + e.clasepago_descripcion + '</option>';
                });

                $.each(cmbs, function (i, e) {
                    $("#" + e).html(tpl);
                });

                if(callback){
                    callback();
                }
            }
        },
        'json'
    );
}

function listar_periodos(cmbs, callback){
    $.post(
        'ajax_administrativo.php',
        {
            option: 'listar_simple_periodoescolar'
        },
        function(data){
            if(data.periodoescolares){
                var tpl = '<option value="">Seleccionar nivel de estudio...</option>';
                $.each(data.periodoescolares, function(i, e){
                    tpl += '<option value="'+e.periodoescolar_id+'">'+ e.periodoescolar_anio +'</option>';
                });

                $.each(cmbs, function (i, e) {
                    $("#" + e).html(tpl);
                });

                if(callback){
                    callback();
                }
            }
        },
        'json'
    );
}

function listar_nivelestudios(cmbs, callback){
    $.post(
        'ajax_administrativo.php',
        {
            option: 'listar_simple_nivelestudios'
        },
        function(data){
            if(data.nivelestudios){
                var tpl = '<option value="">Seleccionar nivel de estudio...</option>';
                $.each(data.nivelestudios, function(i, e){
                    tpl += '<option value="'+e.nivelestudio_id+'">'+ e.nivelestudio_descripcion +'</option>';
                });

                $.each(cmbs, function (i, e) {
                    $("#" + e).html(tpl);
                });

                if(callback){
                    callback();
                }
            }
        },
        'json'
    );
}
