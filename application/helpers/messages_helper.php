<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Messages
 *
 * Displays Messages Lists and Misc. Data
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
			    	|| $segment == 'delete' 
			    	|| $segment == 'deleted' 
			    	|| $segment == 'read' 
			    	|| $segment == 'unread' 
			    	|| $segment == 'outgoing' 
			    	|| $segment == 'search'
			    )
			    {
			    	$action = $segment;
			    }
			    elseif($segment == 'sent')
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


// ------------------------------------------------------------------------

/* End of file messages_helper.php */
/* Location: ./system/application/helpers/messages_helper.php */