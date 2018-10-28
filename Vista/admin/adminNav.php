<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="/">GoToEvent - Admin Panel</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <ul class="navbar-nav form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- <i class="fas fa-user-circle fa-fw"></i> -->
                <img src="<?= $_SESSION['picture_url'] ?> "
                     alt="" width="25px" class="rounded-circle"> <?php if(isset($_SESSION['fb_access_token'])) {
                            echo $_SESSION['first_name'];
                         }else {
                             echo $_SESSION['email'];
                            }
                     ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="userDropdown">
                <a class="dropdown-item text-white" href="#" data-toggle="modal" data-target="#logoutModal">Salir</a>
            </div>
        </li>
    </ul>

</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguro que quieres salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Click en "Salir" en el boton de abajo si estas listo para terminar tu sesion actual
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary"
                    <?php if(isset($_SESSION['fb_access_token'])){ ?>
                        href="/Facebook/logout"
                    <?php }else { ?>
                        href="/cuenta/logout"
                    <?php } ?>
                >Salir</a>
            </div>
        </div>
    </div>
</div>