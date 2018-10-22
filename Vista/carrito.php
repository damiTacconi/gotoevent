
<?php
if(!empty($_SESSION['cart'])){
    $carrito = $_SESSION['cart'];
    $items = json_decode(json_encode($carrito, FALSE));
}

if(!empty($_SESSION['cartPromo'])){
  $carritoPromo = $_SESSION['cartPromo'];
  $packs = json_decode(json_encode($carritoPromo, FALSE));
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
              <?php if(isset($items)) { ?>
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
                    <?php
                        foreach($items as $key => $item) {
                            $plaza = $item->plazaEvento;

                            ?>
                            <tr>
                                <th scope="row"><?= $plaza->calendario->evento->titulo ?> </th>
                                <td><?= $plaza->calendario->fecha ?></td>
                                <td><?= $plaza->plaza->sede->nombre ?></td>
                                <td><?= $plaza->plaza->descripcion ?></td>
                                <td>
                                    <input type="number" name="precio[]" class="form-control"
                                           value="<?= $plaza->precio ?>" disabled>
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
                    </tbody>
                </table>
                <?php } ?>
                <?php if(isset($packs)) { ?>
                  <hr>
                  <h4>PROMOS</h4>
                  <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Evento</th>
                          <th>Cantidad</th>
                          <th>Precio</th>
                          <th>Descuento</th>
                          <th>Descuento total</th>
                          <th>Subtotal</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="tbodyCartPromo">
                        <?php foreach ($packs as $key => $value) {
                              $descuentoTotal = $value->descuento * $value->cantidad;
                              $subtotal = ($value->precio * $value->cantidad) - $descuentoTotal;
                          ?>
                            <tr>
                              <td><?= $value->evento->titulo ?>
                                  <input type="hidden" name="idPromo[]" value="<?= $value->id_promo ?>">
                              </td>
                              <td><input type="number" name="cantidadPromo[]" style="width: 60px;"
                                     class="form-control" min="1" max="5" onkeydown="return false"
                                     value="<?= $value->cantidad ?>">
                                   </td>
                              <td>
                                <input type="number"  class="form-control"
                                       value="<?= $value->precio ?>" disabled>
                              </td>
                              <td>
                                <input type="number"  class="form-control"
                                       value="<?= $value->descuento ?>" disabled>
                              </td>
                              <td>
                                <input type="number"  class="form-control"
                                       value="<?= $descuentoTotal ?>" disabled>
                              </td>
                              <td>
                                <input type="number"  class="form-control" name="subtotalPromo[]"
                                       value="<?= $subtotal ?>" disabled>
                              </td>
                              <td><a onclick="removeOfCart(<?= $key ?>,'promo')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                      </tbody>
                  </table>
                <?php } ?>
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

<script src="/./js/carrito.js"></script>
