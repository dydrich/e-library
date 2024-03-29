<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Gestione armadi</title>
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
						<form method="post" id="bookcaseform"  class="userform" style="width: 90%; text-align: center; margin: auto; padding: 20px">
							<div class="form_row">
								<p class="material_label" style="text-align: left; grid-row: 1; grid-column: 1/2">Locale</p>
								<select class="android" style="width: 100%; grid-row: 1; grid-column: 2/3" name="room" id="room" <?php if(isset($bookcase)) echo "disabled" ?>>
									<?php if (!isset($bookcase)) { ?><option selected value="0">Seleziona un locale</option><?php } ?>
									<?php
									while ($row = $res_rooms->fetch_assoc()) {
										$selected = '';
										if (isset($bookcase)) {
											if ($bookcase['room'] == $row['rid']) {
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
							</div>
							<div class="form_row">
								<p class="material_label" style="text-align: left; grid-row: 2; grid-column: 1/2">Nome armadio</p>
								<input type="text" id="bookcase" name="bookcase" class="android" value="<?php if ($bookcase != null) echo $bookcase['description']; else echo 'Armadio '.$progressive ?>" style="grid-row: 2; grid-column: 2/3" />
							</div>
							<div class="form_row">
								<p class="material_label" style="text-align: left; grid-row: 3; grid-column: 1/2">Codice armadio</p>
								<input type="text" id="code" name="code" class="android disabled_link" disabled value="<?php if ($bookcase != null) echo $bookcase['code']; else echo "" ?>" style="grid-row: 3; grid-column: 2/3" />
							</div>
							<div class="form_row">
								<p class="material_label" style="text-align: left; grid-row: 4; grid-column: 1/2">Numero di scaffali</p>
								<input type="text" id="shelves" name="shelves" class="android" value="<?php if ($bookcase != null) echo $bookcase['shelves']; else echo "0" ?>" style="grid-row: 4; grid-column: 2/3" />
							</div>
							<section class="mdc-card__actions" style="grid-row: 5; grid-column: 1/3; padding: 0">
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
				//window.mdc.autoInit();
				
				document.addEventListener("DOMContentLoaded", function () {
					

					var sel = document.getElementById("room").addEventListener("click", function(ev) {
						//document.location.href = "get_locale_code.php?type=bookcase&object_id="+document.getElementById("room").value+"&object_action=<?php echo $_REQUEST['bid'] ?>";
						var xhr = new XMLHttpRequest();
						document.getElementById('code').disabled = false;
						var formData = new FormData();

						xhr.open('post', 'get_locale_code.php');
						formData.append('type', "bookcase");
						formData.append('object_id', document.getElementById("room").value);
						formData.append("object_action", <?php echo $_REQUEST['bid'] ?>);
						xhr.responseType = 'json';
						xhr.send(formData);
						xhr.onreadystatechange = function () {
							var DONE = 4; // readyState 4 means the request is done.
							var OK = 200; // status 200 is a successful return.
							if (xhr.readyState === DONE) {
								if (xhr.status === OK) {
									console.log("data retrieved");
									var code = xhr.response.code;
									document.getElementById('code').value = code;
								}
							} else {
								console.log('Error: ' + xhr.status);
							}
						}
					});
				});

				var bid = <?php if (isset($_REQUEST['bid'])) echo $_REQUEST['bid']; else echo 0 ?>;

				var submit_data = function (event) {
					if(!validate_form()) {
						event.preventDefault();
						return false;
					}
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

				var validate_form = function() {
                    var go = true;
                    var msg = new Object();
                    msg.data_field = "validation_data";
                    msg.validation_message = "";
                    msg.focus = "room";
                    var index = 1;
					if(document.getElementById('room').value == 0){
                        msg.validation_message += "<br />"+index+". Non hai scelto il locale";
                        go = false;
                        index++;
						
			        }
                    if(document.getElementById('bookcase').value == ""){
                        msg.validation_message += "<br />"+index+". Nome dell'armadio non presente";
                        go = false;
                        index++;
			        }
                    if(document.getElementById('code').value == ""){
                        msg.validation_message += "<br />"+index+". Codice dell'armadio non presente";
                        go = false;
						index++;
			        }
					if(document.getElementById('shelves').value == 0){
                        msg.validation_message += "<br />"+index+". Numero di scaffali dell'armadio non presente";
                        go = false;
						index++;
			        }
                    msg.message = "Errori nel form";
                    if(!go){
                        j_alert("information", msg);
                        return false;
                    }

                    return true;
                }

			</script>
		</div>
	</body>
</html>