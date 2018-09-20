window.fbAsyncInit = () => {
    FB.init({
        appId      : '215614699309419',
        cookie     : true,
        xfbml      : true,
        version    : 'v3.1'
    });
};
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/es_LA/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function statusChangeCallback(response){

    if(response.status === 'connected'){
        ajaxURL('/facebook/login' , data => {
            let result = $.trim(data);
            if(result === 'success'){
                window.location.href = "/";
            }else{
                alert("ERROR AL CONECTAR, INFORMACION EN CONSOLA");
                console.log(data);
            }
        });
    }
}
