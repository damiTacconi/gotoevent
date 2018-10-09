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
                    <div class="col-12">
                        <div class="card border-dark mb-3">
                            <div class="card-header">Consultar cantidad de ventas </div>
                            <div class="card-body text-dark">
                                <div class="form">
                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            <label for="selectEvento">Evento </label>
                                            <select onchange="actualizarCalendario()" name="eventoSelect" id="selectEvento"
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
                                        <div class="form-group col-6">
                                            <label>Calendarios</label>
                                            <select name="artistaSelect" id="selectCalendario" class="form-control"
                                                required>
                                                <option value="" selected disabled>Elegir calendario...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button onclick="consultarEvento();" class="btn btn-primary">Consultar</button>
                                    <button onclick="consultarPorCalendario();" class="btn btn-secondary">Consultar Por
                                        Calendario</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FIN FORMULARIOS -->
            <hr>

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
    function actualizarCalendario() {
        let id = $('#selectEvento option:selected').val();
        let obj = {
            id: id
        };
        ajaxURL('/evento/getCalendariosAjax/', data => {
            let result = JSON.parse(data);
            let $selectCalendario = $('#selectCalendario');
            $selectCalendario.find('option').not(':first').remove();
            if (result != Array) {
                if (result['evento']['calendarios'].length >= 1) {
                    let calendarios = result['evento']['calendarios'];
                    let option = '';
                    for (let i = 0; i < calendarios.length; i++) {
                        option += '<option value="' + calendarios[i].id_calendario + '">' + calendarios[i].fecha +
                            '</option>';
                    }
                    $selectCalendario.append(option);
                }
            }
        }, 'POST', obj);
    }

    function consultarEvento() {
        let id_evento = $('#selectEvento option:selected').val();
        if (id_evento === "")
            alertify.alert('Ups', 'Debe seleccionar un evento', function () {
                alertify.success('Ok');
            });
        else {
            ajaxURL( "/evento/consultar/"+id_evento, data => {
                result = JSON.parse(data);
                
            });
        }
    }

    function consultarPorCalendario() {
        let id_calendario = $('#selectCalendario option:selected').val();
        if (id_calendario === "")
            alertify.alert('Ups', 'Debe seleccionar un calendario', function () {
                alertify.success('Ok');
            });
        else {
            let obj = {
                id : id_calendario
            }
            ajaxURL( "/compra/consultarVentasPorCalendarioAjax/", data => {
                alertify.alert(data);

                let result = JSON.parse(data);
                let sizeJSON = Object.keys(result).length;

                if(sizeJSON > 0){
                        alertify.alert("CANTIDAD VENTAS Y REMANENTES",`
                            <div class="text-center">
                            <h3>Evento: <strong> ${result['calendario']['evento']['titulo'] }</strong> </h3>
                            <h4>Fecha: <strong> ${result['calendario']['fecha']} </strong> </h4>
                            <hr>
                            <p>Cantidad de Ventas: <strong> ${result['cantidad_ventas_totales']} </strong> </p>
                            <p>Cantidad de Remanentes: <strong> ${result['cantidad_remanentes_totales']}</strong> </p>
                            </div>
                        `).set('resizable',true).resizeTo("50%",350);
                }else{
                    alertify.alert("UPS" , "NO HAY REGISTROS AUN");
                }
            }, "POST" , obj);
        }
    }
</script>