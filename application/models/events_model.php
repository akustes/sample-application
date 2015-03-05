<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Models
 * @description Events Model
 * @Files       
 */

// ------------------------------------------------------------------------

class Events_model extends CI_Model {



/* =================================================================================
* DATA MODEL AND BUSINESS LOGIC 
* ================================================================================= */

	
	function get($id = NULL, $per_page = NULL, $offset = NULL, $type = NULL, $keyword = NULL)
	{ 
        
        
        if( ! empty($id))
        {            
        	$this->db->where('event_id', $id);
        	$this->db->limit(1);
        	
        	$query = $this->db->get('events');
        	
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
        			$this->db->where('event_active', 1);
        			$this->db->where('event_completed', 0);
        			$this->db->where('event_deleted', 0);
        		break;
        		case 'not_active':
        			$this->db->where('event_active', 0);
        			$this->db->where('event_completed', 0);
        			$this->db->where('event_deleted', 0);
        		break;
        		case 'deleted':
        			$this->db->where('event_active', 0);
        			$this->db->where('event_completed', 0);
        			$this->db->where('event_deleted', 1);
        		break;
        		case 'completed':
        			$this->db->where('event_active', 0);
        			$this->db->where('event_completed', 1);
        			$this->db->where('event_deleted', 0);
        		break;
        		case 'search':
        			$this->db->like('event_name', $keyword);
        		break;
        		case 'by_account':
        			$this->db->where('event_invite_account_id', $keyword);
        			$this->db->where('event_active', 1);
        			$this->db->where('event_deleted', 0);
        		break;
        		default:
        			$this->db->where('event_active', 1);
        			$this->db->where('event_completed', 0);
        			$this->db->where('event_deleted', 0);
        	}
        	
        	$this->db->join('events_invites', 'events_invites.event_invite_event_id = events.event_id', 'left');
            
           
            $this->db->order_by('event_start_date', 'desc');
        

			$query = $this->db->get('events', $per_page, $offset);
			
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
	
	
	function get_preview($id)
	{ 
        	
		$query = $this->db->where('event_active', 1)
        ->where('event_completed', 0)
        ->where('event_deleted', 0)
        ->where('event_invite_account_id', $id)
        ->join('events_invites', 'events_invites.event_invite_event_id = events.event_id', 'left')
        ->order_by('event_start_date', 'desc')
        ->limit(6)
		->get('events');
		
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
	

	
	
	function create($data, $signup = FALSE)
	{
		
        // Set Form Validation Rules
        $this->form_validation->set_rules('active', 'Active', 'trim|xss_clean');
        $this->form_validation->set_rules('completed', 'Completed', 'trim|xss_clean');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean');
        $this->form_validation->set_rules('state', 'State', 'trim|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
        $this->form_validation->set_rules('invite_type', 'Invite Type', 'trim|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['event_hash_id'] = $this->encrypt->sha1(random_string('alnum', 8));
			$fields['event_start_date'] = human_to_unix(set_value('start_date'));
			$fields['event_end_date'] = human_to_unix(set_value('end_date'));
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
			
				 
				 // Notify Accounts
				 switch(set_value('invite_type'))
				 {
				 	case 'none':
				 		// Do Nothing
				 	break;
				 	case 'both':
				 		// Send Out Invites to All Accounts
				 		$this->create_invite($auto_event_id, 'both');
				 		
				 		// Send Email Notification
				 		
				 	break;
				 	case 'male':
				 		// Send Out Invites to Male Accounts
				 		$this->create_invite($auto_event_id, 'male');
				 		
				 		// Send Email Notification
				 		
				 	break;
				 	case 'female':
				 		// Send Out Invites to Female Accounts
				 		$this->create_invite($auto_event_id, 'female');
				 		
				 		// Send Email Notification
				 		
				 	break;
				 }
				 
				 // Redirect to Events
				 return redirect('events', 'refresh');
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
        $this->form_validation->set_rules('event_id', 'Event ID', 'trim|xss_clean');
        $this->form_validation->set_rules('active', 'Active', 'trim|xss_clean');
        $this->form_validation->set_rules('completed', 'Completed', 'trim|xss_clean');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
        $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean');
        $this->form_validation->set_rules('state', 'State', 'trim|xss_clean');
        $this->form_validation->set_rules('zip', 'Zip Code', 'trim|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
        $this->form_validation->set_rules('invite_type', 'Invite Type', 'trim|xss_clean');
        $this->form_validation->set_rules('resend_invites', 'Resend Invites', 'trim|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['event_start_date'] = human_to_unix(set_value('start_date'));
			$fields['event_end_date'] = human_to_unix(set_value('end_date'));
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

		
			$this->db->where('event_id', set_value('event_id'));
			$this->db->update('events', $fields);
			
			$output = 'success';
		}
		
		switch($output)
		{
			case 'success':
				 
				 if(set_value('resend_invites') == 1)
				 {
					 // Notify Accounts
					 switch(set_value('invite_type'))
					 {
					 	case 'none':
					 		// Do Nothing
					 	break;
					 	case 'both':
					 		// Send Out Invites to All Accounts
					 		$this->create_invite(set_value('event_id'), 'both');
					 		
					 		// Send Email Notification
					 		
					 	break;
					 	case 'male':
					 		// Send Out Invites to Male Accounts
					 		$this->create_invite(set_value('event_id'), 'male');
					 		
					 		// Send Email Notification
					 		
					 	break;
					 	case 'female':
					 		// Send Out Invites to Female Accounts
					 		$this->create_invite(set_value('event_id'), 'female');
					 		
					 		// Send Email Notification
					 		
					 	break;
					 }
				 }

				 
				 // Redirect to User Account
				 return redirect('events/manage/' . set_value('event_id') . '/edit/saved', 'refresh');
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
        		$fields['event_active'] = 1;

        	break;
        	case 'deactive':
        		$fields['event_active'] = 0;
        	break;
        	case 'completed':
        		$fields['event_active'] = 0;
        		$fields['event_completed'] = 1;

        	break;
        	case 'not_completed':
        		$fields['event_active'] = 1;
        		$fields['event_completed'] = 0;

        	break;
        	case 'delete':
        		$fields['event_active'] = 0;
        		$fields['event_deleted'] = 1;

        	break;
        	case 'restore':
        		$fields['event_active'] = 1;
        		$fields['event_deleted'] = 0;
        	break;
        }

		$this->db->where('event_id', $id);
		$this->db->update('events', $fields);
				
		return redirect('events', 'refresh');
	}
	
	
	function create_invite($id, $type)
	{
		
		if($type == 'both')
		{
			$search = '';
			$search_action = '';
		}
		else
		{
			$search = $type;
			$search_action = 'search_gender';
		}
		
		$this->load->model('accounts_model');
		
		$accounts = $this->accounts_model->get(NULL, NULL, NULL, $search_action, $search);
				
		if($accounts)
		{
			foreach($accounts as $account)
			{
				$fields['event_invite_event_id'] = $id;
				$fields['event_invite_account_id'] = $account['account_id'];
				$fields['event_invite_status'] = lang('events_invited');
				
				$this->db->insert('events_invites', $fields);
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function update_invite($id, $account_id, $type)
	{
		$fields['event_invite_status'] = $type;
		
		$this->db->where('event_invite_event_id', $id);
		$this->db->where('event_invite_account_id', $account_id);
		$this->db->update('events_invites', $fields);
		
		return redirect('events/view/' . $id . '/saved', 'refresh');
	}
	
	function get_rsvp($id)
	{
		$query = $this->db->where('event_invite_event_id', $id)
        ->where('event_invite_status', 'attending')
        ->join('accounts', 'accounts.account_id = events_invites.event_invite_account_id', 'left')
        ->order_by('account_name', 'asc')
        ->limit(6)
		->get('events_invites');
		
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

/* End of file events_model.php */
/* Location: ./application/models/events_model.php */