<?
class sign_up_model extends CI_Model {
 
 
   public function registrationUser(){
        $dbObj		=	new dbConfig();
		$Query		=	$dbObj->registration(null,'81a5a53ab00840abb12697127c789c5e');
    
   }
 
    #function  addUser
    public function addUser()
    {
		
			if(!isset($_POST) || $_POST['clsLogin_customer_email'] =="" || $_POST['clsLogin_customer_password'] == ""){
				return 0;
			}else{
				$email      = $_POST['clsLogin_customer_email'];
				$password   = $_POST['clsLogin_customer_password'];
				$client_id  = $_POST['client_id'];
				$secret_key = $_POST['secret_key'];
				$query = $this->db->query("SELECT * from registration where email='".$email."'");
				if($query->num_rows()>0){
					return 1;
				}
				else{
					try{
					//$query = $this->db->query("SELECT * from registration where client_id='".$client_id."' and secret_key='".$secret_key."'");
				//$auth =	1;
					//if($query->num_rows()>0){
						//return 5;
					//}
					//else{
						$this->session->set_userdata(array('client_id'=>$client_id,'secret_key'=>$secret_key,'email'=>$email,'password'=>md5($password),'signupflag'=>true ));
				//$auth = $this->authenticate($email,$password,$client_id, $secret_key);
						Podio::setup($client_id, $secret_key);
						Podio::$debug=true;
						$auth_url = htmlentities(Podio::authorize_url(site_url('sign_in/server_side_authentication')));
   						header("Location:$auth_url");
						
				}
				catch(PodioError $e){
					$message['error']=$e->body['error_description'];	
					return;
				}
				
				//header("Location: https://podio.com/oauth/authorize?client_id=".$client_id."&redirect_uri=".site_url('sign_in/server_side_authentication'));
						
					/*if($auth == ""){
						$this->db->select('*');
						$this->db->from('registration');
						$this->db->where('email', $email);
	
						$result = $this->db->get();
						$row = $result->result_array();
			
						if (count($row) > 0) { 
							return 1;
						}else{
							$postedArr = array('email' => $email,'password' => md5($password),'client_id' => $client_id,'secret_key' => $secret_key);
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
					}else{
						return $auth;
					}*/
					//}
				}
			}
    }
	/*public function authenticate($email,$password,$client_id, $secret_key)
	{
		try{
			Podio::setup($client_id, $secret_key);
			header("Location: https://podio.com/oauth/authorize?client_id=".$client_id."&redirect_uri=".site_url('sign_in/server_side_authentication'));
			//Podio::authenticate('password', array('username' => $email, 'password' => $password));
			return "";
		}catch (PodioError $e) {
			return $e->body['error']."##@##".$e->body['error_description'];
		}
	}*/

}
?>
