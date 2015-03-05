<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Account Administration
 */

// ------------------------------------------------------------------------


class Accounts extends CI_Controller {

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
		
		$this->lang->load('accounts');
		$this->load->model('accounts_model');
		$this->load->helper('accounts');
		
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
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'accounts/index';
		$config['total_rows'] = count($this->accounts_model->get(NULL, NULL, NULL, $this->action));
		$config['per_page'] = 10;
		
		$this->pagination->initialize($config); 
		
		$data['accounts'] = $this->accounts_model->get(NULL, $config['per_page'], $offset, $this->action, $keyword);
		$data['pages'] = $this->pagination->create_links();
		$data['total'] = $config['total_rows'];
		$data['action'] =  $this->action;
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('accounts', $data);
		$this->load->view('layout/footer');
	}
	
		
	public function manage()
	{

		// Load Helpers
		$this->load->helper('states_countries');
				
		if($this->input->post())
		{			
			switch($this->input->post('action'))
			{
				case 'add':
					$this->accounts_model->create($this->input->post());
					
				break;
				case 'edit':
					$this->accounts_model->update($this->input->post());
					
				break;
			}
		
		}
		
		// Set View Variables
		$data['section'] = 'form';
		$data['roles'] = roles();
		$data['genders'] = genders();
		$data['states'] = states();
		$data['countries'] = countries();
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		$data['accounts'] = $this->accounts_model->get($this->id);
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('accounts', $data);
		$this->load->view('layout/footer');
	}
	
	
	public function billing()
	{

		// Load Helpers
		$this->load->helper('states_countries');
				
		if($this->input->post())
		{
			$this->accounts_model->update_billing($this->input->post());
		}
		
		$data['states'] = states();
		$data['countries'] = countries();
		$data['section'] = 'billing_form';
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		
		$data['account'] = $this->accounts_model->get_billing($this->id);
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('accounts', $data);
		$this->load->view('layout/footer');
	}


	public function password()
	{
		
		if($this->input->post())
		{
			$this->accounts_model->update_password($this->input->post());
		}
		
		$data['section'] = 'password_form';
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('accounts', $data);
		$this->load->view('layout/footer');
	}
	
	
	public function status()
	{
		
		$id = ($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : '';
		$status = ($this->uri->segment(4, 0)) ? $this->uri->segment(4, 0) : '';
		
		$this->accounts_model->update_status($id, $status);
		
	}		
}

/* End of file accounts.php */
/* Location: ./application/controllers/accounts.php */