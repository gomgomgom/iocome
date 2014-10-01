<?php
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->view('login');
	}
	
	// We can't encrypt password on client side, this is article to explain the reason ::
	// Reference :: http://stackoverflow.com/questions/4121629/password-encryption-at-client-side
	// Reference :: http://stackoverflow.com/questions/3715920/about-password-hashing-system-on-client-side
	function process_login()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Validation format parameter
		if(! isset($decode_param->Username) ||
			! isset($decode_param->Password)
		){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter is wrong')); // 500 = Internal Server Error
			exit;
		}
		
		// Validation of null value
		if($decode_param->Username == '' ||
			$decode_param->Password == ''
		){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter must be filled')); // 500 = Internal Server Error
			exit;
		}
		
		// Set variable
		$username = $decode_param->Username;
		$password = $decode_param->Password;
		
		// Check to database
		$result = $this->db->get_where('tbl_user', array('username'=>$username, 'password'=>md5($password)));
		if($result->num_rows() > 0){
			// Set last login
			// In order to create same value between last login at database and session
			$last_login_time = date('Y-m-d H:i:s', strtotime("now"));
			
			// Insert data last login
			$this->db->where('id', $result->row()->id);
			$this->db->update('tbl_user', array('last_login_time'=>$last_login_time));
			
			// Save session
			$data = array(
				'username' => $username,
				'name' => $result->row()->name,
				'last_login' => $last_login_time
			);
			$this->session->set_userdata($data);
			
			// Return login success
			// 200 = OK
			echo json_encode(array('Status' => 200, 'Message' => 'Login Success'));
			
		} else {
		
			// Return login failed
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Login Failed'));
		}
		
		
	}
	
	// Reference :: http://www.w3schools.com/php/php_mail.asp
	function process_lost_password()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Validation format parameter
		if(! isset($decode_param->Email)){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter is wrong')); // 500 = Internal Server Error
			exit;
		}
		
		// Validation of null value
		if($decode_param->email == ''){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter must be filled')); // 500 = Internal Server Error
			exit;
		}
		
		// Set variable
		$email = $decode_param->Email;
		
		// Get password from database
		$result = $this->db->get_where('tbl_user', array('email'=>$email));
		if($result->num_rows() > 0){
			// mail("webmaster@example.com",$subject,$message,"From: $from\n");
			mail($email, "IOcome - Lost password", $result->row()->password, "From: IOcome support \n");
			
			// 200 = OK - Save success
			echo json_encode(array('Status' => 200, 'Message' => 'Send password success. Please check your email immediately'));
			exit;
			
		} else {
		
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Send failed. Please try again'));
			exit;
		}
		
	}
	
	function process_signup()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Validation format parameter
		if(! isset($decode_param->Name) ||
			! isset($decode_param->Username) ||
			! isset($decode_param->Password)
		){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter is wrong')); // 500 = Internal Server Error
			exit;
		}
		
		// Validation of null value
		if($decode_param->Name == '' ||
			$decode_param->Username == '' ||
			$decode_param->Password == ''
		){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter must be filled')); // 500 = Internal Server Error
			exit;
		}
		
		// Set variable
		$name = $decode_param->Name;
		$username = $decode_param->Username;
		$password = $decode_param->Password;
		
		// Check to database
		// Duplicate email or not
		$duplicate_email = $this->db->query("SELECT COUNT(*) AS count_data FROM tbl_user WHERE username = '". $username ."'")->row()->count_data;
		if($duplicate_email > 0){
			echo json_encode(array('Status' => 500, 'Message' => 'Your email have exist at database. Please, choose another email or recover your password.')); // 500 = Internal Server Error
			exit;
		}
		
		// Save data
		$date_now = date('Y-m-d H:i:s', strtotime("now"));
		$data = array(
			'username' => $username,
			'password' => md5($password),
			'name' => $name,
			'email' => $username,
			'last_login_time' => '0000-00-00 00:00:00',
			'created_on' => $date_now,
			'last_modified_on' => $date_now
		);
		if($this->db->insert('tbl_user', $data)){
			// 200 = OK - Save success
			echo json_encode(array('Status' => 200, 'Message' => 'Save Success. You can login now'));
		} else {
			// 500 = Internal Server Error - Save failed
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed. Please try again'));
		}
		
	}
	
}
?>