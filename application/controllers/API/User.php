<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function AddUser()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Set variable
		$username = (isset($decode_param->Username) ? $decode_param->Username : -1);
		$password = (isset($decode_param->Password) ? $decode_param->Password : -1);
		$name = (isset($decode_param->Name) ? $decode_param->Name : -1);
		$email = (isset($decode_param->Email) ? $decode_param->Email : -1);
		
		// Validation data
		if($username == -1 || $password == -1 || $name == -1 || $email == -1){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'All/One of your format parameter is wrong. Please, check it again !'));
			exit;
		}
		if($username == '' || $password == '' || $name == '' || $email == ''){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'All field must be filled'));
			exit;
		}
		
		// Process save & return
		if($this->db->insert('tbl_user', 
			array(
				'username' => $username, 
				'password' => md5($password), 
				'name' => $name, 
				'email' => $email, 
				'created_on' => date('Y-m-d H:i:s', strtotime('now')),
				'last_modified_on' => date('Y-m-d H:i:s', strtotime('now'))
			)
		)){
			// 200 = OK
			echo json_encode(array('Status' => 200, 'Message' => 'Save success'));
		} else {
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Save failed. Please, try again!'));
		}
		
	}
	
	public function EditUser()
	{
		// Session checking
		check_session();
		
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Set variable
		$id = (isset($decode_param->ID) ? $decode_param->ID : -1);
		$password = (isset($decode_param->Password) ? $decode_param->Password : -1);
		$name = (isset($decode_param->Name) ? $decode_param->Name : -1);
		$email = (isset($decode_param->Email) ? $decode_param->Email : -1);
		
		// Validation data
		if($id == -1 || $password == -1 || $name == -1 || $email == -1){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'All/One of your format parameter is wrong. Please, check it again !'));
			exit;
		}
		if($id != $this->session->userdata('userid') && $id != 1){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'You cannot change others account data'));
			exit;
		}
		
		// Selection data to update (only for data is not null), To reduce bandwidth usage
		$arrayData = array();
		$arrayData['last_modified_on'] = date('Y-m-d H:i:s', strtotime('now'));
		if($password != ''){ $arrayData['password'] = md5($password); }
		if($name != ''){ $arrayData['name'] = $name; }
		if($email != ''){ $arrayData['email'] = $email; }
		
		// Process save & return
		$this->db->where('tbl_user.id', $id);
		if($this->db->update('tbl_user', $arrayData)){
			// 200 = OK
			echo json_encode(array('Status' => 200, 'Message' => 'Update success')); // 200 = OK
		} else {
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Update failed. Please, try again!'));
		}
		
	}
	
	public function GetSessionData()
	{
		echo json_encode($this->session->all_userdata());
	}
	
	public function Login()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Set variable
		$username = (isset($decode_param->Username) ? $decode_param->Username : -1);
		$password = (isset($decode_param->Password) ? $decode_param->Password : -1);
		
		// Validation data
		if($username == -1 || $password == -1){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter is wrong. Please, check it again !'));
			exit;
		}
		
		
		
		// Get data user
		$query = $this->db->get_where('tbl_user', array('username'=>$username, 'password'=>md5($password)));
		
		if($query->num_rows() > 0){
			$data = $query->row();
			
			// Set session
			$list_userdata = array(
				'userid' => $data->id,
				'username' => $data->username,
				'name' => $data->name,
				'email' => $data->email
			);
			$this->session->set_userdata($list_userdata);
			
			// Update last login time at database
			$this->db->where('tbl_user.id', $data->id);
			$this->db->update('tbl_user', array('last_login_time' => date('Y-m-d H:i:s', strtotime('now'))));
			
			// 200 = OK
			echo json_encode(array('Status' => 200, 'Message' => 'Login Success'));
		} else {
			// 401 = Unauthorized
			$this->session->sess_destroy(); // If before this user have been login and success then try again but failed
			echo json_encode(array('Status' => 401, 'Message' => 'Your account cannot found. Please input username & password properly'));
		}
		
	}
	
	public function Logout()
	{
		// Session checking
		check_session();
		
		$this->session->sess_destroy();
		
		// 200 = OK
		echo json_encode(array('Status' => 200, 'Message' => 'Logout Success'));
	}
	
	public function RemoveUser()
	{
		// Session checking
		check_session();
		
		// Get data (GET method)
		// Set variable
		$id = (isset($_GET['id']) ? $_GET['id'] : -1);
		
		// Validation data
		if($id == -1){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter is wrong. Please, check it again !'));
			exit;
		}
		if($id != $this->session->userdata('userid') && $this->session->userdata('userid') != 1){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'You cannot change others account data'));
			exit;
		}
		
		
		
		// Check others data that have relation with this user
		// 1. Check category
		if($this->db->query('SELECT COUNT(*) AS count_data 
			FROM tbl_category 
			WHERE user_id = '. $id)->row()->count_data > 0){
			
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'This account have data at Category table. You must remove it before'));
			exit;
		}
		
		// 2. Check transaction
		if($this->db->query('SELECT COUNT(*) AS count_data 
			FROM tbl_transaction_data 
			WHERE user_id = '. $id)->row()->count_data > 0){
			
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'This account have data at Transaction table. You must remove it before'));
			exit;
		}
		
		// 3. Check user group
		if($this->db->query('SELECT COUNT(*) AS count_data 
			FROM tbl_user_group_member 
			WHERE user_id = '. $id)->row()->count_data > 0){
			
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'This account have data at User Group table. You must remove it before'));
			exit;
		}
		
		
		
		// Process save & return
		$this->db->where('tbl_user.id', $id);
		if($this->db->delete('tbl_user')){
			// 200 = OK
			echo json_encode(array('Status' => 200, 'Message' => 'Delete account success')); // 200 = OK
		} else {
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Delete account failed. Please, try again!'));
		}
		
	}
	
}
?>