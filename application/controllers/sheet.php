<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sheet extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		//$this->ship_trans_id = $this->input->get('ship_trans_id', TRUE);
		$this->load->library("pagination");
		$this->load->model('login_model');
		
	}
	public function index()
	{
		$this->load->view('sign_in');
	}
	
	
	public function loginUrl()
	{
		header('Location:'.site_url('sign_in'));
	}
	
	public function regUrl()
	{
	
		$this->load->view('sign_up');
	}
}