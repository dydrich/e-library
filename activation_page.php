<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 27/05/18
 * Time: 18.09
 */

require_once "./lib/start.php";

if($_SESSION['activation_message'] == 'account_already_activated'){
	$message = "Errore: account attivo";
}
else if ($_SESSION['activation_message'] == 'code_expired') {
	$message = "Errore nell'attivazione";
}
else if($_SESSION['activation_message'] == 'account_activated') {
    $message = 'Account attivato';
}
else if($_SESSION['activation_message'] == 'activation_code_sent') {
	$message = "Codice di attivazione inviato";
}

$drawer_label = 'Pagina di attivazione account';

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Attivazione account</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="text/javascript" src="js/page.js"></script>
	<script type="text/javascript">

	</script>
</head>
<body>
<div id="page" class="" style="margin: auto">
	<?php include "header.php" ?>
	<?php include "nav.php" ?>
    <section id="main">
        <div id="content" style="order: 2">
            <div class="main_front_label">
                <p>
                    <i class="material-icons">watch_later</i>
                    <span><?php echo $message ?></span>
                </p>
            </div>
            <div style="display: flex; padding-left: 20px; margin-top: 20px; flex-wrap: wrap">
                <div style="width: 75%; ">
					<?php
					if($_SESSION['activation_message'] == 'account_already_activated'){
						?>
                            <div class="mdc-elevation--z2" style="padding: 15px; font-size: 1em">
                                <p class="attention" style="display: flex; align-content: center; font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">
                                    <i class="material-icons attention">sync_disabled</i>
                                    Account attivo
                                </p>
                                <p class="w_text" style="margin-top: 15px">
                                    Il codice di attivazione &egrave; stato usato in precedenza.<br /><br />
                                    Il tuo account risulta attivo.<br /><br />
                                    Puoi fare il login usando il link in alto a destra.
                                </p>

                            </div>
						<?php
					}
					else if ($_SESSION['activation_message'] == 'code_expired') {
						?>
                            <div class="mdc-elevation--z2" style="padding: 15px; font-size: 1em">
                                <p class="attention" style="display: flex; align-content: center; font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">
                                    <i class="material-icons attention">sync_problem</i>
                                    Codice scaduto
                                </p>
                                <p class="w_text" style="margin-top: 15px">
                                    Il tuo codice di attivazione &egrave; scaduto.<br /><br />
                                    Ti ricordiamo che l'account va attivato entro 24 dalla ricezione della mail di conferma.<br /><br />
                                    <a href="activate.php?action=reactivate" class="normal" onclick="document.location.href='activate.php?action=reactivate'">Richiedi un nuovo codice di attivazione</a>.
                                </p>

                            </div>
						<?php
					}
					else if($_SESSION['activation_message'] == 'account_activated') {
						?>
                        <div class="mdc-elevation--z2" style="padding: 15px; font-size: 1em">
                            <p class="normal" style="display: flex; align-content: center; font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">
                                <i class="material-icons">how_to_reg</i>
                                Account attivato
                            </p>
                            <p class="w_text" style="margin-top: 15px">
                                L'attivazione &egrave; stata completata con successo.<br/><br/>
                                Ora puoi andare nella home del sito o fare il login usando il link in alto a destra.<br/><br/>
                                <a href="<?php echo ROOT_SITE ?>" onclick="document.location.href='<?php echo ROOT_SITE ?>'">Vai alla Home</a>.
                            </p>

                        </div>
						<?php
					}
						else if ($_SESSION['activation_message'] == 'activation_code_sent') {
						?>
                            <div class="mdc-elevation--z2" style="padding: 15px; font-size: 1em">
                                <p class="normal" style="display: flex; align-content: center; font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">
                                    <i class="material-icons">email</i>
                                    Codice inviato
                                </p>
                                <p class="w_text" style="margin-top: 15px">
                                    Un nuovo codice di attivazione &egrave; stato inviato al tuo indirizzo email.<br/><br/>
                                    Clicca sul link di conferma contenuto nella mail entro 24 ore per attivare l'account.<br/><br/>
                                    <a href="<?php echo ROOT_SITE ?>">Vai alla Home</a>.
                                </p>

                            </div>
					<?php
					}
					?>
                </div>
            </div>

            <p class="spacer"></p>
        </div>
    </section>
</div>
<?php include "footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="front.js" type="application/javascript"></script>
</body>
</html>
