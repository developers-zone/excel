<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ajax extends CI_Controller {

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
	}
	public function index()
	{
		$this->load->view('podio_includes');
		$this->load->model('home_model');
		// $allMyContacts = $this->home_model->loadAllContacts();
		// $data['allMyContacts'] = $allMyContacts;
		// $this->load->view('search',$data);
		$this->load->view('ajax');
	}
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
