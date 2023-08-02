<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Caricamento utenti</title>
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
            <form class="no_border">
                <div style="width: 75%; margin: 0 auto 0 auto; padding: 15px" class="mdc-elevation--z3">
                    <em>Questa funzione ti permette di importare tutti gli alunni, associandoli alla classe, con un solo comando, usando un file che contenga i dati nel formato richiesto.<br />
                        Tale formato DEVE essere preciso ed &egrave; facilmente ottenibile, se si hanno i dati in un file excel: basta esportare il file in formato
                        CSV, rispettando le indicazioni di sotto riportate. Ecco le caratteristiche:<br /></em>
                    <ul style="list-style-type: disc; margin-left: 0">
                        <li>Ogni riga deve contenere le informazioni di un alunno</li>
                        <li>I campi devono essere separati tra loro con un carattere di punto e virgola (;)</li>
                        <li>I campi NON devono essere racchiusi da virgolette</li>
                        <li>L'ordine dei campi deve essere il seguente: </li>
                        <li style="margin-left: 20px">Cognome (obbligatorio)</li>
                        <li style="margin-left: 20px">Nome (obbligatorio)</li>
                        <li style="margin-left: 20px">Classe (nel formato di 2 lettere, ad esempio 2F, senza spazi)</li>
                        <li style="margin-left: 20px">Email </li>
                        <li>In ogni riga devono essere presenti tutti i campi.<br />
                    </ul>
                </div>
                <div class="normal _bold" style="width: 75%; margin-top: 20px; margin-left: 12.5%">Carica il file per l'importazione</div>
                <div style="width: 75%; margin: auto; padding: 15px" class="mdc-elevation--z3">
                    <p class="normal" style="margin-bottom: 0; margin-top: 0">File</p>
                    <div style="min-height: 90px; width: 100%; border: 1px solid lightgray; border-radius: 0 8px 8px 8px">
                        <iframe src="upload_manager.php" style="border: none; width: 75%;  margin: 0" id="aframe"></iframe>
                        <a href="#" onclick="del_file()" id="del_upl" style="float: right; display: none; text-decoration: none">Annulla upload</a>
                    </div>
                    <div style="margin-top: 15px">
                        <span class="normal">Caricamento:</span>
                        <span id="info_div" style="font-weight: bold; display: none">inseriti <span id="load_info"></span> su <span id="tot"></span> con <span id="err"></span> errori</span>
                    </div>
                    <div class="_bold" style="display: none; margin-top: 15px" id="log_div">
                        <a href="" id="errors_info" class="attention" download >Scarica file di log</a>
                    </div>
                    <div style="margin-right: auto; margin-left: auto; margin-top: 25px">
                        <button type="button" class="mdc-button mdc-button--raised" id="import_button">
                            Importa file
                        </button>
                    </div>
                </div>
                <input type="hidden" name="server_file" id="server_file" />
            </form>
		</div>
        <div id="right_col">
			<?php include_once "menu.php" ?>
		</div>
        <div id="right_space"></div>
		<?php include_once "../share/footer.php" ?>
	</div>
	
    <script type="application/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('import_button').addEventListener('click', function (event) {
                import_data();
            }, false);
        });

        var del_file = function(event){
            event.preventDefault();
            if(document.getElementById('server_file').value === ""){
                j_alert("error", "Non hai ancora fatto l'upload di alcun file");
                return false;
            }
            var url = "file_manager.php";

            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', 'file_manager.php');
            var file = document.getElementById('server_file').value;
            var action = <?php echo ACTION_DELETE ?>;

            formData.append('file', file);
            formData.append('action', action);
            xhr.responseType = 'json';
            xhr.send(formData);
            xhr.onreadystatechange = function () {
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        j_alert('alert', xhr.response.message);
                        reload_iframe();
                        document.getElementById('server_file').value = "";
                    }
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };

        var import_data = function(){
            var url = "import_students.php";

            background_process("Operazione in corso", 20, true);

            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            xhr.open('post', url);
            var file = document.getElementById('server_file').value;

            formData.append('file', file);
            xhr.responseType = 'json';
            xhr.send(formData);
            xhr.onreadystatechange = function () {
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        document.getElementById('load_info').innerHTML = xhr.response.ok;
                        document.getElementById('tot').innerText = xhr.response.tot;
                        document.getElementById('err').innerText = xhr.response.ko;
                        document.getElementById('info_div').style.display = '';
                        document.getElementById('log_div').style.display = '';
                        document.getElementById('errors_info').setAttribute("href", "../upload/" + xhr.response.log_path);
                        loaded("Operazione conclusa");
                    }
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };

        var reload_iframe = function(){
            document.getElementById('aframe').setAttribute('src', 'upload_manager.php');
        };
    </script>
</body>
</html>