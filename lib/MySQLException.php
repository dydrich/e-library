<?php
/**
 * Created by PhpStorm.
 * User: rb
 * Date: 07/10/17
 * Time: 16.12
 */

namespace edocs;

require_once "CustomException.php";


/**
 * Handles SQL errors
 * @author	 	Riccardo Bachis <cravenroad17@gmail.com>
 * @created 	06/28/2011
 * @last_mod 	06/28/2011
 *
 ****************************************************************************/
class MySQLException extends CustomException{

    /**
     * the sql associated with the exception
     */
    private $sql;

    /**
     * array of data about the error
     */
    private $errors;

    public function __construct($message, $code, $query){
        parent::__construct($message, $code);
        if ($query != null){
            $this->sql = $query;
            $this->errors = array();
            $this->errors['data'] = date("d/m/Y");
            $this->errors['ora'] = date("H:i:s");
            $this->errors['ip_address'] = $_SERVER['REMOTE_ADDRESS'];
            $this->errors['referer'] = $_SERVER['HTTP_REFERER'];
            $this->errors['script'] = $_SERVER['SCRIPT_NAME'];
            $this->errors['query'] = $this->sql;
            $this->errors['error'] = $this->message;
            $_SESSION['__mysql_error__'] = $this->errors;
        }
    }

    /**
     * Convert the Exception to String
     *
     * @return String
     */
    function __toString(){
        return "Si e' verificato un errore SQL nell'istruzione seguente: ".$this->sql.". Messaggio d'errore: ".$this->message;
    }

    /**
     * Convert the Exception to an html formatted string
     *
     * @return String
     */
    function __toHTML(){
        return "<span>Si &egrave; verificato un errore SQL nell'istruzione seguente:</span> <span style='font-weight: bold'>$this->sql. </span><br />Messaggio d'errore: <span style='color: red'>".$this->message."</span>";
    }

    /**
     * Redirect to an html error page
     *
     * @return String
     */
    function redirect(){
        header("Location: ".ROOT_SITE."/share/db_errors.php");
    }

    /**
     * Get an alert about the error
     *
     * @return String
     */
    function alert(){
        $alert = '<script type="text/javascript">alert("Si è verificato un errore.");window.close();</script>';
        print $alert;
    }

    /**
     * Get an alert about the error in a "fake-window"
     *
     * @return String
     */
    function fake_alert(){
        print "kosql;".$this->getMessage().";".$this->getQuery();
        exit;
    }

    function getQuery(){
        return $this->sql;
    }
}