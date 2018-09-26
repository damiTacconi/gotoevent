
<!-- HEADER -->
<?php include "header-inicio.php" ?>
<!-- FIN HEADER -->

<?php include 'example.php' ?>

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
