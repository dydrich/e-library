<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Modifica password</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/reg.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" href="css/general.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="application/javascript" src="js/page.js"></script>
    <script type="application/javascript" src="js/md5-min.js"></script>
    <style>
        .mdc-textfield {
            width: 90%;
        }

        #footer {
            margin-right: 20px;
        }

        form {
            border: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="wrap">
            <div style="" id="_header">
                <h1 class="mdc-typography--display1"><?php echo $_SESSION['__config__']['software_name']." ".$_SESSION['__config__']['software_version'] ?></h1>
                <p id="sw_version" style="font-size: 0.7em; font-weight: normal; line-height: 20px; margin: 0; padding-top: 10px; text-transform: none">
                    Software di condivisione e archiviazione materiali didattici
                </p>
            </div>
        </div>
    </header>
    <section class="wrap">
        <div id="login_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center; justify-content: center">
            <form id='myform' method='post' action='#'>
            <?php
            if ($token != null):
            ?>
                <h3>Procedura di recupero password</h3>
                <div style="display: block; width: 300px">
                    <div class="mdc-textfield" data-mdc-auto-init="MDCTextfield">
                        <input required type="password" id="pwd1" name="pwd1" class="mdc-textfield__input">
                        <label class="mdc-textfield__label" for="pwd1">Inserisci la password</label>
                    </div>
                </div>
                <div style="display: block; width: 300px">
                    <div class="mdc-textfield" data-mdc-auto-init="MDCTextfield">
                        <input required type="password" class="mdc-textfield__input" id="pwd2" name="pwd2">
                        <label for="pwd2" class="mdc-textfield__label">Password</label>
                        <div class="mdc-textfield__bottom-line"></div>
                    </div>
                </div>
                <button type="button" class="mdc-button mdc-button--raised" id="mail_button">
                    Invia
                </button>
            <?php
            else :
            ?>
                <h3 style="min-width: 200px; margin: auto">
                    <i class="material-icons attention">warning</i>
                    <span style="position: relative; bottom: 5px">Richiesta non valida</span>
                </h3>
                <div class="mdc-elevation--z5" style="padding: 15px; font-size: 1em; min-height: 45%; margin-top: 20px">
                    <p class="attention" style="font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">Codice scaduto</p>
                    <p class="w_text" style="margin-top: 10px">L'indirizzo inserito non &egrave; pi&ugrave; valido: devi effettuare una nuova richiesta.</p>
                    <p class="w_text" style="margin-top: 10px">Ti ricordiamo che la password va cambiata entro 24 ore dalla richiesta stessa.</p>
                    <div style="width: 100%; margin-top: 20px">
                        <a href="<?php echo ROOT_SITE ?>" class="material_link normal">Home</a>
                    </div>
                </div>
            <?php
            endif;
            ?>
            </form>
            <?php include 'share/footer.php' ?>
        </div>
    </section>
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <script type="text/javascript">
        window.mdc.autoInit();
        mdc.textfield.MDCTextfield.attachTo(document.querySelector('.mdc-textfield'));

        (function() {
            load_jalert();
            var btn = document.getElementById('mail_button');
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
