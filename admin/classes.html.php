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
            .app-fab--absolute.app-fab--absolute {
                position: fixed;
                /*right: 39rem;*/
            }
        </style>
    </head>
    <body>
        <div id="page" class="page">
            <?php include_once "../share/header.php" ?>
            <?php include_once "../share/nav_mdtabs.php" ?>
            <div id="main">
                <div id="left_space"></div>
                <div id="left_col">
                    <div id="content" style="width: 90%; margin: auto;">
                        <div class="mdc-list" style="display: flex; flex-wrap: wrap; align-items: center; flex-direction: row; column-gap: 40px; justify-content: center; margin: auto">
                            <?php
                            while ($row = $res_classes->fetch_assoc()) {
                                ?>
                                <a href="class.php?cid=<?php echo $row['cid'] ?>&back=classes.php" data-id="<?php echo $row['cid'] ?>" data-active="<?php echo $row['active'] ?>" id="item<?php echo $row['cid'] ?>" class="square-card">
                                    <span class="square-card__circle normal_card">
                                        <?php echo $row['year'].$row['section'] ?>
                                    </span>
                                </a>
                                <?php
                            }
                            //if ($noclass_students > 0) {
                                ?>
                                <a href="class.php?cid=0&back=classes.php" data-id="0" data-active="1" id="item0" class="square-card">
                                    <span class="square-card__circle accent_card">
                                    SC
                                    </span>
                                </a>
                            <?php
                            //}
                            ?>

                        </div>
                    </div>
                </div>
                <div id="right_col">
                    <?php include_once "menu.php" ?>
                </div>
                <div id="right_space"></div>
                <button id="newcls" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuova classe">
                    <span class="mdc-fab__icon">
                        create
                    </span>
                </button>
            </div>
            <?php include_once "../share/footer.php" ?>

            <div id="class_context_menu" class="mdc-elevation--z2">
                <div id="open_cls_item" class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                    <a href="#" id="open_cls">
                        <i class="material-icons">mode_edit</i>
                        <span>Modifica</span>
                    </a>
                </div>
                <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                    <a href="#" id="students_cls">
                        <i class="material-icons">people</i>
                        <span>Alunni</span>
                    </a>
                </div>
                <div id="deactivate_cls_item" class="item">
                    <a href="#" id="inactive_cls">
                        <i class="material-icons">sync_disabled</i>
                        <span>Disattiva</span>
                    </a>
                </div>
                <div id="activate_cls_item" class="item">
                    <a href="#" id="active_cls">
                        <i class="material-icons">sync</i>
                        <span>Attiva</span>
                    </a>
                </div>
                <div id="destroy_cls" class="item" style="border-top: 1px solid rgba(0, 0, 0, .10)">
                    <a href="#" id="remove_cls">
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
                    var top = document.getElementById('header').getBoundingClientRect().height + document.getElementById('navigation-with-mdtabs').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
                    var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
                    console.log("top="+top);
                    console.log("left="+left);
                    btn.style.top = top+"px";
                    btn.style.left = left+"px";
                    btn.style.position = 'fixed';

                    btn.addEventListener('click', function () {
                        window.location = 'class.php?cid=0&back=classes.php';
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

                    var ends = document.querySelectorAll('.square-card');
                    for (i = 0; i < ends.length; i++) {
                        document.getElementById('open_cls').addEventListener('click', function (ev) {
                            open_in_browser();
                        });
                        document.getElementById('students_cls').addEventListener('click', function (event) {
                            event.preventDefault();
                            list_students(event);
                        });
                        document.getElementById('inactive_cls').addEventListener('click', function (event) {
                            event.preventDefault();
                            deactivate_item(event);
                        });
                        document.getElementById('active_cls').addEventListener('click', function (event) {
                            event.preventDefault();
                            activate_item(event);
                        });
                        document.getElementById('remove_cls').addEventListener('click', function (ev) {
                            j_alert("confirm", "Eliminare la classe?");
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
                            is_active = event.currentTarget.getAttribute("data-active");
                            selected_tag = event.currentTarget.getAttribute("data-id")
                        });
                        ends[i].addEventListener('contextmenu', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            event.currentTarget.classList.add('selected_tag');
                            is_active = event.currentTarget.getAttribute("data-active");
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            current_target_id = event.currentTarget.getAttribute("data-id");
                            //clear_context_menu(event);
                            show_context_menu(event, null, 150, 'class_context_menu');
                            if (current_target_id === '0') {
                                document.getElementById('activate_cls_item').style.display = 'none';
                                document.getElementById('destroy_cls').style.display = 'none';
                                document.getElementById('deactivate_cls_item').style.display = 'none';
                                document.getElementById('open_cls_item').style.display = 'none';
                            }
                            else {
                                document.getElementById('open_cls_item').style.display = '';
                                if (is_active === '1') {
                                    document.getElementById('activate_cls_item').style.display = 'none';
                                    document.getElementById('deactivate_cls_item').style.display = '';
                                    document.getElementById('destroy_cls').style.display = 'none';
                                }
                                else {
                                    document.getElementById('activate_cls_item').style.display = '';
                                    document.getElementById('deactivate_cls_item').style.display = 'none';
                                    document.getElementById('destroy_cls').style.display = '';
                                }
                            }
                        });
                        ends[i].addEventListener('dblclick', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            open_in_browser();
                        });
                    }

                    var list_students = function (event) {
                        document.location.href = 'class_students.php?cid='+selected_tag+'&back=classes.php';
                    };

                    var open_in_browser = function () {
                        document.location.href = 'class.php?cid='+selected_tag+'&back=classes.php';
                    };
                });

                var remove_item = function (ev) {
                    fade('confirm', 'out', .1, 0);
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'class_manager.php');
                    var action = <?php echo ACTION_DELETE ?>;

                    formData.append('cid', selected_tag);
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

                var deactivate_item = function (ev) {
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'class_manager.php');
                    var action = <?php echo ACTION_DEACTIVATE ?>;

                    formData.append('cid', selected_tag);
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

                var activate_item = function (ev) {
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'class_manager.php');
                    var action = <?php echo ACTION_RESTORE ?>;

                    formData.append('cid', selected_tag);
                    formData.append('action', action);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                j_alert("alert", xhr.response.message);
                                window.setTimeout(function(){
                                    document.location.href = 'classes.php?active=1';
                                }, 2000);
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