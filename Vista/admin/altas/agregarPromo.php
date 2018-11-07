<div class="card border-dark mb-3">
    <div class="card-header">Agregar Promo</div>
    <div class="card-body text-dark">
        <form action="/promo/save" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputSede">Evento</label>
                    <select id="selectEvento"
                            class="form-control" name="evento" required>
                        <option value="" selected disabled>Elegir evento...</option>
                        <?php if(!empty($param['promos'])) { ?>
                            <?php foreach ($param['promos'] as $evento) { ?>
                                    <option value='<?= $evento->getId() ?>'><?= $evento->getTitulo() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputDescuento">Descuento</label>
                    <input required type="number" min="1" class="form-control" name="descuento" id="inputDescuento" >
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</div>