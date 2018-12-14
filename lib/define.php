<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 13/10/17
 * Time: 21.39
 */

define("IT_DATE_STYLE", 1);
define("SQL_DATE_STYLE", 2);
define("US_DATE_STYLE", 3);

define("ACTION_INSERT", 1);
define("ACTION_DELETE", 2);
define("ACTION_UPDATE", 3);
define("ACTION_RESTORE", 4);
define("ACTION_DEACTIVATE", 5);
define("ACTION_SET_DEFAULT", 6);
define("ACTION_DESTROY", 7); // permanently delete from db

/*
 * tipologie di finestra per check_session
 *
 */
define("MAIN_WINDOW", 1);
define("POPUP_WINDOW", 2);
define("FAKE_WINDOW", 3);
define("AJAX_CALL", 4);

/*
 * ordini di scuola
 */
define("MIDDLE_SCHOOL", 1);
define("PRIMARY_SCHOOL", 2);
define("FIRST_SCHOOL", 3);

/*
 * paginazione
 */
define("PREVIOUS", -1);
define("NEXT", 1);
define("INDEX_OUT_OF_BOUND", 0);

define("ROOT_SITE", 'https://e-library.rbachis.net');