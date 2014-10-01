<?php
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		print_r($this->session->all_userdata());
		// check_session();
	}
	
	function index()
	{
		if(isset($_POST["isPageFromAjax"])){
			$this->load->view('dashboard/main-view');
		} else {
			$this->load->view('main');
		}
	}
}
?>