<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Dettaglio etichetta</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
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
<div id="page" class="page">
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
<div id="main">
<div id="left_space"></div>
<div id="left_col">
	<div style="margin: auto" class="form_container">
		<form method="post" id="userform"  class="userform" style="text-align: center; margin: auto; padding: 10px" onsubmit="submit_data()">
			<div class="form_row">
				<p class="material_label" style="text-align: left; grid-row: 1; grid-column: 1/2">Anno di corso</p>
				<select class="android" name="year" id="year" style="grid-row: 1; grid-column: 2/3">
					<?php
					foreach ($levels as $level) {
						$selected = '';
						if (isset($class)) {
							if ($level == $class->getGrade()) {
								$selected = "default selected";
							}
						}
						?>
						<option <?php echo $selected ?> value="<?php echo $level ?>"><?php echo $level ?></option>
						<?php
					}
					?>
				</select>
			</div>	
			<div class="form_row">
				<p class="material_label" style="text-align: left; grid-row: 2; grid-column: 1/2">Sezione</p>
				<select class="android" name="section" id="section" style="grid-row: 2; grid-column: 2/3">>
					<?php
					foreach ($sections as $section) {
						$selected = '';
						if (isset($class)) {
							if ($section == $class->getSection()) {
								$selected = "default selected";
							}
						}
						?>
						<option <?php echo $selected ?> value="<?php echo $section ?>"><?php echo $section ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="form_row">
				<p class="material_label" style="text-align: left; grid-row: 3; grid-column: 1/2">Anno</p>
				<select class="android" name="start" id="start" style="grid-row: 3; grid-column: 2/3">>
					<?php
					while($row = $res_years->fetch_assoc()) {
						$selected = '';
						if (isset($class)) {
							if ($row['_id'] == $class->getFirstYear()) {
								$selected = "default selected";
							}
						}
						?>
						<option <?php echo $selected ?> value="<?php echo $row['_id'] ?>"><?php echo $row['year'] ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<section class="mdc-card__actions" style="margin-top: 45px; margin-bottom: 30px; text-align: left; grid-row: 4; grid-column: 1/3; padding: 0">
				<button id="submit_btn" onclick="submit_data(event)" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="">Registra</button>
			</section>
		</form>
			</div>
	</div>
	<div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
	<div id="right_space"></div>
	<?php include_once "../share/footer.php" ?>
</div>

<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();

    var cid = <?php if (isset($_REQUEST['cid'])) echo $_REQUEST['cid']; else echo 0 ?>;

    var submit_data = function (event) {
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        var form = document.getElementById('userform');
        var formData = new FormData(form);

        xhr.open('post', 'class_manager.php');
        var action = <?php if ($_REQUEST['cid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

        formData.append('cid', cid);
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
                        window.location = 'classes.php';
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