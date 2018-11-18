<!DOCTYPE html>
<html class="mdc-typography">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Nuova password</title>
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<link rel="stylesheet" href="css/site_themes/light_blue/index.css">
	<link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="css/layouts/small.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style>
		.mdc-textfield {
			width: 90%;
		}

        #footer {
            margin-right: 20px;
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
	<div id="login_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center;">
		<form id="myformreq" action="do_login.php" method="post" style="margin: auto">
			<div class="rb-login-container">
				<div class="mdc-textfield" data-mdc-auto-init="MDCTextfield">
					<input required type="email" id="my-username" name="my-username" class="mdc-textfield__input">
					<label class="mdc-textfield__label" for="my-username">Email</label>
				</div>
			</div>
			<div class="mdc-elevation--z5" id="pwdreq_info">
				Inserisci l'indirizzo email con il quale ti sei registrato e riceverai a breve una mail contenente le istruzioni per la modifica della password.
			</div>
			<button type="submit" class="mdc-button mdc-button--raised" id="login_button">
				Invia
			</button>
			<p style="margin-top: 20px" id="pwd_req">
				<a href="index.php" class="normal">Torna indietro</a>
			</p>
		</form>
		<?php include "share/footer.php"; ?>
</section>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();
    mdc.textfield.MDCTextfield.attachTo(document.querySelector('.mdc-textfield'));

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