<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sign_up extends CI_Controller {

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
		$this->load->helper('url');
		$this->userPassword = $this->input->post('clsLogin_customer_password', TRUE);
		$this->userName	 = $this->input->post('clsLogin_customer_email', TRUE);
		$this->client_id = $this->input->post('client_id', TRUE);
		$this->secret_key = $this->input->post('secret_key', TRUE);
		
		require_once 'briefcase/apiFunction/includes/header.php';
		require_once 'briefcase/apiFunction/includes/functions.php';
	}
	public function index()
	{
		@session_start();
		$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
		if($user_id != "")
		{
			header('Location:'.site_url('index'));
		}
		$action = $this->input->post('form_action', TRUE);
		
		$message = array();
		$returnMessage = "";
		//$this->load->view('podio_includes');
		$this->load->model('sign_up_model');
		
		if(isset($_GET['code'])){
				$returnMessage  =   doServerAuthentication();
				if($returnMessage  == "true"){
					$uri = site_url('sign_in')."?reg=".$_SESSION['REG_EMAIL'];
					echo "<a href='".$uri."' id='clickTrigger1'></a>
					 <script>document.getElementById('clickTrigger1').click();</script>";
				}
		}
			
		if($action=="REGISTER_NOW"){
		   
			if(array_key_exists('clsLogin_customer_email',$_POST)){
			     $returnMessage	=	doregister();
			}else if(isset($_GET['code'])){
				$returnMessage  =   doServerAuthentication();
			}else if(isset($_GET['action']) && $_GET['action'] == "duplication" ){
				$returnMessage  =    "We already have an account with email '{$_GET['clsLogin_customer_email']}'. ";
			}
			//$this->userPassword = $this->input->post('clsLogin_customer_password', TRUE);
			//$this->userName	    = $this->input->post('clsLogin_customer_email', TRUE);
			
		}
		
			
		$errorArr = explode("##@##", $returnMessage);
		if(isset($errorArr[0]) && isset($errorArr[1])){
			$message['error'] = $errorArr[0];
			$message['error_description'] = $errorArr[1];
		}else if($returnMessage != ""){
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
		
		$this->load->view('sign_up',$message);	
	}	
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
