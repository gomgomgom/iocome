<?php
class Dashboard extends CI_Controller
{
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