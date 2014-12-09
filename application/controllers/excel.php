<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class excel extends CI_Controller {

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
	var $recs_per_page = "";
	var $exportAction = "";
	public function __construct(){
		parent::__construct();
		@session_start();
		$this->load->helper('url');
		$this->load->model('login_model');
		$this->exportAction = $this->input->post('frmAction', TRUE);
		 $this->recs_per_page 	= $this->input->post('recs_per_page', TRUE);
		if($this->recs_per_page != "")
		{
			$this->session->set_userdata('per_page', $this->recs_per_page);
		}
		else
		{
			$per_page = $this->session->userdata('per_page');
			if($per_page != "")
			$this->recs_per_page = $per_page;
			else
			$this->recs_per_page = 5;
		}
		
	}
	public function index()
	{
		
		$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
		if($user_id == "" || $this->session->userdata('client_id') == "")
		{
			$this->login_model->logout();
			header('Location:'.site_url('sign_in'));
		}
		$this->load->view('podio_includes');
		$this->load->model('excel_model');
		$this->load->library('session');
		// print_r($this->postedFields);
		//print_r($_POST);
		$message = array();
		$returnMessage = "";
		if(isset($_GET['vid'])){
			$this->session->set_userdata('view_id', $_GET['vid']);
		}
		$action = $this->input->post('frmAction', TRUE);
		$appId = $this->uri->segment(3);
		$refId = $this->uri->segment(4);
		if($refId != "" && $action == "SAVE_PODIO"){
			try{
				$returnMessage = $this->excel_model->saveItemToApp($refId);
			}catch (PodioError $e) {
				$returnMessage = $e->body['error']."##@##".$e->body['error_description'];
			}
		}
		else if($appId != "" && $action == "SAVE_PODIO"){
			try{
				$returnMessage = $this->excel_model->saveItemToApp($appId);
			}catch (PodioError $e) {
				$returnMessage = $e->body['error']."##@##".$e->body['error_description'];
			}
		}
		else if($action == "UPDATE_PODIO"){
			try{
				$returnMessage = $this->excel_model->updatePodioItems();
			}catch (PodioError $e) {
				$returnMessage = $e->body['error']."##@##".$e->body['error_description'];
			}
		}

		$errorArr = explode("##@##", $returnMessage);
		if(isset($errorArr[0]) && isset($errorArr[1])){
			$message['error'] = $errorArr[0];
			$message['error_description'] = $errorArr[1];
		}
		else if($returnMessage != ""){
			$message['success'] = "$returnMessage";
		}
		$this->load->view('excel_sheet',$message);	
	}	
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */

