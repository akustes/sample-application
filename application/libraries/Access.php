<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Library
 * @description Access, User Authorization
 */

// ------------------------------------------------------------------------

class CI_Access {

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
	
	public function login($username, $password)
	{
	
		// Set Form Validation Rules
        $this->CI->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->CI->form_validation->set_rules('password', 'Password', 'trim|required|sha1');
        
        // Checks to see if Form data passes the validation
        if( ! $this->CI->form_validation->run())
        {
                // Failed Re Display the View, Errors will display
                $output = 'failed_validation';

        }
        else
        {
               // Form validation success!!
                          
               // Authenticate User                                
                $query = $this->CI->db->where('account_username', set_value('username'))
                ->where('account_password', set_value('password'))
                ->where('account_active', 1)
                ->where('account_deleted', 0)
                ->join('accounts_roles', 'accounts_roles.account_role_id = accounts.account_role_id', 'left')
        		->limit(1)
				->get('accounts');
				
				if($query->num_rows() > 0)
				{
			
					// return result set as an associative array
					$accounts = $query->result_array();
				}
				else
				{
					$accounts = FALSE;
				}


                if($accounts)
				{
					
					foreach($accounts as $account)
					{
						$id = $account['account_id'];
	                    $role_id = $account['account_role_id'];
	                    $username = $account['account_username'];
	                    $name  = $account['account_name'];
	                    $permissions = $account['account_role_permissions'];
					}
					
					// Login Successful!!
	                $account_data = array(
	                   'account_id'  => $id,
	                   'role_id'  => $role_id,
	                   'username'  => $username,
	                   'name'  => $name,
	                   'permissions'  => $permissions,
	                   'logged_in' => TRUE
	                );
	
			   		$this->CI->session->set_userdata($account_data);
			   		
	              	$output = 'success';
	              
				}
				else
				{
					// Failed Login Re Display the View, Errors will display
					$output = 'failed_login';
				}
				
        }
        
        switch($output)
		{
			case 'success':
				 return redirect('dashboard', 'refresh');
				 exit();
			break;
			case 'failed_validation':
				return '';
			break;
			case 'failed_login':
				return lang('error_invalid_login');
			break;
			default:
				return '';
		}
	
	}
	

/*
|--------------------------------------------------------------------------
| USER AUTHENTIFICAION
|--------------------------------------------------------------------------
|
*/

    function authorized()
    {
      	return $this->CI->session->userdata('logged_in');
    }
    
    
    function is_online($id)
    {
	     
	    $query = $this->CI->db->select('user_data')->get('ci_sessions');
				
		if($query->num_rows() > 0)
		{
	
			// return result set as an associative array
			$account = $query->result_array();
		}
		else
		{
			$account = FALSE;
		}

	     
	     if($account)
	     {
	     
	     	foreach($account as $session)
		  	{
		  		if( ! empty($session['user_data']))
		  		{
		  			$data = unserialize($session['user_data']);
			  		
		  			if($data['account_id'] == $id)
		  			{
		  				$output = $data['logged_in'];
		  			}
		  			else
		  			{
		  				$output = FALSE;
		  			}
			  		
		  		}
		  		else
		  		{
		  			$output = FALSE;
		  		}
		  	}
	     
	     }
	     else
	     {
	     	$output = FALSE;
	     }
	     	      
      	 return $output;
    }
     
/*
|--------------------------------------------------------------------------
| ACTIVE MODULES
|--------------------------------------------------------------------------
|
*/   
     function module_active($module)
     {

           $query = $this->CI->db->where('module_name', $module)
                ->where('module_active', 1)
        		->limit(1)
				->get('modules');
				
				if($query->num_rows() > 0)
				{
			
					// return result set as TRUE
					return  TRUE;
				}
				else
				{
					return  FALSE;
				}
     }

/*
|--------------------------------------------------------------------------
| USER PERMISSIONS
|--------------------------------------------------------------------------
|
*/

     public function permission($module, $action, $permissions)
     {	
     	
     	$array = json_decode($permissions, true);
     	
     	if(array_key_exists($module, $array[0]))
     	{
			foreach ($array[0][$module] as $key => $value)
			{ 
 				if($key == $action)
 				{
 					$output = $value;
 				}
			}
     	}
     	else
     	{
     		$output = FALSE;
     	}

		return $output;
     }
      
}

// END CI_Access class

/* End of file access.php */
/* Location: ./system/application/libraries/access.php */