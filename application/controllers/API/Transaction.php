<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Transaction extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		// Session checking
		check_session();
		
	}
	
	public function AddTransaction()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Set variable
		$date_time = (isset($decode_param->DateTime) ? $decode_param->DateTime : 0);
		$description = (isset($decode_param->Description) ? $decode_param->Description : '');
		
		// Validation data
		if($date_time == 0){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Your transaction must have date & time'));
			exit;
		}
		
		// print_r($decode_param->Detail);
		// exit;
		// -----------------  Save to database  -----------------
		$this->db->trans_start();
		
		// Save transaction data
		$transaction_data = array(
			'date' => $date_time,
			'description' => $description,
			'user_id' => 1,
			'created_on' => date('Y-m-d H:i:s', strtotime('now')),
			'created_by' => 1,
			'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
			'last_modified_by' => 1
		);
		$status_save_data = $this->db->insert('tbl_transaction_data', $transaction_data);
		$transaction_data_id = $this->db->insert_id(); // Get id
		
		// Check status save transaction data
		if(! $status_save_data){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed. Transaction cannot be save. There is an error at Transaction Data process. Please try again'));
			exit;
		}
		
		
		// Save transaction detail
		// Loop data and put into array to do insert batch
		$array_list_data = array();
		$data = array();
		if(isset($decode_param->Detail)){
			for($i=0; $i<count($decode_param->Detail); $i++){
				
				// Validation data
				if($decode_param->Detail[$i]->CategoryID == '' || $decode_param->Detail[$i]->CategoryID == 0){
					// 500 = Internal Server Error
					echo json_encode(array('Status' => 500, 'Message' => 'Category cannot be null'));
					exit;
				}
				
				if($decode_param->Detail[$i]->Nominal == '' || $decode_param->Detail[$i]->Nominal == 0){
					// 500 = Internal Server Error
					echo json_encode(array('Status' => 500, 'Message' => 'Nominal cannot be null'));
					exit;
				}
				
				$data = array(
					'transaction_data_id' => $transaction_data_id,
					'category_id' => $decode_param->Detail[$i]->CategoryID,
					'type' => $decode_param->Detail[$i]->Type,
					'nominal' => $decode_param->Detail[$i]->Nominal,
					'description' => $decode_param->Detail[$i]->Description,
					'created_on' => date('Y-m-d H:i:s', strtotime('now')),
					'created_by' => 1,
					'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
					'last_modified_by' => 1
				);
				
				// Collecting array into array group
				array_push($array_list_data, $data);
			}
		} else {
			echo json_encode(array('Status' => 500, 'Message' => 'Your data cannot found')); // 500 = Internal Server Error
			exit;
		}
		
		// Insert batch
		$status_save_detail = $this->db->insert_batch('tbl_transaction_detail', $array_list_data);
		
		$this->db->trans_complete();
		// -----------------  Save to database  -----------------
		
		
		// Return
		if($status_save_detail){
			echo json_encode(array('Status' => 200, 'Message' => 'Save Success')); // 200 = OK
		} else {
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed. Transaction cannot be save. There is an error at Transaction Detail process. Please try again'));
		}
	}
	
	public function EditTransaction()
	{
	}
	
	public function RemoveTransaction()
	{
	}
	
	public function GetListAllTransactions()
	{
	}
	
}
?>