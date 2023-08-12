<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Dettaglio locale</title>
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
					<div class="form_container" style="margin: auto">
						<form method="post" id="userform"  class="userform" style="margin: auto; padding: 10px" onsubmit="submit_data()">
							<div class="form_row">
								<p class="material_label mandatory" style="text-align: left; grid-row: 1; grid-column: 1/2">Plesso</p>	
								<div style="grid-row: 1; grid-column: 2/3">
									<select class="android" name="venue" id="venue" style="width: 100%" <?php if($res != null) echo "disabled" ?> >
										<?php if($res == null) { ?><option selected value="0">Seleziona un plesso</option><?php } ?>
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
								</div>
							</div><!-- form row #1 -->
							<div class="form_row">
								<p class="material_label mandatory" style="text-align: left; grid-row: 2; grid-column: 1/2">Locale</p>	
								<div style="grid-row: 2; grid-column: 2/3">
									<input type="text" id="room" name="room" class="android" style="width: 100%" value="<?php if ($res != null) echo $res['name'] ?>" />
								</div>
							</div><!-- form row #2 -->
							<div class="form_row">
								<p class="material_label mandatory" style="text-align: left; grid-row: 3; grid-column: 1/2">Codice locale</p>	
								<div style="grid-row: 3; grid-column: 2/3">
									<input type="text" id="code" name="code" class="android disabled_link" disabled style="width: 100%" value="<?php if ($res != null) echo $res['code'] ?>" />
								</div>
							</div><!-- form row #3 -->
							<section class="mdc-card__actions" style="grid-row: 2; grid-column: 1/3; padding: 0">
								<button id="submit_btn" onclick="submit_data(event)" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="margin-top: 45px; margin-bottom: 35px">Registra</button>
							</section>
						</form>
					</div>
				</div>
				<div id="right_col">
					<?php include_once "menu.php" ?>
				</div>
				<div id="right_space"></div>	
			</div>
			<?php include_once "../share/footer.php" ?>
			<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
			<script>
				window.mdc.autoInit();
				var rid = <?php if (isset($_REQUEST['rid'])) echo $_REQUEST['rid']; else echo 0 ?>;

				var submit_data = function (event) {
					console.log(validate_form());
					if(!validate_form()) {
						event.preventDefault();
                        return false;
                    }
					event.preventDefault();
					var xhr = new XMLHttpRequest();
					document.getElementById('code').disabled = false;
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

				var validate_form = function() {
                    var go = true;
                    var msg = new Object();
                    msg.data_field = "validation_data";
                    msg.validation_message = "";
                    msg.focus = "venue";
                    var index = 1;
					if(document.getElementById('venue').value == 0){
                        msg.validation_message += "<br />"+index+". Non hai scelto il plesso";
                        go = false;
                        index++;
			        }
                    if(document.getElementById('room').value == ""){
                        msg.validation_message += "<br />"+index+". Nome del locale non presente";
                        go = false;
                        index++;
			        }
                    if(document.getElementById('code').value == ""){
                        msg.validation_message += "<br />"+index+". Codice del locale non presente";
                        go = false;
			        }
                    msg.message = "Errori nel form";
                    if(!go){
                        j_alert("information", msg);
                        return false;
                    }

                    return true;
                }

				document.addEventListener("DOMContentLoaded", function () {
					var screenW = screen.width;
					var bodyW = document.body.clientWidth;
					var right_offset = (bodyW - 1024) / 2;
					right_offset += document.getElementById('right_col').clientWidth;

					var sel = document.getElementById("venue").addEventListener("click", function(ev) {
						if(document.getElementById("venue").value == 0) {
							return;
						}
						//document.location.href = "get_locale_code.php?type=room&object_id="+document.getElementById("venue").value+"&object_action=<?php echo $_REQUEST['rid'] ?>";
						var xhr = new XMLHttpRequest();
						var formData = new FormData();

						xhr.open('post', 'get_locale_code.php');
						formData.append('type', "room");
						formData.append('object_id', document.getElementById("venue").value);
						formData.append("object_action", <?php echo $_REQUEST['rid'] ?>);
						xhr.responseType = 'json';
						xhr.send(formData);
						xhr.onreadystatechange = function () {
							var DONE = 4; // readyState 4 means the request is done.
							var OK = 200; // status 200 is a successful return.
							if (xhr.readyState === DONE) {
								if (xhr.status === OK) {
									var code = xhr.response.code;
									document.getElementById('code').value = code;
								}
							} else {
								console.log('Error: ' + xhr.status);
							}
						}
					});
				});
			</script>
		</div>
	</body>
</html>