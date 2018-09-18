<?php
/*
 * - SI LA SESION NO ESTA INICIADA, MUESTRO EL NAVBAR TRANSPARENTE.
 * - SI LA SESION ESTA INICIADA, MUESTRO EL NAVBAR CON ESTILO DARK.
 */
if(!empty($_SESSION))
  $bgT = false; // bgT = Background Transparente.
else
  $bgT = true;
?>


<!-- ************************************************************************************
                                      NAV OVERLAY
***************************************************************************************-->
<div id="myNav" class="overlay">
 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
 <div class="overlay-content">
   <ul class="navbar-nav list-inline">
       <li class="nav-item <?php if(isset($page)){echo ($page === 'inicio') ? 'active':''; } ?> ">
           <a class="nav-link text-center" href="/"><i class="fas fa-home"></i> Inicio <span class="sr-only">(current)</span></a>
       </li>
       <li class="nav-item <?php if(isset($page)){echo ($page === 'contacto') ? 'active':''; } ?> ">
         <div class="dropdown-divider"></div>
           <a class="nav-link text-center" href="/"><i class="fas fa-user-alt"></i> Contactanos <span class="sr-only">(current)</span></a>
       </li>
   </ul>
   <?php if(!empty($_SESSION)){?>
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
               <a class="nav-link" href="/"><i class="fas fa-user-alt"></i> Contactanos <span class="sr-only">(current)</span></a>
           </li>
       </ul>

       <?php if(!empty($_SESSION)){?>
       <ul id="" class="navbar-nav ml-auto list-inline">
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
           <li class="list-inline-item nav-sm-center">
           <a data-toggle="modal" data-target="#modalCart" class="nav-link">
                <i class="fas fa-shopping-cart"></i> 
                <span>Carrito</span>
            </a>
           </li>
           <li id="separator" class="list-inline-item"><span class="nav-link disabled"> |</span></li>
           <li class="list-inline-item nav-sm-center">
                   <a class="nav-link"
                       <?php if(isset($_SESSION['fb_access_token'])){ ?>
                           href="/Facebook/logout"
                       <?php }else { ?>
                           href="/cuenta/logout"
                       <?php } ?>
                   ><i class="fas fa-sign-out-alt"></i> Salir</a>
           </li>

       </ul>
       <?php }?>
     </div>

 </nav>
