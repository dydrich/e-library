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
            <div id="request_form" class="mdc-elevation--z2 ">
                <div style="width: 100%; height: 70px; display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                    <p class="material_label _bold" style="color: var(--mdc-theme-primary); font-size: 1.5em; width: 100%; text-align: center">Richiesta di accesso - Seleziona il tuo nome</p>
                </div>
                <?php
                while($row = $r_users->fetch_assoc()){
                ?>
                <div data-id="<?php echo $row['uid'] ?>" id="item<?php echo $row['uid'] ?>" data-email="<?php echo $row['username'] ?>" data-name="<?php echo $row['lastname']." ".$row['firstname'] ?>" class="usercard-mini">
                    <span class="usercard-mini__icon-cont " role="presentation">
                        <i class="material-icons">person</i>
                    </span>
                    <span class="usercard-mini__text">
                        <?php echo $row['lastname']." ".$row['firstname'] ?>
                    </span>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</div>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="front.js" type="application/javascript"></script>
<script>
                var selected_tag = 0;
                var name = "";
                var uname = "";
                document.addEventListener("DOMContentLoaded", function () {
                    var heightMain = document.getElementById('main').clientHeight;
                    var heightScreen = document.body.clientHeight;
                    var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;

                    

                    var ends = document.querySelectorAll('.usercard-mini');
                    for (i = 0; i < ends.length; i++) {
                        ends[i].addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            event.currentTarget.classList.add('selected_tag');
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            name = event.currentTarget.getAttribute("data-name");
                            uname = event.currentTarget.getAttribute("data-email");
                            document.location.href = "confirm_request.php?sid="+selected_tag;
                        });
                        
                    }
                });

                var request_activation = function (ev) {
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', '../confirm_request.php');

                    formData.append('student', selected_tag);
                    formData.append('uname', uname);
                    formData.append('cid', 0);
                    formData.append('action', 'add_student');
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                document.location.href = document.location.href;
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
                };
            </script>
</body>
</html>