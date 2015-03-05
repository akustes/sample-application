<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description User Signup Process
 */

// ------------------------------------------------------------------------


class Signup extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
				
		$this->lang->load('accounts');
		$this->load->model('accounts_model');
		$this->load->helper('accounts');
	}
		
		
	public function index()
	{

		// Load Helpers
		$this->load->helper('states_countries');
		
		// Set Controller Variables
		$post_data = $this->input->post();

		if($post_data)
		{
			$this->accounts_model->create($post_data, TRUE);
		}
		
		// Set View Variables
		$data['genders'] = genders();
		$data['states'] = states();
		$data['countries'] = countries();
		$data['section'] = 'form';
		
		$this->load->view('layout/header');
		$this->load->view('layout/no_navigation');
		$this->load->view('layout/body');
		$this->load->view('signup', $data);
		$this->load->view('layout/footer');
	}
	
	public function confirm()
	{
		$data['section'] = 'confirm';
		
		$this->load->view('layout/header');
		$this->load->view('layout/no_navigation');
		$this->load->view('layout/body');
		$this->load->view('signup', $data);
		$this->load->view('layout/footer');
	}
	
	function username_check($str)
	{

	    $username = $this->accounts_model->get_username($str);
		
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

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */