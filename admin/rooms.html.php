<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione locali libreria</title>
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
			<div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; justify-content: left; margin: auto">
				<?php
				$idx = 0;
				foreach ($venues as $idv => $venue) {
					$order = 1;
					?>
				<div class="venue_container mdc-elevation--z2" style="border: 1px solid <?php echo $_SESSION['venues'][$idv]['color'] ?>">
					<div class="venue_container_label" style="background-color: <?php echo $_SESSION['venues'][$idv]['color'] ?>">
						<span><?php echo $venue['venue'] ?></span>
					</div>
					<div style="display: flex; align-items: center; justify-content: center; flex-wrap: wrap; padding-bottom: 15px; padding-top: 35px">
						<?php
						foreach ($venue['rooms'] as $room) {
							?>
							<a href="room.php?rid=<?php echo $room['rid'] ?>&back=rooms.php" data-id="<?php echo $room['rid'] ?>" id="item<?php echo $room['rid'] ?>" class="mdc-list-item tag" style="border: 1px solid <?php echo $_SESSION['venues'][$idv]['color'] ?>; border-radius: 4px; margin-left: auto; margin-right: auto; margin-bottom: 20px; margin-top: 0; order: <?php echo $order ?>">
								<span class="mdc-list-item__start-detail _bold" role="presentation">
									<i class="material-icons">room</i>
								</span>
								<span class="mdc-list-item__text">
								  <?php echo $room['name'] ?>
								</span>
							</a>
							<?php
							$order++;
						}
						?>
					</div>
				</div>
					<?php
					$idx++;
					if ($idx == count($colors)) {
						$idx = 0;
					}
				}
				?>

			</div>
		</div>
	</div>
	<button id="newcls" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo locale">
        <span class="mdc-fab__icon">
            create
        </span>
	</button>
	<p class="spacer"></p>
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

        var ends = document.querySelectorAll('.mdc-list-item');
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
</body>
</html>