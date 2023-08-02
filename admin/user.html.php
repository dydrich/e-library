<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Admin area</title>
        <link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
        <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
        <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
        <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
        <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,600,600italic,700,700italic,900,200' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
        <script type="application/javascript" src="../js/page.js"></script>
        <style>
            .mdc-text-field, .mdc-select {
                width: 90%;
                margin-left: auto;
                margin-right: auto;
            }

            .mdc-select {
                margin-top: 16px;
                margin-bottom: 16px;
                font-size: 0.95em;
            }
        </style>
        <script type="application/javascript">

        </script>
    </head>
    <body>
        <div id="page" class="page">
            <?php include_once "../share/header.php" ?>
            <?php include_once "../share/nav.php" ?>
            <div id="main">
                <div id="left_space"></div>
                <div id="left_col">
                    <div style="margin: auto" class="form_container">
                        <form method="post" id="userform" onsubmit="submit_data()">
                            <div class="form_row">
                                <p class="material_label" style="text-align: left; grid-row: 1; grid-column: 1/2">Username</p>
                                <div style="grid-row: 1; grid-column: 2/3">
                                    <input type="email" required <?php if (isset($_user)) echo 'disabled' ?> style="<?php if (!isset($_user)) echo "width: 100%"; ?>%" id="username" name="username" class="input_with_icon android <?php if (isset($_user)) echo 'disabled_link' ?>" value="<?php if (isset($_user)) echo $_user->getUsername() ?>">
                                    <?php if (isset($_user)): ?>
                                    <a href="#" id="unlock" style="float: right; border-bottom: 1px solid rgba(0,0,0,.42);">
                                        <i class="material-icons accent_color" id="ulk_i">edit</i>
                                    </a>
                                    <?php endif; ?>
                                </div>    
                            </div>
                            <div class="form_row">
                                <p class="material_label" style="text-align: left; grid-row: 2; grid-column: 1/2">Nome</p>  
                                <div style="grid-row: 2; grid-column: 2/3">  
                                    <input type="text" required style="width: 100%" id="firstname" name="firstname" class="android" value="<?php if (isset($_user)) echo $_user->getFirstName() ?>">
                                </div>
                            </div>
                            <div class="form_row">
                                <p class="material_label" style="text-align: left; grid-row: 3; grid-column: 1/2">Cognome</p>    
                                <div style="grid-row: 3; grid-column: 2/3">
                                    <input type="text" required style="width: 100%" id="lastname" name="lastname" class="android" value="<?php if (isset($_user)) echo $_user->getLastName() ?>">
                                </div>
                            </div>
                            <div class="form_row">
                                <p class="material_label" style="text-align: left; grid-row: 4; grid-column: 1/2">Ruolo</p>    
                                <div style="grid-row: 4; grid-column: 2/3">
                                    <select class="android" name="role" style="width: 100%">
                                    <?php
                                    while ($row = $res_roles->fetch_assoc()) {
                                        $selected = '';
                                        if (!isset($_user)) {
                                            if ($row['rid'] == User::$STUDENT) {
                                                $selected = "default selected";
                                            }
                                        }
                                        else {
                                            if ($_user->getCurrentRole() == $row['rid']) {
                                                $selected = "default selected";
                                            }
                                        }
                                    ?>
                                    <option <?php echo $selected ?> value="<?php echo $row['rid'] ?>"><?php echo $row['role'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <section class="mdc-card__actions form_row" style="margin-top: 45px; margin-bottom: 30px; text-align: left; padding: 0; grid-row: 5; grid-column: 1/3">
                                <button id="submit_btn" onclick="submit_data(event)" class="mdc-button mdc-button--raised mdc-card__action" style="margin-left: 0">Registra</button>
                            </section>
                        </form>
                    </div>
                </div>
                <div id="right_col">
                    <?php include_once "menu.php" ?>
                </div>
                <div id="right_space"></div>
            </div>
            <?php include_once "../share/footer.php" ?>
            <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
            <script>
                window.mdc.autoInit();

                function supportFormData() {
                    return !! window.FormData;
                }

                var uid = <?php if (isset($_REQUEST['uid'])) echo $_REQUEST['uid']; else echo 0 ?>;

                var submit_data = function (event) {
                    event.preventDefault();
                    if (!supportFormData()) {
                        alert("Not supported :(");
                    }

                    var message = '';
                    var ok = true;

                    if (document.getElementById('username').value === '') {
                        message += "Username non valida<br>";
                        ok = false;
                    }
                    if (document.getElementById('firstname').value === '') {
                        message += "Nome non valido<br>";
                        ok = false;
                    }
                    if (document.getElementById('lastname').value === '') {
                        message += "Cognome non valido<br>";
                        ok = false;
                    }
                    if (!ok) {
                        var msg = {};
                        msg.data_field = 'validation_data';
                        msg.validation_message = message;
                        msg.message = 'Dati non validi';
                        msg.min_height = 180;
                        var okbtn = document.getElementById('close_button');
                        okbtn.addEventListener('click', function () {
                            fade('overlay', 'out', 100, .3);
                            fade('information', 'out', 300, 1);
                        });
                        j_alert("information", msg);
                        return false;
                    }


                    var xhr = new XMLHttpRequest();
                    var form = document.getElementById('userform');
                    var formData = new FormData(form);

                    xhr.open('post', 'user_manager.php');
                    var action = <?php if ($_REQUEST['uid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

                    formData.append('uid', uid);
                    formData.append('action', action);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                if (action === 1) {
                                    j_alert("information", xhr.response);
                                    var okbtn = document.getElementById('close_button');
                                    okbtn.addEventListener('click', function () {
                                        window.location.href = 'users.php?active=1';
                                    });
                                }
                                else {
                                    j_alert('alert', 'Dati aggiornati');
                                    window.setTimeout(function () {
                                        window.location.href = 'users.php?active=1';
                                    }, 2500);
                                }
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
                };

                document.addEventListener("DOMContentLoaded", function () {
                    if (uid !== 0) {
                        var unlock = document.getElementById('unlock');
                        var uname = document.getElementById('username');
                        unlock.addEventListener('click', function (event) {
                            event.preventDefault();
                            uname.classList.toggle('disabled_link');
                            if (uname.disabled === true) {
                                document.getElementById('username').disabled = false;
                                unlock.innerHTML = "<i class='material-icons accent_color'>block</i>";
                            }
                            else {
                                document.getElementById('username').disabled = true;
                                unlock.innerHTML = "<i class='material-icons accent_color'>edit</i>";
                            }

                        });
                    }
                });
            </script>
        </div>
    </body>
</html>