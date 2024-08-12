<!DOCTYPE html>
<html class="mdc-typography">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>E-Library</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" media="screen and (min-width: 2200px)" href="css/layouts/index/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="css/layouts/index/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="css/layouts/index/normal.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="application/javascript" src="js/page.js"></script>
    <script type="application/javascript" src="js/md5-min.js"></script>
</head>
<body>
<div id="page" class="hp" style="margin: 0">
    <?php include "header.php" ?>
    <section id="main">
        <div id="content" style="order: 2">
            <div id="login" class="mdc-elevation--z2">
                <div id="login_form" style="align-items: center; width: 75%">
                    <form id='myform' method='post' action='#' style="width: 100%; margin: 10px auto 0 auto">
                    <?php
                    if ($token != null):
                    ?>
                        <div style="width: 100%; height: 70px; display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                            <p class="material_label _bold" style="color: var(--mdc-theme-primary); font-size: 1.5em; width: 100%; text-align: center">Procedura di recupero password</p>
                        </div>
                        <div class="rb-login-container">
                            <div style="width: 100%">
                                <p>Inserisci la password</p>
                                <input required autocomplete="off" type="password" id="pwd1" name="pwd1" class="android" style="width: 100%">
                            </div>
                        </div>
                        <div class="rb-login-container" style="margin-top: 30px">
                            <div style="width: 100%">
                                <p>Ripeti la password</p>
                                <input required type="password" class="android" id="pwd2" name="pwd2"
                                       autocomplete="current-password" style="width: 100%">
                            </div>
                        </div>
                        <button type="button" class="mdc-button mdc-button--raised" id="login_button" style="margin-top: 20px">
                            Invia
                        </button>
                    <?php
                    else :
                    ?>
                        <div style="width: 100%; height: 70px; display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                            <i class="material-icons attention">warning</i>
                            <p class="material_label _bold" style="margin-left: 15px; color: var(--mdc-theme-primary); font-size: 1.5em">Richiesta non valida</p>
                        </div>
                        <div class="mdc-elevation--z1" style="padding: 15px; font-size: 1.1em; min-height: 45%; margin-top: 20px">
                            <p class="attention" style="font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">Codice scaduto</p>
                            <p class="w_text" style="margin-top: 10px">L'indirizzo inserito non &egrave; pi&ugrave; valido: devi effettuare una nuova richiesta.</p>
                            <p class="w_text" style="margin-top: 10px">Ti ricordiamo che la password va cambiata entro 24 ore dalla richiesta stessa.</p>
                        </div>
                        <div style="width: 100%; margin-top: 20px; font-size: 1.1em">
                            <a href="<?php echo ROOT_SITE ?>" class="material_link normal">Torna indietro</a>
                        </div>
                    <?php
                    endif;
                    ?>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</div>
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script type="text/javascript">
        
        (function() {
            load_jalert();
            var btn = document.getElementById('login_button');
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                registra();
            });
        })();

        var registra = function (){
            var patt = /[^a-zA-Z0-9]/;
            if(document.forms[0].pwd1.value === ""){
                j_alert('error', "Password non valida.");
                return false;
            }
            else if(document.forms[0].pwd1.value.match(patt)){
                j_alert('error', "Password non valida: sono ammessi solo lettere e numeri");
                return false;
            }
            if(document.forms[0].pwd1.value !== document.forms[0].pwd2.value){
                j_alert('error', "Le password inserite sono differenti. Ricontrolla.");
                return false;
            }
            p = hex_md5(document.forms[0].pwd1.value);

            var uid = <?php echo $uid ?>;

            var url = "password_manager.php";

            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'password_manager.php');
            var action = 'change';
            formData.append('uid', uid);
            formData.append('action', action);
            formData.append('new_pwd', p);

            xhr.responseType = 'json';
            xhr.send(formData);

            xhr.onreadystatechange = function () {
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        if (xhr.response.status === 'ok') {
                            j_alert("alert", xhr.response.message);
                            setTimeout(function(){
                                    window.location = "index.php";
                                }, 2000);
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
