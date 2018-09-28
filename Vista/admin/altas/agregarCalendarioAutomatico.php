<div class="card border-dark mb-3">
    <div class="card-header">Calendario Automatico</div>
    <div class="card-body text-dark">
        <form action="/calendario/saveAll" method="post">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputSede">Evento </label>
                    <select name="eventoSelect" class="form-control" required>
                        <option value="" selected disabled>Elegir evento...</option>
                        <?php if(!empty($param['eventos'])) {?>
                            <?php foreach ($param['eventos'] as $evento) { ?>
                                <option value='<?= $evento->getId() ?>'><?= $evento->getTitulo() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-dark-green">Generar</button>
        </form>
    </div>
</div>