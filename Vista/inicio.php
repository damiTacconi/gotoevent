<?php include "navbar.php" ?>
<!--- HEADER --------------->
<?php include "header-inicio.php" ?>
<!---FIN HEADER------------->
    <div class="container">
        <div class="row">
            <div class="col">
                    <h1 >Lista de Eventos</h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col"><i class="far fa-calendar-alt"></i> Proximos eventos</th>
                                <th scope="col">Fecha de inicio</th>
                                <th scope="col">Sede</th>
                                <th scope="col">Informacion</th>
                                <th scope="col">Entrada</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Festival Show 2018
                                </th>
                                <td>5/10/2018</td>
                                <td>Casa de Chiaradia</td>
                                <td class="text-center"><button class="btn btn-info btn-rounded"> MAS INFO </button></td>
                                <td class="text-center"><button onclick="add(this);" class="btn btn-success btn-rounded"><i class="fas fa-shopping-cart"></i> AÑADIR </button></td>
                            </tr>
                            <tr>
                                <th scope="row">Abel Pintos</th>
                                <td>21/9/2018</td>
                                <td>Gran Rex</td>
                                <td class="text-center"><button class="btn btn-info btn-rounded"> MAS INFO </button></td>
                                <td class="text-center"><button onclick="add(this);" class="btn btn-success btn-rounded"><i class="fas fa-shopping-cart"></i> AÑADIR</button></td>
                            </tr>
                            <tr>
                                <th scope="row">Rata Blanca</th>
                                <td>20/9/2018</td>
                                <td>Estadio Monumental</td>
                                <td class="text-center"> <button class="btn btn-info btn-rounded"> MAS INFO </button></td>
                                <td class="text-center"> <button onclick="add(this);" class="btn btn-success btn-rounded"><i class="fas fa-shopping-cart"></i> AÑADIR </button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
<?php include "modalRegister.php"; ?>
<script type="text/javascript">

    function add(event){
        ajaxURL('/cuenta/verificarSesion', data => {
            let result = $.trim(data);
            if(result === 'success') {
                if ($(event).hasClass("btn-success")) {
                    $(event).removeClass("btn-success");
                    $(event).addClass("btn-danger");
                    $(event).html('<i class=\"fas fa-shopping-cart\"></i> CANCELAR');
                } else {
                    $(event).removeClass("btn-danger");
                    $(event).addClass("btn-success");
                    $(event).html('<i class=\"fas fa-shopping-cart\"></i> AÑADIR');
                }
            }else{
                $('#registrarse').click();
            }
        });
    }
</script>
