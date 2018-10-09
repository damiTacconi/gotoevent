<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Evento</a>
                </li>
                <li class="breadcrumb-item active">Consultar</li>
            </ol>
            <!-- FORMULARIOS -->
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card border-grey mb-3">
                            <div class="card-header">Consultar cantidad de ventas </div>
                            <div class="card-body text-dark">
                                <div class="form">
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label for="selectEvento">Evento </label>
                                            <select onchange="consultarEvento()" name="eventoSelect" id="selectEvento"
                                                class="form-control" required>
                                                <option value="" selected disabled>Elegir evento...</option>
                                                <?php if(!empty($param['eventos'])) {?>
                                                <?php foreach ($param['eventos'] as $evento) { ?>
                                                <option value='<?= $evento->getId() ?>'>
                                                    <?= $evento->getTitulo() ?>
                                                </option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                      <div class="card mb-3">
                          <div class="card-header">
                              <i class="fas fa-table"></i>
                              Cantidad de Ventas y Remanentes</div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                      <tr>
                                          <th>Id</th>
                                          <th>Fecha</th>
                                          <th>N° Ventas</th>
                                          <th>N° Remanentes</th>
                                      </tr>
                                      </thead>
                                      <tfoot>
                                      <tr>
                                          <th>Id</th>
                                          <th>Fecha</th>
                                          <th>N° Ventas</th>
                                          <th>N° Remanentes</th>
                                      </tr>
                                      </tfoot>
                                      <tbody>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>

            <!-- FIN FORMULARIOS -->
            <hr>

            <div class="container-fluid">

            </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2018</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->


<script type="text/javascript">

    function consultarEvento() {
        let id_evento = $('#selectEvento option:selected').val();
        if (id_evento === "")
            alertify.alert('Ups', 'Debe seleccionar un evento', function () {
                alertify.success('Ok');
            });
        else {

            obj = {id: id_evento};
            ajaxURL( "/compra/consultarAjax/", data => {
                let result = JSON.parse(data);
                let table = $('#dataTable').DataTable();
                table.clear();
                let cant = Object.keys(result).length;
                for(let i=0;i<cant;i++){
                  table.row.add([
                    result[i]['calendario']['id_calendario'],
                    result[i]['calendario']['fecha'],
                    result[i]['cantidad_ventas_totales'],
                    result[i]['cantidad_remanentes_totales']
                  ]).draw();
                }
            }, "POST" , obj);
        }
    }
</script>
