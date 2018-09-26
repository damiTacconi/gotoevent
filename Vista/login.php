<div id="loginPanel" class="card">
    <div class="card-header indigo wsmoke " style="text-align: center">
        <i class="fas fa-address-book"></i> LOGIN
    </div>
    <ul id="lista" class="list-group list-group-flush" >
        <?php if(isset($param['mensaje'])){ ?>
            <li id="loginError" class="list-group-item list-group-item-danger text-center">
                <?= $param['mensaje'] ?>
                <span onclick="closeLoginError(this)" class="login-error-close float-right"> x </span>
            </li>
        <?php } ?>
        <li class="list-group-item">
            <form action="/cuenta/loguear" method="post">
                <!-- Material input -->
                <div style="color:dimgrey" class="md-form">
                    <i class="fa fa-envelope prefix"></i>
                    <input id="inputEmail" type="text" name="email" class="form-control" aria-label="Username"
                           aria-describedby="basic-addon1" required>
                    <label for="inputEmail">Email</label>
                </div>
                <div class="md-form input-password">
                    <i class="fas fa-lock prefix"></i>
                    <input name="password" type="password" class="form-control" id="inputPassword"
                           aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                    <label for="inputPassword">Contraseña</label>
                </div>
                <small class="float-right small-forgot-password"><a href="/"> Olvide mi contraseña </a></small>
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Acceder</button>
            </form>
            <button id="registrarse" type="submit" class="btn btn-mdb-color btn-block mt-1" data-toggle="modal"
                    data-target="#modalRegister"><i class="far fa-registered"></i> Registrarse</button>
        </li>
        <li class="list-group-item text-center" >
            <fb:login-button id="fb-login-sm"
                             scope="public_profile,email,user_posts"
                             onlogin="checkLoginState();"
                             class="fb-login-button" data-max-rows="1" data-size="large"
                             data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false"
                             data-use-continue-as="true">
            </fb:login-button>
        </li>
    </ul>
</div>
<script type="text/javascript">
    function closeLoginError(event){
        $(event).parent().remove();
    }
</script>