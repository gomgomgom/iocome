<?php
class Web_services extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	/*
		Used for	: Cek apakah parameter yang dimasukkan kosong. Jika ya maka keluar pesan error
					  Karena parameter HARUS dimasukkan
	*/
	function check_parameter() {
		$json = $this->get_json();
		if($json == '') {
			$msg = array('status' => 999, 'message' => 'Your parameter is required');
			echo json_encode($msg);
			exit;
		}
	}
	
	/*
		Used for	: Mendapatkan parameter json dari client
	*/
	function get_json() {
		$rest_json = file_get_contents("php://input");
		$rest_vars = json_decode($rest_json, true);
		return $rest_vars;
	}
	
	/*
		Used for	: Melakukan parsing terhadap parameter json
	*/
	function parsing_json() {
		echo "asas";
	}

	
	
}
?>