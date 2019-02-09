<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Dettaglio locale</title>
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
		<form method="post" id="userform"  class="mdc-elevation--z5" style="width: 50%; text-align: center; margin: auto; padding: 20px" onsubmit="submit_data()">
			<select class="mdc-select" name="venue" id="venue">
				<?php
				while ($row = $res_venues->fetch_assoc()) {
					$selected = '';
					if (isset($res)) {
						if ($res['vid'] == $row['vid']) {
							$selected = "default selected";
						}
					}
					?>
					<option <?php echo $selected ?> value="<?php echo $row['vid'] ?>"><?php echo $row['name'] ?></option>
					<?php
				}
				?>
			</select>
			<div class="mdc-text-field mdc-ripple-upgraded" data-mdc-auto-init="MDCTextField" id="lnk_field" style="margin: auto;">
				<input type="text" id="room" name="room" class="mdc-text-field__input" value="<?php if ($res != null) echo $res['name'] ?>" />
				<label for="room" class="mdc-floating-label" style="margin-top: 5px">Nome locale</label>
			</div>
			<section class="mdc-card__actions" style="margin-top: 20px">
				<button id="submit_btn" onclick="submit_data(event)" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="margin-left: 17px; margin-top: 15px">Registra</button>
			</section>
		</form>

	</div>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));
    var rid = <?php if (isset($_REQUEST['rid'])) echo $_REQUEST['rid']; else echo 0 ?>;

    var submit_data = function (event) {
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        var form = document.getElementById('userform');
        var formData = new FormData(form);

        xhr.open('post', 'room_manager.php');
        var action = <?php if ($_REQUEST['rid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

        formData.append('rid', rid);
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
                       window.location = 'rooms.php';
                    }, 2500);
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

    document.addEventListener("DOMContentLoaded", function () {
        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - 1024) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
    });
</script>
</body>
</html>