<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione armadi</title>
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
		.mdc-text-field, .mdc-select {
			width: 90%;
			margin-left: auto;
			margin-right: auto;
			
		}
		
		.mdc-select {
			margin-top: 10px;
			margin-bottom: 10px;
			font-size: 0.95em;
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
		<form method="post" id="bookcaseform"  class="mdc-elevation--z5" style="width: 50%; text-align: center; margin: auto; padding: 20px">
			<select class="mdc-select" name="room" id="room">
				<?php
				while ($row = $res_rooms->fetch_assoc()) {
					$selected = '';
					if (isset($bookcase)) {
						if ($bookcase['rid'] == $row['rid']) {
							$selected = "default selected";
						}
					}
					else {
						if (isset($_GET['rid'])) {
							if ($_GET['rid'] == $row['rid']) {
								$selected = "default selected";
							}
						}
					}
					?>
					<option <?php echo $selected ?> value="<?php echo $row['rid'] ?>"><?php echo $row['name']." (".$row['venue'].")" ?></option>
					<?php
				}
				?>
			</select>
			<div class="mdc-text-field mdc-ripple-upgraded" data-mdc-auto-init="MDCTextField" id="lnk_field" style="margin: auto;">
				<input type="text" id="bookcase" name="bookcase" class="mdc-text-field__input" value="<?php if ($bookcase != null) echo $bookcase['description']; else echo 'Armadio '.$progressive ?>" />
				<label for="bookcase" class="mdc-floating-label" style="margin-top: 5px">Nome armadio</label>
			</div>
            <div class="mdc-text-field mdc-ripple-upgraded" data-mdc-auto-init="MDCTextField" id="prog_field" style="margin-right: auto; margin-left: auto; margin-top: 10px">
                <input type="text" id="progressive" name="progressive" class="mdc-text-field__input" value="<?php echo $progressive ?>" />
                <label for="progressive" class="mdc-floating-label" style="margin-top: 5px">Numero progressivo</label>
            </div>
            <div class="mdc-text-field mdc-ripple-upgraded" data-mdc-auto-init="MDCTextField" id="prog_field" style="margin-right: auto; margin-left: auto; margin-top: 10px">
                <input type="text" id="shelves" name="shelves" class="mdc-text-field__input" value="<?php if ($bookcase != null) echo $bookcase['shelves']; else echo "0" ?>" />
                <label for="shelves" class="mdc-floating-label" style="margin-top: 5px">Numero di scaffali</label>
            </div>
			<section class="mdc-card__actions" style="margin-top: 20px">
				<button id="submit_btn" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="margin-left: 17px; margin-top: 15px">Registra</button>
			</section>
		</form>
	</div>
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
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('submit_btn').addEventListener('click', function(event) {
            submit_form(event);
        });
    });

    var bid = <?php if (isset($_REQUEST['bid'])) echo $_REQUEST['bid']; else echo 0 ?>;

    var submit_form = function (event) {
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        var form = document.getElementById('bookcaseform');
        var formData = new FormData(form);

        xhr.open('post', 'bookcase_manager.php');
        var action = <?php if ($_REQUEST['bid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

        formData.append('bid', bid);
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
                       window.location = 'bookcases.php';
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