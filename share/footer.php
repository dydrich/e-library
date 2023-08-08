<footer id="hfooter" class="homepage" style="margin-top: auto;">
	<div id="leftFspaceI"></div>
	<div class="footer_info" id="footer_info">
		<a href="https://icnivolaiglesias.edu.it" style="color: white">Istituto comprensivo Nivola</a> - Iglesias <span style="padding-left: 5px; padding-right: 5px">|</span> <span style="color: #909090"> Scuola secondaria di primo grado</span>
	</div>
	<div id="rightFspaceI"></div>
	<div id="leftFspaceC"></div>
	<div class="copyright" id="copyright">
		<p>Copyright <?php echo date("Y") ?> Riccardo Bachis </p>
	</div>
	<div id="rightFspaceC"></div>
</footer>
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
        <i class="material-icons primary_color">warning</i>
    </div>
    <div id="alert_title" style="grid-row: 1; grid-column: 2/3">Errore</div>
    <p class="errormessage" id="errormessage"></p>
</div>

<!-- information window -->
<div id="information" class="confirm_msg" style="display: none">
    <div class="confirm_title" style="grid-row: 1; grid-column: 1/2">
        <i class="material-icons accent_color">info</i>
    </div>
    <div id="message_title" style="grid-row: 1; grid-column: 2/3"></div>
    <p class="confirmmessage" id="infomessage" style="grid-row: 2; grid-column: 1/3"></p>
    <div class="confirmbuttons" style="grid-row: 3; grid-column: 1/3">
        <button id="close_button" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" >Chiudi</button>
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

<!-- confirm -->
<div id="confirm" class="confirm_msg" style="display: none">
    <div class="alert_icon" style="grid-row: 1; grid-column: 1/2">
        <i class="material-icons warning_color">help</i>
    </div>
    <div id="alert_title" style="grid-row: 1; grid-column: 2/3">Conferma</div>
    <p class="confirmmessage" id="confirmmessage" style="grid-row: 2; grid-column: 1/3"></p>
    <div class="confirmbuttons"  style="grid-row: 3; grid-column: 1/3; display: flex; flex-direction: rows; flex-shrink: 0; column-gap: 30px">
        <button id="okbutton" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="width: 40px">OK</button>
        <button id="nobutton" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="width: 40px">NO</button>
    </div>
</div>

<div id="context_menu" class="mdc-elevation--z2">
    <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
        <a href="#" id="open_item">
            <i class="material-icons">open_in_browser</i>
            <span>Modifica</span>
        </a>
    </div>
    <div class="item">
        <a href="#" id="remove_item">
            <i class="material-icons">delete</i>
            <span>Rimuovi</span>
        </a>
    </div>
</div>
<div id="yearcontext_menu" class="mdc-elevation--z2">
    <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
        <a href="#" id="open_item">
            <i class="material-icons">open_in_browser</i>
            <span>Modifica</span>
        </a>
    </div>
    <div class="item" style="border-bottom: 1px solid rgba(0, 0, 0, .10)">
        <a href="#" id="default_item">
            <i class="material-icons">done_all</i>
            <span>Imposta come anno in corso</span>
        </a>
    </div>
    <div class="item">
        <a href="#" id="remove_item">
            <i class="material-icons">delete</i>
            <span>Rimuovi</span>
        </a>
    </div>
</div>

<!-- user profiles -->
<div id="profile_menu">
    <div class="profile_item">
        <span class="_bold">Cambia profilo</span>
        </a>
    </div>
<?php
$links = array("admin/index.php", "librarian/index.php", "student/index.php");
$labels = array("Amministratore", "Bibliotecario", "Studente");
$icons = array('admin_panel_settings', 'person', 'school');
$roles = $user->getRoles();
if(count($roles) > 0) {
	foreach($roles as $role){
?>
    <div class="profile_item">
        <a href="../<?php echo $links[$role - 1] ?>" id="default_item">
            <i class="material-icons"><?php echo $icons[$role - 1] ?></i>
            <span style="margin-left: 10px"><?php echo $labels[$role - 1] ?></span>
        </a>
    </div>

<?php
    }
}
?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('profile').addEventListener('click', function(ev) {
        show_profile_menu(ev);
    });
});
</script>