<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Libreria</title>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <script type="application/javascript" src="../js/page.js"></script>
</head>
<body>
<div id="page" class="page">
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
    <div id="main">
        <div id="left_space"></div>
        <div id="left_col">
            <div style="display: flex; flex-wrap: wrap">
                <div id="cards_container" style="display: flex; width: 64%; flex-wrap: wrap; order: 1; justify-content: center">

                </div>
            </div>    
        </div>
        <div id="right_col">
            <?php include_once "menu.php" ?>
        </div>
        <div id="right_space"></div>
        <?php include_once "../share/footer.php" ?>
    </div>

    <script>
        (function() {

        })();
    </script>
</div>
</body>
</html>