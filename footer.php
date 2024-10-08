<footer id="hfooter" class="homepage" style="margin-top: auto;">
	<div id="leftFspaceI"></div>
	<div class="footer_info" id="footer_info">
		<a href="https://icnivolaiglesias.edu.it" style="color: white">Istituto comprensivo Nivola</a> <span style="color: white"> - Iglesias</span> <span style="padding-left: 5px; padding-right: 5px; color: white">|</span> <span style="color: #909090"> Scuola secondaria di primo grado</span>
	</div>
	<div id="rightFspaceI"></div>
	<div id="leftFspaceC"></div>
	<div class="copyright" id="copyright">
		<p>Copyright <?php echo date("Y") ?> Riccardo Bachis </p>
	</div>
	<div id="rightFspaceC">
<!-- alert window -->
<div id="alert" class="alert_msg" style="display: none">
    <div class="alert_icon" style="grid-row: 1; grid-column: 1/2">
        <i class="material-icons primary_color">thumb_up</i>
    </div>
    <div id="alert_title" style="grid-row: 1; grid-column: 2/3">Successo</div>
    <p id="alertmessage" class="alertmessage" style="grid-row: 2; grid-column: 1/3"></p>
</div>

<!-- error window -->
<div id="error" class="error_msg" style="display: none">
<div class="alert_icon" style="grid-row: 1; grid-column: 1/2">
        <i class="material-icons accent_color">warning</i>
    </div>
    <div id="alert_title" style="grid-row: 1; grid-column: 2/3">Errore</div>
    <p class="errormessage" id="errormessage" style="grid-row: 2; grid-column: 1/3"></p>
</div>
<div id="information" class="confirm_msg" style="display: none">
	<div class="confirm_title">
		<i class="material-icons">info</i>
		<span></span>
	</div>
	<p class="confirmmessage" id="infomessage"></p>
	<div class="confirmbuttons">
		<a href="#" id="close_button">
			<div class="alert_button material_dark_bg">
				<span class="material_link">Chiudi</span>
			</div>
		</a>
	</div>
</div>
<div id='background' class="alert_msg" style='display: none'>
	<div class="alert_title">
		<i class="fa fa-spin fa-circle-o-notch"></i>
		<span>Attendi...</span>
	</div>
	<p id="background_msg" class="alertmessage"></p>
</div>
<div class="overlay" id="overlay" style="display:none;"></div>
<div id="confirm" class="confirm_msg" style="display: none">
	<div class="confirm_title">
		<i class="material-icons">help</i>
		<span>Conferma</span>
	</div>
	<p class="confirmmessage" id="confirmmessage"></p>
	<div class="confirmbuttons">
		<a href="#" id="okbutton">
			<div class="alert_button material_dark_bg">
				<span class="material_link">OK</span>
			</div>
		</a>
		<a href="#" id="nobutton">
			<div class="alert_button material_dark_bg" style="margin-left: 20px">
				<span>NO</span>
			</div>
		</a>
	</div>
</div>
<div id="user_menu" class="mdc-elevation--z2">
	<div class="item">
		<a href="../profile.php">
			<i class="material-icons">account_box</i>
			<span>Profilo</span>
		</a>
	</div>
	<div class="item">
		<a href="do_logout.php">
			<i class="material-icons">cloud_off</i>
			<span>Logout</span>
		</a>
	</div>
</div>
<?php
$link = 'back/index.php';
$lab = "Area privata";
if (isset($user) && $user->getCurrentRole() == 3) {
    $link = 'admin/index.php';
}
else if (isset($user) && $user->getCurrentRole() == 2) {
	$link = 'request_update.php';
	$lab = 'Richiedi accesso come utente contributore';
}
?>
<div id="access_menu" class="mdc-elevation--z2">
    <div class="item">
        <a href="<?php echo $link ?>">
            <i class="material-icons">lock</i>
            <span><?php echo $lab ?></span>
        </a>
    </div>
    <div class="item" style="border-top: 1px solid rgba(0, 0, 0, .10)">
        <a href="do_logout.php">
            <i class="material-icons">cloud_off</i>
            <span>Logout</span>
        </a>
    </div>
</div>
<div id="signup" class="mdc-elevation--z6">
	<div id="signup_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center;">
		<div style="width: 100%; height: 70px; background-color: var(--main-700); display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0">
			<p class="material_label _bold" style="color: white; font-size: 1.5em; width: 100%; text-align: center">Registrati</p>
		</div>
		<form id="signupform" action="do_login.php" method="post" style="width: 90%; margin: auto">
            <div class="rb-login-container">
                <div class="mdc-text-field" data-mdc-auto-init="MDCTextField" style="width: 100%">
                    <input required autocomplete="off" type="text" id="fname" name="fname" class="mdc-text-field__input" style="width: 100%">
                    <label class="mdc-floating-label" for="fname">Nome</label>
                </div>
            </div>
            <div class="rb-login-container">
                <div class="mdc-text-field" data-mdc-auto-init="MDCTextField" style="width: 100%">
                    <input required autocomplete="off" type="text" id="lname" name="lname" class="mdc-text-field__input" style="width: 100%">
                    <label class="mdc-floating-label" for="lname">Cognome</label>
                </div>
            </div>
			<div class="rb-login-container">
				<div class="mdc-text-field" data-mdc-auto-init="MDCTextField" style="width: 100%">
					<input required autocomplete="off" type="text" id="new-username" name="new-username" class="mdc-text-field__input" style="width: 100%">
					<label class="mdc-floating-label" for="new-username">Email</label>
				</div>
			</div>
			<div class="rb-login-container">
				<div class="mdc-text-field" data-mdc-auto-init="MDCTextField" style="width: 100%">
					<input required type="password" class="mdc-text-field__input" id="npw" name="npw"
						   autocomplete="current-password" style="width: 100%">
					<label for="npw" class="mdc-floating-label">Password</label>
					<div class="mdc-text-field__bottom-line"></div>
				</div>
			</div>
			<div class="rb-login-container">
				<div class="mdc-text-field" data-mdc-auto-init="MDCTextField" style="width: 100%">
					<input required type="password" class="mdc-text-field__input" id="pw2" name="pw2" style="width: 100%">
					<label for="pw2" class="mdc-floating-label">Ripeti Password</label>
					<div class="mdc-text-field__bottom-line"></div>
				</div>
			</div>
			<button type="button" class="mdc-button mdc-button--raised" id="signup_button">
				Registrati
			</button>
		</form>
	</div>
</div>
<div id="reqpwd" class="mdc-elevation--z6">
    <div id="reqpwd_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center;">
        <div style="width: 100%; height: 70px; background-color: var(--main-700); display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0">
            <p class="material_label _bold" style="color: white; font-size: 1.5em; width: 100%; text-align: center">Richiedi nuova password</p>
        </div>
        <div class="" id="pwdreq_info">
            Inserisci l'indirizzo email con il quale ti sei registrato e riceverai a breve una mail contenente le istruzioni per la modifica della password.
        </div>
        <form id="reqform" action="pwd_request.php" method="post" style="width: 90%; margin: auto">
            <div class="rb-login-container">
                <div class="mdc-text-field" data-mdc-auto-init="MDCTextField" style="width: 100%">
                    <input required autocomplete="off" type="text" id="my-email" name="my-email" class="mdc-text-field__input" style="width: 100%">
                    <label class="mdc-floating-label" for="my-email">Email</label>
                </div>
            </div>
            <button type="button" class="mdc-button mdc-button--raised" id="req_button">
                Invia
            </button>
            <p style="margin-top: 20px">
                <a href="#" id="closereq" class="material_link">Chiudi</a>
            </p>
        </form>
    </div>
</div>
<div id="doc_context_menu" class="mdc-elevation--z2">
    <div class="item">
        <a href="#" id="stat_doc">
            <i class="material-icons">equalizer</i>
            <span>Statistiche</span>
        </a>
    </div>
    <div class="item">
        <a href="#" id="det_doc">
            <i class="material-icons">info</i>
            <span>Info</span>
        </a>
    </div>
    <div class="item" style="border-top: 1px solid rgba(0, 0, 0, .10)">
        <a href="#" id="show_doc">
            <i class="material-icons">open_in_browser</i>
            <span>Apri</span>
        </a>
    </div>
    <div class="item">
        <a href="#" id="down_doc">
            <i class="material-icons">file_download</i>
            <span>Scarica una copia</span>
        </a>
    </div>
</div>
	</div>
</footer>
