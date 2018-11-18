<?php
/**
 * Created by PhpStorm.
 * User: rb
 * Date: 07/10/17
 * Time: 16.11
 */

namespace edocs;


class CustomException extends \Exception {
    protected $message = 'Unknown exception';     // Exception message
    protected $code = 0;                          // User-defined exception code
    protected $file;                              // Source filename of exception

	public static $USER_NOT_ACTIVE_CODE = 1;
	public static $LOGIN_ERROR_CODE = 2;
	public static $GUEST_NOT_AMITTED_CODE = 3;
	public static $CANT_DELETE_OBJECT = 4;


    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }

    public function __toString(){
        switch ($this->code) {
			case CustomException::$USER_NOT_ACTIVE_CODE:
				return "Il tuo account utente risulta disabilitato. #<a href='mailto:". $_SESSION['__config__']['admin_email'] ."?subject=Problema di accesso' class='normal' style='text-decoration: underline'>Contatta l'amministratore</a> della piattaforma, se ritieni che si tratti di un errore.";
				break;
			case CustomException::$LOGIN_ERROR_CODE:
				return "Username e/ o password errati. #Controlla i dati inseriti e riprova, o <a href='mailto:". $_SESSION['__config__']['admin_email'] ."?subject=Problema di accesso' class='normal' style='text-decoration: underline'>richiedi una nuova passord</a> per l'accesso alla piattaforma.";
				break;
			case CustomException::$GUEST_NOT_AMITTED_CODE:
				return "Operazione non consentita per il tuo account. #<a href='mailto:". $_SESSION['__config__']['admin_email'] ."?subject=Problema di accesso' class='normal' style='text-decoration: underline'>Contatta l'amministratore</a> della piattaforma, se ritieni che si tratti di un errore.#Oppure, <a href='".ROOT_SITE."' class='normal'>vai all'area pubblica</a>, l'unica consentita al tuo tipo di utenza.";
				break;
			case CustomException::$CANT_DELETE_OBJECT:
				return "Oggetto non cancellabile in quanto in uso";
				break;
		}
		return get_class($this)." ==> ".$this->getMessage();
    }
}