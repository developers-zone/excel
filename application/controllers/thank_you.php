<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class thank_you extends CI_Controller {

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
	 var $track_id = "";
	 var $fid = "";
	public function __construct(){
		parent::__construct();
		
		
		$this->track_id = $this->input->get('track_id', TRUE);
		$this->fid = $this->input->get('fid', TRUE);
		$this->load->helper('url');
	}
	public function index()
	{
		$data['track_id'] = $this->track_id;
		$data['fid'] = $this->fid;
		$this->load->view('thank_you',$data);
	}
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */