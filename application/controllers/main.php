<?php
class Main extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		redirect("dashboard");
		
		// // Get data category
		// $this->db->select('*');
		// $this->db->order_by('name', 'asc');
		// $query = $this->db->get('tbl_category');
		// $categorys = $query->result_array();

		// // Sorting category by parent
		// $data['category_data'] = $this->_sorting_category_data($categorys);
		
		// // List category for menu transaction
		// $list_categorys = array();
		// $list_categorys[0] = " ---  Choose category --- ";
		// if(count($categorys) > 0)
		// for($i=0; $i<count($categorys); $i++){
			// $list_categorys[$categorys[$i]['id']] = $categorys[$i]['name'];
		// }
		// $data['list_categorys'] = $list_categorys;
		
		
		
		
		// // Get data transaction
		// $this->db->order_by('date','asc');
		// $transaction_data = $this->db->get('tbl_transaction_data')->result_array();
		
		// // Get detail transaction
		// $this->db->select('
			// tbl_transaction_detail.id,
			// tbl_transaction_detail.transaction_data_id,
			// tbl_transaction_detail.category_id,
			// tbl_category.name AS category_name,
			// tbl_transaction_detail.nominal,
			// tbl_transaction_detail.description,
			// tbl_transaction_detail.created_on,
			// tbl_transaction_detail.created_by,
			// tbl_transaction_detail.last_modified_on,
			// tbl_transaction_detail.last_modified_by
		// ');
		// $this->db->from('tbl_transaction_detail');
		// $this->db->join('tbl_category', 'tbl_category.id = tbl_transaction_detail.category_id', 'INNER');
		// $transaction_detail = $this->db->get()->result_array();
		
		// // Merge data & detail transaction
		// // For get summary transaction
		// $merge_transaction = array();
		// $summary_transaction = '';
		// if(count($transaction_data) > 0){
			// for($i=0; $i<count($transaction_data); $i++){
				
				// $summary_transaction = ''; // Back to default for filled again
				// $no = 0;
				// for($j=0; $j<count($transaction_detail); $j++){
				
					// // Summary cannot bigger than 3 records
					// if($no > 3) {
						// $summary_transaction .= "....";
						// break;
					// }
					
					// // Entry summary transaction to variable string
					// if($transaction_data[$i]['id'] == $transaction_detail[$j]['transaction_data_id']){
						// $no++;
						// $summary_transaction .= $no . ". " . $transaction_detail[$j]['category_name'] . " - " . $this->config->item('currency') . number_format($transaction_detail[$j]['nominal'], 0, '', '.') . "<br/>";
					// }
				// }
				
				// $transaction_data[$i]['summary_transaction'] = $summary_transaction;
				
			// }
		// }
		// $data['transaction_data'] = $transaction_data;
		// $data['transaction_detail'] = $transaction_detail;
		
		
		$this->load->view('main');
	}
	
	/**
	 * Sorting category data
	 *
	 * Merapihkan data category agar bisa muncul sesuai antara parent & child-nya
	 * NB : Saat ini sorting hanya bisa mencakup sampai kedalaman 2 level
	 *
	 * @param		$data			Data category yang diambil dari database
	 * @param		$result			Data category yang sudah di sortir / urutkan berdasarkan parent & child-nya masing-masing
	 */
	private function _sorting_category_data($data)
	{
		// print_rr($data);
		
		// Set variable
		$arrayParentRoot = array(); // list data yang sudah tampil tapi hanya untuk yang parent_id = 0
		$arrayParentLevel1 = array();
		$arrayParentLevel2 = array();
		$result = array(); // untuk menampung output data
		
		// Loop data for sorting
		// Level Root
		if(count($data) > 0){
		
			foreach($data as $val){
				if($val['parent_id'] == 0 && ! in_array($val['parent_id'], $arrayParentRoot) ){
					array_push($arrayParentRoot, $val['id']);
					array_push($result, $val);
					
					
					// Loop data for sorting
					// Level 1
					foreach($data as $val_1){
						if($val_1['parent_id'] == $val['id'] && ! in_array($val_1['parent_id'], $arrayParentLevel1) ){
							array_push($arrayParentLevel1, $val_1['id']);
							$val_1['name'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $val_1['name'];
							array_push($result, $val_1);
							
							
							// Loop data for sorting
							// Level 2
							foreach($data as $val_2){
								if($val_2['parent_id'] == $val_1['id'] && ! in_array($val_2['parent_id'], $arrayParentLevel2) ){
									array_push($arrayParentLevel2, $val_2['id']);
									$val_2['name'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $val_2['name'];
									array_push($result, $val_2);
								}
							} // end loop level 2
					
					
						}
					} // end loop level 1
					
					
				}
			} // end loop level Root
			
		}
		
		// print_rr($result);
		// $result = $data;
		return $result;
	}
	
	// Generate your multidimensional array from the linear array
	function GenerateNavArray($arr, $parent = 0)
	{
		$pages = Array();
		foreach($arr as $page)
		{
			if($page['parent_id'] == $parent)
			{
				$page['sub'] = isset($page['sub']) ? $page['sub'] : $this->GenerateNavArray($arr, $page['id']);
				$pages[] = $page;
			}
		}
		return $pages;
	}

	// loop the multidimensional array recursively to generate the HTML
	function GenerateNavHTML($nav)
	{
		$html = '';
		foreach($nav as $page)
		{
			// $html .= '<ul><li>';
			$html .= '<tr><td><table><tr><td>';
			// $html .= '<a href="#">' . $page['name'] . ' - ' . $page['description'] . '</a>';
			$html .= '' . $page['name'] . ' - ' . $page['description'] . '';
			$html .= $this->GenerateNavHTML($page['sub']);
			// $html .= '</li></ul>';
			$html .= '</td></tr></table></td></tr>';
		}
		return $html;
	}
	
}
?>