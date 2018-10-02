<?php $page = "perfil"; $bgT = false; ?>
<?php include "navbar.php" ?>
<div class="container">
    <div class="row">
        <div class="col">
            <header id="" class="m-3 p-5">
                <h3> <img class="rounded-circle" src='<?= $_SESSION['picture_url'] ?>' alt="">
                 <?= $_SESSION['name'] ?>
                </h3>
                <ul class="list-group">
                    <li class="list-group-item"> USER EMAIL: <?= $_SESSION['email'] ?></li>
                </ul>
            </header>
            <div id="feed" class="mb-3"> </div>
        </div>
    </div>
</div>
