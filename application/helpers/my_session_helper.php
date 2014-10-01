<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Session Checking
 * 
 * Create a local URL based on your basepath for css url.
 *
 * @access	public
 * @param string
 * @return	string
 */
function check_session()
{
	$CI =& get_instance();
	if(! $CI->session->userdata('userid')){
		echo json_encode(array('Status' => 440, 'Message' => 'Your session has expired !')); // 200 = OK
		exit;
	}
}

?>