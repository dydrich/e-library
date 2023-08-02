<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Gestione locali libreria</title>
        <link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
        <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
        <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
        <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
        <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
        <script type="application/javascript" src="../js/page.js"></script>
        <style>
            .app-fab--absolute.app-fab--absolute {
                position: fixed;
                /*right: 39rem;*/
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
                        <div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; justify-content: center; margin: auto; column-gap: 30px; row-gap: 40px">
                        <?php
                        foreach ($rooms as $idv => $room) {
                        ?>
                            <a href="room.php?uid=<?php echo $idv ?>" data-id="<?php echo $idv ?>" id="item<?php echo $idv ?>">
                                <div id="room<?php echo $idv ?>" data-id="<?php echo $idv ?>" class="user-card">
                                    <div class="user-card__name"><?php echo $room['room'] ?></div>
                                    <div class="user-card__icon">
                                        <i class="material-icons librarian_color">location_on</i>
                                    </div>
                                    <div class="user-card__role"><?php echo $room['venue']['venue'] ?></div>
                                </div>
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
                <button id="newcls" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo locale">
                    <span class="mdc-fab__icon">
                        create
                    </span>
                </button>
            </div>
            <?php include_once "../share/footer.php" ?>
            <div id="class_context_menu" class="mdc-elevation--z2">
            <div id="open_room_item" class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                <a href="#" id="open_room">
                    <i class="material-icons">mode_edit</i>
                    <span>Modifica</span>
                </a>
            </div>
            <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                <a href="#" id="bookcases_room">
                    <i class="material-icons">work</i>
                    <span>Armadi</span>
                </a>
            </div>
            <div id="destroy_room" class="item" style="">
                <a href="#" id="remove_room">
                    <i class="material-icons">delete</i>
                    <span>Elimina</span>
                </a>
            </div>
            </div>
            <script>
                var selected_tag = 0;
                var is_active = '1';
                document.addEventListener("DOMContentLoaded", function () {
                    var btn = document.getElementById('newcls');
                    var pos = scroll_button(btn);
                    var top = document.getElementById('header').getBoundingClientRect().height + document.getElementById('navigation').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
                    var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
                    console.log("top="+top);
                    console.log("left="+left);
                    btn.style.top = top+"px";
                    btn.style.left = left+"px";
                    btn.style.position = 'fixed';
                    btn.style.zIndex = 3;

                    btn.addEventListener('click', function () {
                        window.location = 'room.php?rid=0&back=rooms.php';
                    });

                    document.getElementById('left_col').addEventListener('contextmenu', function (ev) {
                        ev.preventDefault();
                        clear_context_menu(ev, 'class_context_menu');
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        return false;
                    });
                    document.getElementById('content').addEventListener('click', function (ev) {
                        ev.preventDefault();
                        clear_context_menu(ev, 'class_context_menu');
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        return false;
                    });

                    var ends = document.querySelectorAll('.user-card');
                    for (i = 0; i < ends.length; i++) {
                        document.getElementById('open_room').addEventListener('click', function (ev) {
                            open_in_browser();
                        });
                        document.getElementById('bookcases_room').addEventListener('click', function (event) {
                            event.preventDefault();
                            list_bookcases(event);
                        });
                        document.getElementById('remove_room').addEventListener('click', function (ev) {
                            j_alert("confirm", "Eliminare la sede?");
                            document.getElementById('okbutton').addEventListener('click', function (event) {
                                event.preventDefault();
                                remove_item(ev);
                            });
                            document.getElementById('nobutton').addEventListener('click', function (event) {
                                event.preventDefault();
                                fade('overlay', 'out', .1, 0);
                                fade('confirm', 'out', .3, 0);
                                return false;
                            })
                        });
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
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            current_target_id = event.currentTarget.getAttribute("data-id");
                            //clear_context_menu(event);
                            show_context_menu(event, null, 150, 'class_context_menu');

                        });
                        ends[i].addEventListener('dblclick', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            open_in_browser();
                        });
                    }

                    var list_bookcases = function (event) {
                        document.location.href = 'bookcases.php?rid='+selected_tag+'&back=rooms.php';
                    };

                    var open_in_browser = function () {
                        document.location.href = 'room.php?rid='+selected_tag+'&back=rooms.php';
                    };
                });

                var remove_item = function (ev) {
                    fade('confirm', 'out', .1, 0);
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'venue_manager.php');
                    var action = <?php echo ACTION_DELETE ?>;

                    formData.append('vid', selected_tag);
                    formData.append('action', action);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                j_alert("alert", xhr.response.message);
                                var item_to_del = document.getElementById('item'+selected_tag);
                                item_to_del.style.display = 'none';
                                clear_context_menu(ev, 'class_context_menu');
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