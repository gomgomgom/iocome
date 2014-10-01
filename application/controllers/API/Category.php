<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Category extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		// Session checking
		check_session();
		
	}
	
	// Create nested array data
	// From database with parent_id field
	// Reference :: http://stackoverflow.com/questions/2273449/creating-a-multilevel-array-using-parentids-in-php
	private function _buildTree( $ar, $pid = 0, $content = '') {
		$op = array();
		$content = $content;
		foreach( $ar as $item ) {
			if( $item['parent_id'] == $pid ) {
				$op[$item['id']] = array(
					'id' => $item['id'],
					'parent_id' => $item['parent_id'],
					'name' => $item['name']
				);
				
				// using recursion
				if($item['source'] == 'profile'){
					$children =  $this->_buildTree( $ar, $item['id'], $content . '<ul>' );
					if( $children ) {
						$op[$item['id']]['children'] = $children;
					} else {
						$op[$item['id']]['children'] = array();
					}
				} else {
					$op[$item['id']]['children'] = array();
				}
				
			}
		}
		return $op;
	}

	public function AddCategory()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Validation format parameter
		if(! isset($decode_param->ParentID) ||
			! isset($decode_param->ListData) ||
			! isset($decode_param->ListData[0]->Name)
		){
			echo json_encode(array('Status' => 500, 'Message' => 'Your format parameter is wrong')); // 500 = Internal Server Error
			exit;
		}
		
		// Set variable
		$parent_id = (isset($decode_param->ParentID) ? $decode_param->ParentID : -1);
		
		// Validation data
		if($parent_id == -1){
			echo json_encode(array('Status' => 500, 'Message' => 'Your data cannot found')); // 500 = Internal Server Error
			exit;
		}
		
		
		// -----------------  Save to database  -----------------
		// Loop data and put into array to do insert batch
		$array_list_data = array();
		$data = array();
		$user_id = $this->session->userdata('userid');
		for($i=0; $i<count($decode_param->ListData); $i++){
			
			// Validation data
			if($decode_param->ListData[$i]->Name == ''){
				echo json_encode(array('Status' => 500, 'Message' => 'Name cannot be null')); // 500 = Internal Server Error
				exit;
			}
			
			$data = array(
				'parent_id' => $parent_id,
				'name' => $decode_param->ListData[$i]->Name,
				'description' => $decode_param->ListData[$i]->Description,
				'user_id' => $user_id,
				'created_on' => date('Y-m-d H:i:s', strtotime('now')),
				'created_by' => $user_id,
				'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
				'last_modified_by' => $user_id
			);
			
			// Collecting array into array group
			array_push($array_list_data, $data);
		}
		
		
		// Insert batch
		$status_save = $this->db->insert_batch('tbl_category', $array_list_data);
		// -----------------  Save to database  -----------------
		
		// Return
		if($status_save){
			echo json_encode(array('Status' => 200, 'Message' => 'Save Success')); // 200 = OK
		} else {
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed')); // 500 = Internal Server Error
		}
	}
	
	public function EditCategory()
	{
		// Get data (POST method)
		$parameter = file_get_contents("php://input");
		
		// Decode data
		$decode_param = json_decode($parameter);
		
		// Set variable
		$id = (isset($decode_param->ID) ? $decode_param->ID : -1);
		$parent_id = (isset($decode_param->ParentID) ? $decode_param->ParentID : -1);
		$name = (isset($decode_param->Name) ? $decode_param->Name : null);
		$description = (isset($decode_param->Description) ? $decode_param->Description : null);
		
		// Validation data
		if($id == -1 || $parent_id == -1 || $name == null){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Your data cannot found'));
			exit;
		}
		if(! is_numeric($id)){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'ID field must be numeric'));
			exit;
		}
		if(! is_numeric($parent_id)){
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Parent ID field must be numeric'));
			exit;
		}
		
		
		
		// -----------------  Save to database  -----------------
		$data = array(
			'parent_id' => $parent_id,
			'name' => $name,
			'description' => $description,
			'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
			'last_modified_by' => 1
		);
		$this->db->where('id', $id);
		$status_save = $this->db->update('tbl_category', $data);
		// -----------------  Save to database  -----------------
		
		// Return
		if($status_save){
			// 200 = OK
			echo json_encode(array('Status' => 200, 'Message' => 'Save Success'));
		} else {
			// 500 = Internal Server Error
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed'));
		}
	}
	
	public function RemoveCategory()
	{
		// Set variable
		$id = (isset($_GET['id']) ? $_GET['id'] : -1);
		
		// Validation data
		if($id == -1){
			echo json_encode(array('Status' => 500, 'Message' => 'Your data cannot found')); // 500 = Internal Server Error
			exit;
		}
		
		
		// -----------------  Delete to database  -----------------
		// Check if this category have already been data
		// You must remove all transaction before
		// And then you can remove this category
		if($this->db->query('SELECT COUNT(*) AS count_data 
			FROM tbl_transaction_detail 
			WHERE category_id = '. $id)->row()->count_data > 0){
			
			echo json_encode(array('Status' => 500, 'Message' => 'This category still have transaction data. You must remove all transaction that use this category')); // 500 = Internal Server Error
			exit;
		}
		
		// Delete data
		$this->db->where('id', $id);
		$status_delete = $this->db->delete('tbl_category');
		// -----------------  Delete to database  -----------------
		
		
		// Return
		if($status_delete){
			echo json_encode(array('Status' => 200, 'Message' => 'Save Success')); // 200 = OK
		} else {
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed')); // 500 = Internal Server Error
		}
	}
	
	public function GetListAllCategory()
	{
		// -----------------  Get data from database  -----------------
		$this->db->from('tbl_category');
		$result = $this->db->get()->result();
		// -----------------  Get data from database  -----------------
		
		// Change array key consistent with documentation API
		$list_new_result = array();
		$new_result = array();
		for($i=0; $i<count($result); $i++){
			foreach($result[$i] as $key=>$val){
			
				// Change key of array
				switch($key){
					case "id":
						$new_result["ID"] = $val;
						break;
					case "parent_id":
						$new_result["ParentID"] = $val;
						break;
					case "name":
						$new_result["Name"] = $val;
						break;
					case "description":
						$new_result["Description"] = $val;
						break;
					case "created_on":
						$new_result["CreatedOn"] = $val;
						break;
					case "created_by":
						$new_result["CreatedBy"] = $val;
						break;
					case "last_modified_on":
						$new_result["LastModifiedOn"] = $val;
						break;
					case "last_modified_by":
						$new_result["LastModifiedBy"] = $val;
						break;
				}
			}
			
			// Collecting array with new key to group
			array_push($list_new_result, $new_result);
			
			// Empty an array for filled the data at next loop
			$new_result = array();
		}
		
		// Encode all data to JSON Format
		$json_content = json_encode($list_new_result);
		
		// Return
		echo $json_content;
	}
	
}
?>