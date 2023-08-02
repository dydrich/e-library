<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Librerie</title>
		<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
		<link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
		<link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
		<link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
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
		<div id="page" class="page">
			<?php include_once "../share/header.php" ?>
			<?php include_once "../share/nav.php" ?>
			<div id="main">
				<div id="left_space"></div>
				<div id="left_col">
					<div id="cards_container" style="display: flex; width: 85%; flex-wrap: wrap; order: 1; justify-content: center">
						<div class="dashboard_card users_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 1">
							<div class="dashboard_card_body">
								<div class="dashboard_body_left">
									<span style="font-size: 2em;"><?php echo $count_venues ?></span>
									<br /> sedi
								</div>
								<div class="dashboard_body_right">
									<i class="material-icons" style="color: #29b6f6; font-size: 3.5em">home</i>
								</div>
							</div>
							<div class="dashboard_card_row users_card_dark">
								<div>
									<a href="school_complexes.php">
										<span>Gestisci </span>
										<i class="material-icons" style="font-size: 1.2em; position: relative; top: 4px">forward</i>
									</a>
								</div>
							</div>
						</div>
						<div class="dashboard_card docs_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 2">
							<div class="dashboard_card_body">
								<div class="dashboard_body_left">
									<span style="font-size: 2em;"><?php echo $count_rooms ?></span>
									<br /> locali
								</div>
								<div class="dashboard_body_right">
									<i class="material-icons" style="color: #4db6ac; font-size: 3.5em">room</i>
								</div>
							</div>
							<div class="dashboard_card_row docs_card_dark">
								<div>
									<a href="rooms.php">
										<span>Gestisci </span>
										<i class="material-icons" style="font-size: 1.2em; position: relative; top: 4px">forward</i>
									</a>
								</div>
							</div>
						</div>
						<div class="dashboard_card accesses_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 3">
							<div class="dashboard_card_body">
								<div class="dashboard_body_left">
									<span style="font-size: 2em"><?php echo $count_bookcases ?></span>
									<br />
									armadi
								</div>
								<div class="dashboard_body_right">
									<i class="material-icons" style="color: #e57373; font-size: 3.5em">work</i>
								</div>
							</div>
							<div class="dashboard_card_row accesses_card_dark">
								<div>
									<a href="bookcases.php">
										<span>Gestisci </span>
										<i class="material-icons" style="font-size: 1.2em; position: relative; top: 4px">forward</i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div id="right_col">
					<?php include_once "menu.php" ?>
				</div>
				<div id="right_space"></div>
			</div>
			<?php include_once "../share/footer.php" ?>
		</div>
	</body>
</html>