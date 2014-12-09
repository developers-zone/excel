<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forget extends CI_Controller {

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
		$this->txtforgotuserEmail 	= "";
		$this->action	= "";
		$this->load->helper('url');
		$this->load->library('session');
		
		require_once 'briefcase/apiFunction/includes/config.php';
		require_once 'briefcase/apiFunction/classes/class.database.php';
		// print_r(PodioSession::getSessionFromPodio());
		
	}
	public function index()
	{
		// $this->session->all_userdata();
		@session_start();
		//$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
		$user_id =  "";
		if($user_id != "")
		{
			header('Location:'.site_url('index'));
		}
		$message = array();
		$returnMessage = "";
		$this->txtforgotuserEmail= $this->input->post('txtforgotuserEmail', TRUE);
		$this->action 	   = $this->input->post('form_action', TRUE);
		
		 
		$this->load->view('podio_includes');
		$this->load->model('login_model');

		if($this->action == "FORGET_MAIL")
		{
			$returnMessage = $this->login_model->forgetMail();
		}
		$errorArr = explode("##@##", $returnMessage);
		if(isset($errorArr[0]) && isset($errorArr[1])){
			$message['error'] = $errorArr[0];
			$message['error_description'] = $errorArr[1];
		}
		else if($returnMessage != ""){
			$errorValues = "Posting values failure occurred.";
			$error1 = "Authentication failure occurred.";
			$msg1 = "Error in password reseting";
			$msg2 = "Password reseted successfully. The new password will be send to your mail.";
			$msg3 = "Incorrect Email/Password";
			//$msg4 = "Client ID";

			if($returnMessage == 0)
				$message['error'] = $errorValues;
			else if($returnMessage == 1)
				$message['error'] = $msg1;
			else if($returnMessage == 2)
				$message['success'] = $msg2;
			else if($returnMessage == 3)
				$message['error'] = $error1;
			else if($returnMessage == 4)
				$message['error'] = $msg3;
		}
		$this->load->view('forget_view',$message);

	}
}