<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>E-Library</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" media="screen and (min-width: 2200px)" href="css/layouts/index/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="css/layouts/index/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="css/layouts/index/normal.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="application/javascript" src="js/page.js"></script>
</head>
<body>
<div id="page" class="hp" style="margin: 0">
    <?php include "header.php" ?>
    <section id="main">
        <div id="content" style="order: 2">
            <div id="login" class="mdc-elevation--z2">
                <div id="login_form" style="align-items: center; width: 75%">
                    <div style="width: 100%; height: 70px; display: flex; align-items: center; align-content: center; border-radius: 3px 3px 0 0; margin-top: 15px">
                        <p class="material_label _bold" style="color: var(--mdc-theme-primary); font-size: 1.5em; width: 100%; text-align: center">Accedi al sito</p>
                    </div>
                    <form id="signinform" action="do_login.php" method="post" style="width: 100%; margin: 10px auto 0 auto">
                        <div class="rb-login-container">
                            <div style="width: 100%">
                                <p>Username</p>
                                <input required autocomplete="off" type="text" id="my-username" name="my-username" class="android" style="width: 100%">
                            </div>
                        </div>
                        <div class="rb-login-container" style="margin-top: 30px">
                            <div style="width: 100%">
                                <p>Password</p>
                                <input required type="password" class="android" id="pw" name="pw"
                                       autocomplete="current-password" style="width: 100%">
                            </div>
                        </div>
                        <button type="button" class="mdc-button mdc-button--raised" id="login_button" style="margin-top: 10px">
                            Login
                        </button>
                        <p style="margin-top: 30px; width: 100%; text-align: center; margin-bottom: 30px" id="pwd_req">
                            <a href="pwd_request.php" class="normal material_link" style="margin-right: 25px">Password dimenticata?</a>|
                            <a href="request_login.php" id="request" class="normal material_link" style="margin-left: 25px">Vuoi registrarti al sito?</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>
</div>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="front.js" type="application/javascript"></script>
<script type="application/javascript">
    var is_mobile = <?php if ($detect->isMobile()) echo 1; else echo 0; ?>;
    (function() {

    })();
</script>
</body>
</html>