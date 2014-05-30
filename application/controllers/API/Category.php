<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Category extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
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
		
		// Set variable
		$parent_id = (isset($decode_param->ParentID) ? $decode_param->ParentID : -1);
		
		// Validation data
		if($parent_id == -1){
			echo json_encode(array('Status' => 500, 'Message' => 'Your data cannot found')); // 500 = Internal Server Error
			exit;
		}
		
		// -----------------  Save to database  -----------------
		$data = array(
			'parent_id' => $parent_id,
			'name' => $name,
			'description' => $description,
			'user_id' => 1,
			'created_on' => date('Y-m-d H:i:s', strtotime('now')),
			'created_by' => 1,
			'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
			'last_modified_by' => 1
		);
		$status_save = $this->db->insert('tbl_category', $data);
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
			echo json_encode(array('Status' => 500, 'Message' => 'Your data cannot found')); // 500 = Internal Server Error
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
			echo json_encode(array('Status' => 200, 'Message' => 'Save Success')); // 200 = OK
		} else {
			echo json_encode(array('Status' => 500, 'Message' => 'Save Failed')); // 500 = Internal Server Error
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
	
	public function GetListAllCategories()
	{
		// -----------------  Get data from database  -----------------
		$this->db->from('tbl_category');
		$result = $this->db->get()->result();
		// -----------------  Get data from database  -----------------
		
		// Encode all data to JSON Format
		$json_content = json_encode($result);
		
		// Return
		echo $json_content;
	}
	
}
?>