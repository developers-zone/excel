
    <?php require_once 'briefcase/apiFunction/includes/config.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Spreadsheet Podio :: TECHeGO.com</title> 
		<link rel="stylesheet" href="<? echo base_url();?>briefcase/pageLoad/css/uikit.css" type="text/css"/>
		<link rel="stylesheet" href="<? echo base_url();?>briefcase/pageLoad/css/style.css" type="text/css"/>
		<link href="favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
		<link href='http://fonts.googleapis.com/css?family=Josefin+Slab:400,700' rel='stylesheet' type='text/css'>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<? echo base_url();?>briefcase/pageLoad/js/uikit.js" type="text/javascript"></script>
		<script src="<? echo base_url();?>briefcase/pageLoad/js/custom.js" type="text/javascript"></script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-704907-4', 'auto');
			ga('send', 'pageview');
		</script>
	</head>

	<?$appId = $this->uri->segment(3);
	  $refId = $this->uri->segment(4);
	  $this->load->library('session');
	  if(isset($_GET['error']) && $_GET['error'] == 1){
		$error = "Permission Required";
		$error_description = "You does not have the right view_structure on this app";
	  }
	  ?>
	<body>
		<div id="wrapper">
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
			
			
			<div id="container">
				<div align="center" style="margin-top: 78px;">
					<img src="<? echo base_url();?>briefcase/images/TECHeGO.png" style="width:53%;" />
				</div>
				<h2  id="projectlogo"><?php echo PROJECT_NAME;?></h2>
