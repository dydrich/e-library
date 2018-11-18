<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin area</title>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
    <link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <script type="application/javascript" src="../js/page.js"></script>
</head>
<body>
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
<div id="main">
    <div id="right_col">
        <?php include_once "menu.php" ?>
    </div>
    <div id="left_col">
        <div style="display: flex; flex-wrap: wrap">
            <div id="cards_container" style="display: flex; width: 64%; flex-wrap: wrap; order: 1; justify-content: center">
                <div class="dashboard_card users_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 1">
                    <div class="dashboard_card_body">
                        <div class="dashboard_body_left">
                            <span style="font-size: 2em;"><?php echo $users_count ?></span>
                            <br /> utenti
                        </div>
                        <div class="dashboard_body_right">
                            <i class="material-icons" style="color: #29b6f6; font-size: 3.5em">people</i>
                        </div>
                    </div>
                    <div class="dashboard_card_row users_card_dark">
                        <div>
                            <a href="users.php">
                                <span>Gestisci</span>
                                <i class="material-icons">forward</i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dashboard_card docs_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 2">
                    <div class="dashboard_card_body">
                        <div class="dashboard_body_left">
                            <span style="font-size: 2em;"><?php echo $docs_count ?></span>
                            <br /> documenti
                        </div>
                        <div class="dashboard_body_right">
                            <i class="material-icons" style="color: #4db6ac; font-size: 3.5em">insert_drive_file</i>
                        </div>
                    </div>
                    <div class="dashboard_card_row docs_card_dark">
                        <div>
                            <a href="labels.php">
                                <span>Gestisci</span>
                                <i class="material-icons">forward</i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dashboard_card accesses_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 3">
                    <div class="dashboard_card_body">
                        <div class="dashboard_body_left">
                            <span style="">Statistiche di accesso</span>
                        </div>
                        <div class="dashboard_body_right">
                            <i class="material-icons" style="color: #e57373; font-size: 3.5em">poll</i>
                        </div>
                    </div>
                    <div class="dashboard_card_row accesses_card_dark">
                        <div>
                            <a href="">
                                <span>Visualizza</span>
                                <i class="material-icons">forward</i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dashboard_card downloads_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 4">
                    <div class="dashboard_card_body">
                        <div class="dashboard_body_left">
                            <span style="">Downloads</span>
                        </div>
                        <div class="dashboard_body_right">
                            <i class="material-icons" style="color: #ce93d8; font-size: 3.5em">cloud_download</i>
                        </div>
                    </div>
                    <div class="dashboard_card_row downloads_card_dark">
                        <div>
                            <a href="">
                                <span>Visualizza</span>
                                <i class="material-icons">forward</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; width: 34%; order: 2">
                <div id="stats_card" class="dashboard_longcard mdc-elevation--z5 mdc-elevation-transition" style="order: 1">
                    <div class="dashboard_card_title">
                        <i class="material-icons" style="font-size: 2.5em">cloud</i>
                        <span style="margin-left: 10px; position: relative; bottom: 10px; font-size: 1.2em">Traffico del mese</span>
                    </div>
                    <div class="dashboard_longcard_body">
                        <div class="dashboard_indicator_container">
                            <div style="width: 300px"><?php echo $monthly_users ?> nuovi utenti</div>
                            <div class="dashboard_linear_indicator">
                                <div class="dashboard_linear_indicator_value users_card_light"> </div>
                            </div>
                        </div>
                        <div class="dashboard_indicator_container">
                            <div style="width: 300px"><?php echo $monthly_docs ?> nuovi documenti</div>
                            <div class="dashboard_linear_indicator">
                                <div class="dashboard_linear_indicator_value docs_card_light"> </div>
                            </div>
                        </div>
                        <div class="dashboard_indicator_container">
                            <div style="width: 300px"><?php echo $monthly_public_accesses ?> accessi pubblici</div>
                            <div class="dashboard_linear_indicator">
                                <div class="dashboard_linear_indicator_value linear_accessess"> </div>
                            </div>
                        </div>
                        <div class="dashboard_indicator_container">
                            <div style="width: 300px"><?php echo $monthly_private_accesses ?> accessi privati</div>
                            <div class="dashboard_linear_indicator">
                                <div class="dashboard_linear_indicator_value linear_unq_accessess"> </div>
                            </div>
                        </div>
                        <div class="dashboard_indicator_container">
                            <div style="width: 300px">-- download</div>
                            <div class="dashboard_linear_indicator">
                                <div class="dashboard_linear_indicator_value linear_downloads"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script>
    (function() {
        var hoverEl = document.getElementById('stats_card');
        hoverEl.addEventListener('mouseenter', function() {
            this.classList.remove('mdc-elevation--z5');
            this.classList.add('mdc-elevation--z12');
        });
        hoverEl.addEventListener('mouseleave', function() {
            this.classList.remove('mdc-elevation--z12');
            this.classList.add('mdc-elevation--z5');
        });
        document.body.addEventListener('mouseover', function (event) {
            if (event.target.classList.contains('dashboard_card_body')) {
                event.target.classList.remove('mdc-elevation--z3');
                event.target.classList.add('mdc-elevation--z6');
            }
        });
        document.body.addEventListener('mouseout', function (event) {
            if (event.target.classList.contains('dashboard_card_body')) {
                event.target.classList.remove('mdc-elevation--z6');
                event.target.classList.add('mdc-elevation--z3');
            }
        });
    })();
</script>
</body>
</html>