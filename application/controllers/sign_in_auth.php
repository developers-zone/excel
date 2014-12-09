<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sign_in_auth extends CI_Controller {

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
	
	public function __construct(){
		parent::__construct();
		$this->userPassword 	= "";
		$this->userName 	= "";
		$this->action		= "";
		$this->load->helper('url');
		$this->load->library('session');
		
		// print_r(PodioSession::getSessionFromPodio());
		
	}
	public function index()
	{
		 
		// $this->session->all_userdata();
		@session_start();
		$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
		if($user_id != "")
		{
			header('Location:'.site_url('index'));
		}
		$message = array();
		$returnMessage = "";
		$this->userPassword= $this->input->post('userPassword', TRUE);
		$this->userName	   = $this->input->post('userName', TRUE);
		$this->action 	   = $this->input->post('form_action', TRUE);
		
		 
		$this->load->model('login_auth');

		if($this->action == "LOGIN_NOW")
		{
			$returnMessage = $this->login_model->login();
		}
		$errorArr = explode("##@##", $returnMessage);
		if(isset($errorArr[0]) && isset($errorArr[1])){
			$message['error'] = $errorArr[0];
			$message['error_description'] = $errorArr[1];
		}
		else if($returnMessage != ""){
			$errorValues = "Posting values failure occurred.";
			$error1 = "Authentication failure occurred.";
			$msg1 = "Already registered your mail id";
			$msg2 = "Signed Up Successfully";

			if($returnMessage == 0)
				$message['error'] = $errorValues;
			else if($returnMessage == 1)
				$message['error'] = $msg1;
			else if($returnMessage == 2)
				$message['success'] = $msg2;
			else if($returnMessage == 3)
				$message['error'] = $error1;
		}
		$this->load->view('sign_in',$message);

	}
	 
	public function logout()
	{
		@session_start();
		$this->load->model('login_model');
		$this->login_model->logout();
		header('Location:'.site_url('sign_in'));
	}
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
