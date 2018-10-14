/*
 * AJAX FORM: SERIALIZA EL FORMULARIO Y ADEMAS LE AGREGA LA DIRECCION DE LA CONTROLADORA Y METODO CORRESPONDIENTE.
 */
function ajaxForm(id_form, url , callback){
    id_form = '#'+id_form;
    $.ajax({
            type: "POST",
            url: url,
            data: $(id_form).serialize(),
            success: function (data) {
                if(callback.length === 1)
                    callback(data);
                else
                    callback();
            }
    });

}

/*
 * AJAX: UNICAMENTE AGREGA LA URL DE LA CONTROLADORA Y METODO CORRESPONDIENTE.
 */
function ajax(id,url,callback,type="POST",object){
    type = $.trim(type);
    if(type === "GET"){
        type='GET';
    }else type = "POST";
    id = '#'+id;
    $(id).on('click',()=>{
        $.ajax({
            type: type,
            url: url,
            data:object,
            success: function (data) {
                if(callback.length === 1)
                    callback(data);
                else
                    callback();
            }
        });
    })
}

function ajaxURL(url,callback,method='POST',object){
    method = $.trim(method);
    if(method === "GET"){
        method='GET';
    }else method = "POST";

    $.ajax({
        type: method,
        url: url,
        data: object,
        success: function (data) {
            if(callback.length === 1)
                callback(data);
            else
                callback();
        },
        error: function () {
            alert("NO SE PUDO CUMPLIR LA PETICION");
        }
    });
}
