<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Gestione categorie</title>
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
                            while ($row = $res->fetch_assoc()) {
                                $style="unused_card";
                                if($row['books'] > 0) {
                                    $style = "librarian_card";
                                }
                                ?>
                                <a href="category.php?cid=<?php echo $row['cid'] ?>" data-id="<?php echo $row['cid'] ?>" id="item<?php echo $row['cid'] ?>" data-books="<?php echo $row['books'] ?>" class="_2sides-horiz-card-mini">
                                    <span class="_2sides-horiz-card-mini__icon-cont <?php echo $style ?>" role="presentation">
                                        <i class="material-icons">category</i>
                                    </span>
                                    <span class="_2sides-horiz-card-mini__text">
                                        <?php echo $row['category'] ?>
                                    </span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="right_col">
                    <?php include_once "menu_books.php" ?>
                </div>
                <div id="right_space"></div>
            </div>
            <?php include_once "../share/footer.php" ?>
            <button id="newcls" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuova categoria">
                <span class="mdc-fab__icon">
                    add
                </span>
            </button>
            <div id="cat_context_menu" class="mdc-elevation--z2">
                <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
                    <a href="#" id="open_cat">
                        <i class="material-icons">mode_edit</i>
                        <span>Modifica</span>
                    </a>
                </div>
                <div id="destroy_item" class="item" style="">
                    <a href="#" id="remove_cat">
                        <i class="material-icons">delete</i>
                        <span>Elimina</span>
                    </a>
                </div>
            </div>
            <script>
                var selected_tag = 0;
                document.addEventListener("DOMContentLoaded", function () {
                    var btn = document.getElementById('newcls');
                    var pos = scroll_button(btn);
                    var top = document.getElementById('header').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
                    var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
                    console.log("top="+top);
                    console.log("left="+left);
                    btn.style.top = top+"px";
                    btn.style.left = left+"px";
                    btn.style.position = 'fixed';
                    btn.style.zIndex = '99';

                    btn.addEventListener('click', function () {
                        window.location = 'category.php?cid=0';
                    });

                    document.getElementById('left_col').addEventListener('contextmenu', function (ev) {
                        ev.preventDefault();
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        clear_context_menu(ev, 'cat_context_menu');
                        return false;
                    });
                    document.getElementById('left_col').addEventListener('click', function (ev) {
                        ev.preventDefault();
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        clear_context_menu(ev, 'cat_context_menu');
                        return false;
                    });
                    document.getElementById('open_cat').addEventListener('click', function (ev) {
                        alert("click");
                        open_in_browser();
                    });

                    document.getElementById('remove_cat').addEventListener('click', function (ev) {
                        if(document.getElementById("item"+selected_tag).getAttribute("data-books") > 0){
                            var msg = new Object();
                            msg.data_field = "warning";
                            msg.warning_message = "Impossibile cancellare la categoria perché vi sono dei libri associati.<br />Per eliminare la categoria, modifica prima i libri";
                            msg.focus = null;
                            msg.message = "Operazione non consentita";
                            clear_context_menu(ev, 'cat_context_menu');
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag')
                            j_alert("information", msg);
                            return;
                        }
                        
                        j_alert("confirm", "Questa operazione è definitiva.<br/>Vuoi davvero eliminare questa categoria dall'archivio?");
                        document.getElementById('okbutton').addEventListener('click', function (ev) {
                            event.preventDefault();
                            remove_item(ev);
                        });
                        document.getElementById('nobutton').addEventListener('click', function (ev) {
                            event.preventDefault();
                            clear_context_menu(ev, 'cat_context_menu');
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag')
                            fade('overlay', 'out', .1, 0);
                            fade('confirm', 'out', .3, 0);
                            return false;
                        })
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
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            clear_context_menu(event, 'cat_context_menu');
                        });
                        ends[i].addEventListener('contextmenu', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            clear_context_menu(event, 'cat_context_menu');
                            event.currentTarget.classList.add('selected_tag');
                            current_target_id = event.currentTarget.getAttribute("data-id");
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            show_context_menu(event, null, 150, 'cat_context_menu');
                            
                        });  
                        ends[i].addEventListener('dblclick', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            open_in_browser();
                        });
                    }
                });

                var open_in_browser = function () {
                    document.location.href = 'category.php?cid='+selected_tag;
                };

                var remove_item = function (ev) {
                    fade('confirm', 'out', .1, 0);
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'category_manager.php');
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
                                clear_context_menu(ev, 'cat_context_menu');
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