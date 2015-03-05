<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Models
 * @description Messages Model
 * @Files       
 */

// ------------------------------------------------------------------------

class Messages_model extends CI_Model {



/* =================================================================================
* DATA MODEL AND BUSINESS LOGIC 
* ================================================================================= */

	
	function get($account_id = NULL, $message_id = NULL, $per_page = NULL, $offset = NULL, $type = NULL, $keyword = NULL)
	{ 
                    
            if( ! empty($type))
            {            
	            switch($type)
	            {
	            	case 'unread':
	            		$this->db->where('message_to_account_id', $account_id);
	            		$this->db->where('message_read', 0);
	            		$this->db->where('message_deleted', 0);
	            		$this->db->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left');
	            	break;
	            	case 'read':
	            		$this->db->where('message_to_account_id', $account_id);
	            		$this->db->where('message_read', 1);
	            		$this->db->where('message_deleted', 0);
	            		$this->db->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left');
	            	break;
	            	case 'outgoing':
	            		$this->db->where('message_from_account_id', $account_id);
	            		$this->db->where('message_deleted', 0);
	            		$this->db->join('accounts', 'accounts.account_id = messages.message_to_account_id', 'left');
	            	break;
	            	case 'deleted':
	            		$this->db->where('message_to_account_id', $account_id);
	            		$this->db->where('message_deleted', 1);
	            		$this->db->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left');
	            	break;
	           	   	case 'view':
	           	   		$this->db->where('message_to_account_id', $account_id);
	            		$this->db->where('message_id', $message_id);
	            		$this->db->where('message_deleted', 0);
	            		$this->db->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left');
	            	break;
	            	case 'search':
	            		$this->db->like('message_from_account_id', $keyword);
	            		$this->db->or_like('message_body', $keyword);
	            		$this->db->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left');
	            	break;
	            }
            }
            else
            {
            	$this->db->where('message_to_account_id', $account_id);
            	$this->db->where('message_deleted', 0);
            	$this->db->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left');
            }
         
            
            $this->db->order_by('message_created_date', 'desc');
            //$this->db->group_by("message_parent_id");

			$query = $this->db->get('messages', $per_page, $offset);
			
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
	
	
	function get_message($account_id, $message_id, $type = 'to')
	{
			
			if($type == 'to')
			{
				$where_str = 'message_to_account_id';
				$join_str = 'accounts.account_id = messages.message_from_account_id';
			}
			else
			{
				$where_str = 'message_from_account_id';
				$join_str = 'accounts.account_id = messages.message_to_account_id';
			}
			
			$query = $this->db->where('message_id', $message_id)
			->where($where_str, $account_id)
			->join('accounts', $join_str, 'left')
        	->limit(1)
        	->get('messages');
        	
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
	
	function get_preview($id)
	{ 
        	
		$query = $this->db->where('message_to_account_id', $id)
        ->where('message_deleted', 0)
        ->join('accounts', 'accounts.account_id = messages.message_from_account_id', 'left')
        ->order_by('message_created_date', 'desc')
        ->limit(3)
		->get('messages');
		
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
	

	function get_unread($id)
	{ 
        	
		return $this->db->from('messages')
			->where('message_to_account_id', $id)
			->where('message_read', 0)
			->count_all_results();	
	}

	
	function reply($data)
	{
		
        // Set Form Validation Rules
        $this->form_validation->set_rules('message_id', 'Message ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('from_account_id', 'From Account ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to_account_id', 'To Account ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
        $this->form_validation->set_rules('reply_message', 'Message', 'trim|required|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['message_hash_id'] = $this->encrypt->sha1(random_string('alnum', 8));
			$fields['message_to_account_id'] = set_value('to_account_id');
			$fields['message_from_account_id'] = set_value('from_account_id');
			$fields['message_parent_id'] = set_value('message_id');
			$fields['message_subject'] = set_value('subject');
			$fields['message_body'] = set_value('reply_message');
			$fields['message_created_date'] = now();
			
			$this->db->insert('messages', $fields);		
			$auto_id = $this->db->insert_id();
			
			$output = 'success';
		}
		
		
		switch($output)
		{
			case 'success':				 
				 return redirect('messages/detail/' . set_value('message_id') . '/sent', 'refresh');
				 exit();
			break;
			case 'failed_validation':
				 return FALSE;
			break;
			default:
				 return FALSE;
		}

	}
	
	
	function create($data)
	{
		
        // Set Form Validation Rules
        $this->form_validation->set_rules('from_account_id', 'From Account ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('to_account_id', 'To Account ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
       
        
        // Checks to see if Form data passes the validation
        if( ! $this->form_validation->run())
        {
            $output = 'failed_validation';

        }
        else
        {
			
			$fields['message_hash_id'] = $this->encrypt->sha1(random_string('alnum', 8));
			$fields['message_to_account_id'] = set_value('to_account_id');
			$fields['message_from_account_id'] = set_value('from_account_id');
			$fields['message_subject'] = set_value('subject');
			$fields['message_body'] = set_value('message');
			$fields['message_created_date'] = now();
			
			$this->db->insert('messages', $fields);		
			$auto_id = $this->db->insert_id();
			
			$output = 'success';
		}
		
		
		switch($output)
		{
			case 'success':				 
				 return TRUE;
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
        	case 'delete':
        		$fields = array('message_deleted' => 1);
        	break;
        	case 'restore':
        		$fields = array('message_deleted' => 0);
            break;
        }

        $this->db->where('message_id', $id)
        	->limit(1)
        	->update('messages', $fields);

		return redirect('messages', 'refresh');
	}
	
	
	function mark_as_read($id)
	{
        
        $fields = array('message_read' => 1);
        
        $this->db->where('message_id', $id)
        	->limit(1)
        	->update('messages', $fields);
        
	}				 
}

/* End of file messages_model.php */
/* Location: ./application/models/messages_model.php */