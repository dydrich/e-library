</div>
<footer id="footer">
	<span>Copyright <?php echo date("Y") ?> Riccardo Bachis </span>
</footer>
<div id="alert" class="alert_msg" style="display: none">
    <div class="alert_title">
        <i class="material-icons">thumb_up</i>
        <span>Successo</span>
    </div>
    <p id="alertmessage" class="alertmessage"></p>
</div>
<div id="error" class="error_msg" style="display: none">
    <div class="error_title">
        <i class="material-icons">warning</i>
        <span>Errore</span>
    </div>
    <p class="errormessage" id="errormessage"></p>
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