<!DOCTYPE html>
<html class="mdc-typography">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>E-Library</title>
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/site_themes/light_blue/index.css">
	<link rel="stylesheet" media="screen and (min-width: 2000px)" href="css/layouts/index/larger.css">
	<link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="css/layouts/index/wide.css">
	<link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1024px)" href="css/layouts/index/normal_ext.css">
	<link rel="stylesheet" media="screen and (max-width: 1023px) and (min-width: 640px)" href="css/layouts/index/normal.css">
	<link rel="stylesheet" media="screen and (max-width: 639px)" href="css/layouts/index/small.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="application/javascript" src="js/page.js"></script>
</head>
<body>
<div id="page" class="" style="margin: auto">
	<?php include "header.php" ?>
	<section id="main">
		<div id="content" style="order: 2">
			<div id="login" class="mdc-elevation--z2">
				<div id="login_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center; margin-top: 10px; width: 75%">
					<div style="width: 100%; height: 70px; background-color: var(--main-700); display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
						<p class="material_label _bold" style="color: white; font-size: 1.5em; width: 100%; text-align: center">Welcome back, <?php echo $user->getFullName() ?></p>
					</div>
					<div style="text-align: center; margin-top: 10px; margin-left: auto; margin-right: auto">
                        <?php
                        foreach ($roles as $role) {
                            ?>
                            <a href='<?php echo $links[$role -1] ?>' style='text-transform: uppercase; color: #<?php echo $colors[$role -1] ?>'>
                                <div class='nowcard'>
                                    <div class='icon_card' style='background-color: #<?php echo $colors[$role -1] ?>'>
                                        <i class='material-icons' style='color: white; position: relative; top: 6px'><?php echo $icons[$role -1] ?></i>
                                    </div>
                                    <p class='text_card'>Accedi come <?php echo $labels[$role -1] ?></p></div></a>
                            <?php
                        }
                        ?>
                        <a href='do_logout.php' style='text-transform: uppercase; color: #607d8b'>
                            <div class='nowcard logout'>
                                <div class='icon_card' style='background-color: #607d8b'>
                                    <i class='material-icons' style='color: #FFFFFF; position: relative; top: 6px'>exit_to_app</i>
                                </div>
                                <p class='text_card'>Logout</p></div></a>
					</div>
				</div>
			</div>
			<p class="spacer"></p>
			<p class="spacer"></p>
		</div>
	</section>
</div>
<?php include "footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script type="application/javascript">
    (function() {

    })();
</script>
</body>
</html>