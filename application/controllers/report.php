<?php
class Report extends CI_Controller
{
	function index()
	{
		if(isset($_POST["isPageFromAjax"])){
			$this->load->view('report/main-view');
		} else {
			$this->load->view('main');
		}
	}
}
?>