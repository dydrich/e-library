<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 20/10/17
 * Time: 17.24
 */
include "../lib/start.php";

?>
<!DOCTYPE html>
<html class="mdc-typography">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<link rel="stylesheet" href="../css/site_themes/light_blue/index.css">
	<link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<header>
	<div class="wrap">
		<div style="" id="_header">
			<h1 class="mdc-typography--display1"><?php echo $_SESSION['__config__']['software_name']." ".$_SESSION['__config__']['software_version'] ?></h1>
			<p id="sw_version" style="font-size: 0.7em; font-weight: normal; line-height: 20px; margin: 0; padding-top: 10px; text-transform: none">
				Software di condivisione e archiviazione materiali didattici
			</p>
		</div>
	</div>
</header>
<section class="wrap">
	<div id="login_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center; align-content: center; justify-content: center">
		<h3 style="min-width: 200px">
			<i class="material-icons attention">warning</i>
			<span style="position: relative; bottom: 5px"><?php echo $_SESSION['error']['message'] ?></span>
		</h3>
		<div class="mdc-elevation--z5" style="padding: 15px; font-size: 1em; min-height: 45%">
			<?php
			$rows = explode("#", $_SESSION['error']['detail']);
			$title = '';
			switch ($_SESSION['error']['code']) {
				case \edocs\CustomException::$USER_NOT_ACTIVE_CODE:
					$title = 'Accesso negato';
					break;
				case \edocs\CustomException::$LOGIN_ERROR_CODE:
					$title = "Accesso negato";
					break;
				case \edocs\CustomException::$GUEST_NOT_AMITTED_CODE:
					$title = "Non hai i permessi necessari per effettuare il login";
					break;
			}
			?>
			<p class="attention" style="font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;"><?php echo $title ?></p>
			<p class="w_text" style="font-weight: bold; margin-top: 10px"><?php echo $rows[0] ?></p>
			<?php
			for ($i = 1; $i < count($rows); $i++) {
				?>
				<p class="w_text"><?php echo $rows[$i] ?></p>
				<?php
			}
			?>
			<div style="width: 100%; margin-top: 20px">
				<a href="<?php echo ROOT_SITE ?>" class="material_link normal">Torna indietro</a>
			</div>
		</div>
		<p class="spacer"></p>
		<footer id="footer" style="margin-right: 40px; position: relative; bottom: -40px">
			<span>Copyright <?php echo date("Y") ?> Riccardo Bachis </span>
		</footer>
	</div>
</section>
</body>
</html>