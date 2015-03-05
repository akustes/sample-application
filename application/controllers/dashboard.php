<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Default
 */

// ------------------------------------------------------------------------


class Dashboard extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
				
		if( ! logged_in())
		{
			redirect('access', 'refresh');
		}
		
		$this->lang->load('dashboard');
		
		$this->load->model('events_model');
		$this->lang->load('events');
		

	}
	
	
	public function index()
	{
		
		$data['events'] = $this->events_model->get_preview(session('id'));
		
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('dashboard', $data);
		$this->load->view('layout/footer');
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */