<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Events Administration
 */

// ------------------------------------------------------------------------


class Events extends CI_Controller {

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
		
		$this->lang->load('events');
		$this->load->model('events_model');
		$this->load->helper('events');
		
		// handle URI's
		$uri = uri_parser();
		
		$this->id = $uri['id'];
		$this->action = $uri['action'];
		$this->message = $uri['message'];
	}
	
	
	public function index($offset = 0)
	{

		$keyword = ($this->input->post('keyword')) ? $this->input->post('keyword') : NULL;
		
		if(session('role_id') > 2)
		{
			$this->action = 'by_account';
			$keyword = session('id');
		}
		
		$data['section'] = 'list';
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'events/index';
		$config['total_rows'] = count($this->events_model->get(NULL, NULL, NULL, $this->action, $keyword));
		$config['per_page'] = 10;
		
		$this->pagination->initialize($config); 
		
		$data['events'] = $this->events_model->get(NULL, $config['per_page'], $offset, $this->action, $keyword);
		$data['pages'] = $this->pagination->create_links();
		$data['total'] = $config['total_rows'];
		$data['action'] =  $this->action;
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('events', $data);
		$this->load->view('layout/footer');
	}
	
		
	public function manage()
	{

		// Load Models
		$this->load->model('accounts_model');
		
		// Load Helpers
		$this->load->helper('states_countries');
				
		if($this->input->post())
		{			
			switch($this->input->post('action'))
			{
				case 'add':
					$this->events_model->create($this->input->post());
					
				break;
				case 'edit':
					$this->events_model->update($this->input->post());
					
				break;
			}
		
		}
		
		// Set View Variables
		$data['section'] = 'form';
		$data['response'] = response();
		$data['type'] = type();
		$data['states'] = states();
		$data['countries'] = countries();
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		$data['events'] = $this->events_model->get($this->id);
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('events', $data);
		$this->load->view('layout/footer');
	}
	
	
	public function view()
	{
	
		
				
		if($this->input->post())
		{	
			if( ! empty($this->input->post('response')))
			{
				$this->events_model->update_invite($this->input->post('event_invite_event_id'), $this->input->post('event_invite_account_id'), $this->input->post('response'));
			}
		}
		
		// Set View Variables
		$data['section'] = 'view';
		$data['response'] = response();
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		$data['events'] = $this->events_model->get($this->id);
		$data['attendees'] = $this->events_model->get_rsvp($this->id);
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('events', $data);
		$this->load->view('layout/footer');
	}
	
	
	
	public function status()
	{
		
		$id = ($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : '';
		$status = ($this->uri->segment(4, 0)) ? $this->uri->segment(4, 0) : '';
		
		$this->events_model->update_status($id, $status);
		
	}
	
}

/* End of file events.php */
/* Location: ./application/controllers/events.php */