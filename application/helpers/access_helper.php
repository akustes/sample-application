<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Access
 *
 * Check if User has Proper Permissions for User Actions
 *
 * @access	public
 * @param	string
 * @return	string
 */	


if ( ! function_exists('logged_in'))
{
	function logged_in()
	{
	
		$CI =& get_instance();
		
		return $CI->access->authorized();
	}

}


if ( ! function_exists('session'))
{
	function session($type)
	{
	
		$CI =& get_instance();
		
		switch($type)
		{
			case 'session_id':
				$output = $CI->session->userdata('session_id');
			break;
			case 'id':
				$output = $CI->session->userdata('account_id');
			break;
			case 'role_id':
				$output = $CI->session->userdata('role_id');
			break;
			case 'username':
				$output = $CI->session->userdata('username');
			break;
			case 'name':
				$output = $CI->session->userdata('name');
			break;
			case 'permissions':
				$output = $CI->session->userdata('permissions');
			break;
			case 'online':
				$output = $CI->session->userdata('logged_in');
			break;
		}

		return $output;
	}

}


if ( ! function_exists('active_module'))
{
	function active_module($module)
	{
	
		$CI =& get_instance();
		
		return $CI->access->module_active($module);
	}

}


if ( ! function_exists('current_module'))
{
	function current_module($module)
	{
	
		$CI =& get_instance();
		
		if($module == $CI->router->fetch_class())
		{
			$active = 'active';
		}
		else
		{
			$active = '';
		}
		
		return $active;
	
	}

}


if ( ! function_exists('permission_check'))
{
	function permission_check($module, $action)
	{
	
		$CI =& get_instance();
		
		return $CI->access->permission($module, $action, $CI->session->userdata('permissions'));			
	}

}


if ( ! function_exists('account_online'))
{
	function account_online($id)
	{
	
		$CI =& get_instance();
		
		return $CI->access->is_online($id);
	}

}
	
// ------------------------------------------------------------------------

/* End of file access_helper.php */
/* Location: ./system/application/helpers/access_helper.php */