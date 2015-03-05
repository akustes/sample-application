<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Test, Debugging
 */

// ------------------------------------------------------------------------


class Testing extends CI_Controller {

		
	public function index()
	{
        	    if($this->config->item('smtp_gateway'))
        	    {
        	            if($this->config->item('smtp_gateway_smtp'))
        	            {
                		    $email_config['protocol'] = 'smtp';
                		    $email_config['smtp_host'] = $this->config->item('smtp_gateway_host');
                		    $email_config['smtp_user'] = $this->config->item('smtp_gateway_username');
                		    $email_config['smtp_pass'] = $this->config->item('smtp_gateway_password');
                		    $email_config['smtp_port'] = $this->config->item('smtp_gateway_port');
                		    $email_config['smtp_timeout'] = $this->config->item('smtp_gateway_timeout');
        	            }
        	            
        	            if($this->config->item('smtp_gateway_api'))
        	            {
  
                		   $email_user = $this->config->item('smtp_gateway_username');
                		   $email_password = $this->config->item('smtp_gateway_password');
                		   
                		   
                		    
        	            }
        	    }  
	}
	
}

/* End of file testing.php */
/* Location: ./application/controllers/testing.php */