<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Models
 * @description Profiles Model
 * @Files       
 */

// ------------------------------------------------------------------------

class Profiles_model extends CI_Model {



/* =================================================================================
* DATA MODEL AND BUSINESS LOGIC 
* ================================================================================= */

	
	function get($id = NULL, $per_page = NULL, $offset = NULL, $type = NULL, $keyword = NULL)
	{ 
        
        
        if( ! empty($id))
        {            
        	$this->db->where('profile_id', $id);
        	$this->db->limit(1);
        	
        	$this->db->join('accounts', 'accounts.account_id = profiles.account_id', 'left');
        	
        	$query = $this->db->get('profiles');
        	
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
        			$this->db->where('profile_active', 1);
        			$this->db->where('profile_deleted', 0);
        		break;
        		case 'not_active':
        			$this->db->where('profile_active', 0);
        			$this->db->where('profile_deleted', 0);
        		break;
        		case 'deleted':
        			$this->db->where('profile_active', 0);
        			$this->db->where('profile_deleted', 1);
        		break;
        		case 'search':
        			$this->db->like('profile_name', $keyword);
        		break;
        		default:
        			$this->db->where('profile_active', 1);
        			$this->db->where('profile_deleted', 0);
        	}
        	
        	$this->db->join('accounts', 'accounts.account_id = profiles.account_id', 'left');
            
           
            $this->db->order_by('profile_created_date', 'desc');
        

			$query = $this->db->get('profiles', $per_page, $offset);
			
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
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean');
        $this->form_validation->set_rules('state', 'State', 'trim|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['profile_hash_id'] = $this->encrypt->sha1(random_string('alnum', 8));
			$fields['event_name'] = set_value('name');
			$fields['event_description'] = set_value('description');
			$fields['event_phone'] = set_value('phone');
			$fields['event_address'] = set_value('address');
			$fields['event_city'] = set_value('city');
			$fields['event_state'] = set_value('state');
			$fields['event_zip'] = set_value('zip');
			$fields['event_country'] = set_value('country');
			$fields['event_created_date'] = now();
			$fields['event_active'] = set_value('active');
			$fields['event_completed'] = set_value('completed');
			$fields['event_invite_type'] = set_value('invite_type');
			
			$this->db->insert('events', $fields);		
			$auto_event_id = $this->db->insert_id();
						
			$output = 'success';
		}
		
		
		switch($output)
		{
			case 'success':
				 // Redirect to Events
				 return redirect('profiles', 'refresh');
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
        $this->form_validation->set_rules('profile_id', 'Profile ID', 'trim|xss_clean');
        $this->form_validation->set_rules('active', 'Active', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean');
        $this->form_validation->set_rules('state', 'State', 'trim|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {

			$fields['event_name'] = set_value('name');
			$fields['event_description'] = set_value('description');
			$fields['event_phone'] = set_value('phone');
			$fields['event_address'] = set_value('address');
			$fields['event_city'] = set_value('city');
			$fields['event_state'] = set_value('state');
			$fields['event_zip'] = set_value('zip');
			$fields['event_country'] = set_value('country');
			$fields['event_created_date'] = now();
			$fields['event_active'] = set_value('active');

		
			$this->db->where('profile_id', set_value('profile_id'));
			$this->db->update('profiles', $fields);
			
			$output = 'success';
		}
		
		switch($output)
		{
			case 'success':
				 // Redirect to User Account
				 return redirect('profiles/manage/' . set_value('profile_id') . '/edit/saved', 'refresh');
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
        		$fields['profile_active'] = 1;

        	break;
        	case 'deactive':
        		$fields['profile_active'] = 0;
        	break;
        	case 'delete':
        		$fields['profile_active'] = 0;
        		$fields['profile_deleted'] = 1;

        	break;
        	case 'restore':
        		$fields['profile_active'] = 1;
        		$fields['profile_deleted'] = 0;
        	break;
        }

		$this->db->where('profile_id', $id);
		$this->db->update('profiles', $fields);
				
		return redirect('profiles', 'refresh');
	}
	
	function viewed($id)
	{
		$fields['profile_account_id'] = session('id');
		$fields['profile_viewed_account_id'] = $id;
		$fields['profile_date_created'] = now();

		$this->db->insert('profiles_views', $fields);
		$new_id = $this->db->insert_id();
		
		return $new_id;
	}
	
	function blocked($id)
	{
		return FALSE;
	}
	
	function create_favorite($data)
	{
		$fields['profile_favorite_account_id'] = session('id');
		$fields['profile_favorite_marked_account_id'] = $data['viewed_account_id'];
		$fields['profile_favorite_date_created'] = now();

		$this->db->insert('profiles_favorites', $fields);
		$new_id = $this->db->insert_id();
		
		return $new_id;
	}
	
	function create_blocked($data)
	{
		$fields['profile_block_account_id'] = session('id');
		$fields['profile_block_marked_account_id'] = $data['viewed_account_id'];
		$fields['profile_block_date_created'] = now();

		$this->db->insert('profiles_blocked', $fields);
		$new_id = $this->db->insert_id();
		
		return $new_id;
	}
	
	function delete_favorite($id)
	{
		$this->db->where('profile_favorite_id', $id);
		$this->db->delete('profiles_favorites');
		
		return TRUE;
	}
	
	function delete_blocked($id)
	{
		$this->db->where('profile_block_id', $id);
		$this->db->delete('profiles_blocked'); 
		
		return TRUE;
	}
	
	function get_profile_images($id)
	{
			
			$this->db->where('profile_id', $id);
        	
        	$query = $this->db->get('profiles_images');
        	
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
		
}

/* End of file events_model.php */
/* Location: ./application/models/events_model.php */