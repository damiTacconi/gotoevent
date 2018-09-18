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
                     alt="" width="25px" class="rounded-circle"> <?= $_SESSION['first_name'] ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="userDropdown">
                <a class="dropdown-item text-white" href="#">Settings</a>
                <a class="dropdown-item text-white" href="#">Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-white" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>

</nav>