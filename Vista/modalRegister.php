<!-- Modal -->
<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formRegister" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="far fa-registered"></i> Registrarse</h5>
                <button id="btnClose" type="button" onclick="resetForm();" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="mensajeFb" role="alert" style="display:none;" class="alert alert-warning text-center">
                    <strong>
                        <span>
                            Es necesario que se registre para poder acceder
                        </span>
                    </strong>
                </div>
                <div id="modalAlert" style="display: none" class="alert alert-danger" role="alert">
                    <span id="mensajeAjax"></span>
                </div>
                    <p><strong>DATOS DE CLIENTE</strong></p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNombre">Nombre</label>
                            <input name="nombre" type="text" class="form-control"
                                   id="inputNombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Apellido</label>
                            <input type="text" class="form-control" id="inputApellido" placeholder="Apellido"
                                   name="apellido" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDNI">DNI</label>
                        <input type="text" pattern="\d*" minlength="8" maxlength="8" class="form-control"
                               id="inputDNI" placeholder="DNI" name="dni" required>
                    </div>
                    <p><strong>DATOS DE USUARIO</strong></p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email"
                                   name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Contraseña</label>
                            <input type="password" class="form-control required error" id="inputPassword4" placeholder="Contraseña"
                                   name="pass" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="btnRegister" type="submit" class="btn btn-success mr-auto ">Registrarse</button>
                <button onclick="resetForm();" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    function send() {
        ajaxForm("formRegister", "Cuenta/registrarAjax", (data) =>{
            let result = $.trim(data);
            $('#mensajeFb').hide();

            if(result === 'success') {
                $('#btnClose').click();
                alertify.success('El registro se completo con exito!!');
            }else {
                $("#mensajeAjax").html(data);
                $("#modalAlert").show();
            }
            $('#btnRegister').prop('disabled',false);
        });
    }

    function resetForm(){
        $("#formRegister")[0].reset();
        $('#modalAlert').hide();
    }

    $('#formRegister').submit((event) => {
        event.preventDefault();
        $('#btnRegister').prop('disabled',true);
        send();
    });
</script>
