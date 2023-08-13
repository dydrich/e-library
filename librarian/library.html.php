<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione libri</title>
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
            <div id="content" style="width: 90%; margin: auto; display: flex">
                <?php
                while ($row = $res_books->fetch_assoc()) {
                ?>
                <div class="book-card">
                    <div class="book-cover">
                        <img src="<?php echo $covers_home.$row['cover'] ?>" alt=""/>
                    </div>
                    <div class="book-data">
                        <p style="margin: 10px 0 0 0; font-weight: bold"><?php echo $row['title'] ?>
                        <p style="margin: 5px 0 0 0; font-style: italic"><?php echo $row['author'] ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div id="right_col">
            <?php include_once "menu_books.php" ?>
        </div>
        <div id="right_space"></div>
        <button id="newbook" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo libro">
            <span class="mdc-fab__icon">
                add
            </span>
        </button>
    </div>
    <?php include_once "../share/footer.php" ?>
    <div id="book_context_menu" class="mdc-elevation--z2">
        <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
            <a href="#" id="open_book">
                <i class="material-icons">open_in_browser</i>
                <span>Modifica</span>
            </a>
        </div>
        <div id="profile" class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
            <a href="#" id="profile_book">
                <i class="material-icons">screen_share</i>
                <span>Stato</span>
            </a>
        </div>
        <div id="history" class="item">
            <a href="#" id="history_book">
                <i class="material-icons">poll</i>
                <span>Storico</span>
            </a>
        </div>
        <div id="delete" class="item">
            <a href="#" id="delete_book">
                <i class="material-icons">delete</i>
                <span>Elimina</span>
            </a>
        </div>
    </div>
    <script>
        var selected_tag = 0;
        var is_active = '1';
        document.addEventListener("DOMContentLoaded", function () {
            var btn = document.getElementById('newbook');
            var pos = scroll_button(btn);
            var top = document.getElementById('header').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
            var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
            console.log("top="+top);
            console.log("left="+left);
            btn.style.top = top+"px";
            btn.style.left = left+"px";
            btn.style.position = 'fixed';
            btn.style.zIndex = 3;

            btn.addEventListener('click', function () {
                window.location = 'book.php?book_id=0&back=library.php';
            });
            document.getElementById('main').addEventListener('contextmenu', function (ev) {
                ev.preventDefault();
                clear_context_menu(ev, 'book_context_menu');
                if (selected_tag !== 0) {
                    document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                }
                return false;
            });
            document.getElementById('left_col').addEventListener('click', function (ev) {
                ev.preventDefault();
                clear_context_menu(ev, 'book_context_menu');
                if (selected_tag !== 0) {
                    document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                }
                return false;
            });

            var ends = document.querySelectorAll('.file-card');
            for (var i = 0; i < ends.length; i++) {
                document.getElementById('open_book').addEventListener('click', function (event) {
                    event.preventDefault();
                    open_in_browser();
                });
                document.getElementById('profile_book').addEventListener('click', function (event) {
                    event.preventDefault();
                    deactivate_item(event);
                });
                document.getElementById('history_book').addEventListener('click', function (event) {
                    event.preventDefault();
                    activate_item(event);
                });
                document.getElementById('delete_book').addEventListener('click', function (event) {
                    j_alert("confirm", "Eliminare il libro?");
                    document.getElementById('okbutton').addEventListener('click', function (event) {
                        event.preventDefault();
                        remove_item(event);
                    });
                    document.getElementById('nobutton').addEventListener('click', function (event) {
                        event.preventDefault();
                        fade('overlay', 'out', .1, 0);
                        fade('confirm', 'out', .3, 0);
                        return false;
                    });
                });

                ends[i].addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    clear_context_menu(event, 'book_context_menu');
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
                    show_context_menu(event, null, 150, 'book_context_menu');
                    if (current_target_id === '0') {

                    }
                    else {

                    }
                });
                ends[i].addEventListener('dblclick', function (event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    selected_tag = event.currentTarget.getAttribute("data-id");
                    open_in_browser();
                });
            }
            
            var open_in_browser = function () {
                document.location.href = 'book.php?book_id='+selected_tag+'&back=library.php';
            };
        });

        var remove_item = function (ev) {
            fade('confirm', 'out', .1, 0);
            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'book_manager.php');
            var action = <?php echo ACTION_DELETE ?>;

            formData.append('book_id', selected_tag);
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
                        clear_context_menu(ev, 'book_context_menu');
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