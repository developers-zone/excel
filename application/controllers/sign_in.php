<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sign_in extends CI_Controller {

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
		//$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
		$user_id =  "";
		if($user_id != "")
		{
			header('Location:'.site_url('index'));
		}
		$message = array();
		$returnMessage = "";
		$this->userPassword= $this->input->post('userPassword', TRUE);
		$this->userName	   = $this->input->post('userName', TRUE);
		$this->action 	   = $this->input->post('form_action', TRUE);
		
		 
		$this->load->view('podio_includes');
		$this->load->model('login_model');

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
		$this->load->view('sign_in',$message);

	}
	 
	public function logout()
	{
		@session_start();
		$this->load->model('login_model');
		$this->login_model->logout();
		header('Location:'.site_url('sign_in'));
	}
	
	public function server_side_authentication(){
		 
		//error_reporting(E_ALL);ini_set('display_errors', '1');
		if($_GET['code']){
			$this->load->view('podio_includes');
			//$this->login_model->process_server_authentication();
		
			$client_id = $this->session->userdata('client_id');
			$secret_key = $this->session->userdata('secret_key');
			$signupflag = $this->session->userdata('signupflag');
			
			try{
				Podio::setup($client_id, $secret_key);
				Podio::authenticate('authorization_code', array('code' => $_GET['code'], 'redirect_uri' => site_url('sign_in/server_side_authentication')));
						
				$access_token = Podio::$oauth->access_token;
				$refresh_token = Podio::$oauth->refresh_token;
				
				if(isset($access_token)){
					if($signupflag==true){
						$email = $this->session->userdata('email');
						$password = $this->session->userdata('password');
						
						$this->db->select('*');
						$this->db->from('registration');
						$this->db->where('email', $email);
			
						$result = $this->db->get();
						$row = $result->result_array();
			
						if (count($row) > 0) { 
							header('Location:'.site_url('index'));
						}else{
							$postedArr = array('email' => $email,'password' => $password,'client_id' => $client_id,'secret_key' => $secret_key,'access_token' => $access_token,'refresh_token' => $refresh_token);
							$this->load->database();
							$result_ship	= $this->db->insert('registration', $postedArr);
							
							$last_insert_id	= $this->db->insert_id();
							
							
							
							/************* Save Register users in to database *************/
							
							$contact						=	PodioUserStatus::get(  );
							
							$data['reg_id']					=	$last_insert_id; 
							
							if( !empty( $contact->profile->profile_id ) ) 
								$data['profile_id']			=	$contact->profile->profile_id; 
							
							if( !empty( $contact->profile->user_id ) ) 
								$data['user_id']			=	$contact->profile->user_id; 
							
							if( !empty( $contact->profile->name ) ) 
								$data['name']				=	$contact->profile->name;
							
							if( !empty( $contact->profile->avatar ) ) 
								$data['avatar']				=	$contact->profile->avatar; 
							 
							if( count( (array)$contact->profile->birthdate) ) 
								$data['birthdate']		=	$contact->profile->birthdate->format('Y-m-d');
							
							if( !empty( $contact->profile->skype ) )	
								$data['skype']				=	$contact->profile->skype;
							
							if( !empty( $contact->profile->about ) )		
								$data['about']				=	$contact->profile->about;
							
							if( !empty( $contact->profile->address ) )		
								$data['address']			=	@implode(', ', $contact->profile->address);
							
							if( !empty( $contact->profile->zip ) )			
								$data['zip']				=	$contact->profile->zip;
							
							if( !empty( $contact->profile->city ) )				
								$data['city']				=	$contact->profile->city;
							
							if( !empty( $contact->profile->country ) )			
								$data['country']			=	$contact->profile->country;
							
							if( !empty( $contact->profile->state ) )	
								$data['state']				=	$contact->profile->state;
							
							if( !empty( $contact->profile->im ) )		
								$data['im']					=	@implode(', ', $contact->profile->im);
								
							if( !empty( $contact->profile->location ) )			
								$data['location']			=	@implode(', ', $contact->profile->location);
							
							if( !empty( $contact->profile->mail ) )				
								$data['mail']				=	@implode(', ', $contact->profile->mail);
							
							if( !empty( $contact->profile->phone ) )		
								$data['phone']				=	@implode(', ', $contact->profile->phone);
							
							if( !empty( $contact->profile->title ) )		
								$data['title']				=	@implode(', ', $contact->profile->title);
							
							if( !empty( $contact->profile->url ) )			
								$data['url']				=	@implode(', ', $contact->profile->url);
							
							if( !empty( $contact->profile->skill ) )				
								$data['skill']				=	@implode(', ', $contact->profile->skill);
								
							if( !empty( $contact->profile->linkedin ) )				
								$data['linkedin']			=	$contact->profile->linkedin;
							
							if( !empty( $contact->profile->twitter ) )				
								$data['twitter']			=	$contact->profile->twitter;
							
							if( !empty( $contact->profile->organization ) )			
								$data['organization']		=	$contact->profile->organization;
								
							if( !empty( $contact->profile->type ) )			
								$data['type']				=	$contact->profile->type;
							
							if( !empty( $contact->profile->space_id ) )			
								$data['space_id']			=	$contact->profile->space_id;
							 
							$this->db->insert('sp_users', $data);
								
							/**************************************************************************8 */
							
							
							if($last_insert_id != "") {
								//$this->load->model('login_model');
								//$this->login_model->login();
								//return 2;
								}
							else {
								header('Location:'.site_url('index'));
								}
			
			
						}
					}
					
					$this->db->select('reg_id');
					$this->db->where('client_id',$client_id);
					$this->db->where('secret_key',$secret_key);
					$query = $this->db->get('registration');
					$result=$query->result_array();
					$reg_id=$result[0]['reg_id'];
					
					$data=array('access_token'=>$access_token,'refresh_token'=>$refresh_token);
					$this->db->where('reg_id',$reg_id);
					$this->db->update('registration',$data);
					
					$podio_user_id = $_SESSION['podio-php-session']['ref']['id'];
					$arrUser = PodioUserStatus::get();
					if($arrUser!=""){
						$this->session->set_userdata('podio_thumbnail_link',$arrUser->__attributes['profile']->__attributes['image']->__attributes['thumbnail_link']);
						$this->session->set_userdata('podio_user',$arrUser->__attributes['profile']->__attributes['name']);
					}
					$this->session->set_userdata('podio_userName',$this->login_model->userName);
					$this->session->set_userdata('podio_user_id',$podio_user_id);
					$this->session->set_userdata('client_id',$client_id);
					$this->session->set_userdata('secret_key',$secret_key);
		
					header('Location:'.site_url('index'));
				}
				else{
					//return 3;
					header('Location:'.site_url('index'));
				}
			}catch (PodioError $e) {
				//return $e;
				header('Location:'.site_url('index'));
				//return $e;
				//echo $e->body['error']."##@##".$e->body['error_description'];
			}
			
			
		}
		else{
			header('Location:'.site_url('index'));
		}
		
	}
	/*public function signup_server_authentication(){
		if($_GET['code']){
			$this->load->view('podio_includes');
			$client_id = $this->session->userdata('client_id');
			$secret_key = $this->session->userdata('secret_key');
			$email = $this->session->userdata('email');
			$password = $this->session->userdata('password');
			
			try{
				Podio::setup($client_id, $secret_key);
				Podio::authenticate('authorization_code', array('code' => $_GET['code'], 'redirect_uri' => site_url('sign_in/signup_server_authentication')));
				
				$access_token = Podio::$oauth->access_token;
				$refresh_token = Podio::$oauth->refresh_token;
				
				$this->db->select('*');
				$this->db->from('registration');
				$this->db->where('email', $email);
	
				$result = $this->db->get();
				$row = $result->result_array();
	
				if (count($row) > 0) { 
					return 1;
				}else{
					$postedArr = array('email' => $email,'password' => $password,'client_id' => $client_id,'secret_key' => $secret_key,'access_token' => $access_token,'refresh_token' => $refresh_token);
					$this->load->database();
					$result_ship	= $this->db->insert('registration', $postedArr);
	
					$last_insert_id	= $this->db->insert_id();
					if($last_insert_id != "") {
						$this->load->model('login_model');
						$this->login_model->login();
						//return 2;
						}
					else {
						return 0;
						}
	
	
				}
			}catch (PodioError $e) {
				return $e->body['error']."##@##".$e->body['error_description'];
			}
		}
	}*/
}


/* End of file sign_in.php */
/* Location: ./application/controllers/sign_in.php */
