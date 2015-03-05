<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Models
 * @description Accounts Model
 * @Files       
 */

// ------------------------------------------------------------------------

class Accounts_model extends CI_Model {



/* =================================================================================
* DATA MODEL AND BUSINESS LOGIC 
* ================================================================================= */

	
	function get($id = NULL, $per_page = NULL, $offset = NULL, $type = NULL, $keyword = NULL)
	{ 
        
        
        if( ! empty($id))
        {            
        	$this->db->where('account_id', $id);
        	$this->db->limit(1);
        	
        	$query = $this->db->get('accounts');
        	
        	if($query->num_rows() > 0)
			{
				foreach ($query->result_array() as $row)
				{
					$result_arr = $row;
				}
				
				return $result_arr;
			}
			else
			{
				return FALSE;
			}
		
        }
        else
        {         
            
            switch($type)
        	{
        		
        		case 'active':
        			$this->db->where('account_active', 1);
        			$this->db->where('account_deleted', 0);
        		break;
        		case 'not_active':
        			$this->db->where('account_active', 0);
        			$this->db->where('account_deleted', 0);
        		break;
        		case 'deleted':
        			$this->db->where('account_active', 0);
        			$this->db->where('account_deleted', 1);
        		break;
        		case 'search_last_name':
        			$this->db->like('account_last_name', $keyword);
        		break;
        		case 'search_gender':
        			$this->db->where('account_gender', $keyword);
        			$this->db->where('account_active', 1);
        			$this->db->where('account_deleted', 0);
        		break;
        		default:
        			$this->db->where('account_active', 1);
        			$this->db->where('account_deleted', 0);
        	}
            
           
            $this->db->order_by('account_last_name', 'asc');
        

			$query = $this->db->get('accounts', $per_page, $offset);
			
			if($query->num_rows() > 0)
			{
		
				// return result set as an associative array
				return $query->result_array();
			}
			else
			{
				return FALSE;
			}
		
		}
		
	}
	
	
	function create($data, $signup = FALSE)
	{
		
        // Set Form Validation Rules
        $this->form_validation->set_rules('active', 'Active', 'trim|xss_clean');
        $this->form_validation->set_rules('role_id', 'Role', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[2]|max_length[20]|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|sha1');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
        $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('county', 'County', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['account_hash_id'] = $this->encrypt->sha1(random_string('alnum', 8));
			$fields['account_role_id'] = set_value('role_id');
			$fields['account_gender'] = set_value('gender');
			$fields['account_dob'] = set_value('dob');
			$fields['account_username'] = set_value('username');
			$fields['account_password'] = set_value('password');
			$fields['account_name'] = set_value('first_name') . ' ' . set_value('last_name');
			$fields['account_first_name'] = set_value('first_name');
			$fields['account_last_name'] = set_value('last_name');
			$fields['account_phone'] = set_value('phone');
			$fields['account_email'] = set_value('email');
			$fields['account_address'] = set_value('address');
			$fields['account_city'] = set_value('city');
			$fields['account_state'] = set_value('state');
			$fields['account_zip'] = set_value('zip');
			$fields['account_county'] = set_value('county');
			$fields['account_country'] = set_value('country');
			$fields['account_created_date'] = now();
			$fields['account_active'] = set_value('active');
			
			if($_FILES['userfile']['name'])
			{			
				$image = $this->upload_image($_FILES['userfile']['name']);
				
				if( ! isset($image['error']))
				{
					$fields['account_image'] = $image['upload_data']['client_name'];
				}
	
			}
			
			$this->db->insert('accounts', $fields);		
			$auto_account_id = $this->db->insert_id();
			
			$billing_fields['account_id'] = $auto_account_id;
			$billing_fields['account_billing_active'] = 1;
			
			$this->db->insert('accounts_billing', $billing_fields);
			$auto_account_billing_id = $this->db->insert_id();
			
			$output = 'success';
		}
		
		
		switch($output)
		{
			case 'success':
		
				// Send Email Notification
				
				 if($signup)
				 {
				 	// Redirect to Confirmation Page
				 	$controller =  'signup/confirm';
				 }
				 else
				 {
				 	 // Redirect to Account User's Dashboard
				 	$controller =  'accounts';
				 }
				 
				 return redirect($controller, 'refresh');
				 exit();
			break;
			case 'failed_validation':
				 return FALSE;
			break;
			default:
				 return FALSE;
		}

	}
	
	
	function update($data)
	{
		
        // Set Form Validation Rules
        $this->form_validation->set_rules('account_id', 'Account ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');

        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');

        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');

        $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('county', 'County', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
        $this->form_validation->set_rules('original_image', 'Original Image', 'trim|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['account_dob'] = set_value('dob');
			$fields['account_username'] = set_value('username');
			$fields['account_name'] = set_value('first_name') . ' ' . set_value('last_name');
			$fields['account_first_name'] = set_value('first_name');
			$fields['account_last_name'] = set_value('last_name');
			$fields['account_phone'] = set_value('phone');
			$fields['account_email'] = set_value('email');
			$fields['account_address'] = set_value('address');
			$fields['account_city'] = set_value('city');
			$fields['account_state'] = set_value('state');
			$fields['account_zip'] = set_value('zip');
			$fields['account_county'] = set_value('county');
			$fields['account_country'] = set_value('country');
			
			if($_FILES['userfile']['name'])
			{			
				$image = $this->upload_image($_FILES['userfile']['name']);
				
				if( ! isset($image['error']))
				{
					$fields['account_image'] = $image['upload_data']['client_name'];
				}
	
			}
			else
			{
				$fields['account_image'] = set_value('original_image');
			}

		
			$this->db->where('account_id', set_value('account_id'));
			$this->db->update('accounts', $fields);
			
			$output = 'success';
		}
		
		switch($output)
		{
			case 'success':
				 // Redirect to User Account
				 return redirect('accounts/manage/' . set_value('account_id') . '/edit/saved', 'refresh');
				 exit();
			break;
			case 'failed_validation':
				 return FALSE;
			break;
			default:
				 return FALSE;
		}


	}
	
	function update_password($data)
	{

        // Set Form Validation Rules
        $this->form_validation->set_rules('account_id', 'Account ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_confirm]|sha1');
	$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required|xss_clean');       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			$fields['account_password'] = set_value('password');
			
			$this->db->where('account_id', set_value('account_id'));
		
			$this->db->update('accounts', $fields);
			
			$output = 'success';
		}
		
		switch($output)
		{
			case 'success':
				 // Redirect to Account User's Dashboard
				 return redirect('accounts/password/' . set_value('account_id') . '/saved', 'refresh');
				 exit();
			break;
			case 'failed_validation':
				 return FALSE;
			break;
			default:
				 return FALSE;
		}


	}
	
	
	function get_billing($id)
	{ 

		$query = $this->db->where('account_id', $id)
        ->limit(1)
		->get('accounts_billing');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$result_arr = $row;
			}
			
			return $result_arr;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	
	function update_billing($data)
	{
		
        // Set Form Validation Rules
        $this->form_validation->set_rules('account_id', 'Account ID', 'trim|xss_clean');
        $this->form_validation->set_rules('account_billing_id', 'Account Billing ID', 'trim|xss_clean');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
        $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|required|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			$fields['account_billing_name'] = set_value('first_name') . ' ' . set_value('last_name');
			$fields['account_billing_first_name'] = set_value('first_name');
			$fields['account_billing_last_name'] = set_value('last_name');
			$fields['account_billing_phone'] = set_value('phone');
			$fields['account_billing_address'] = set_value('address');
			$fields['account_billing_city'] = set_value('city');
			$fields['account_billing_state'] = set_value('state');
			$fields['account_billing_zip'] = set_value('zip');
			$fields['account_billing_country'] = set_value('country');	
			$fields['account_id'] = set_value('account_id');
		
			$this->db->where('account_billing_id', set_value('account_billing_id'));
			$this->db->update('accounts_billing', $fields);
			
			$output = 'success';
		}
		
		switch($output)
		{
			case 'success':
				 // Redirect to Account User's Dashboard
				 return redirect('accounts/billing/' . set_value('account_id') . '/saved', 'refresh');
				 exit();
			break;
			case 'failed_validation':
				 return FALSE;
			break;
			default:
				 return FALSE;
		}


	}

	
	function update_status($id, $status)
	{
        
        switch($status)
        {
        	case 'active':
        		$fields['account_active'] = 1;
        		$bfields['account_billing_active'] = 1;
        	break;
        	case 'deactive':
        		$fields['account_active'] = 0;
        		$bfields['account_billing_active'] = 0;
        	break;
        	case 'delete':
        		$fields['account_active'] = 0;
        		$fields['account_deleted'] = 1;
        		$bfields['account_billing_active'] = 0;
        		$bfields['account_billing_deleted'] = 1;
        	break;
        	case 'restore':
        		$fields['account_active'] = 1;
        		$fields['account_deleted'] = 0;
        		$bfields['account_billing_active'] = 1;
        		$bfields['account_billing_deleted'] = 0;
        	break;
        }

		$this->db->where('account_id', $id);
		$this->db->update('accounts', $fields);
		
		$this->db->where('account_id', $id);
		$this->db->update('accounts_billing', $bfields);
		
		return redirect('accounts', 'refresh');
	}
	
	function get_username($username)
	{
	     
        $query = $this->db->select('account_username')
        ->where('account_username', $username)
        ->limit(1)
		->get('accounts');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$result_arr = $row;
			}
			
			return $result_arr;
		}
		else
		{
			return FALSE;
		}

	}
	
	
	function upload_image($file)
	{
		
		$config['upload_path'] = './assets/images/accounts/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$image = array('error' => $this->upload->display_errors());

		}
		else
		{
			
			$image = array('upload_data' => $this->upload->data());

			
			// Resize Image for Mediumn Size
			$mconfig['image_library'] = 'gd2';
			$mconfig['source_image']	= './assets/images/accounts/' . $image['upload_data']['file_name'];
			$mconfig['create_thumb'] = FALSE;
			$mconfig['maintain_ratio'] = TRUE;
			$mconfig['width']	= 300;
			$mconfig['height']	= 300;
			$mconfig['new_image'] = './assets/images/accounts/medium/' . $image['upload_data']['raw_name'] . strtolower($image['upload_data']['file_ext']);
					
			$this->load->library('image_lib', $mconfig); 
			
			$this->image_lib->resize();
			
			
			// Resize Image for Thumbnails
			$config['image_library'] = 'gd2';
			$config['source_image']	= './assets/images/accounts/' . $image['upload_data']['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	= 100;
			$config['height']	= 100;
			$config['new_image'] = './assets/images/accounts/thumbs/' . $image['upload_data']['raw_name'] . strtolower($image['upload_data']['file_ext']);
					
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
		}
		
		return $image;
	}
	
	
	function username_check($str)
	{
	    
	    $username = $this->get_username($str);
		
		if ($username)
		{
			$this->form_validation->set_message('username_check', 'The %s is already in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


		 
}

/* End of file accounts_model.php */
/* Location: ./application/models/accounts_model.php */