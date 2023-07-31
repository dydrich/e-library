<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Configurazione del sito</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
	<link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.jeditable.mini.js"></script>
    <script>
        $(function(){
            load_jalert();
            setOverlayEvent();

            $('.edit').editable('env_manager.php', {
                indicator : 'Saving...',
                tooltip   : 'Click to edit...'
            });

        });
    </script>
	<style>
		.app-fab--absolute.app-fab--absolute {
			position: fixed;
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
        <div class="form_container" style="width: 80%; padding: 40px; margin: auto">
            <table class="admin_table" style="width: 95%; border-collapse: collapse; margin: auto">
                <tr class="accent_decoration" style="height: 50px">
                    <td style="width: 40%; padding-left: 10px; font-weight: bold">Variabile</td>
                    <td style="width: 50%; padding-left: 10px; font-weight: bold">Valore</td>
                    <td style="width: 10%; padding-left: 10px; font-weight: bold"></td>
                </tr>
				<?php
				$res_env->data_seek(0);
				while($row = $res_env->fetch_assoc()){
					$k = $row['var'];
					$v = $row['value'];
					?>
                    <tr style="height: 40px" class="bottom_decoration" id="row<?php echo $row['id'] ?>">
                        <td style="width: 40%; padding-left: 10px" id=""><?php print $k ?></td>
                        <td style="width: 50%; padding-left: 10px;">
                            <p id="<?php print $k ?>" class="edit" data-id="<?php echo $row['id'] ?>" style="margin-top: auto; margin-bottom: auto"><?php echo stripslashes($v) ?></p>

                        </td >
                        <td style="width: 10%; padding-left: 10px; text-align: center;">
                            <a href="#" class="del" data-id="<?php echo $row['id'] ?>">
                                <i class="material-icons" style="font-size: 1.1rem; color: rgba(0,0,0,.67)">delete</i>
                            </a>
                        </td>
                    </tr>
				<?php } ?>
            </table>
        </div>
	</div>
    <div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
    <div id="right_space"></div>
	<button id="newvalue" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo valore">
        <span class="mdc-fab__icon">
            create
        </span>
	</button>
	<?php include_once "../share/footer.php" ?>
</div>

<script type="application/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var btn = document.getElementById('newvalue');
        var pos = scroll_button(btn);
        var top = document.getElementById('header').getBoundingClientRect().height + document.getElementById('navigation').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
        var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
        console.log("top="+top);
        console.log("left="+left);
        btn.style.top = top+"px";
        btn.style.left = left+"px";
        btn.style.position = 'fixed';
        btn.style.zIndex = 3;

        var ends = document.querySelectorAll('.del');
        for (i = 0; i < ends.length; i++) {
            ends[i].addEventListener('click', function (event) {
                event.preventDefault();
                value_to_del = this.dataset.id;
                del_value(value_to_del);
            });
        }
    });

    var btn = document.getElementById('newvalue');
    btn.addEventListener('click', function (event) {
        event.preventDefault();
        window.location.href = 'setting.php?sid=0&back=settings.php';
    });

    var del_value = function (itemID) {
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'setting_manager.php');
        var action = <?php echo ACTION_DELETE ?>;

        formData.append('sid', itemID);
        formData.append('action', action);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    j_alert("alert", xhr.response.message);
                    var item_to_del = document.getElementById('row'+itemID);
                    item_to_del.style.display = 'none';
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>