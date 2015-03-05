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

class Email_model extends CI_Model {


	function outbid_users_email($user_id, $lot_id, $lot_name)
	{
	
	    $this->load->model('user_model');
	    
	    // Send Outbid Notification
	    $data['outbid'] = $this->user_model->get_user($user_id, $fields);
	    $data['lot_id'] = $lot_id;
	    $data['lot_name'] = $lot_name;
	    
	    $body = $this->load->view('email/outbid', $data, TRUE);
	    
	    $to = $outbid['user_email'];
	    $from = 'info@americanauctioneers.com';
	    $from_title = 'American Auctioneers Auction';
	    $subject = 'Sorry! You have been outbid by another bidder Lot#' . $lot_id . ' ' . $lot_name;
	    
	
	    if($this->config->item('smtp_gateway_api') || $this->config->item('smtp_gateway_smtp'))
	    {
		    $this->sendgrid->send_email($to, $from, $from_title, $subject, $body, 'api');
	    }
	    else
	    {
		    $this->load->library('email');
		    
		    $email_config['mailtype'] = 'html';
		    $email_config['charset'] = 'iso-8859-1';
		    $email_config['wordwrap'] = TRUE;
		
		    $this->email->initialize($email_config);
		    $this->email->from($from, $from_title);
		    $this->email->to($to);
		    $this->email->subject($subject);
		    $this->email->message($body);
		    $this->email->send();
	    
	     }

	}
	
	function winning_users_email($user_id, $lot_id, $lot_name)
	{
	
		$this->load->model('control_model');
		$this->load->model('user_model');
		
	    // Get Lot And Buyer Info
		$row = $this->control_model->get_lot_invoice($lot_id);

		$data['event_id'] = $row['event_id'];		
		$data['event_event_type_id'] = $row['event_event_type_id'];		
		$data['event_name'] = $row['event_name'];		
		$data['event_description'] = $row['event_description'];
		$data['event_city'] = $row['event_city'];
		$data['event_state'] = $row['event_state'];
		$data['event_end_date'] = $row['event_end_date'];
		$data['event_buyer_premium'] = $row['event_buyer_premium'];
	
		
		$data['user_id'] = $row['user_id'];
		$data['user_company_name'] = $row['user_company_name'];
		$data['user_address'] = $row['user_address'];
		$data['user_city'] = $row['user_city'];
		$data['user_state'] = $row['user_state'];
		$data['user_zip'] = $row['user_zip'];
		$data['user_phone'] = $row['user_phone'];
		$data['user_email'] = $row['user_email'];
		
		
		$data['user_tax_rate'] = $row['user_tax_rate'];
		$data['lot_id'] = $row['lot_id'];		
		$data['lot_number'] = $row['lot_number'];
		$data['lot_tag'] = $row['lot_tag'];
		$data['lot_deposit_collected'] = $row['lot_deposit_collected'];
		//$data['lot_amount'] = $row['lot_amount_collected'];
		$data['lot_buyer'] = $row['bid_user_id'];
		$data['lot_name'] = $row['lot_name'];
		$data['lot_end_date'] = convert_to_human($row['lot_end_date']);
		$data['lot_description'] = $row['lot_description'];
		$data['lot_image'] = $row['lot_image'];
		$data['lot_active'] = $row['lot_active'];
		$data['lot_paid'] = $row['lot_paid'];
		$data['payment_type'] = $row['lot_payment_type'];
		$data['lot_amount'] = $row['bid_amount'];
		
		
		$buyer_info = $this->user_model->get_user($data['lot_buyer'], $fields);
		$data['buyer_first_name'] = $buyer_info['user_first_name'];
		$data['buyer_last_name'] = $buyer_info['user_last_name'];
		
		
		// calculate some items
		
		$data['lot_total'] = $row['bid_amount'];
		$buyers_premium = $row['event_buyer_premium'] / 100;
		
		
		$data['buyers_premium'] =  $row['event_buyer_premium'];
		$data['lot_buyers_premium'] = ( ! empty($row['event_buyer_premium_online'])) ? $row['event_buyer_premium_online'] : 0;
		
		$data['lot_subtotal'] = $row['bid_amount'] + $data['lot_buyers_premium'];
		$data['lot_sales_tax_rate'] = $row['event_sales_tax'];
		
		if($buyer_info['user_resell']) 
		{
			$data['lot_sales_tax'] = '0.00';	
		}
		else
		{
			$data['lot_sales_tax'] = $row['event_sales_tax'] / 100 * $data['lot_subtotal'];
			//$data['lot_sales_tax'] = 323;
			
		}
								
		$data['lot_total'] = $data['lot_subtotal'] + $data['lot_sales_tax'];
		
		$data['lot_paid_status'] = ($row['lot_paid']) ? 'LOT PAID' : 'AMOUNT DUE';
		
		
 
    	$body = $this->load->view('email/winning', $data, TRUE);
    
    	$to = $buyer_info['user_email'];
    	$from = 'info@americanauctioneers.com';
    	$from_title = 'American Auctioneers Auction Won!';
    	$subject = 'Congratulations! You won the auction for ' . $lot_name;
	    
	
	    if($this->config->item('smtp_gateway_api') || $this->config->item('smtp_gateway_smtp'))
	    {
		    $this->sendgrid->send_email($to, $from, $from_title, $subject, $body, 'api');
	    }
	    else
	    {
		    $this->load->library('email');
		    
		    $email_config['mailtype'] = 'html';
		    $email_config['charset'] = 'iso-8859-1';
		    $email_config['wordwrap'] = TRUE;
		
		    $this->email->initialize($email_config);
		    $this->email->from($from, $from_title);
		    $this->email->to($to);
		    $this->email->bcc('mammyths@gmail.com');
		    $this->email->subject($subject);
		    $this->email->message($body);
		    $this->email->send();
	    
	     }
	}
	
	
	function seller_users_email($user_id, $lot_id, $lot_name)
	{
	
	    $this->load->model('control_model');
		$this->load->model('user_model');
		
	    // Get Lot And Buyer Info
		$row = $this->control_model->get_lot_invoice($lot_id);

		$data['event_id'] = $row['event_id'];		
		$data['event_event_type_id'] = $row['event_event_type_id'];		
		$data['event_name'] = $row['event_name'];		
		$data['event_description'] = $row['event_description'];
		$data['event_city'] = $row['event_city'];
		$data['event_state'] = $row['event_state'];
		$data['event_end_date'] = $row['event_end_date'];		
		$data['event_seller_premium'] = $row['event_seller_premium'];
	
		
		$data['user_id'] = $row['user_id'];
		$data['user_company_name'] = $row['user_company_name'];
		$data['user_first_name'] = $row['user_first_name'];
		$data['user_last_name'] = $row['user_last_name'];
		$data['user_address'] = $row['user_address'];
		$data['user_city'] = $row['user_city'];
		$data['user_state'] = $row['user_state'];
		$data['user_zip'] = $row['user_zip'];
		$data['user_phone'] = $row['user_phone'];
		$data['user_email'] = $row['user_email'];
		
		
		$data['user_tax_rate'] = $row['user_tax_rate'];
		$data['lot_id'] = $row['lot_id'];		
		$data['lot_number'] = $row['lot_number'];
		$data['lot_tag'] = $row['lot_tag'];
		$data['lot_deposit_collected'] = $row['lot_deposit_collected'];
		//$data['lot_amount'] = $row['lot_amount_collected'];
		$data['lot_buyer'] = $row['bid_user_id'];
		$data['lot_name'] = $row['lot_name'];
		$data['lot_end_date'] = convert_to_human($row['lot_end_date']);
		$data['lot_description'] = $row['lot_description'];
		$data['lot_image'] = $row['lot_image'];
		$data['lot_active'] = $row['lot_active'];
		$data['lot_paid'] = $row['lot_paid'];
		$data['payment_type'] = $row['lot_payment_type'];
		$data['lot_amount'] = $row['bid_amount'];
		
		
		$buyer_info = $this->user_model->get_user($data['lot_buyer'], $fields);
		$data['buyer_first_name'] = $buyer_info['user_first_name'];
		$data['buyer_last_name'] = $buyer_info['user_last_name'];
		$data['buyer_city'] = $buyer_info['user_city'];
		$data['buyer_state'] = $buyer_info['user_state'];
		$data['buyer_zip'] = $buyer_info['user_zip'];
		$data['buyer_phone'] = $buyer_info['user_phone'];
		$data['buyer_email'] = $buyer_info['user_email'];
		
		
		// calculate some items
		
		$data['lot_total'] = $row['bid_amount'];
		
		$data['event_seller_premium_factor'] = $data['event_seller_premium'] / 100;
		
		$data['event_sellers_charge'] = $data['event_seller_premium_factor'] * $row['bid_amount'];
		
		
				
		
		$data['lot_subtotal'] = $row['bid_amountl'] + ($buyers_premium * $row['bid_amount']);
		$data['lot_sales_tax_rate'] = $row['user_tax_rate'];

		
								
		$data['lot_total'] = $data['lot_subtotal'] + $data['lot_sales_tax'];
		
		$data['lot_paid_status'] = ($row['lot_active']) ? 'LOT PAID' : 'AMOUNT DUE';
	    
	    $body = $this->load->view('email/selling', $data, TRUE);
	    
	    $to = $data['user_email'];
	    $from = 'info@americanauctioneers.com';
	    $from_title = 'American Auctioneers Your Auction Sold!';
	    $subject = 'Congratulations! You Sold Your Auction ' . $lot_name;
	    
	
	    if($this->config->item('smtp_gateway_api') || $this->config->item('smtp_gateway_smtp'))
	    {
		    $this->sendgrid->send_email($to, $from, $from_title, $subject, $body, 'api');
	    }
	    else
	    {
		    $this->load->library('email');
		    
		    $email_config['mailtype'] = 'html';
		    $email_config['charset'] = 'iso-8859-1';
		    $email_config['wordwrap'] = TRUE;
		
		    $this->email->initialize($email_config);
		    $this->email->from($from, $from_title);
		    $this->email->to($to);
		    $this->email->subject($subject);
		    $this->email->message($body);
		    $this->email->send();
	    
	     }

	}
	
	
	function signup($email, $name, $username, $body_message)
	{

		

	    $data['name'] = $name;
	    $data['email'] = $email;
	    $data['username'] = $username;
	    $data['body_message'] = $body_message;
	   
	    
	    $body = $this->load->view('email/signup', $data, TRUE);
	  
	    $to = $email;
	    $from = 'info@americanauctioneers.com';
	    $from_title = 'American Auctioneers';
	    $subject = 'You have signed up with American Auctioneers';
	    
	
	    if($this->config->item('smtp_gateway_api') || $this->config->item('smtp_gateway_smtp'))
	    {
		    
		    $this->sendgrid->send_email($to, $from, $from_title, $subject, $body, 'api');
	    }
	    else
	    {
		    $this->load->library('email');
		    
		    $email_config['mailtype'] = 'html';
		    $email_config['charset'] = 'iso-8859-1';
		    $email_config['wordwrap'] = TRUE;
		
		    $this->email->initialize($email_config);
		    $this->email->from($from, $from_title);
		    $this->email->to($to);
		    $this->email->subject($subject);
		    $this->email->message($body);
		    $this->email->send();
	    
	     }
	}
	
	function admin($params, $type)
	{
        
        switch($type)
        {
            case 'signup':
                $subject_text = 'New Sign Up!';
                $from_title = 'American Auctioneers New Sign Up';
                $message = 'New Sign Up!';
            break;
        }
        
	    $data['email'] = $params['email'];
	    //$data['name'] = $params['name'];
	    $data['message'] = $message;
	    
	    $body = $this->load->view('email/admin', $data, TRUE);
	    
	    $to = 'contact@andrewkustes.com';  // $email
	    $from = 'info@americanauctioneers.com';
	    $from_title = $from_title;
	    $subject = $subject_text;
	    
	
	    if($this->config->item('smtp_gateway_api') || $this->config->item('smtp_gateway_smtp'))
	    {
		    $this->sendgrid->send_email($to, $from, $from_title, $subject, $body, 'api');
	    }
	    else
	    {
		    $this->load->library('email');
		    
		    $email_config['mailtype'] = 'html';
		    $email_config['charset'] = 'iso-8859-1';
		    $email_config['wordwrap'] = TRUE;
		
		    $this->email->initialize($email_config);
		    $this->email->from($from, $from_title);
		    $this->email->to($to);
		    $this->email->subject($subject);
		    $this->email->message($body);
		    $this->email->send();
	    
	     }
	}
}
     

/* End of file email_model.php */
/* Location: ./application/models/email_model.php */