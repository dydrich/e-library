<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Admin area</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
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

        .mdc-card__subtitle {
            font-style: italic;
            color: rgba(0, 0, 0, .54);
        }
    </style>
</head>
<body>
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
<div id="main">
	<div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
	<div id="left_col">
        <div class="mdtabs">
            <div class="mdtab <?php if (!isset($_GET['active'])) echo "mdselected_tab" ?>">
                <a href="users.php"><span>Tutti</span></a>
            </div>
            <div class="mdtab <?php if ($_GET['active'] == 1) echo "mdselected_tab" ?>">
                <a href="users.php?active=1"><span>Attivi</span></a>
            </div>
            <div class="mdtab <?php if (isset($_GET['active']) && $_GET['active'] == 0) echo "mdselected_tab" ?>">
                <a href="users.php?active=0"><span>Non attivi</span></a>
            </div>
        </div>
        <div style="margin: auto; display: flex; flex-wrap: wrap; align-content: center; align-items: center">
            <?php
			foreach ($users as $user) {
                if ($user['role'] == \edocs\User::$USER) {
					$color = "#1565c0";
                }
                else if ($user['role'] == \edocs\User::$ADMIN) {
					$color = "#c2185b";
                }
                else {
					$color = "rgba(0, 0, 0, .45)";
                }
            ?>
                <div id="user<?php echo $user['uid'] ?>" class="mdc-card demo-card">
                    <div class="mdc-card__horizontal-block" style="display: flex; flex-flow: row wrap">
                        <section class="mdc-card__primary" style="order: 1; flex: 4 85%">
                            <h1 class="mdc-card__title"><?php echo $user['lastname']." ".$user['firstname'] ?></h1>
                            <h2 class="mdc-card__subtitle"><?php echo \edocs\User::getHumanReadableRole($user['role']) ?></h2>
                        </section>
                        <i class="material-icons" style="font-size: 2.5em; color: <?php echo $color ?>; order: 2; flex: 1 15%; margin-top: 10px">people</i>
                        <section class="" style="order: 3; flex: 1 100%; padding-left: 10px">
                            <button type="submit" class="mdc-button mdc-button--compact mdc-card__action upd" data-uid="<?php echo $user['uid'] ?>">Modifica</button>
							<?php if ($user['active'] == 1): ?>
                                <button class="mdc-button mdc-button--compact mdc-card__action del" data-uid="<?php echo $user['uid'] ?>">Elimina</button>
							<?php else: ?>
                                <button class="mdc-button mdc-button--compact mdc-card__action res" data-uid="<?php echo $user['uid'] ?>">Ripristina</button>
							<?php endif; ?>
                        </section>
                    </div>

                </div>
            <?php
            }
            ?>
        </div>
	</div>
    <button id="newuser" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo utente">
        <span class="mdc-fab__icon">
            create
        </span>
    </button>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script type="application/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var heightMain = document.getElementById('main').clientHeight;
        var heightScreen = document.body.clientHeight;
        var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;
        var btn = document.getElementById('newuser');
        btn.style.top = (usedHeight)+"px";
        //btn.style.top = '700px';

        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - document.getElementById('main').clientWidth) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
        btn.style.right = (right_offset - 18)+"px";

        document.body.addEventListener('click', function (event) {
            if (event.target.classList.contains('upd')) {
                uid = event.target.getAttribute('data-uid');
                window.location.href = 'user.php?uid='+uid+'&back=users.php';
            }
            if (event.target.classList.contains('del')) {
                user_to_del = event.target.getAttribute('data-uid');
                j_alert("confirm", "Eliminare l'utente?");
                document.getElementById('okbutton').addEventListener('click', function (event) {
                    event.preventDefault();
                    del_user();
                });
                document.getElementById('nobutton').addEventListener('click', function (event) {
                    event.preventDefault();
                    fade('overlay', 'out', .1, 0);
                    fade('confirm', 'out', .3, 0);
                    return false;
                })
            }
            if (event.target.classList.contains('res')) {
                uid = event.target.getAttribute('data-uid');
                restore_user(uid);
            }
        });

        document.getElementById('okbutton').addEventListener('click', function (event) {
            event.preventDefault();
            del_user();
        });

        var user_to_del = 0;
        var del_user = function(){
            fade('confirm', 'out', .1, 0);
            var url = "users_manager.php";

            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'user_manager.php');
            var uid = user_to_del;
            var action = <?php echo ACTION_DELETE ?>;

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

        var restore_user = function(uid){
            var url = "users_manager.php";

            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'user_manager.php');
            var action = <?php echo ACTION_RESTORE ?>;

            formData.append('uid', uid);
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