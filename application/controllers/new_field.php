<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class new_field extends CI_Controller {

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
	var $field_type = "";
	var $description = "";
	var $required_val = "";
	var $field_name = "";
	var $delta = "";
	var $action = "";
	var $contact_type = "";
	var $multi_choice = "";
	var $errorValues = array();
	var $allowedCurrecies = array();
	var $optionValues = array();
	var $references = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->action 		= $this->input->post('formAction', TRUE);
		$this->field_type 	= $this->input->post('field_type', TRUE);
		$this->description 	= $this->input->post('description', TRUE);
		$this->delta 	= $this->input->post('delta', TRUE);
		$this->multi_choice 	= $this->input->post('multi_choice', TRUE);
		$this->required_val     = $this->input->post('required_val', TRUE);
		$this->field_name 	= $this->input->post('field_name', TRUE);
		$this->optionValues 	= $this->input->post('optionValues', TRUE);
		$this->references 	= $this->input->post('references', TRUE);
		$this->allowedCurrecies 	= $this->input->post('allowedCurrecies', TRUE);
		$this->contact_type 	= $this->input->post('contact_type', TRUE);
		$this->load->model('login_model');
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
		$this->load->model('new_field_model');
		$this->load->library('session');
		
		$message = array();
		$returnMessage = "";
		$appId = $this->uri->segment(3);
		$refId = $this->uri->segment(4);//echo '............'.$this->action;
		if($this->action == "CREATE_NEW_FIELD" && $refId != ""){
			try{
				$returnMessage = $this->new_field_model->createNewField($refId);
			}catch (PodioError $e) {
				$returnMessage = $e->body['error']."##@##".$e->body['error_description'];
			}
		}
		if($this->action == "CREATE_NEW_FIELD" && $appId != ""){
			try{
				$returnMessage = $this->new_field_model->createNewField($appId);
			}catch (PodioError $e) {
				$returnMessage = $e->body['error']."##@##".$e->body['error_description'];
			}
		}
		$errorArr = explode("##@##", $returnMessage);
		if(isset($errorArr[0]) && isset($errorArr[1])){
			$message['error'] = $errorArr[0];
			$message['error_description'] = $errorArr[1];
		}else if(isset($returnMessage) && $returnMessage!=""){
			$errorValues = "Field Name already exists in the app.";
			$msg = "Field Created Successfully";

			if($returnMessage == 0)
				$message['error'] = $errorValues;
			else if($returnMessage == 1)
				$message['success'] = $msg;
		}
		$this->load->view('new_field',$message);
	
	}
	 

	
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
