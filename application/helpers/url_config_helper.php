<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CSS URL
 * 
 * Create a local URL based on your basepath for css url.
 *
 * @access	public
 * @param string
 * @return	string
 */
function css_url()
{
	$CI =& get_instance();
	return $CI->config->item("css_url");
}

/**
 * Images URL
 * 
 * Create a local URL based on your basepath for images url.
 *
 * @access	public
 * @param string
 * @return	string
 */
function images_url()
{
	$CI =& get_instance();
	return $CI->config->item("images_url");
}

/**
 * JS URL
 * 
 * Create a local URL based on your basepath for javascript url.
 *
 * @access	public
 * @param string
 * @return	string
 */
function js_url()
{
	$CI =& get_instance();
	return $CI->config->item("js_url");
}

/**
 * Plugins URL
 * 
 * Create a local URL based on your basepath for plugins url.
 *
 * @access	public
 * @param string
 * @return	string
 */
function plugins_url()
{
	$CI =& get_instance();
	return $CI->config->item("plugins_url");
}

?>