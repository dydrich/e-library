<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Gestione classi</title>
        <link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
        <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
        <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
        <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
        <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
        <script type="application/javascript" src="../js/page.js"></script>
        <style>
            div.item:first-of-type {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                border-top-color: var(--mdc-theme-secondary);
                border-top: 1px solid var(--mdc-theme-secondary);
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
                    <div id="content" style="width: 90%; margin: auto;">
                        <div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; align-items: center; flex-direction: row; column-gap: 40px; justify-content: center; margin: auto; row-gap: 40px">
                            <?php
                            while ($row = $res_students->fetch_assoc()) {
                                $url = urlencode('class_students.php?cid='.$_REQUEST['cid']);
                                $style="student_card";
                                if($row['rid'] == 2) {
                                    $style = "librarian_card";
                                }
                                ?>
                                <a href="user.php?uid=<?php echo $row['uid'] ?>&back=<?php echo $url ?>" data-id="<?php echo $row['uid'] ?>" id="item<?php echo $row['uid'] ?>" class="_2sides-horiz-card-mini">
                                    <span class="_2sides-horiz-card-mini__icon-cont <?php echo $style ?>" role="presentation">
                                        <i class="material-icons">person</i>
                                    </span>
                                    <span class="_2sides-horiz-card-mini__text">
                                        <?php echo $row['lastname']." ".$row['firstname'] ?>
                                    </span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="right_col">
                    <?php include_once "menu.php" ?>
                </div>
                <div id="right_space"></div>
            </div>
            <?php include_once "../share/footer.php" ?>
            <div id="student_context_menu" class="mdc-elevation--z2">
                <div class="label_menu_item" style="border-bottom: 1px solid var(--mdc-theme-secondary)">
                    <span>Assegna a...</span>
                </div>
                <?php
                while ($row = $res_classes->fetch_assoc()) {
                    ?>
                    <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                        <a href="#" data-id="<?php echo $row['cid'] ?>" class="destination">
                            <i class="material-icons">people</i>
                            <span><?php echo $row['year'].$row['section'] ?></span>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                    <a href="#" data-id="0" class="destination">
                        <i class="material-icons">people</i>
                        <span>ASC</span>
                    </a>
                </div>
            </div>
            <script>
                var selected_tag = 0;
                document.addEventListener("DOMContentLoaded", function () {
                    var heightMain = document.getElementById('main').clientHeight;
                    var heightScreen = document.body.clientHeight;
                    var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;

                    document.getElementById('left_col').addEventListener('contextmenu', function (ev) {
                        ev.preventDefault();
                        clear_context_menu(ev, 'student_context_menu');
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        return false;
                    });
                    document.getElementById('content').addEventListener('click', function (ev) {
                        ev.preventDefault();
                        clear_context_menu(ev, 'student_context_menu');
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        return false;
                    });

                    var ends = document.querySelectorAll('._2sides-horiz-card-mini');
                    for (i = 0; i < ends.length; i++) {
                        ends[i].addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            event.currentTarget.classList.add('selected_tag');
                            selected_tag = event.currentTarget.getAttribute("data-id")
                        });
                        ends[i].addEventListener('contextmenu', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            event.currentTarget.classList.add('selected_tag');
                            current_target_id = event.currentTarget.getAttribute("data-id");
                            //clear_context_menu(event);
                            show_context_menu(event, null, 150, 'student_context_menu');
                            selected_tag = event.currentTarget.getAttribute("data-id");
                        });
                    }
                    var links = document.querySelectorAll('.destination');
                    for (i = 0; i < links.length; i++) {
                        links[i].addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            cls = event.currentTarget.getAttribute("data-id");
                            move_student(event, selected_tag, cls);
                        });
                    }
                });

                var move_student = function (ev, student, cls) {
                    clear_context_menu(ev, 'student_context_menu');

                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'student_manager.php');
                    var action = <?php echo ACTION_RESTORE ?>;

                    formData.append('cid', cls);
                    formData.append('student', student);
                    formData.append('action', 'move_student');
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                j_alert("alert", xhr.response.message);
                                document.getElementById('item'+selected_tag).style.display = 'none';
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
                };
            </script>
        </div>
    </body>
</html>