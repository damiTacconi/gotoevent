<div class="card border-dark mb-3">
    <div class="card-header">Crear Sede</div>
    <div class="card-body text-dark">
        <form action="/sede/save" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputSede">Nombre Sede</label>
                    <input required type="text" class="form-control" name="sede" id="inputSede" placeholder="Ej: 'Gran Rex' ">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputCapacidad">Capacidad</label>
                    <input required type="number" min="1" class="form-control" name="capacidad" id="inputCapacidad" placeholder="Ej: 'Gran Rex' ">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
</div>