<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Accounts
 *
 * Displays Accounts Lists and Misc. Data
 */
 	
/**
 * URI Segment Parser
 *
 * handles actions, id's and messages
 */
 	
if ( ! function_exists('uri_parser'))
{
	function uri_parser()
	{
		
		$CI =& get_instance();
		
		$segs = $CI->uri->segment_array();
		
		if(isset($segs))
		{
			foreach ($segs as $segment)
			{
			    if(is_numeric($segment))
			    {
			    	$id = $segment;
			    }
			    elseif($segment == 'view' 
			    	|| $segment == 'add' 
			    	|| $segment == 'edit' 
			    	|| $segment == 'delete' 
			    	|| $segment == 'deleted' 
			    	|| $segment == 'active' 
			    	|| $segment == 'not_active' 
			    	|| $segment == 'search_last_name' 
			    	|| $segment == 'search_gender'
			    )
			    {
			    	$action = $segment;
			    }
			    elseif($segment == 'saved')
			    {
			    	$message = $segment;
			    }
			    else
			    {
			    	$id = '';
			    	$action = '';
			    	$message = '';
			    }
			}
						
			return array(
				'id' => $id,
				'action' => $action,
				'message' => $message
			);

		}
		else
		{
			return FALSE;
		}

	}
}


if ( ! function_exists('roles'))
{
	function roles()
	{
	
		return array( 
			
			'' => 'Choose User Role',
			'1' => 'Administrator',
			'2' => 'Manager',
			'3' => 'Standard'
		);	

	}
}


if ( ! function_exists('genders'))
{
	function genders()
	{
	
		return array( 
			
			'' => 'Choose Gender',
			'male' => 'Male',
			'female' => 'Female'
		);	
		
	}
}


// ------------------------------------------------------------------------

/* End of file accounts_helper.php */
/* Location: ./system/application/helpers/accounts_helper.php */