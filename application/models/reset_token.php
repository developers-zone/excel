<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reset_token extends CI_Controller {

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
	var $postedFields = array();
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('login_model');
		$this->load->model('reset_token_model');
	}
	public function index()
	{
		@session_start();
		$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
		if($user_id == "" || $this->session->userdata('client_id') == "")
		{
			$this->login_model->logout();
			header('Location:'.site_url('sign_in'));
		}
		$this->load->view('podio_includes');
		$message = array();
		$returnMessage = "";

		$action = $this->input->post('frmAction', TRUE);
		if($action == "PODIO_SETUP"){
			$returnMessage = $this->reset_token_model->resetToken();
		}
		$success = "Successfully updated";
		 $error = "Failure in updation";
		echo $returnMessage;.'...........';
		if($returnMessage == 1)
			$message['success'] = $success;
		else if($returnMessage == '0' && $returnMessage != "")
			$message['error'] = $error;

		$this->load->view('reset_token_view',$message);	
	}	
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
