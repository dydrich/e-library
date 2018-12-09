<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione anni scolastici</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
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
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
<div id="main">
	<div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
	<div id="left_col">
		<div style="display: flex; flex-wrap: wrap">
            <div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; justify-content: left; margin: auto">
				<?php
				while ($row = $res_years->fetch_assoc()) {
					?>
                    <a href="year.php?_id=<?php echo $row['_id'] ?>&back=years.php" data-id="<?php echo $row['_id'] ?>" id="item<?php echo $row['_id'] ?>"  class="mdc-list-item mdc-elevation--z3" data-mdc-auto-init="MDCRipple">
						<span class="mdc-list-item__start-detail _bold <?php if($row['current_year'] == 1) echo 'accent_color' ?>" role="presentation">
							<i class="material-icons">style</i>
						</span>
                        <span class="mdc-list-item__text <?php if($row['current_year'] == 1) echo 'accent_color' ?>">
						  <?php echo $row['description'] ?>
						</span>
                        <span class="mdc-list-item__end-detail material-icons accent_color" style="display: none; font-size: 1rem; position: relative; right: -7px; top: -7px">
                            delete
                        </span>
                    </a>
					<?php
				}
				?>
            </div>
        </div>
	</div>
    <button id="newyear" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo anno">
        <span class="mdc-fab__icon">
            create
        </span>
    </button>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script>
    var selected_tag = 0;
    document.addEventListener("DOMContentLoaded", function () {
        var heightMain = document.getElementById('main').clientHeight;
        var heightScreen = document.body.clientHeight;
        var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;
        var btn = document.getElementById('newyear');
        btn.style.top = (usedHeight)+"px";
        //btn.style.top = '700px';

        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - document.getElementById('main').clientWidth) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
        btn.style.right = (right_offset - 18)+"px";

        btn.addEventListener('click', function () {
            window.location = 'year.php?_id=0&back=years.php';
        });

        document.getElementById('left_col').addEventListener('contextmenu', function (ev) {
            ev.preventDefault();
            clear_context_menu(ev, 'yearcontext_menu');
            if (selected_tag !== 0) {
                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
            }
            return false;
        });
        document.getElementById('left_col').addEventListener('click', function (ev) {
            ev.preventDefault();
            clear_context_menu(ev, 'yearcontext_menu');
            if (selected_tag !== 0) {
                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
            }
            return false;
        });

        var ends = document.querySelectorAll('.mdc-list-item');
        for (i = 0; i < ends.length; i++) {
            document.getElementById('open_item').addEventListener('click', function (ev) {
                open_in_browser();
            });
            document.getElementById('default_item').addEventListener('click', function (ev) {
                set_default(ev);
            });
            document.getElementById('remove_item').addEventListener('click', function (ev) {
                j_alert("confirm", "Eliminare l'anno?");
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
                current_target_id = event.currentTarget.getAttribute("data-id");
                //clear_context_menu(event);
                show_context_menu(event, null, 150, 'yearcontext_menu');
                selected_tag = event.currentTarget.getAttribute("data-id");
            });
            ends[i].addEventListener('dblclick', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                selected_tag = event.currentTarget.getAttribute("data-id");
                open_in_browser();
            });
        }

        var open_in_browser = function () {
            document.location.href = 'year.php?_id='+selected_tag+'&back=years.php';
        };


    });

    var remove_item = function (ev) {
        fade('confirm', 'out', .1, 0);
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'year_manager.php');
        var action = <?php echo ACTION_DELETE ?>;

        formData.append('_id', selected_tag);
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
                    clear_context_menu(ev, 'yearcontext_menu');
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

    var set_default = function (ev) {
        clear_context_menu(ev, 'yearcontext_menu');
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'year_manager.php');
        var action = 'SET_AS_DEFAULT';

        formData.append('_id', selected_tag);
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
                        window.location = 'years.php';
                    }, 2500);
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>