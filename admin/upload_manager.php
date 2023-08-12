<?php

require_once "../lib/start.php";
require_once "../lib/UploadManager.php";
require_once "../lib/MimeType.php";

check_session();

ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>File uploader</title>
        <link rel="stylesheet" href="../css/general.css" type="text/css" />
        <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
    <script type="text/javascript"></script>
    </head>
<body style="background-color: #FFF !important; background: none">
    <form action="upload_manager.php?action=upload" method="post" enctype="multipart/form-data" id="doc_form">
        <div style="height: 45px; display: block" id="_div">
        <?php if (isset($_REQUEST['action'])){ ?>
            <div style="padding-left: 2px">
                <span style="font-weight: normal" id="_span"></span>
                <p>
                    <a href="#" onclick="parent.del_file(event);" class="material_link accent_color">Annulla upload</a>
                </p>
            </div>
        <?php
        }
        else{
        ?>
            <input class="file" type="file" name="fname" id="fname" style="width: 90%; border: 1px solid lightgray;" onchange="parent.loading(300); document.forms[0].submit()" />
        <?php
        }
        ?>
        </div>
    </form>
</body>
</html>
<?php

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "upload"){
    $file_name = $_FILES['fname']['name'];
	$file = preg_replace("/ /", "_", $file_name);
	$file = preg_replace("/'/", "", $file);
	$file = preg_replace("/\\\/", "", $file);
	$upload_manager = new UploadManager($_FILES['fname'], $db, null);

    $ext = ['jpg', 'jpeg', 'gif', 'png'];
    $dir = $_SESSION['__config__']['document_root']."/images/covers/";
	$ret = $upload_manager->upload($ext);
    $path = $dir.$ret;
    if(!$ret) {
        $html = "error;Il file caricato non è una immagine valida per il web";
	    print("<script>parent.reload_iframe('{$html}'); </script>");
        exit;
    }

	$fs = 00;
	$dati_file = MimeType::getMimeContentType($file);
	if (file_exists($path)) {
        $fs = filesize($path);
        $dati_file['size'] = formatBytes($fs, 2);
	}
    else {
        $fs = "non trovato ".$path;
        $dati_file['size'] = $fs;
    }


	$dati_file['encoded_name'] = $file;
	$json = json_encode($dati_file);
	$html = "Nome file: $file_name<br />Tipo: {$dati_file['tipo']}<br />Size: {$dati_file['size']}<br />Nome in archivio: {$ret}";
	print('<script>document.getElementById("_span").innerHTML = "'.$html.'"; parent.document.getElementById("server_file").value = "'.$ret.'"; </script>');
}
