<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Messages
 *
 * Displays Events Lists and Misc. Data
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
			    	|| $segment == 'completed' 
			    	|| $segment == 'not_completed' 
			    	|| $segment == 'search'
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

if ( ! function_exists('response'))
{
	function response()
	{
	
		return array( 
			
			'' => lang('events_choose_response'),
			'attending' => lang('events_attending'),
			'not attending' => lang('events_not_attending')
		);	

	}
}

if ( ! function_exists('type'))
{
	function type()
	{
	
		return array( 
			
			'' => lang('events_choose_status'),
			'invite' => lang('events_invite'),
			'cancelled' => lang('events_cancelled')
		);	

	}
}




// ------------------------------------------------------------------------

/* End of file events_helper.php */
/* Location: ./system/application/helpers/events_helper.php */