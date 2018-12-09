<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione classi</title>
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
		<div id="content" style="width: 90%; margin: auto;">
			<div class="normal _bold" style="font-size: 2em; margin-left: 10px">
				<?php echo $class->toString(SchoolClass::$FIRST_UPPER) ?>
			</div>
			<div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; justify-content: left; margin: auto">
				<?php
				while ($row = $res_students->fetch_assoc()) {
					$url = urlencode('class_students.php?cid='.$_REQUEST['cid']);
					?>
					<a href="user.php?uid=<?php echo $row['uid'] ?>&back=<?php echo $url ?>" data-id="<?php echo $row['uid'] ?>" id="item<?php echo $row['uid'] ?>" class="mdc-list-item mdc-elevation--z3 tag">
						<span class="mdc-list-item__start-detail _bold" role="presentation">
							<i class="material-icons accent_color">person</i>
						</span>
						<span class="mdc-list-item__text">
						  <?php echo $row['lastname']." ".$row['firstname'] ?>
						</span>
					</a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script>
    var selected_tag = 0;
    document.addEventListener("DOMContentLoaded", function () {
        var heightMain = document.getElementById('main').clientHeight;
        var heightScreen = document.body.clientHeight;
        var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;
        var btn = document.getElementById('newcls');
        btn.style.top = (usedHeight)+"px";
        //btn.style.top = '700px';

        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - document.getElementById('main').clientWidth) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
        btn.style.right = (right_offset - 18)+"px";

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

        var ends = document.querySelectorAll('.mdc-list-item');
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
                show_context_menu(event, null, 150, 'class_context_menu');
                selected_tag = event.currentTarget.getAttribute("data-id");
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
                    document.location.href = 'classes.php?active=1';
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>