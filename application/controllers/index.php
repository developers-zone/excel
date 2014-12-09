<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class index extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	var $ship_trans_id = "";
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
		@session_start();
		$this->session->unset_userdata('space_id');
		if(isset($_SESSION['podio-php-session']['ref']['id']) && $_SESSION['podio-php-session']['ref']['id'] != "" && $this->session->userdata('client_id') != "")
			$user_id = $_SESSION['podio-php-session']['ref']['id'];
		else
			$user_id = "";
		
		$this->userPassword= $this->input->post('userPassword', TRUE);
		$this->userName	   = $this->input->post('userName', TRUE);
		$this->action 	   = $this->input->post('form_action', TRUE);
		
		 
		$this->load->view('podio_includes');
		$this->load->model('login_model');

		if($this->action == "LOGIN_NOW")
		{
			$returnMessage = $this->login_model->login();
		}
		
		if($user_id == "")
		{
			$this->login_model->logout();
			header('Location:'.site_url('sign_in'));
		}
		$this->load->view('podio_includes');
		$this->load->model('home_model');
		$arrOrganaizations = $this->home_model->retrieveOrganizations();
		$this->session->unset_userdata('view_id');
		$this->session->unset_userdata('per_page');
		// $arrOrganaizations = $this->home_model->retrieveViews(5654058);
		$data['arrOrganaizations'] = $arrOrganaizations ;
		$this->load->view('index_view',$data);
	}
	 

	
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
