<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Gestione categorie</title>
        <link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
        <link rel="stylesheet" media="screen and (min-width: 2200px)" href="../css/layouts/larger.css">
        <link rel="stylesheet" media="screen and (max-width: 2199px) and (min-width: 1600px)" href="../css/layouts/wide.css">
        <link rel="stylesheet" media="screen and (max-width: 1599px) and (min-width: 1024px)" href="../css/layouts/normal.css">
        <link rel="stylesheet" href="../css/site_themes/light_blue/reg.css" type="text/css" media="screen,projection" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
        <script type="application/javascript" src="../js/page.js"></script>
        <style>
            div.item:first-of-type {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                border-top-color: var(--mdc-theme-secondary);
                border-top: 1px solid var(--mdc-theme-secondary);
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
                    <div id="content" style="width: 90%; margin: auto;">
                        <div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; align-items: center; flex-direction: row; column-gap: 40px; justify-content: center; margin: auto; row-gap: 40px">
                            <?php
                            while ($row = $res->fetch_assoc()) {
                                $style="unused_card";
                                if($row['books'] > 0) {
                                    $style = "librarian_card";
                                }
                                ?>
                                <a href="category.php?cid=<?php echo $row['cid'] ?>" data-id="<?php echo $row['cid'] ?>" id="item<?php echo $row['cid'] ?>" class="_2sides-horiz-card-mini">
                                    <span class="_2sides-horiz-card-mini__icon-cont <?php echo $style ?>" role="presentation">
                                        <i class="material-icons">category</i>
                                    </span>
                                    <span class="_2sides-horiz-card-mini__text">
                                        <?php echo $row['category'] ?>
                                    </span>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="right_col">
                    <?php include_once "menu_books.php" ?>
                </div>
                <div id="right_space"></div>
            </div>
            <?php include_once "../share/footer.php" ?>
            <button id="newcls" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuova categoria">
                <span class="mdc-fab__icon">
                    add
                </span>
            </button>
            <script>
                var selected_tag = 0;
                document.addEventListener("DOMContentLoaded", function () {
                    var btn = document.getElementById('newcls');
                    var pos = scroll_button(btn);
                    var top = document.getElementById('header').getBoundingClientRect().height + document.getElementById('navigation').getBoundingClientRect().height - (btn.getBoundingClientRect().height / 2);
                    var left = document.getElementById('left_space').getBoundingClientRect().width + document.getElementById('left_col').getBoundingClientRect().width;
                    console.log("top="+top);
                    console.log("left="+left);
                    btn.style.top = top+"px";
                    btn.style.left = left+"px";
                    btn.style.position = 'fixed';
                    btn.style.zIndex = '99';

                    btn.addEventListener('click', function () {
                        window.location = 'category.php?cid=0';
                    });

                    document.getElementById('left_col').addEventListener('contextmenu', function (ev) {
                        ev.preventDefault();
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        return false;
                    });
                    document.getElementById('left_col').addEventListener('click', function (ev) {
                        ev.preventDefault();
                        if (selected_tag !== 0) {
                            document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                        }
                        return false;
                    });

                    var ends = document.querySelectorAll('._2sides-horiz-card-mini');
                    for (i = 0; i < ends.length; i++) {
                        ends[i].addEventListener('click', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            event.currentTarget.classList.add('selected_tag');
                            selected_tag = event.currentTarget.getAttribute("data-id");
                        });
                        ends[i].addEventListener('contextmenu', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (selected_tag !== 0) {
                                document.getElementById('item'+selected_tag).classList.remove('selected_tag');
                            }
                            event.currentTarget.classList.add('selected_tag');
                            current_target_id = event.currentTarget.getAttribute("data-id");
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            
                        });  
                        ends[i].addEventListener('dblclick', function (event) {
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            selected_tag = event.currentTarget.getAttribute("data-id");
                            open_in_browser();
                        });
                    }
                });

                var open_in_browser = function () {
                    document.location.href = 'category.php?cid='+selected_tag;
                };

            </script>
        </div>
    </body>
</html>