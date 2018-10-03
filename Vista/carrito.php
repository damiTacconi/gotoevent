
<?php
if(!empty($_SESSION['cart'])){
    $carrito = $_SESSION['cart'];
    $items = json_decode(json_encode($carrito, FALSE));
}
?>
<!-- Modal: modalCart -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="/compra/terminar" method="post" class="form modal-content" id="formCart">
            <!--Header-->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mi Carrito</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body table-responsive">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Fecha</th>
                            <th>Sede</th>
                            <th>Plaza</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="bodyCart">
                    <?php if(isset($items)) {
                        foreach($items as $key => $item) {
                            $plaza = $item->plazaEvento;

                            ?>
                            <tr>
                                <th scope="row"><?= $plaza->calendario->evento->titulo ?> </th>
                                <td><?= $plaza->calendario->fecha ?></td>
                                <td><?= $plaza->sede->nombre ?></td>
                                <td><?= $plaza->plaza->descripcion ?></td>
                                <td>
                                    <input type="number" name="precio[]" class="form-control"
                                           value="<?= $plaza->precio ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" name="cantidad[]" style="width: 60px;"
                                           class="form-control" min="1" max="5" onkeydown="return false"
                                           value="<?= $item->cantidad ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="subtotal[]"
                                           value="<?= $item->cantidad * $plaza->precio ?>" readonly>
                                    <input type="hidden" name="id_plazaEvento[]" value="<?= $plaza->id_plazaEvento ?>">
                                </td>
                                <td><a onclick="removeOfCart(<?= $key ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>

                    <?php } ?>
                    </tbody>
                </table>
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <label for="inputTotal">TOTAL</label>
                            <input type="text" name="total" style="width: 150px" class="form-control" id="inputTotal" value="0" readonly>
                        </div>
                    </div>
                </div>

            </div>
            <!--Footer-->
            <div class="modal-footer">
                <button id="btnClearCart" type="button" class="btn btn-outline-secondary float-left btn-sm">VACIAR</button>
                <button type="button" onclick="verificarSesion()" id="btnComprar" class="btn btn-primary float-right btn-md">COMPRAR</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal: modalCart -->

<!-- MODAL LOGIN -->
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">LOGUEATE PARA COMPRAR</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <?php include URL_VISTA . 'login.php' ?>
            </div>
        </div>
    </div>
</div>

<!-- FIN MODAL LOGIN -->
<script type="text/javascript">
    function removeOfCart(id){
        let url = '/compra/removeOfCart/'+id;
        ajaxURL(url, () => location.reload(),"GET");
    }
    ajax('btnClearCart',"/compra/clear", () => location.reload());

    $(`#formCart :input[name="cantidad[]"]`).bind('keyup mouseup', function () {
        let quantity = $(this).val();
        let price = $(this).closest('td').prev().find('input').val();
        let idPlaza = $(this).closest('td').next().find('input[type="hidden"]').val();
        let $subtotal = $(this).closest('td').next().find('input[type="text"]');
        $subtotal.val( (price * quantity) );
        total();
    });

    function total(){
        let $inputTotal = $('#inputTotal');
        let total = 0;
        $('#bodyCart > tr').each(function () {
            let precio = $(this).find('input[name="precio[]"]').val();
            let cantidad = $(this).find('input[name="cantidad[]"]').val();
            total +=  Number(precio * cantidad);
            $inputTotal.val(total);
        });
        if(total === 0){
            $("#btnComprar").prop("disabled", "disabled");
            $("#btnClearCart").prop("disabled", "disabled");
        }
    }

    function verificarSesion(){
        ajaxURL("/cuenta/verificarSesionCliente", data => {
           let result = $.trim(data);
           if(result === 'success'){
               $('#formCart').submit();
           }else{
               $('#modalLoginForm').modal('toggle');
           }
        });
    }
    total();
</script>