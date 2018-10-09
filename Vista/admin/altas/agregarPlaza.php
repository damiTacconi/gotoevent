<div class="card border-dark mb-3">
    <div class="card-header">Crear Plaza</div>
    <div class="card-body text-dark">
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
                                <option value='<?= $sede->getId() ?>'><?= $sede->getNombre() ?> </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</div>