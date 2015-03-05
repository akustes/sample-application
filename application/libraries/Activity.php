<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Library
 * @description Capture User Activities
 */

// ------------------------------------------------------------------------

class CI_Activity {

	var $CI;
	
/*
|--------------------------------------------------------------------------
| CONSTRUCTOR
|--------------------------------------------------------------------------
| Access Control List Constructor
| The constructor loads the CI Super Object and Global Variables
*/
	
	public function __construct()
	{
		
		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();
	}
	
/*
|--------------------------------------------------------------------------
| MAIN
|--------------------------------------------------------------------------
|
*/
	

      
}

// END CI_Activity class

/* End of file activity.php */
/* Location: ./system/application/libraries/activity.php */