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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <script type="application/javascript" src="../js/page.js"></script>
    <style>
        .demo-card {
            margin-left: 25px;
            margin-bottom: 25px;
        }

        .app-fab--absolute.app-fab--absolute {
             position: fixed;
             bottom: 4rem;
             right: 38.6rem;
         }

        .mdc-card__primary {
            padding: 1px 16px 0 16px
        }

        .mdc-card__action {
            padding: 0;
            margin: 0;
        }

        .upd {
            height: 30px;
        }

        .mdc-card__title {
            margin-bottom: 10px;
        }

        .mdc-card__subtitle {
            font-style: italic;
            color: rgba(0, 0, 0, .54);
            margin-top: 0;
            margin-bottom:0;
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
        <div id="content" style="margin: auto; display: flex; flex-wrap: wrap; align-content: center; align-items: center">
            <?php
			foreach ($users as $_user) {
			    if ($_user['person_in_charge'] == 1) {
					$color = "#EF6C00";
                }
                else if ($_user['role'] == User::$ADMIN) {
					$color = "#1E4389";
                }
				else if ($_user['role'] == User::$LIBRARIAN) {
					$color = "#c2185b";
				}
                else {
					$color = "#7E57C2";
                }
            ?>
                <div id="user<?php echo $_user['uid'] ?>" data-id="user<?php echo $_user['uid'] ?>" class="mdc-card demo-card">
                    <a href="user.php?uid=<?php echo $_user['uid'] ?>&back=users.php" style="color: #263238" data-id="<?php echo $_user['uid'] ?>" data-active="<?php echo $_user['active'] ?>" id="item<?php echo $_user['uid'] ?>" class="user_item">
                        <div class="mdc-card__horizontal-block" style="display: flex; flex-flow: row wrap">
                            <section class="mdc-card__primary" style="order: 1; flex: 3 75%">
                                <h1 class="mdc-card__title"><?php echo $_user['lastname']." ".$_user['firstname'] ?></h1>
                                <h2 class="mdc-card__subtitle"><?php echo User::getHumanReadableRole($_user['role']) ?></h2>
                            </section>
                            <i class="material-icons" style="font-size: 2.5em; color: <?php echo $color ?>; order: 2; flex: 1 25%; margin-top: 10px">people</i>
                           <!-- <section class="" style="order: 3; flex: 1 100%; padding-left: 10px">
                                <button type="submit" class="mdc-button mdc-button--compact mdc-card__action upd" data-uid="<?php echo $_user['uid'] ?>">Modifica</button>
                                <?php if ($_user['active'] == 1): ?>
                                    <button class="mdc-button mdc-button--compact mdc-card__action del" data-uid="<?php echo $_user['uid'] ?>">Elimina</button>
                                <?php else: ?>
                                    <button class="mdc-button mdc-button--compact mdc-card__action res" data-uid="<?php echo $_user['uid'] ?>">Ripristina</button>
                                <?php endif; ?>
                            </section>-->
                        </div>
                    </a>

                </div>
            <?php
            }
            ?>
        </div>
	</div>
    <div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
    <div id="right_space"></div>
    <?php include_once "../share/footer.php" ?>
    <button id="newuser" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo utente" style="z-index: 3">
        <span class="mdc-fab__icon">
            create
        </span>
    </button>
</div>

<div id="user_context_menu" class="mdc-elevation--z2">
    <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
        <a href="#" id="open_user">
            <i class="material-icons">mode_edit</i>
            <span>Modifica</span>
        </a>
    </div>
    <div id="it_delete" class="item">
        <a href="#" id="deactivate_user">
            <i class="material-icons">sync_disabled</i>
            <span>Disattiva</span>
        </a>
    </div>
    <div id="it_restore" class="item">
        <a href="#" id="activate_user">
            <i class="material-icons">sync</i>
            <span>Ripristina</span>
        </a>
    </div>
    <div id="it_destroy" class="item" style="border-top: 1px solid rgba(0, 0, 0, .10)">
        <a href="#" id="remove_user">
            <i class="material-icons">delete</i>
            <span>Elimina</span>
        </a>
    </div>
</div>
<script type="application/javascript">
    var selected_tag = 0;
    var is_active = 1;
    document.addEventListener("DOMContentLoaded", function () {
        var btn = document.getElementById('newuser');
        var pos = scroll_button(btn);
        var top = document.getElementById('header').getBoundingClientRect().height + document.getElementById('navigation-with-mdtabs').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
        var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
        console.log("top="+top);
        console.log("left="+left);
        btn.style.top = top+"px";
        btn.style.left = left+"px";
        btn.style.position = 'fixed';

        document.getElementById('left_col').addEventListener('contextmenu', function (ev) {
            ev.preventDefault();
            clear_context_menu(ev, 'user_context_menu');
            if (selected_tag !== 0) {
                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                document.getElementById('user'+selected_tag).classList.remove('selected_tag_parent');
            }
            return false;
        });
        document.getElementById('content').addEventListener('click', function (ev) {
            ev.preventDefault();
            clear_context_menu(ev, 'user_context_menu');
            if (selected_tag !== 0) {
                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                document.getElementById('user'+selected_tag).classList.remove('selected_tag_parent');
            }
            return false;
        });

        var ends = document.querySelectorAll('.user_item');
        for (i = 0; i < ends.length; i++) {
            document.getElementById('open_user').addEventListener('click', function (ev) {
                open_in_browser();
            });
            document.getElementById('deactivate_user').addEventListener('click', function (event) {
                j_alert("confirm", "Disattivare l'utente?");
                document.getElementById('okbutton').addEventListener('click', function (event) {
                    event.preventDefault();
                    deactivate_item(event);
                });
            });
            document.getElementById('activate_user').addEventListener('click', function (event) {
                event.preventDefault();
                restore_user(event);
            });
            document.getElementById('remove_user').addEventListener('click', function (ev) {
                j_alert("confirm", "Eliminare definitivamente l'utente?");
                document.getElementById('okbutton').addEventListener('click', function (event) {
                    event.preventDefault();
                    destroy_item(event);
                });
            });
            document.getElementById('nobutton').addEventListener('click', function (event) {
                event.preventDefault();
                fade('overlay', 'out', .1, 0);
                fade('confirm', 'out', .3, 0);
                return false;
            });
            ends[i].addEventListener('click', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                if (selected_tag !== 0) {
                    document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                    document.getElementById('user'+selected_tag).classList.remove('selected_tag_parent');
                }
                selected_tag = event.currentTarget.getAttribute("data-id");
                is_active = event.currentTarget.getAttribute("data-active");
                event.currentTarget.classList.add('selected_tag');
                document.getElementById('user'+selected_tag).classList.add('selected_tag_parent');
            });
            ends[i].addEventListener('contextmenu', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                if (selected_tag !== 0) {
                    document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                    document.getElementById('user'+selected_tag).classList.remove('selected_tag_parent');
                }
                selected_tag = event.currentTarget.getAttribute("data-id");
                is_active = event.currentTarget.getAttribute("data-active");
                event.currentTarget.classList.add('selected_tag');
                document.getElementById('user'+selected_tag).classList.add('selected_tag_parent');
                current_target_id = event.currentTarget.getAttribute("data-id");
                //clear_context_menu(event);
                show_context_menu(event, null, 150, 'user_context_menu');
                if (is_active === '1') {
                    document.getElementById('it_restore').style.display = 'none';
                    document.getElementById('it_delete').style.display = '';
                    document.getElementById('it_destroy').style.display = 'none';
                }
                else {
                    document.getElementById('it_restore').style.display = '';
                    document.getElementById('it_delete').style.display = 'none';
                    document.getElementById('it_destroy').style.display = '';
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
            document.location.href = 'user.php?uid='+selected_tag+'&back=users.php';
        };

        var deactivate_item = function (event) {
            del_user(event, false);
        };

        var destroy_item = function (event) {
            del_user(event, true);
        };

        var del_user = function(event, delete_from_db){
            fade('confirm', 'out', .1, 0);
            clear_context_menu(event, 'user_context_menu');
            var url = "users_manager.php";

            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'user_manager.php');
            var uid = selected_tag;
            var action = null;
            if (delete_from_db) {
                action = <?php echo ACTION_DESTROY ?>;
            }
            else {
                action = <?php echo ACTION_DELETE ?>;
            }

            formData.append('uid', uid);
            formData.append('action', action);
            xhr.responseType = 'json';
            xhr.send(formData);
            xhr.onreadystatechange = function () {
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        j_alert('alert', xhr.response.message);
						<?php if(isset($_GET['active'])): ?>
                        document.getElementById("user"+uid).style.display = 'none';
                        <?php else: ?>
                        var btn = document.querySelector('#user'+uid+" section button.del");
                        btn.classList.remove('del');
                        btn.classList.add('res');
                        btn.innerText = "Ripristina";
                        <?php endif; ?>
                    }
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };

        var restore_user = function(event){
            var url = "users_manager.php";
            clear_context_menu(event, 'user_context_menu');
            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'user_manager.php');
            var action = <?php echo ACTION_RESTORE ?>;

            formData.append('uid', selected_tag);
            formData.append('action', action);
            xhr.responseType = 'json';
            xhr.send(formData);
            xhr.onreadystatechange = function () {
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        j_alert("alert", xhr.response.message);
                        <?php if(isset($_GET['active']) && $_GET['active'] == 0): ?>
                        window.setTimeout(function () {
                            window.location.href = "users.php?active=1";
                        }, 2500);
                        <?php else: ?>
                        var btn = document.querySelector('#user'+uid+" section button.res");
                        btn.classList.remove('res');
                        btn.classList.add('del');
                        btn.innerText = "Elimina";
                        <?php endif; ?>
                    }
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };
    });

    var btn = document.getElementById('newuser');
    btn.addEventListener('click', function (event) {
        event.preventDefault();
        document.location.href = 'user.php?uid=0&back=users.php';
    });
</script>
</body>
</html>