<?php

/**
* Plugin Name: Accordion - TMS Media
* Plugin URI: http://tms-media.co.uk
* Description: Adds shortcode for displaying an Accordion
* Version: 1.0
* Author: Ryan Knights - TMS Media
* Author URI: http://ryanknights.co.uk
*/
	
	if (!defined( 'ABSPATH'))
	{
		exit();
	}
	
	require_once('inc/tms-accordion.class.php');

	new TmsAccordion();
?>