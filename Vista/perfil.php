<?php $page = "perfil"; $bgT = false; ?>
<?php include "navbar.php" ?>
<div class="container">
    <div class="row">
        <div class="col">
            <header id="" class="m-3 p-5">
                <h3 class="bg-dark wsmoke p-3"> <img class="rounded-circle" src='<?= $_SESSION['picture_url'] ?>' alt="">
                 <?= $_SESSION['name'] ?>
                </h3>
                <ul class="list-group">
                    <li class="list-group-item"> USER EMAIL: <?= $_SESSION['email'] ?></li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item"><a href="/cuenta/tickets" style="text-decoration: none"> MIS TICKETS</a></li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item bg-danger wsmoke" style="cursor: pointer" data-toggle="tooltip" data-placement="bottom" title="No implementado"> ELIMINAR CUENTA </li>
                </ul>
                <p class="p-2"> Sin terminar ... </p>

            </header>
        </div>
    </div>
</div>