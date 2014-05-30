<?php
class Transaction extends CI_Controller
{
	function index()
	{
		if(isset($_POST["isPageFromAjax"])){
			$data = array();
			
			// Get list category
			$this->db->select('id, parent_id, name');
			$list_categories = $this->db->get('tbl_category')->result();
			$data['list_categories'] = $list_categories;
			
			// View
			$data["page_section_form_add"] = $this->load->view('transaction/section-form-add', $data, true);
			// $data["page_section_form_edit"] = $this->load->view('transaction/section-form-edit', $data, true);
			$data["page_section_info_shortcuts"] = $this->load->view('transaction/section-info-shortcuts', '', true);
			$data["page_section_list_data"] = $this->load->view('transaction/section-list-data', $data, true);
			$this->load->view('transaction/main-view', $data);
		} else {
			$this->load->view('main');
		}
	}

	function delete()
	{
		// Set variable
		$id = $_POST['category_id'];
		
		$this->db->where('id', $id);
		$this->db->delete('tbl_category');
	}
	
	function save()
	{
		// Set variable
		$array_type = $_POST['array_type'];
		$array_category = $_POST['array_category'];
		$array_nominal = $_POST['array_nominal'];
		$array_description = $_POST['array_description'];
		$date_transaction = $_POST['date_transaction'];
		$description_transaction = $_POST['description_transaction'];
		
		$data = array(
			'date' => date('Y-m-d H:i:s', strtotime($date_transaction)),
			'description' => $description_transaction,
			'user_id' => 1,
			'created_on' => date('Y-m-d H:i:s', strtotime("now")),
			'created_by' => 1,
			'last_modified_on' => date('Y-m-d H:i:s', strtotime("now")),
			'last_modified_by' => 1
		);
		$this->db->insert('tbl_transaction_data', $data);
		$transaction_data_id = $this->db->insert_id();
		
		for($i=0; $i<count($array_type); $i++){
			$data = array(
				'transaction_data_id' => $transaction_data_id,
				'type' => $array_type[$i],
				'category_id' => $array_category[$i],
				'nominal' => $array_nominal[$i],
				'description' => $array_description[$i],
				'created_on' => date('Y-m-d H:i:s', strtotime("now")),
				'created_by' => 1,
				'last_modified_on' => date('Y-m-d H:i:s', strtotime("now")),
				'last_modified_by' => 1
			);
			$this->db->insert('tbl_transaction_detail', $data);
		}
	}
	
	function update()
	{
		// Set variable
		$name = $_POST['name'];
		$description = $_POST['description'];
		$category_id = $_POST['category_id'];
		$parent_id = $_POST['parent_id'];
		
		$data = array(
			'parent_id' => $parent_id,
			'name' => $name,
			'description' => $description,
			'last_modified_on' => date('Y-m-d H:i:s', strtotime("now")),
			'last_modified_by' => 1
		);
		$this->db->where('id', $category_id);
		$this->db->update('tbl_category', $data);
	}

}
?>