<?php
class Category extends CI_Controller
{
	private function _get_data_list($order_by, $order_value)
	{
		$this->db->where('user_id', $this->config->item('user_id'));
		$this->db->order_by($order_by, $order_value);
		return $this->db->get('tbl_category')->result();
	}
	
	private function _get_list_nested_data($data_category, $id, $new_data = array())
	{
		// get $data[$id] and work with that array, building the array.
		for($i=0; $i<sizeof($data_category[$id]); $i++){
			while(sizeof($data_category[$id]) > 0){
				array_push($new_data, $data_category[$i]);
				$this->_get_list_nested_data($data_category[$id], $id, $new_data);
			}
		}
		
	}
	
	private function _get_data_parent2($list_data)
	{
		// Get data category to display as parent field on form Add
		$arrayNestedCategory = array();
		$listNestedCategory = array();
		$listParentCategory = array();
		
		if(sizeof($list_data) > 0){
			$arrayNestedCategory = $list_data;
			
			// -- Get level Root --
			// Make separated because later will be there is  unset (remove element from an array)
			// That is influencing on syntax sizeof for next loop be decreased of value actual
			$lengthNestedCategory = sizeof($arrayNestedCategory);
			for($i=0; $i<$lengthNestedCategory; $i++){
				// echo $i;
				if($arrayNestedCategory[$i]->parent_id == 0) {
					array_push($listParentCategory, $arrayNestedCategory[$i]);
					unset($arrayNestedCategory[$i]); // remove element from an array which have been pushed to list parent
				}
			}
			// -- Get level Root --
			
			
			// -- Get next level (Root to down) --
			// Array that use for this have no parent_id = 0
			// Because it have removed when getting level root
			for($i=0; $i<sizeof($listParentCategory); $i++){
				array_push($listNestedCategory, $listParentCategory[$i]); // Push to new array for get those child
				
				// Get child category
				// Cannot use syntax "for" because key of an array have been random so we must use synatx "foreach"
				foreach($arrayNestedCategory as $key => $val){
					if($arrayNestedCategory[$key]->parent_id == $listParentCategory[$i]->id){
						$arrayNestedCategory[$key]->name = "&nbsp;-&nbsp;" . $arrayNestedCategory[$key]->name; // Give space to differentiate between parent and child
						array_push($listNestedCategory, $arrayNestedCategory[$key]);
					}
				}
			}
			// -- Get next level (Root to down) --
			
			return $listNestedCategory;
		}
		
		return array();
	}
	
	function index()
	{
		if(isset($_POST["isPageFromAjax"])){
		
			// Get all data, ordered by parent id
			$list_data = $this->_get_data_list('parent_id', 'asc');
			$data["list_data"] = $list_data;
			
			
			// ------  Begin :: Get parent & child  ------
			$list_nested_category = $this->_get_data_parent2($list_data);
			$data['list_nested_category'] = $list_nested_category;
			
			
			// Put row into $data[$parent_id][]
			// $data_category[] = array();
			// if(sizeof($list_data) > 0){
				// for($i=0; $i<sizeof($list_data); $i++){
					// $data_category[$list_data[$i]->parent_id] = $list_data;
				// }
			// }
			
			// $listNestedCategory = $this->_get_data_parent($list_data);
			// $data["list_nested_category"] = $listNestedCategory;
			
			// print_rr($list_data);
			// ------  End :: Get parent & child  ------
			
			// View
			$data["page_section_form_add"] = $this->load->view('category/section-form-add', $data, true);
			$data["page_section_form_edit"] = $this->load->view('category/section-form-edit', $data, true);
			$data["page_section_info_shortcuts"] = $this->load->view('category/section-info-shortcuts', '', true);
			$data["page_section_list_data"] = $this->load->view('category/section-list-data', $data, true);
			$this->load->view('category/main-view', $data);
		} else {
			$this->load->view('main');
		}
	}

	function delete()
	{
		// Set variable
		$id = $_POST['category_id'];
		
		$this->db->where('id', $id);
		echo $this->db->delete('tbl_category');
	}
	
	function update()
	{
		// Set variable
		$category_id = (isset($_POST['category_id']) ? $_POST['category_id'] : 0);
		$parent_category_id = (isset($_POST['parent_category_id']) ? $_POST['parent_category_id'] : 0);
		$name = (isset($_POST['name']) ? $_POST['name'] : null);
		$description = (isset($_POST['description']) ? $_POST['description'] : null);
		$last_modified_on = date('Y-m-d H:i:s', strtotime("now"));
		
		$data = array(
			'parent_id' => $parent_category_id,
			'name' => $name,
			'description' => $description,
			'last_modified_on' => $last_modified_on,
			'last_modified_by' => 1
		);
		$this->db->where('id', $category_id);
		
		// Return
		echo json_encode(
			array(
				"status" => $this->db->update('tbl_category', $data),
				"last_modified_on" => date('d-M-Y H:i:s', strtotime($last_modified_on))
			)
		);
	}
	
	function view_list_data()
	{
		$data["list_data"] = $this->db->get('tbl_category')->result();
		echo $this->load->view('category/section-list-data', $data, true);
	}
	
	
}
?>