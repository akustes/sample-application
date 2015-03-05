<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Messages
 */

// ------------------------------------------------------------------------


class Messages extends CI_Controller {

var $id;
var $action;
var $message;

	public function __construct()
	{
		parent::__construct();
				
		if( ! logged_in())
		{
			redirect('access', 'refresh');
		}
		
		$this->lang->load('messages');
		$this->load->model('messages_model');
		$this->load->helper('messages');
		
		// handle URI's
		$uri = uri_parser();
		
		$this->id = $uri['id'];
		$this->action = $uri['action'];
		$this->message = $uri['message'];

	}
	
	
	public function index($offset = 0)
	{
	
		$keyword = ($this->input->post('keyword')) ? $this->input->post('keyword') : NULL;
		
		$data['section'] = 'list';
		$data['type'] = $this->action;
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'messages/index';
		$config['total_rows'] = count($this->messages_model->get(session('id'), NULL, NULL, $this->action));
		$config['per_page'] = 10;
		
		$this->pagination->initialize($config); 
		
		$data['messages'] = $this->messages_model->get(session('id'), NULL, $config['per_page'], $offset, $this->action, $keyword);
		$data['pages'] = $this->pagination->create_links();
		$data['total'] = $config['total_rows'];
		$data['unread'] = $this->messages_model->get_unread(session('id'));

		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('messages', $data);
		$this->load->view('layout/footer');
	}
	
		
	
	public function detail()
	{
		
		if($this->input->post())
		{

			$this->messages_model->reply($this->input->post());
		}
		
		// Set View Variables
		if($this->action == 'outgoing')
		{
			$type = 'from';
		}
		else
		{
			$type = 'to';
		}
		
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		$data['thread'] = $this->messages_model->get_message(session('id'), $this->id, $type);
		$data['section'] = 'detail';
		
		// Mark Message as Read
		$this->messages_model->mark_as_read($this->id);
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('messages', $data);
		$this->load->view('layout/footer');
	}

	
	
	public function status()
	{
		
		$id = ($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : '';
		$status = ($this->uri->segment(4, 0)) ? $this->uri->segment(4, 0) : '';
		
		$this->messages_model->update_status($id, $status);
		
	}
	
	public function send_message()
	{
		if($this->input->post())
		{
			$this->messages_model->create($this->input->post());
		}
	}

}

/* End of file messages.php */
/* Location: ./application/controllers/messages.php */