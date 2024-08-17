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
</head>
<body style="">
<div id="page" class="hp" style="margin: 0">
    <?php include "header.php" ?>
    <section id="main">
        <div id="content" style="order: 2">
            <div id="confirm_form" class="mdc-elevation--z2 ">
                <div style="width: 100%; display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                    <p class="material_label _bold" style="color: var(--mdc-theme-primary); font-size: 1.5em; width: 100%; text-align: center">Conferma attivazione account</p>
                </div>
                <div style="width: 100%; align-items: left; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                    <p>Gentile <?php echo $student->getFullName() ?>,</p>
                    <p>inserisci il codice ricevuto via email all'indirizzo <strong><?php echo $student->getUsername() ?></strong> entro 15 minuti per attivare il tuo account:</p>
                    <div style="display: flex; width: 20%; float: left; margin-top: 20px">
                        <input type="text" name="code" id="code" style="width: 120px; height: 50px; font-size: 1.3em; border: 1px solid #AAAAAA; text-align: center; border-radius: 2px; font-weight: bold" maxlength="6" />
                    </div>
                    <div style="display: flex; width: 70%; float: right; margin-top: 20px">
                        <p id="message_space" style="font-size: 1.2em; margin: 0; padding: 0" class="attention _bold"></p>
                    </div>
                </div>
                <div>
                    <button type="button" class="mdc-button mdc-button--raised" id="confirmreq_button" style="margin-top: 10px">
                        Confermo
                    </button>
                    <button type="button" class="mdc-button mdc-button--raised" id="error_button" style="margin-top: 10px; margin-left: 40px">
                        Non sono io
                    </button>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</div>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="front.js" type="application/javascript"></script>
<script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById("confirmreq_button").addEventListener("click", function(ev) {
                        //document.location.href = "admin/student_manager.php?action=activate_student&student=<?php echo $student->getUid() ?>&code="+document.getElementById('code').value;
                        //provv(ev);
                        activate(ev);
                    });

                    document.getElementById("error_button").addEventListener("click", function(ev) {
                        j_alert("alert", "Scusa l'errore. Sarai ora riportato alla pagina di attivazione: seleziona il tuo nome");
                        setTimeout(function () {
                            document.location.href = "request_login.php";
                        }, 3000);
                        
                    });
                });

                var provv = function(ev) {
                    alert(document.getElementById('code').value);
                }

                var activate = function (ev) {
                    console.log("activate");
                    if(document.getElementById('code').value == "") {
                        j_alert("error", "Non hai inserito alcun codice");
                        return;
                    }

                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'admin/student_manager.php');

                    formData.append('student', <?php echo $student->getUid() ?>);
                    formData.append('cid', 0);
                    formData.append('action', 'activate_student');
                    formData.append('code', document.getElementById('code').value);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                if(xhr.response.out == 4) {
                                    j_alert("alert", "Il tuo account è stato attivato. Sarai reindirizzato alla pagina di login entro pochi secondi");
                                    setTimeout(function () {
                                        document.location.href = "index.php";
                                    }, 2500);
                                }
                                else if(xhr.response.out == 2) {
                                    j_alert("error", "Il codice inserito è scaduto. Sarai reindirizzato alla pagina di richiesta di un nuovo codice");
                                    setTimeout(function () {
                                        document.location.href = "confirm_request.php?sid=<?php echo $student->getUid() ?>";
                                    }, 2000);
                                }
                                else if(xhr.response.out == 1) {
                                    document.getElementById('message_space').innerText = "Il codice inserito non è valido: ricontrolla la mail e inserisci il codice corretto";
                                }
                                
                            }
                            else {
                                j_alert("error", xhr.response.message);
                                setTimeout(function () {
                                    //document.location.href = "index.php";
                                }, 2000);
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                            console.log("state is "+xhr.readyState);
                        }
                    }
                };
            </script>
</body>
</html>