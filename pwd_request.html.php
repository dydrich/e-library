<!DOCTYPE html>
<html class="mdc-typography">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Nuova password</title>
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" media="screen and (min-width: 2200px)" href="css/layouts/index/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="css/layouts/index/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="css/layouts/index/normal.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="application/javascript" src="js/page.js"></script>
</head>
<body>
<div id="page" class="hp" style="margin: 0">
    <?php include "header.php" ?>
    <section id="main">
        <div id="content" style="order: 2">
            <div id="login" class="mdc-elevation--z2">
                <div id="login_form" style="align-items: center; width: 75%">
                    <div style="width: 100%; height: 70px; display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                        <p class="material_label _bold" style="color: var(--mdc-theme-primary); font-size: 1.5em; width: 100%; text-align: center">Richiedi una nuova password</p>
                    </div>
                    <form id="myformreq" action="do_login.php" method="post" style="width: 100%; margin: 10px auto 0 auto">
                        <div class="rb-login-container">
                            <div style="width: 100%">
                                <p style="margin-bottom: 10px">Email</p>
                                <input required autocomplete="off" type="email" id="my-username" name="my-username" class="android" style="width: 100%">
                            </div>
                        </div>
                        <div class="mdc-elevation--z1" id="pwdreq_info" style="margin-top: 30px; margin-bottom: 30px; font-size: 1.2em; background-color: #d9ead3">
                            Inserisci l'indirizzo email con il quale ti sei registrato e riceverai a breve una mail contenente le istruzioni per la modifica della password.
                        </div>
                        <button type="button" class="mdc-button mdc-button--raised" id="login_button" style="margin-top: 10px">
                            Login
                        </button>
                        <p style="margin-top: 30px; width: 100%; text-align: center; margin-bottom: 30px" id="pwd_req">
                            <a href="index.php" class="normal material_link" style="margin-right: 25px">Torna indietro</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</div>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    (function() {
        var btn = document.getElementById('login_button');
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            send_email();
        });
    })();

    var send_email = function(){
        var mail = document.getElementById('my-username').value;

        var url = "password_manager.php";

        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'password_manager.php');
        var action = 'sendmail';

        formData.append('email', mail);
        formData.append('action', action);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    if (xhr.response.status === 'ok') {
                        j_alert('alert', xhr.response.message);
                    }
                    else if (xhr.response.status === "nomail" || xhr.response.status === "olduser") {
                        j_alert("error", xhr.response.message);
                    }
                    else if (xhr.response.status === "kosql") {
                        j_alert("error", xhr.response.message);
                    }
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>