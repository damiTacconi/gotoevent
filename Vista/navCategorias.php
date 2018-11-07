<nav class="nozindex navbar navbar-expand-lg navbar-dark blue scrolling-navbar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link hvr-float item-navcat"  href="/buscar/categoria/Obra-de-Teatro">TEATROS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link hvr-float item-navcat" href="/buscar/categoria/concierto">CONCIERTOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link hvr-float item-navcat" href="/buscar/categoria/festival">FESTIVALES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link hvr-float item-navcat" href="#">MAS</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 bg-white">
            <div id="containerSearch" class="border-bottom p-3 border-light">
                <form  action="/buscar/filtrar/" method="POST" class="justify-content-center form-inline active-cyan-4">
                    <input name="nombre" class="form-control form-control-sm mr-3 w-50" type="text" placeholder="ENCONTRA LO MEJOR DEL ENTRETENIMIENTO" aria-label="Search">
                    <button type="submit" id="btnSearch" class="btn btn-primary btn-sm" style="width: 10%"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
