<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Dettaglio sede</title>
        <link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
        <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
        <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
        <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
        <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
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
                margin-top: 10px;
                margin-bottom: 10px;
                font-size: 0.95em;
            }
        </style>
    </head>
    <body>
        <div id="page" class="page">
            <?php include_once "../share/header.php" ?>
            <?php include_once "../share/nav.php" ?>
            <div id="main">
                <div id="left_space"></div>
                <div id="left_col">
                    <div class="form_container" style="margin: auto">
                        <form method="post" id="userform"  class="userform" style="margin: auto; padding: 10px" onsubmit="submit_data()">
                            <div class="form_row" id="lnk_field">
                                <p class="material_label mandatory" style="text-align: left; grid-row: 1; grid-column: 1/2">Nome sede</p>	
                                <div style="grid-row: 1; grid-column: 2/3">
                                    <input type="text" required id="venue" name="venue" class="android" style="width: 100%" value="<?php if ($res != null) echo $res['name'] ?>">
                                </div>
                            </div>
                            <div class="form_row" id="lnk_field">
                                <p class="material_label mandatory" style="text-align: left; grid-row: 2; grid-column: 1/2">Codice sede</p>	
                                <div style="grid-row: 2; grid-column: 2/3">
                                    <input type="text" required id="code" name="code" class="android <?php if ($res != null) echo "disabled_link" ?>" maxlength="3" style="width: 100%" <?php if ($res != null) echo "readOnly" ?> value="<?php if ($res != null) echo $res['code'] ?>">
                                </div>
                            </div>
                            <section class="mdc-card__actions" style="grid-row: 3; grid-column: 1/3; padding: 0">
                                <button id="submit_btn" onclick="submit_data(event)" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="margin-top: 45px; margin-bottom: 35px">Registra</button>
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
                
                var vid = <?php if (isset($_REQUEST['vid'])) echo $_REQUEST['vid']; else echo 0 ?>;

                var submit_data = function (event) {
                    if(!validate_form()) {
                        event.preventDefault();
                        return;
                    }
                    event.preventDefault();
                    var xhr = new XMLHttpRequest();
                    var form = document.getElementById('userform');
                    var formData = new FormData(form);

                    xhr.open('post', 'venue_manager.php');
                    var action = <?php if ($_REQUEST['vid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;
                    console.log(action);
                    formData.append('vid', vid);
                    formData.append('action', action);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                j_alert("alert", xhr.response.message);
                                window.setTimeout(function () {
                                    window.location = 'school_complexes.php';
                                }, 2500);
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
                };

                var validate_form = function() {
                    var go = true;
                    var msg = new Object();
                    msg.data_field = "validation_data";
                    msg.validation_message = "";
                    msg.focus = "venue";
                    var index = 1;
                    if(document.getElementById('venue').value == ""){
                        msg.validation_message += "<br />"+index+". Nome del plesso non presente";
                        go = false;
                        index++;
			        }
                    if(document.getElementById('code').value == ""){
                        msg.validation_message += "<br />"+index+". Codice del plesso non presente";
                        go = false;
			        }
                    msg.message = "Errori nel form";
                    if(!go){
                        j_alert("information", msg);
                        return false;
                    }

                    return true;
                }

                document.addEventListener("DOMContentLoaded", function () {
                    var screenW = screen.width;
                    var bodyW = document.body.clientWidth;
                    var right_offset = (bodyW - 1024) / 2;
                    right_offset += document.getElementById('right_col').clientWidth;
                });
            </script>
        </div>
    </body>
</html>