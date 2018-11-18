<?php

/**

        check_mail

@Author:                Riccardo Bachis
@Copyright:             2003 Riccardo Bachis
@Created at:            Roma, 16 mar 2003
@Last Modified Time:    16 mar 2003

@DESC:      verifica la struttura formale di un indirizzo email
@param:     $mail - l'indirizzo da verificare
@return:    bolean

*****************************************************************************************/

function check_mail($mail){
    if(!preg_match("/.+@.+\..+/", $mail))
        return false;

    return true;

}


/**

         field_null

@Author:                Riccardo Bachis
@Copyright:             2003-2007 Riccardo Bachis
@Created at:            Roma, 15 mar 2003
@Last Modified Time:    11 gen 2011

@DESC:      formatta i parametri delle stringhe sql settandoli a NULL se
            non presenti o aggiungendoci gli apici singoli se necessario
@param:     $var - il parametro da controllare
@param		$is_char - indica se il parametro e' di tipo stringa: nel caso, servono gli apici singoli
@param      $cmd_type - tipo di istruzione (update o query)
@return:    $res - la stringa convertita

*****************************************************************************************/

function field_null($var, $is_char, $cmd_type = 'update'){
	if ($cmd_type == 'update') {
		if ($var == "" || $var == null) {
			$res = "NULL";
		}
		else {
			$res = $var;
			if ($is_char) {
				$res = "'$res'";
			}
		}
	}
	else {
		if($var == "" || $var == null) {
			$res = "IS NULL";
		}
		else{
			if($is_char) {
				$res = " = '$var'";
			}
			else {
				$res = " = $var";
			}
		}
	}
    return $res;
}

/**

         number_format

@Author:                Riccardo Bachis
@Copyright:             2003 Riccardo Bachis
@Created at:            Roma, 15 apr 2003
@Last Modified Time:    15 apr 2003

@DESC:      formatta i parametri numerici o stringhe portandoli ad un numero
            di caratteri passato come parametro, aggiungendo serie di caratteri
@param:     $val - il parametro da manipolare
@param:     $length - la lunghezza da raggiungere
@param:     $char - il carattere da usare come riempi posto
@return:    $res - la stringa modificata

*****************************************************************************************/

function nmb_format($val, $length, $char){
    if(strlen($val) < $length){
        $start = strlen($val) - 1;
        for($i = $start; $i < $length - 1; $i++)
            $val = $char.$val;
    }
    return $val;
}


/**

         format_date

@Author:                Riccardo Bachis
@Copyright:             2003 Riccardo Bachis
@Created at:            Roma, 15 mar 2003
@Last Modified Time:    15 mar 2003

@desc:      formatta le date
@param:     $data - la stringa da formattare
@param:     $or_style - stile della data da formattare (1=>g/m/a, 2=>a/m/g, 3=>m/g/a)
@param:     $style - stile di conversione (1=>g/m/a, 2=>a/m/g)
@param:     $separator - carattere separatore
@return:    $data_mod - la stringa convertita

*****************************************************************************************/

function format_date($data, $or_style, $style, $separator){
    if($data == ""){
    	return "";
    }
    if(get_date_format($data) == $style){
    	return $data;
    }
    if($or_style == IT_DATE_STYLE)
        list($day, $month, $year) = preg_split("/[\/\.-]/", $data);
    else if($or_style == SQL_DATE_STYLE)
        list($year, $month, $day) = preg_split("/[\/\.-]/", $data);
    else
        list($month, $day, $year) = preg_split("/[\/\.-]/", $data);
	
	if(!checkdate($month, $day, $year))
    	return "";
	
    if($style == IT_DATE_STYLE)
        $data_mod = $day.$separator.$month.$separator.$year;
    else
        $data_mod = $year.$separator.$month.$separator.$day;

    return $data_mod;
}

function check_session($window = MAIN_WINDOW){
    if(!isset($_SESSION['__user__'])){
    	switch($window){
    		case POPUP_WINDOW:
    			//print("<script type='text/javascript'>alert('Sessione scaduta: rifai il login'); window.opener.document.location.href = '".$_SESSION['__config__']['root_site']."/index.php'; window.close();</script>");
    			break;
    		case FAKE_WINDOW:
    			//print("<script type='text/javascript'>alert('Sessione scaduta: rifai il login'); window.parent.document.location.href = '".$_SESSION['__config__']['root_site']."/index.php';</script>");
    			break;
    		case AJAX_CALL:
    		case MAIN_WINDOW:
    		default:
    			header("Location: ".ROOT_SITE);
    			break;
    	}
        exit;
    }
}

function check_role($admitted, $window = MAIN_WINDOW){
	if($_SESSION['__user__']->check_role($admitted) == false){
		// registro in sessione la pagina chiamante
		$_SESSION['__referer__'] = $_SERVER['HTTP_REFERER'];

		switch($window){
			case POPUP_WINDOW:
				print("<script type='text/javascript'>window.opener.document.location.href = '".ROOT_SITE."/share/no_perms.php; window.close();</script>");
				break;
			case FAKE_WINDOW:
				print("<script type='text/javascript'>window.parent.document.location.href = '".ROOT_SITE."/share/no_perms.php;</script>");
				break;
			case AJAX_CALL:
				echo "no_permission";
				break;
			case MAIN_WINDOW:
			default:
				header("Location: ".ROOT_SITE."/share/no_perms.php");
				break;
		}
		exit;
	}
}

function text2html($html){
    if($html == "")
    	return $html;
    $html = preg_replace("/\n/", "<br />", $html);
    //$html = preg_replace("/<br>/", "\n", $html);
    return $html;
}

function time_to_sec($time) {
    list($hours, $minutes, $seconds) = explode(":", $time);

    return $hours * 3600 + $minutes * 60 + $seconds;
} 

/**

        minutes2hours

@Author:                Riccardo Bachis
@Copyright:             2011 Riccardo Bachis
@Created at:            Siliqua, 14 gen 2011
@Last Modified Time:    14 gen 2011

@DESC:      restituisce il tempo ricevuto in minuti nel formato hh:mm
@param:     $time_from - il tempo da formattare
@param:     $zero_string - la stringa da restituire se il tempo = 0
@return:	string: tempo formattato

*****************************************************************************************/

function minutes2hours($time_from, $zero_string){
	$fmt_time = $time_from%60;
	$x = $time_from - $fmt_time;
	$x /= 60;
	if($x < 10)
		$x = "0".$x;
	if($fmt_time < 10)
		$fmt_time = "0".$fmt_time;
	$fmt_time = $x.":".$fmt_time;
	if($fmt_time == "00:00")
		return $zero_string;
	return $fmt_time;
}

/**

        truncateString

@Author:                
@Copyright:             
@Created at:            
@Last Modified Time:    31 mag 2011
@source:				https://www.senamion.it/2006/05/30/c-troncare-una-stringa-senza-tagliare-una-parola/

@DESC:      restituisce una stringa troncandola ad un numero max di caratteri, aggiungendo se necessario dei caratteri di "continua"
@param:     $txt - la stringa da formattare
@param:     il numero max di caratteri
@return:	string: la stringa formattata

*****************************************************************************************/
function truncateString($txt, $chars=50) { 
	if (strlen($txt) <= $chars) 
		return $txt; 
	$new = wordwrap($txt, $chars, "|"); 
	$new_text = explode("|",$new); 
	return $new_text[0]." [...]"; 
}

/**

is_installed

@Author:                Riccardo Bachis
@Copyright:             2012 Riccardo Bachis
@Created at:            Siliqua, 24 mar 2012
@Last Modified Time:    24 mar 2012

@DESC:      verifica se un modulo e' installato
@param:     $module - il modulo del quale controllare l'installazione
@return:	boolean: true - installato, false - non installato

*****************************************************************************************/
function is_installed($module){
	if (!isset($_SESSION['__modules__'][$module]))
		return false;
	return $_SESSION['__modules__'][$module]['installed'];
}

/**

get_sibling
Restituisce l'elemento precedente o successivo in un array contenente 2 campi: id e valore.
Riceve un array di elementi, un id da ricercare e un parametro che indica se restituire il precedente o il successivo

@Author:                Riccardo Bachis
@Copyright:             2012 Riccardo Bachis
@Created at:            Siliqua, 6 feb 2012
@Last Modified Time:    14 gen 2011

@DESC:      restituisce, in un elenco di elementi id-valore (array), l'elemento precedente o successivo
@param:     $elements - array con gli elementi
@param:     $value - il valore di riferimento
@param:		$par - PREVIOUS o NEXT
@return:	array: elemento ricercato

*****************************************************************************************/

function get_sibling($elements, $value, $par){
	$ct = count($elements);
	$index = -1;
	for($i = 0; $i < $ct; $i++){
		if($elements[$i]['id'] == $value)
			$index = $i;
	}
	if($index == -1)
		return $index;
	if($index == 0 && ($par == PREVIOUS))
		return $elements[$ct - 1];
	else if(($index == ($ct - 1)) && ($par == NEXT))
		return $elements[0];
	if($par == PREVIOUS)
		$index--;
	else if($par == NEXT)
		$index++;
	return $elements[$index];
}

/**

date_get_format
Restituisce la formattazione di una data ricevuta come argomento.

@Author:                Riccardo Bachis
@Copyright:             2012 Riccardo Bachis
@Created at:            Siliqua, 22 set 2012
@Last Modified Time:    

@DESC:      restituisce uno tra IT_DATE_STYLE, SQL_DATE_STYLE, 0 per formato non riconosciuto, -1 se data non valida
@param:     $date - la data da analizzare
@return:	integer: stile di formattazione

*****************************************************************************************/
function get_date_format($date){
	if(strlen($date) != 10){
		return -1;
	}
	$IT_pattern  = "/\d\d\/\d\d\/\d\d\d\d/";
	$SQL_pattern = "/\d\d\d\d-\d\d-\d\d/";
	if(preg_match($IT_pattern, $date)){
		return IT_DATE_STYLE;
	}
	else if(preg_match($SQL_pattern, $date)){
		return SQL_DATE_STYLE;
	}
	else return 0;
}

function formatBytes($bytes, $precision = 2) {
	$units = array('B', 'KB', 'MB', 'GB', 'TB');

	$bytes = max($bytes, 0);
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
	$pow = min($pow, count($units) - 1);
	$bytes /= (1 << (10 * $pow));

	return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * getTheme
 *
 * @desc restituisce il tema selezionato dall'utente, se presente, altrimenti quello di default
 * @return string (directory tema selezionato)
 *
 */
function getTheme() {
	if (isset($_SESSION['__user_theme__'])) {
		return $_SESSION['__user_theme__'];
	}
	else {
		return $_SESSION['default_theme'];
	}
}

/*
 * set $navigation_label for manager area
 */
function setNavigationLabel($school_order) {
	switch($school_order) {
		case 1:
			return "scuola secondaria";
			break;
		case 2:
			return "scuola primaria";
			break;
	}
	return "";
}

/**
 * getFileName
 *
 * @desc restituisce il nome del file senza il path
 * @return string (nome del file)
 *
 */
function getFileName() {
	$last_pos = strrpos($_SERVER['PHP_SELF'], "/");
	return substr($_SERVER['PHP_SELF'], $last_pos+1);
}

/**
 * searchMultidimensionalArrayForValue
 *
 * @array array nel quale cercare
 * @val valore da cercare
 * @key chiave nella quale cercare il valore
 * @return $k - indice dell'array (-1 se non trovato)
 *
 */
function searchMultidimensionalArrayForValue($array, $val, $key) {
	foreach ($array as $k => $item) {
		if($item[$key] == $val) {
			return $k;
		}
	}
	return -1;
}

function human_filesize($bytes, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}