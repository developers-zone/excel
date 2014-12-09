<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="revisit-after" content="1 days">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="title" content="Welcome">
	<meta name="description" content="">
	<meta name="keywords" content="">
	

 
	<title>Techego :: Welcome</title>
	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width">
	  <link rel="stylesheet" type="text/css" href="<? echo base_url();?>briefcase/css/uikit.almost-flat.min.css"> 

	<link rel="stylesheet" type="text/css" href="<? echo base_url();?>briefcase/css/uikit.gradient.min.css"> 
	<link rel="stylesheet" type="text/css" href="<? echo base_url();?>briefcase/css/mainpage.css"> 
	<link rel="stylesheet" type="text/css" href="<? echo base_url();?>briefcase/css/numlinkstyle.css"> 
	<link rel="stylesheet" type="text/css" href="<? echo base_url();?>briefcase/css/jquery.alerts.css"> 
 
	<script type="text/javascript" src="<? echo base_url();?>briefcase/js/main.js"></script>
	<script type="text/javascript" src="<? echo base_url();?>briefcase/js/common.js"></script> 
 
			
	 
	<!--<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery-ui-sliderAccess.js"></script>
	<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery.alerts.js"></script>
	<script type="text/javascript" src="<? echo base_url();?>briefcase/js/tab.js"></script>
	-->
 
 
	<script src="<? echo base_url();?>briefcase/js/jquery-1.9.1.js"></script>

    <link rel="stylesheet" type="text/css" href="<? echo base_url();?>briefcase/css/uikit.css" /> 
    <script src="<? echo base_url();?>briefcase/js/uikit.min.js"></script>
 

</head>
		<?$appId = $this->uri->segment(3);
		  $refId = $this->uri->segment(4);
		  $this->load->library('session');
		  if(isset($_GET['error']) && $_GET['error'] == 1)
		  {
			$error = "Permission Required";
			$error_description = "You does not have the right view_structure on this app";
		  }
		  
		  ?>
<body class="login_body">
	<div class="ribbon"> 
		<div style="width:78%;margin:auto;"> 
			<?if(!isset($_SESSION['REG_EMAIL'])){?>
				<a href="<?echo base_url();?>" style="background:none;">Hoist</a>
			<?}?>
				<span style="float:right;">
					<?@session_start();
					$user_id = isset($_SESSION['podio-php-session']['ref']['id'])?$_SESSION['podio-php-session']['ref']['id']:"";
					$link = "";$style = "";
					if(isset($_SESSION['REG_EMAIL'])){ 
						 
						if ($this->session->userdata('podio_thumbnail_link')!=""){
							$link = $this->session->userdata('podio_thumbnail_link')."/small";
							$style = "";
						}else{
							$link = base_url()."briefcase/images/podiologo.png";
							$style = "width: 29px;";
						}?>

						<img src="<?echo $link;?>" style="<?echo $style;?>margin-top:-4px" >&nbsp;  &nbsp; &nbsp;

						<label style="      color: #FFFFFF;
								    font-family: Tahoma,Lucida Grande;
								    font-size: 15px;
								    line-height: 2.2;
								   
							"><?echo $this->session->userdata('podio_user');?></label>&nbsp;&nbsp;&nbsp;
						<a href="<?echo site_url('index');?>" style="background:none; font-size: 15px;">Home</a>
						<?if($appId != ""){?>
							<a href="<?echo site_url('new_field').'/index/'.$appId.'/'.$refId;?>" style="font-size: 15px;background:none;">Add Field</a>
						<?}?>
					<a href="<?echo site_url('reset_token');?>" style="background:none; font-size: 15px;">Settings</a>
					<a href="<?echo site_url('sign_in');?>/logout" style="background:none; font-size: 15px;">Logout</a>
					<?}else{?>
						<a href="<?echo site_url('sign_up');?>" style="background:none;">Register Now</a>
					<?}?> 
				</span>
		</div>
	</div>
 	<div class="uk-form-danger" style="margin-left: 0px; border-bottom-width: 0px; margin-top: 0px; text-align:center;">
		<?if(isset($error) && isset($error_description)){			//display error
			echo "There was an error. The API responded with the error type ".$error." and the mesage ".$error_description.".";
		}else if(isset($error)){
			echo $error;
		}?>
	</div>
	<div class="uk-form-success" style="margin-left: 0px; border-bottom-width: 0px; margin-top: 0px;text-align:center;">
		<?if(isset($success)){			//display message
			echo $success;
		}?>
	</div>
	<div id="dvLoading"></div>

	
