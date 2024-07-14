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
                    <p class="material_label _bold" style="color: var(--mdc-theme-primary); font-size: 1.5em; width: 100%; text-align: center; background-color: >?php echo $background_color ?>"><?php echo $response['message'] ?></p>
                </div>
                <?php
                if($response['status'] == "ok") { 
                ?>
                <div style="width: 100%; align-items: left; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                
                </div>
                <div>
                    <button type="button" class="mdc-button mdc-button--raised" id="confirmreq_button" style="margin-top: 10px">
                        Confermo
                    </button>
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
        document.getElementById("confirmreq_button").addEventListener("click", function(ev) {
            document.location.href = "admin/student_manager.php?action=add_student&student=<?php echo $student ?>";
        });
    });

    var add_student = function (ev) {
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'admin/student_manager.php');

        formData.append('student', <?php echo $student ?>);
        formData.append('cid', 0);
        formData.append('action', 'add_student');
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    j_alert("alert", xhr.response.message);
                    setTimeout(function () {
                        //document.location.href = "index.php";
                    }, 2000);

                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>