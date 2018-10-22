function removeOfCart(id , promo=""){
    if(promo === "promo"){
      var url = '/compra/removeOfCartPromo/'+id;
    }else{
      var url = '/compra/removeOfCart/'+id;
    }
    console.log(url);
    ajaxURL(url, () => location.reload(),"GET");
}
ajax('btnClearCart',"/compra/clear", () => location.reload());

$(`#formCart :input[name="cantidad[]"]`).bind('keyup mouseup', function () {

    let quantity = $(this).val();

    let price = $(this).closest('td').prev().find('input').val();
    let idPlaza = $(this).closest('td').next().find('input[type="hidden"]').val();

    let obj = {q: quantity, id: idPlaza};
    ajaxURL('/compra/actualizarCantidad/', () => {} , "POST", obj);

    let $subtotal = $(this).closest('td').next().find('input[type="text"]');
    $subtotal.val( (price * quantity) );
    total();
});

function total(){
    let $inputTotal = $('#inputTotal');
    let total = 0;
    $('#bodyCart > tr').each(function () {
        let subtotal = $(this).find('input[name="subtotal[]"]').val();
        total +=  Number(subtotal);
        $inputTotal.val(total);
    });
    if($('#tbodyCartPromo').length){
      $('#tbodyCartPromo > tr').each(function () {
          let subtotal = $(this).find('input[name="subtotalPromo[]"]').val();
          total +=  Number(subtotal);
          $inputTotal.val(total);
      });
    }
    if(total === 0){
        $("#btnComprar").prop("disabled", "disabled");
        $("#btnClearCart").prop("disabled", "disabled");
    }
}

function verificarSesion(){
    ajaxURL("/cuenta/verificarSesionCliente", data => {
       let result = $.trim(data);
       if(result === 'success'){
            if($('#tbodyCartPromo').length){

              if($('#bodyCart').length){
                $('#formCart').attr('action','/compra/terminarConPromoYPlazas');
              }else{
                $('#formCart').attr('action','/compra/terminarConPromo');
              }

            }
           $('#formCart').submit();
       }else{
           $('#modalLoginForm').modal('toggle');
       }
    });
}


// CARRITO PROMOS

$(`#formCart :input[name="cantidadPromo[]"]`).bind('keyup mouseup', function () {

    let cantidad = $(this).val();

    let precio = $(this).closest('td').next().find('input').val();
    let descuento = $(this).closest('td').next().next().find('input').val();
    let $descuentoTotal = $(this).closest('td').next().next().next().find('input');
    let $subtotal = $(this).closest('td').next().next().next().next().find('input');

    let idPromo = $(this).closest('td').prev().find('input[type="hidden"]').val();

    //let obj = {q: cantidad, id: idPromo};
    //ajaxURL('/compra/actualizarCantidad/', () => {} , "POST", obj);
    $descuentoTotal.val(descuento * cantidad);
    $subtotal.val( ((precio * cantidad) - $descuentoTotal.val()) );
    total();
});

total();
