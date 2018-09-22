<?php include "adminNav.php" ?>
<div id="wrapper">
    <?php include 'sidebar.php' ?>
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Sede</a>
                </li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
            <?php if(isset($param['mensaje'])) {
                echo $param['mensaje'];
            }?>
            <form action="/sede/save" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputSede">Nombre Sede</label>
                        <input required type="text" class="form-control" name="sede" id="inputSede" placeholder="Ej: 'Gran Rex' ">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
            <hr>
            <form action="/sede/saveTipoPlaza" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTipoPlaza">Nombre de Tipo de Plaza</label>
                        <input required type="text" name="nombre" class="form-control" id="inputTipoPlaza" placeholder="Ej: 'Platea'">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputSede" >Sede</label>
                        <select name="sedeSelect" id="inputSede" class="form-control" required>
                            <option value="" selected disabled>Elegir Sede...</option>
                            <?php if(!empty($param['sedes'])) { ?>
                                <?php foreach ($param['sedes'] as $sede) { ?>
                                    <option value='<?= $sede->getNombre() ?>'><?= $sede->getNombre() ?> </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
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