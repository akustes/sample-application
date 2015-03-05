<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Admin
 */

// ------------------------------------------------------------------------


class Admin extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
				
		if( ! logged_in())
		{
			redirect('access', 'refresh');
		}
		
		$this->lang->load('admin');
	}
	
	
	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('admin');
		$this->load->view('layout/footer');
	}
	
	public function accounts($offset = 0)
	{
				
		// Pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'accounts/index';
		$config['total_rows'] = count($this->accounts_model->readonly());
		$config['per_page'] = 10;
		
		$this->pagination->initialize($config); 
		
		$data['accounts'] = $this->accounts_model->readonly($config['per_page'], $offset);
		
		$data['pages'] = $this->pagination->create_links();
		$data['total'] = $config['total_rows'];
		
		$this->load->view('layout/header');
		$this->load->view('layout/navigation');
		$this->load->view('layout/body');
		$this->load->view('accounts', $data);
		$this->load->view('layout/footer');
	}


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */