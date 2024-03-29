<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Gestione libro</title>
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
                    <div id="form_container" class="form_container" style="margin: 0 auto 30px auto;">
                        <form method="post" id="bookform"  class="userform" style="width: 90%; text-align: center; margin: auto; padding: 20px; ">
                            <fieldset style="margin: auto; padding-top: 10px; padding-bottom: 20px; padding-left: 30px; padding-right: 30px">
                                <legend style="text-align: left">Dati di archiviazione</legend>
                                <div class="form_row">
                                    <p class="material_label mandatory" style="text-align: left; grid-row: 1; grid-column: 1/2">Locale</p>
                                    <select class="android" name="room" id="room" style="width: 100%; margin: auto; grid-row: 1; grid-column: 2/3">
                                        <option value="0" selected>Seleziona un plesso per iniziare</option>
                                        <?php
                                        while ($row = $res_rooms->fetch_assoc()) {
                                            $selected = '';
                                            if (isset($book)) {
                                                if ($location['room'] == $row['rid']) {
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
                                </div> <!-- form_row #1 -->
                                <div class="form_row">
                                    <p class="material_label mandatory" style="text-align: left; grid-row: 2; grid-column: 1/2">Libreria</p>
                                    <select class="android" name="bookcase" id="bookcase" style="width: 100%; margin-right: auto; margin-left: auto; grid-row: 2; grid-column: 2/3">
                                        <option value="0" selected>Seleziona una libreria</option>
                                        <?php
                                        while ($row = $res_bookcases->fetch_assoc()) {
                                            $selected = '';
                                            if (isset($book)) {
                                                if (($location['bookcase'] != '') && ($location['bookcase'] == $row['bid'])) {
                                                    $selected = "default selected";
                                                }
                                            }
                                            ?>
                                            <option <?php echo $selected ?> value="<?php echo $row['bid'] ?>"><?php echo $row['description']." (".$row['shelves']." scaffali)" ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div> <!-- form_row #2 --> 
                                <div class="form_row">
                                    <p class="material_label" style="text-align: left; grid-row: 3; grid-column: 1/2">Scaffale</p>
                                    <input type="text" id="shelf" name="shelf" class="android" value="<?php if (isset($book)) echo $location['shelf'] ?>" style="grid-row: 3; grid-column: 2/3" />
                                </div><!-- form_row #3 --> 
                                <div class="form_row">
                                    <p class="material_label mandatory" style="text-align: left; grid-row: 4; grid-column: 1/2">Categoria</p>
                                    <select class="android" name="category" id="category" style="width: 100%; margin: auto; grid-row: 4; grid-column: 2/3">
                                        <option value="0" selected>Seleziona una categoria</option>
                                        <?php
                                        while ($cat = $res_categories->fetch_assoc()) {
                                            $selected = '';
                                            if (isset($book)) {
                                                if ($book->getCategory() == $cat['cid']) {
                                                    $selected = "default selected";
                                                }
                                            }
                                            ?>
                                            <option <?php echo $selected ?> value="<?php echo $cat['cid'] ?>"><?php echo $cat['category'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div> <!-- form_row #4 -->
                                <div class="form_row">
                                    <p class="material_label mandatory" style="text-align: left; grid-row: 5; grid-column: 1/2">Codice</p>
                                    <input type="text" id="code" name="code" class="android disabled_link" value="<?php if (isset($book)) echo $book->getCode() ?>" readOnly style="grid-row: 5; grid-column: 2/3" />
                                </div><!-- form_row #5 -->
                            </fieldset>
                            <fieldset style="margin-right: auto; margin-left: auto; margin-top: 20px; padding-top: 10px; padding-bottom: 20px; padding-left: 30px; padding-right: 30px">
                                <legend style="text-align: left">Dati libro</legend>
                                <div class="form_row">
                                    <p class="material_label mandatory" style="text-align: left; grid-row: 6; grid-column: 1/2">Titolo</p>
                                    <input type="text" id="title" name="title" class="android" value="<?php if (isset($book)) echo $book->getTitle() ?>" style="grid-row: 6; grid-column: 2/3" />
                                </div><!-- form_row #6 -->
                                <div class="form_row">
                                    <p class="material_label mandatory" style="text-align: left; grid-row: 7; grid-column: 1/2">Autore</p>
                                    <input type="text" id="author" name="author" class="android" value="<?php if (isset($book)) echo $book->getAuthor(); ?>" style="grid-row: 7; grid-column: 2/3" />
                                </div><!-- form_row #7 -->
                                <div class="form_row">
                                    <p class="material_label" style="text-align: left; grid-row: 8; grid-column: 1/2">Casa editrice</p>
                                    <input type="text" id="publisher" name="publisher" class="android" value="<?php if (isset($book)) echo $book->getPublisher() ?>" style="grid-row: 8; grid-column: 2/3" />
                                </div><!-- form_row #8 -->
                                <div class="form_row">
                                    <p class="material_label" style="text-align: left; grid-row: 9; grid-column: 1/2">Pagine</p>
                                    <input type="text" id="pages" name="pages" class="android" value="<?php if (isset($book)) echo $book->getPages(); else echo "0" ?>" style="grid-row: 9; grid-column: 2/3" />
                                </div><!-- form_row #9 -->
                                <div class="form_row">
                                    <p class="material_label" style="text-align: left; grid-row: 10; grid-column: 1/2">Copertina</p>
                                <?php if(isset($current_doc)){ ?>
                                    <div id="if_container" style="grid-row: 10; grid-column: 2/3">    
                                        <input class="android" type="text" name="fname" id="fname" style="width: 86%; " readOnly value="<?php print $book->getCover() ?>"/>
                                        <a href="#" onclick="load_iframe('<?php print $book->getCover() ?>')" style="margin-left: 15px; color: rgba(0, 0, 0, .87);">Modifica file</a>
                                    </div>
                                <?php }  else{ ?>
                                    <div id="if_container" style="grid-row: 10; grid-column: 2/3">
                                        <div id="iframe"><iframe src="../admin/upload_manager.php" id="aframe"></iframe></div>
                                        <a href="#" onclick="del_file()" id="del_upl" style="">Annulla</a>
                                    <div>
                                <?php } ?>
                                </div><!-- form_row #10 -->
                            </fieldset>
                            
                            <section class="mdc-card__actions" style="width: 90%; margin-top: 20px; margin-right: auto; margin-left: auto">
                                <button id="submit_btn" onclick="submit_form(event)" class="mdc-button mdc-button--compact mdc-button--raised mdc-card__action" style="margin-left: -8px;margin-top: 15px">Registra</button>
                            </section>
                            <input type="hidden" id="server_file" name="server_file" value="<?php if (isset($book)) echo $book->getCover() ?>" />
                        </form>
                    </div>
                </div>
                <div id="right_col">
                    <?php include_once "menu_books.php" ?>
                </div>
                <div id="right_space"></div>
            </div>
            <?php include_once "../share/footer.php" ?>
            <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
            <script>
                window.mdc.autoInit();
                
                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById('room').addEventListener('change', function() {
                        get_bookcases(this.value);
                        //alert(this.value);
                    });
                    document.getElementById('category').addEventListener('change', function() {
                        event.preventDefault();
                        get_code(this.value);
                        //alert(this.value);
                    });

                });
                var book_id = <?php if (isset($_REQUEST['book_id'])) echo $_REQUEST['book_id']; else echo 0 ?>;
                var debug = <?php echo $_SESSION['__config__']['debug'] ?>;

                var submit_form = function (event) {
                    event.preventDefault();
                    if(!validate_form()) {
                        return;
                    };
                    var xhr = new XMLHttpRequest();
                    var form = document.getElementById('bookform');
                    var formData = new FormData(form);

                    xhr.open('post', 'book_manager.php');
                    var action = <?php if ($_REQUEST['book_id'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

                    formData.append('book_id', book_id);
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
                                    window.location = 'library.php';
                                }, 2500);
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
                };

                var get_bookcases = function (room) {
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', '../share/get_bookcases.php');
                    console.log("get_boockcase opened");
                    formData.append('room', room);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                console.log("data retrieved");
                                var sel_data = xhr.response.bookcases;
                                var b_data = document.getElementById('bookcase');
                                b_data.innerHTML = '';
                                for (var i in sel_data) {
                                    var opt = sel_data[i];
                                    var n_opt = new Option();
                                    n_opt.value = opt.bid;
                                    n_opt.text = opt.description+" ("+opt.shelves+" scaffali)";
                                    b_data.appendChild(n_opt);
                                }
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
                };

                var get_code = function (category) {
                    if(category == 0) {
                        return false;
                    }
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'book_manager.php');
                    formData.append('cat', category);
                    formData.append('action', <?php echo ACTION_GET_BOOK_CODE ?>);
                    formData.append('book_id', 0);
                    xhr.responseType = 'json';
                    xhr.send(formData);
                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                var code = xhr.response.code;
								document.getElementById('code').value = code;
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
                    msg.validation_message = "Ricontrolla il form e inserisci tutti i dati obbligatori.";
                    msg.focus = "room";
                    var index = 1;
                    if(document.getElementById('room').value == 0){
                        msg.validation_message += "<br />"+index+". Non hai selezionato il locale";
                        go = false;
                        index++;
						
			        }
                    if(document.getElementById('bookcase').value == 0){
                        msg.validation_message += "<br />"+index+". Non hai selezionato l'armadio";
                        go = false;
                        index++;
			        }
                    if(document.getElementById('shelf').value == ""){
                        msg.validation_message += "<br />"+index+". Non hai indicato lo scaffale";
                        go = false;
						index++;
			        }
                    if(document.getElementById('category').value == ""){
                        msg.validation_message += "<br />"+index+". Non hai indicato la categoria";
                        go = false;
						index++;
			        }
					if(document.getElementById('title').value == 0){
                        msg.validation_message += "<br />"+index+". Non hai inserito il titolo";
                        go = false;
						index++;
			        }
                    if(document.getElementById('author').value == 0){
                        msg.validation_message += "<br />"+index+". Non hai inserito l'autore";
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

                var del_file = function(event){
                    if(document.getElementById('server_file').value == ""){
                        j_alert("error", "Non hai ancora fatto l'upload di alcun file");
                        return false;
                    }
                    
                    var xhr = new XMLHttpRequest();
                    var formData = new FormData();

                    xhr.open('post', 'book_manager.php');
                    formData.append('action', <?php echo ACTION_UNLOAD_FILE ?>);
                    formData.append('server_file', document.getElementById('server_file').value);
                    xhr.responseType = 'json';
                    xhr.send(formData);

                    xhr.onreadystatechange = function () {
                        var DONE = 4; // readyState 4 means the request is done.
                        var OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                if (xhr.response.status == "kofile"){
                                    if(debug) {
                                        var error_msg = xhr.response.message+"\n"+xhr.response.dbg_message;
                                        j_alert("error", error_msg);
                                    }
                                    else {
                                        j_alert("error", xhr.response.message);
                                    }
                                    console.log(json.dbg_message);
                                }
                                else {
                                    reload_iframe("alert;Il file è stato cancellato dal server");
                                    document.getElementById('server_file').value = "";
                                }
                            }
                        } else {
                            console.log('Error: ' + xhr.status);
                        }
                    }
		        };

                var reload_iframe = function(msg){
                    document.getElementById('aframe').setAttribute('src', '../admin/upload_manager.php');
                    var data = msg.split(";");
                    j_alert(data[0], data[1]);
                };

                var load_iframe = function(file){
                    document.getElementById("if_container").innerHTML = '<div id="iframe"><iframe src="../admin/upload_manager.php" id="aframe"></iframe></div><a href="#" onclick="del_file()" id="del_upl" style="">Annulla</a>';
                };
            </script>
        </div>
    </body>
</html>
