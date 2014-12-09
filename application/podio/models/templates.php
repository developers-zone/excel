<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice Template</title>
<link rel="stylesheet" type="text/css" href="../css/pagestyle.css" /> 
<!---Draggable-->
<link rel="stylesheet" href="../css/Draggable/jquery-ui.css" />
<script src="../js/Draggable/jquery-1.9.1.js"></script>
<script src="../js/Draggable/jquery-ui.js"></script>
<script src="../js/Custom/template3.js"></script>
<!---Draggable-->
<!--Print Preview-->
<link rel="stylesheet" href="../css/Print Preview/print.css" type="text/css" media="print">
<link rel="stylesheet" href="../css/Print Preview/print-preview.css" type="text/css" media="screen">
<script src="../js/Print Preview/jquery.tools.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/Print Preview/jquery.print-preview.js" type="text/javascript" charset="utf-8"></script>  
<script src="../js/Custom/Print Preview.js"></script> 
<!--Print Preview-->
<style>

	.origin{	
		background-color: #FAFAFA;
		height: auto;
		margin-top: 136px;
		min-height: 800px;
		width: 265px;
	}

	#origin img, #drop img {
		margin-top: 3px;
		margin-left: 5px;
	}

	#drop {
		//border: 1px solid gray;
		min-height: 120px;
    }
	
	.over {
		border: 1px solid 5px purple;
	}
	
	.draggable {
		border: 1px solid #C9C8C8;
		font-weight: 700;
		padding:10px;
	}
	.ui-resizable-helper { 
		border: 2px dotted #00F; 
	
	}
	.draggable {
		position: relative;
		left: 0px;
		top: 0px;
		width: 97px;
		min-height: 16px;
		height: auto;
		overflow: hidden;
		text-align: center;
		top:8px;
		left:12px;
		margin-bottom:20px;
		
	}
	
	.holder {
	
	        border: 1px dashed gray;
			float: right;
			height: auto;
			margin-bottom: 5px;
			min-height: 55px;
			width: 145px;
		
	}
	
	.left_holder {
	
	      float: left;
		  height: 28px;
          margin-top: 8px;
          padding: 10px;
          width: 90px;
		
	}

	
</style>
</head>
<body>
<div id="main-wrapper">
  <div id="wrapper">
    <div id="left-panel">
      <div id="placemnt-panl">Template Editing options
	        
			 <div id="right-panel"><button class="btn btn-2 btn-2c">CREATE NEW TEMPLATE</button></div>
             <button class="btn3 btn-3 btn-3c">SAVE TEMPLATE</button>
	  
			 <div id="aside" class="grid_3 push_1"><a class="print-preview">>></a> <a href="dompdf/test.php">Save as PDF</a></div>
	  

	  
	  </div>
	  
	        <!---- Dragable Area---->
			<div id="content-panl" class="drop">
				
				<div class="drop field1"></div>
                <div class="drop field2"></div>
				<div class="drop field3"></div>
                <div class="drop field4"></div>
                <div class="drop field5"></div>
                <div class="drop field6"></div>
                <div class="drop field7"></div>
                <div class="drop field61"></div>
                <div class="drop field71"></div>
                <div class="drop field62"></div>
                <div class="drop field72"></div>
                <div class="drop field8"></div>
                <div class="drop field9"></div>
                <div class="drop field5"></div>
				
				
				
		   
		    </div>
			 <!---- Dragable Area---->
			
			
			
			
			
    </div>
    
   

   <?php
	
	require_once 'config.php';
	require_once 'PodioAPI.php';
	require_once 'models/PodioItem.php';
	require_once 'models/PodioApp.php';
	require_once 'models/PodioAppField.php';
	require_once 'models/PodioContact.php';
	require_once 'models/PodioFile.php';
	require_once 'models/PodioItem.php';


	
	
	Podio::setup($_SESSION['_PODIO_CLIENT_ID'], $_SESSION['_PODIO_CLIENT_SECRET']);
	Podio::$debug = true;
	
	//$apicon = PodioApp::get(4694723,$field_id=array('Screenshot' => '36441955'));
	//$icon = get_object_vars($apicon);
	//var_dump($icon);
    
	$id = $_GET['id'];
	//$item = PodioItem::get(59961549);
	//print $item->title . "<br/>";
	
	

	echo "<pre>";
	//print_r($item);
	echo "</pre>";

	//print $item->title;

	//print "<br/>";

	//$created_by = $item->initial_revision->created_by;
	// $created_by is an instance of PodioByLine class, so you have those properties. Just print the ID:
	//$img_page =  $created_by->image['thumbnail_link'];
	
	
	
	

	
	
	//$app = PodioApp::get_all( $attributes = array() );
	//$x = get_object_vars($app[0]);
	$app = PodioApp::get($id);
	//var_dump($app);
	//$appid =  $app->app_id;
	$itemname = $app->config;
	$app_id = $app->app_id;                // APP ID
	$app_name = $itemname['name'];         // APP NAME
	$app_status = $app->status;            // APP STATUS
	$owner = $app->owner;
	$config = $app->config;
        $owner_name = $owner['name'];         // OWNER NAME
	$link = $owner['link'];              // LINK
	
		


	

	
	?>
   
   

   
   
   
   <!-----------Dragable Contents-------------->
   <div id="right-side-menu" >
	
     <div class="origin" class="fbox">
		
		   <div class="left_holder">Image:</div>
		   <div class="holder">
				<div class="draggable"><img src="<?php ?>" height="200" width="205"></div>
		   </div>
		   
		   <div class="left_holder">APP ID:</div>
		   <div class="holder">
		      <div class="draggable"> <?php   echo $app_id; ?></div>
		   </div>
		   
		   <div class="left_holder">APP Name:</div>
		     <div class="holder">
				<div class="draggable"> <?php echo $app_name; ?></div>
			 </div>
			 
			
           <div class="left_holder">APP Status:</div>
            <div class="holder">		   
		    <div class="draggable"> <?php echo $app_status; ?></div>
		    </div>
			
		    <div class="left_holder">APP Link:</div>
            <div class="holder">
		    <div style="float:left;"></div><div class="draggable"> <?php echo $link; ?></div>
			</div>
		
		    <div class="left_holder">APP Owner:</div>
            <div class="holder">
			<div class="draggable"> <?php echo $owner_name; ?></div>
            </div>
		
	</div>
	   
       
    </div>
	
	<!-----------Dragable Contents-------------->
	
  </div>
</div>


<script>
 jQuery(function() {
	//$("#print-modal-content").css({"height:800px;"}):
  });
</script>

</body>
</html>
<?php ob_end_flush(); ?>
