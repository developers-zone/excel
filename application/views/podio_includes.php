<?
 	require_once constant('APPPATH').'podio/config.php';
	require_once constant('APPPATH').'podio/PodioAPI.php';
	require_once constant('APPPATH').'podio/models/PodioContact.php';
	require_once(constant('APPPATH').'libraries/fedex-common.php');
	$this->load->model('login_model');
	try
	{
		Podio::setup(CONFIG_CLIENT_ID, CONFIG_CLIENT_SECRET);
	}catch (PodioError $e) {
		$this->login_model->logout();
		header('Location:'.site_url('sign_in'));
	}

		@session_start();
		
		
?>