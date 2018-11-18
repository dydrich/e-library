<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 17/10/17
 * Time: 17.02
 */
include "../lib/start.php";

$drawer_label = "Errore SQL";

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Errore in archivio</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
	<script type="text/javascript">
        var send_email = function(){
            var url = "bug_notification.php";
            $.ajax({
                type: "POST",
                url: url,
                data: {cls: cls},
                dataType: 'json',
                error: function() {
                    alert("Errore di trasmissione dei dati");
                },
                succes: function() {

                },
                complete: function(data){
                    r = data.responseText;
                    if(r == "null"){
                        return false;
                    }
                    var json = $.parseJSON(r);
                    if (json.status == "kosql"){
                        alert(json.message);
                        console.log(json.dbg_message);
                    }
                    else {
                        j_alert ("alert", "Segnalazione inviata");
                    }
                }
            });
        };
	</script>
</head>
<body>
<?php include "header.php" ?>
<?php include "nav.php" ?>
<div id="main">
	<div id="right_col">
		<?php include_once "../".$_SESSION['area']."/menu.php" ?>
	</div>
	<div id="left_col">
	<?php if($_SESSION['__config__']['debug']){ ?>
		<div style="width: 85%; margin: auto; ">
			<h3>
				<i class="material-icons attention">warning</i>
				<span style="position: relative; bottom: 5px">Si è verificato un errore nell'accesso al database MySQL</span>
			</h3>
			<div class="mdc-elevation--z5" style="padding: 15px; font-size: 1em">
				<table style="width: 95%; margin: 25px auto">
					<?php
					reset($_SESSION['__mysql_error__']);
					$referer = "";
					foreach ($_SESSION['__mysql_error__'] as $k => $v) {
						if($k == "referer")
							$referer = $v;
						?>
						<tr>
							<td style="width: 20%; padding-left: 10px" class="bottom_decoration material_label"><?php print $k ?></td>
							<td style="width: 80%; padding-left: 10px" class="bottom_decoration normal"><?php print $v ?></td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="2" style="padding-top: 20px">
							<a href="<?php echo $referer ?>" class="material_link">Torna indietro</a>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							&nbsp;
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php }
	else{
		$referer = $_SESSION['__mysql_error__']['referer'];
		$to = $_SESSION['__config__']['admin_email'];
		$subject = "Segnalazione di errore";
		$text = "";

		$referer = "";
		reset($_SESSION['__mysql_error__']);
		foreach ($_SESSION['__mysql_error__'] as $k => $v) {
			if($k == "referer")
				$referer = $v;
			$text .= "{$k}::{$v}\n";
		}
		$text .= "utente::".$_SESSION['__user__']->getUsername()."==>".$_SESSION['__user__']->getUid()."\n";
		$text .= "Browser::{$_SERVER['HTTP_USER_AGENT']}\n";
		$headers = "From: " .$_SESSION['__config__']['admin_email']. "\r\n" .	"Reply-To: ".$_SESSION['__config__']['admin_email']. "\r\n" .'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $text, $headers);
		?>
		<div style="width: 75%; margin: auto">
			<h3>
                <i class="material-icons attention">warning</i>
                <span style="position: relative; bottom: 5px">Si è verificato un errore non previsto</span>
            </h3>
			<div class="mdc-elevation--z5" style="padding: 15px; font-size: 1em">
				<p>Un errore relativo all'accesso ai dati ha impedito di caricare la pagina richiesta.</p>
				<p>Potrebbe trattarsi di un problema di rete: controlla la connessione e prova a ricaricare la pagina.</p>
				<p>Se il problema rimane, contatta l'amministratore del sito.</p>
				<div style="width: 100%; margin-top: 20px">
					<a href="<?php echo $referer ?>" class="material_link">Torna indietro</a>
				</div>
			</div>
		</div>
	<?php } ?>
		<p class="spacer"></p>
	</div>
</div>
<?php include "footer.php" ?>
</body>
</html>