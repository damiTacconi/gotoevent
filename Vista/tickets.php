<?php
$bgT = false;
include "navbar.php";
include "navCategorias.php";

$cliente = $param['cliente'];
$compras = $cliente->getCompras();

?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="bg-primary wsmoke text-center mt-5">
                <h1>MIS TICKETS</h1>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Tickets</div>
                <div class="card-body">
                    <?php if($compras) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Numero Ticket</th>
                                <th scope="col">QR</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Numero Ticket</th>
                                <th scope="col">QR</th>
                                <th scope="col"></th>
                            </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($compras as  $compra) {
                                    $lineas = $compra->getLineas();
                                    foreach ($lineas as  $linea) {
                                        $tickets = $linea->getTickets();
                                        foreach ($tickets as $key => $ticket) {
                                            $url = URL_IMG . 'qr/' . $ticket->getNumero() . '.png';
                                            $i++;
                                            ?>
                                            <tr>
                                                <th scope="row" width="30"><?= $i ?></th>
                                                <td width="30"><?= $ticket->getFecha() ?></td>
                                                <td width="30"><?= $ticket->getNumero() ?></td>
                                                <td class="text-center" width="30" height="15">
                                                    <img width="80" src='<?= $url ?>' alt="">
                                                </td>
                                                <td class="text-center" width="10" height="30">
                                                    <button class="btn btn-primary btn-sm">MAS INFO</button>
                                                </td>
                                            </tr>
                                        <?php }
                                        }
                                    }
                               ?>
                            </tbody>
                        </table>
                    </div>
                    <?php }else{ ?>
                        <h3 class="text-center bg-warning wsmoke"> No hay tickets de momento ...</h3>
                    <?php } ?>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css ">
<script src="/./admin/vendor/datatables/jquery.dataTables.js"></script>
<script src="/./admin/vendor/datatables/dataTables.bootstrap4.js"></script>

<script src="/./admin/js/demo/datatables-demo.js"></script>


