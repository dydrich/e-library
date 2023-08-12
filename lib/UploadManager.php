<?php

require_once 'data_source.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class UploadManager {
	
	private $pathTo;
	private $file;
	private $datasource;
	
	const FILE_EXISTS = 1;
	const UPL_ERROR = 2;
	const UPL_OK = 3;
	const WRONG_FILE_EXT = 4;
	
	public function __construct($file, $db, $pt = 'upload'){
		$this->pathTo = $pt;
		$this->file = $file;
		$this->datasource = new MySQLDataLoader($db);
	}
	
	public function moveFile(){
		/**
		 * gestione del filesystem
		 */
		$file = basename($this->file['name']);
		$file = preg_replace("/ /", "_", basename($this->file['name']));
		$file = preg_replace("/'/", "", $file);
		$file = preg_replace("/\\\/", "", $file);

		/**
		 * gestione file nel filesystem
		*/
		$dir = $_SESSION['__config__']['document_root']."/images/covers/";
		/*
		if(!file_exists($dir)){
			echo $dir. 'non esiste???';
			if (!mkdir($dir, 0775, true)) {
				return self::UPL_ERROR;
			}
		}
		*/
		
		$target_path = $dir . $file;

		if(file_exists($target_path)){

		}
		else{
			if(move_uploaded_file($this->file['tmp_name'], $target_path)) {
				chdir($dir);
				chmod($file, 0644);
			}
			else {
				echo "<br>error moving to $target_path";
			}
		}
		return $file;
	}
	
	public function upload($ext = null){
		if($ext != null) {
			$file_ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);
			if (!in_array($file_ext, $ext)) {
				return false;
			}
		}
		return $this->uploadDocument();
	}
	
	private function uploadDocument(){
		$ret = $this->moveFile();
		return $ret;
	}
}
