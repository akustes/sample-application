<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Controller
 * @description Access, User Authorization
 */

// ------------------------------------------------------------------------


class Access extends CI_Controller {


/* =================================================================================
* LOGIN
* ================================================================================= */

	public function index()
	{
		
		
		if($this->input->post())
		{
			$output = $this->access->login($this->input->post('username'), $this->input->post('password'));
		}
		else
		{
			$output = '';
		}
		
		
		$data['message'] = $output;
		
		$this->load->view('layout/header');
		$this->load->view('layout/body');
	    $this->load->view('index', $data);
	    $this->load->view('layout/footer');
	}
	
	
	public function logout()
	{
		// Destroy Session
		$this->session->sess_destroy();
				
		redirect('access/index', 'refresh');
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */