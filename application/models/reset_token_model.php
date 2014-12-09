<?
class reset_token_model extends CI_Model {
 
    #function  addUser
	public function resetToken()
	{
		$client_id = $_POST['clientId'];
		$secret_key = $_POST['secretKey'];
		$auth = 1;$row="";
		$userName = $this->session->userdata('podio_userName');
		$data = array( 'client_id' => $client_id,
		'secret_key' => $secret_key);
		$this->db->where('email', $userName);
		$row = $this->db->update('registration', $data);
		if($row ==1) return 1;
		else return 0;

	}



}
?>
