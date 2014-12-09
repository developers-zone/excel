<?
class login_model extends CI_Model {

	public function login()
	{
		$query = $this->db->query("SELECT * from registration where email='".$this->login_model->userName."' and password='".$this->login_model->userPassword."'");
		$client_id 	= "";
		$secret_key 	= "";
		$arrUser	= array();
		if ($query->num_rows() > 0)
		{
			$_SESSION['REG_EMAIL'] = $this->login_model->userName;
			foreach ($query->result() as $row)
			{
				 $client_id 	= $row->client_id;
				 $secret_key 	= $row->secret_key;
			}
		}else{
			return 4;
		}
		
		if($client_id != "" && $secret_key != "")
		{
			try
			{
				$this->session->set_userdata(array('client_id'=>$client_id,'secret_key'=>$secret_key ));
				Podio::setup($client_id, $secret_key);
				header("Location: https://podio.com/oauth/authorize?client_id=".$client_id."&redirect_uri=".site_url('sign_in/server_side_authentication'));
				//Podio::authenticate('authorization_code', array('code' => $_GET['code'], 'redirect_uri' => option('http://localhost/podio_excel/')));
    			
				//return $access_token = Podio::$oauth->access_token;
				//echo $access_token = Podio::$oauth->access_token;
				/*if (!Podio::is_authenticated()) 
				{
					Podio::authenticate('password', array('username' => $this->login_model->userName, 'password' => $this->login_model->userPassword));
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
				else
				{				
					header('Location:'.site_url('index'));
				}*/
			}catch (PodioError $e) {
			return $e->body['error']."##@##".$e->body['error_description'];
			}
	
		}
	
	}
	public function logout()
	{
		unset($_SESSION['podio-php-session']);
		$this->session->unset_userdata('session_id');
		$this->session->unset_userdata('podio_thumbnail_link');
		$this->session->unset_userdata('podio_user');
		$this->session->unset_userdata('client_id');
		$this->session->unset_userdata('secret_key');
		session_unset();
 
	}
	
	public function forgetMail(){
		$dbObj	=	new dbConfig();
		$random_password	=	$dbObj->randomPassword();
		$query = $this->db->query("UPDATE registration SET password='".$random_password."' WHERE email='".$this->login_model->txtforgotuserEmail."'");
				
		$subject = 'Reset Password - Spreadsheet Podio!';
		$html =    '<div style="padding:10px;">
						<p>Hi<br><br>It is our pleasure to inform you that your password of account has been successfully reseted with our system. Authentication details for your account have been provided below:</p>
						<p>Username: <b>'.$this->login_model->txtforgotuserEmail.'</b><br>Password: <b>'.$random_password.'</b></p>
						<p>Please feel free to get in touch with us at support@techego.com with any queries, feedback or suggestions you may have for us.
						</p>
						<p>Thank you for choosing Spreadsheet Podio.</p>
						<p>
						Thanks,<br>
						TECHeGO Team
						</p>
					</div>';
		$dbObj->SendEmailUser($this->login_model->txtforgotuserEmail,$random_password,$subject,$html);
		return 2;
	}
}
?>
