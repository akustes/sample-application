<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Profiles
 */

// ------------------------------------------------------------------------


class Profiles extends CI_Controller {

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
		
		$this->lang->load('profiles');
		$this->load->model('profiles_model');
		$this->load->helper('profiles');
		
		// handle URI's
		$uri = uri_parser();
		
		$this->id = $uri['id'];
		$this->action = $uri['action'];
		$this->message = $uri['message'];
	}
	
	
	public function index($offset = 0)
	{
		
		$data['section'] = 'list';
		
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'profiles/index';
		$config['total_rows'] = count($this->profiles_model->get(NULL, NULL, NULL, $this->action));
		$config['per_page'] = 24;
		
		$this->pagination->initialize($config); 
		
		$data['profiles'] = $this->profiles_model->get(NULL, $config['per_page'], $offset, $this->action);
		$data['pages'] = $this->pagination->create_links();
		$data['total'] = $config['total_rows'];
		$data['action'] =  $this->action;
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('profiles', $data);
		$this->load->view('layout/footer');
	}
	
		
	public function manage()
	{

		// Load Models
		$this->load->model('profiles_model');
		
		// Load Helpers
		$this->load->helper('states_countries');
				
		if($this->input->post())
		{			
			switch($this->input->post('action'))
			{
				case 'add':
					$this->profiles_model->create($this->input->post());
					
				break;
				case 'edit':
					$this->profiles_model->update($this->input->post());
					
				break;
			}
		
		}
		
		// Set View Variables
		$data['section'] = 'form';
		$data['states'] = states();
		$data['countries'] = countries();
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		$data['profiles'] = $this->profiles_model->get($this->id);
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('profiles', $data);
		$this->load->view('layout/footer');
	}
	
	
	public function view()
	{
		
		// Capture User that Viewed the Profile
		$this->profiles_model->viewed($this->id);
		
		if($this->profiles_model->blocked($this->id))
		{
			$data['profiles'] = array();
		}
		else
		{
			$data['profiles'] = $this->profiles_model->get($this->id);
			$data['images'] = $this->profiles_model->get_profile_images($this->id);
		}
		
		// Set View Variables
		$data['section'] = 'view';
		$data['id'] = $this->id;
		$data['action'] = $this->action;
		$data['message'] = $this->message;
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('profiles', $data);
		$this->load->view('layout/footer');
	}
	
	
	
	public function status()
	{
		
		$id = ($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : '';
		$status = ($this->uri->segment(4, 0)) ? $this->uri->segment(4, 0) : '';
		
		$this->profiles_model->update_status($id, $status);
		
	}
	
	public function favorite()
	{
		if($this->input->post())
		{
			$this->profiles_model->create_favorite($this->input->post());
		}
	}
	
	public function blocked()
	{
		if($this->input->post())
		{
			$this->profiles_model->create_blocked($this->input->post());
		}
	}
	
}

/* End of file profiles.php */
/* Location: ./application/controllers/profiles.php */