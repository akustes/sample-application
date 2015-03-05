<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Library
 * @description Email, Email System
 */

// ------------------------------------------------------------------------

class CI_Sendgrid {

	var $CI;
	private $username;
	private $password;
	
/*
|--------------------------------------------------------------------------
| CONSTRUCTOR
|--------------------------------------------------------------------------
| The constructor loads the CI Super Object and Global Variables
*/
	
	public function __construct()
	{
		
		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();
		
		$this->username = $this->CI->config->item('smtp_gateway_username');
		$this->password = $this->CI->config->item('smtp_gateway_password');
		
	}
	
/*
|--------------------------------------------------------------------------
| MAIN
|--------------------------------------------------------------------------
|
*/
	
	function send_email($to, $from, $from_title, $subject, $body, $type = 'smtp')
	{
        		
        		
           if($type == 'smtp')
           {
                 $this->CI->load->library('email');
    	
    	         
    	         $config['protocol'] = 'smtp';
    		     $config['smtp_host'] = $this->CI->config->item('smtp_gateway_host');
    		     $config['smtp_user'] = $this->username;
    		     $config['smtp_pass'] = $this->password;
    		     $config['smtp_port'] = $this->CI->config->item('smtp_gateway_port');
    		     $config['smtp_timeout'] = $this->CI->config->item('smtp_gateway_timeout');
    	         $config['mailtype'] = 'html';
    	         $config['charset'] = 'iso-8859-1';
    	         $config['wordwrap'] = TRUE;
    	
    	         $this->CI->email->initialize($config);
    	         
    	         $this->CI->email->from($from, $from_title);
	             $this->CI->email->to($to);
	             $this->CI->email->subject($subject);
	             $this->CI->email->message($body);
	             $this->CI->email->send();
	            
	             return $this->CI->email->print_debugger();
           }
           
           
           if($type == 'api')
           {
        		 $url = 'http://sendgrid.com/';
        		 $user = $this->username;
        		 $pass = $this->password; 
        		
        		 $params = array(
        		      'api_user' => $this->username,
        		      'api_key' => $this->password,
        		      'to' => $to,
        		      'subject' => $subject,
        		      'html' => $body,
        		      'text' => $body,
        		      'from' => $from
        		   );
        		
        		 $request = $url.'api/mail.send.json';
        		
        		 // Generate curl request
        		 $session = curl_init($request);
        		
        		 // Tell curl to use HTTP POST
        		 curl_setopt ($session, CURLOPT_POST, true);
        		
        		 // Tell curl that this is the body of the POST
        		 curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        		
        		 // Tell curl not to return headers, but do return the response
        		 curl_setopt($session, CURLOPT_HEADER, false);
        		 curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        		
        		 // obtain response
        		 $response = curl_exec($session);
        		 curl_close($session);
        		
        		 // print everything out
        		 return $response;
            }
            
	}
      
}

// END CI_Sendgrid class

/* End of file sendgrid.php */
/* Location: ./system/application/libraries/sendgrid.php */