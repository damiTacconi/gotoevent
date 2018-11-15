

<!-- ************************************************************************************
                                      NAV OVERLAY
***************************************************************************************-->
<div id="myNav" class="n-overlay">
 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
 <div class="overlay-content">
   <ul class="navbar-nav list-inline">
       <li class="nav-item <?php if(isset($page)){echo ($page === 'inicio') ? 'active':''; } ?> ">
           <a class="nav-link text-center" href="/"><i class="fas fa-home"></i> Inicio <span class="sr-only">(current)</span></a>
       </li>
       <li class="nav-item <?php if(isset($page)){echo ($page === 'contacto') ? 'active':''; } ?> ">
         <div class="dropdown-divider"></div>
           <a class="nav-link text-center" href="/" data-toggle="tooltip" data-placement="bottom" title="No implementado"><i class="fas fa-user-alt"></i> Contactanos <span class="sr-only">(current)</span></a>
       </li>
   </ul>
   <?php if($_SESSION['rol'] === 'cliente'){?>
   <ul id="" class="navbar-nav ml-auto list-inline">
       <li class="list-inline-item nav-sm-center <?php if(isset($page)){echo ($page === 'perfil') ? 'active':''; } ?>">
         <div class="dropdown-divider"></div>
           <?php
           if(isset($_SESSION['fb_access_token'])){
             include('nav-facebook.php');
            }else{ ?>
               <a class="nav-link" href="/cuenta/perfil/">
                   <span><i class="fas fa-user"></i> Mi Perfil </span>
               </a>
           <?php } ?>
       </li>
       <li class="list-inline-item nav-sm-center">
            <div class="dropdown-divider"></div>
            <a data-toggle="modal" data-target="#modalCart" class="nav-link">
                <i class="fas fa-shopping-cart"></i>
                <span>Carrito</span>
            </a>
       </li>
       <li id="separator" class="list-inline-item"><span class="nav-link disabled"> |</span></li>
       <li class="list-inline-item nav-sm-center">
         <div class="dropdown-divider"></div>
               <a class="nav-link"
                  <?php if(isset($_SESSION['fb_access_token'])){ ?>
                  href="/Facebook/logout"
                  <?php }else { ?>
                  href="/cuenta/logout"
                  <?php } ?>
               ><i class="fas fa-sign-out-alt"></i> Salir</a>
       </li>

   </ul>
   <?php } ?>
 </div>
</div>

<!-- ************************************************************************************
                                      NAVBAR HORIZONTAL
***************************************************************************************-->
 <nav class="navbar navbar-expand-md navbar-dark <?php if((!$bgT)){?> bg-dark <?php } ?>">
   <a class="navbar-brand" href="/">
     <img src="/img/favicon.ico" alt="logo" width="30px"> GoToEvent
   </a>
     <button class="navbar-toggler" type="button" aria-label="Toggle navigation" onclick="openNav()">
       <span class="navbar-toggler-icon wsmoke"></span>
     </button>
     <div class="collapse navbar-collapse">

       <ul class="navbar-nav mr-auto list-inline">
         <li class="nav-item <?php if(isset($page)){echo ($page === 'inicio') ? 'active':''; } ?> ">
             <a class="nav-link" href="/"><i class="fas fa-home"></i> Inicio <span class="sr-only">(current)</span></a>
         </li>
           <li class="nav-item <?php if(isset($page)){echo ($page === 'contacto') ? 'active':''; } ?> ">
               <a class="nav-link" href="/" data-toggle="tooltip" data-placement="bottom" title="No implementado"><i class="fas fa-user-alt"></i> Contactanos <span class="sr-only">(current)</span></a>
           </li>
       </ul>
       <ul id="" class="navbar-nav ml-auto list-inline">
           <li id="icon-cart" class="list-inline-item nav-sm-center">
               <a  class="nav-link">
                   <i class="fas fa-shopping-cart wsmoke"></i>
                   <span class="badge indigo">
                       <?= (count($_SESSION['cart']) + count($_SESSION['cartPromo'] )) ?>
               </a>
           </li>
           <?php if($_SESSION['rol'] === 'cliente'){?>
           <li class="list-inline-item nav-item nav-sm-center <?php if(isset($page)){echo ($page === 'perfil') ? 'active':''; } ?>">
               <?php
               if(isset($_SESSION['fb_access_token'])){
                 include('nav-facebook.php');
                }else{ ?>
                   <a class="nav-link" href="/cuenta/perfil/">
                       <span><i class="fas fa-user"></i> <?= $_SESSION['email'] ?></span>
                   </a>
                <?php  } ?>
           </li>

           <li id="separator" class="list-inline-item"><span class="nav-link disabled"> |</span></li>
           <li class="list-inline nav-sm-center">
                   <a class="nav-link"
                       <?php if(isset($_SESSION['fb_access_token'])){ ?>
                           href="/Facebook/logout"
                       <?php }else { ?>
                           href="/cuenta/logout"
                       <?php } ?>
                   ><i class="fas fa-sign-out-alt"></i> Salir</a>
           </li>
           <?php }?>
       </ul>

     </div>

 </nav>
<script type="text/javascript">

    $('#icon-cart').on('click',() => {
        $("#modalCart").modal("toggle");
    })
    $(window).scroll(function () {
        if($(window).scrollTop() > 100){
            $('#icon-cart a').addClass("fixed-cart");
        }else{
            $('#icon-cart a').removeClass("fixed-cart");
        }
    });
</script>
