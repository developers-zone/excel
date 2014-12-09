 <? $this->load->view('header');?>
 <script type="text/javascript">
	function save2Podio(appId)
	{
		var frm = document.formExcel;
		var elements = document.forms['formExcel'].elements;
		for (i=0; i<elements.length; i++)
		{
			if(document.forms['formExcel'].elements[i].required)
				if(document.forms['formExcel'].elements[i].value == "")		return false;
		}
		frm.frmAction.value = "SAVE_PODIO"; 
		frm.appId.value = appId;
		frm.submit();
	
	}
	function update2Podio(per_page)
	{

		var frm = document.formExcel2;
		var check = 0;
		frm.frmAction.value = "UPDATE_PODIO"; 
		for(var i=0; i<per_page; i++){
			if(document.getElementById('checkbox_'+i))
			{
				if(document.getElementById('checkbox_'+i).checked == true)
				{
					check = 1;
				}
			}
			}
		if(check == 0){
			alert("Choose atleast one row");
			return;
		}else{
			frm.submit();
		}
	
	}
	function export2Podio()
	{
		var frm = document.formExcel2;
		frm.frmAction.value = "EXPORT_PODIO"; 
		//document.getElementById('btn005').className = 'uk-button uk-button-danger';
		frm.submit();
	}
	function export2Google()
	{
		var frm = document.formExcel2;
		frm.frmAction.value = "EXPORT_GOOGLE"; 
		document.getElementById('btn006').className = 'uk-button uk-button-danger';
		frm.submit();
	}
	function activateCheckBox(val){
               if(document.getElementById('checkbox_'+val).checked == false)
                       {
                               document.getElementById('checkbox_'+val).checked = true;
                               
                               document.getElementById('btn002').className = 'uk-button uk-button-danger';
                               
                       }
        }
	function displayTab(element,id,refId){
 
		var tabContents = document.getElementsByClassName('custom-tab');
		for (var i = 0; i < tabContents.length; i++) { 
			tabContents[i].style.display = 'none';
		}

		document.getElementById("tabs"+element).style.display = 'block';
		if(id == refId){
			window.location = "<?echo site_url('excel');?>/index/"+id;
		}else if(refId != ""){
			window.location = "<?echo site_url('excel');?>/index/"+id+"/"+refId;
		}
	}
	function changeBtnColor()
       {
               if(document.getElementById('btn001'))
                       document.getElementById('btn001').className = 'uk-button uk-button-danger';
       }
	function refresh()
	{
		var frm = document.formExcel2;
		if(document.getElementById('btn003')){
		document.getElementById('btn003').className = 'uk-button uk-button-danger';
		frm.submit();
	}
	}
	function reLoad()
	{
		var frm = document.formExcel2;
		if(document.getElementById('btn004'))
		{
			document.getElementById('btn004').className = 'uk-button uk-button-danger';
			tmpAct = "http://<?echo $_SERVER['HTTP_HOST']?><?echo $_SERVER['REQUEST_URI'];?>";
			tmpAction = tmpAct.split("?"); 
			frm.action = tmpAction[0];
			frm.submit();
		}
	}
	

function markAsSelected(id,i)
{
		if(document.getElementById(id).checked)
		{
			document.getElementById(id+"_lab").style.background = "#3399FF";
			document.getElementById(id+"_lab").style.color = "#FFFFFF";
			activateCheckBox(i);
		}
		else
		{
			document.getElementById(id+"_lab").style.background = "#FFFFFF";
			document.getElementById(id+"_lab").style.color = "#000000";
			activateCheckBox(i);
		}
	
}
 </script>
 
<!-- styles needed by jScrollPane - include in your own sites -->
		<link type="text/css" href="<? echo base_url();?>briefcase/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
	 
		<style type="text/css" id="page-css">
			/* Styles specific to this particular page */
 
						.scroll-pane
                       {
                               width: 100%;
                               height:auto;
                               overflow-y: scroll !important;
							   overflow-x: hidden !important;
                       }
                       .horizontal-only
                       {
                               height:auto;
                               width: 100%;
                               
                       }
 
		</style>
		

		<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery-ui.min.js"></script>
		<!-- the mousewheel plugin -->
		<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery.mousewheel.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery.jscrollpane.min.js"></script>
		 <!-- scripts specific to this demo site -->
		
		<!-- Date Picker -->
		<script type="text/javascript" src="<? echo base_url();?>briefcase/js/jquery.simple-dtpicker.js"></script>
		<link type="text/css" href="<? echo base_url();?>briefcase/css/jquery.simple-dtpicker.css" rel="stylesheet" />
		<!-- Date Picker -->
 

	
		 
		<script src="<? echo base_url();?>briefcase/chooson/chosen.jquery.js" type="text/javascript"></script>
 
		<script src="<? echo base_url();?>briefcase/chooson/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="<? echo base_url();?>briefcase/chooson/chosen.css">
 
 

  
  
<div id="main-wrapper" >
	
	<div class="innerBoxFull scroll-pane horizontal-only">	 
		<form class="uk-form uk-margin " style="margin:0px;" onsubmit="return false;" method="POST" action="" name="formExcel" action="">
			<input type="hidden" name="frmAction" value=""/>
			<input type="hidden" name="appId" value=""/>
			<div class="">
<?
  
		$appId = $this->uri->segment(3); 
		$refId = $this->uri->segment(4); 
		$arrFieldsMain = array();
		$arrCal = array();
		try{
			if($refId != ""){
				$arrFieldsMain = PodioApp::get($appId); 
				$arrFields = PodioApp::get($refId);  //coded
			}	 
			else	$arrFields = PodioApp::get($appId); 
			
			$arrCal = PodioApp::calculations($appId);
		}
		catch (PodioError $e) {
			if(isset($_GET['error']) && $_GET['error'] == "1")
			header('Location:'.site_url('index'));
		//	else
		//	header('Location:'.site_url('excel').'/index/'.$appId.'?error=1');
		}
		// print_r($arrFields);
	?>
 
 
	<div class="">
	<table  align='center' border='1' class='uk-table table table-bordered' id='table001'><?
	echo "<tr>";
	// echo $tab1_field_count = count($arrFields->__attributes['fields']);
	$colCount  =count($arrFields->__attributes['fields']);
	$colCount2 = 0;
	for($p = 0;$p<count($arrFields->__attributes['fields']);$p++){
	//print_r($arrFields->__attributes['fields'][$p]->__attributes);
//print_r($arrCal[$p]['app']['app_id']);echo "...";
		$type = $arrFields->__attributes['fields'][$p]->__attributes['type'];
		$width = "";
		if($arrFields->__attributes['fields'][$p]->__attributes['status'] != "active") 
		{
			$colCount--;
			continue;
		}
	// echo $type;
		if($type == "image" || $type == "" || $type == "" || $type == "embed")
		{
			$colCount--;
			continue;   
		}
		
		$desc = "";
		$colCount2++;
	 
		if($type=='date')
			{
				$desc = '';
				$colCount++;
				$width = "style='width:290px;'";
			}
		else
		if($type=='number')
			$desc = '';
		else
		if($type =='progress')
			$desc = '';
		else
		if($type=='duration')
			{
				$desc = '';
				$colCount++;
				$width = "style='width:204px;'";
			}
			 
		if($type =='progress' || $type=='number' || $type == "money" || $type == "calculation")
		$tabWidth = "5%";
		else
		if($type=='date' || $type=='duration')
		$tabWidth = "1%";
		else
		$tabWidth = "10%";
		/*width : <?echo $tabWidth;?>*/
		?><th style='color:#2c9eff;text-align: center;font-weight:normal;'><div <?echo $width;?>><?echo $arrFields->__attributes['fields'][$p]->__attributes['config']['label'].$desc;?></div></th><?
	}
	//echo "<td style='font-weight : bold; width : 7%;'>Action</td>";
	$tmpClass = "tooSmallTextPX2";
	$tmpClass2 = "tooSmallTextPX2";
	if($colCount <= 8)
	{
		$tmpClass = "LargeText";
		$tmpClass2 = "HalfText2";
	}
	else
	if($colCount <= 13)
		{
			$tmpClass = "LargeText";
			$tmpClass2 = "HalfText";
		}
	echo "</tr>";
	echo "<tr>";	 
	$k = 2;	 
	$j = 1; 
	$y = 2; //coded
	$appLoadCount = 0;
	$categoryLoadCount = 0;
	$contactLoadCount = 0;
	$stateLoadCount = 0;
	$arrTab	    = array();
	$arrTabMain = array();	

	


	// if($refId != ""){
		// $arrTabMain['field'][1] = $appId;
		// $arrTabMain['name'][1]  = $arrFieldsMain->__attributes['config']['name'];
 
		// for($x = 0;$x<(isset($arrCal[$x]['app']['app_id'])?count($arrCal[$x]['app']['app_id']):0);$x++){
			// $mainType = $arrCal[$x]['reference_field']['type'];
			// if($mainType == "app"){
				// $arrTabMain['field'][$y] = $arrCal[$x]['app']['app_id'];
				// $arrTabMain['name'][$y] = $arrCal[$x]['app']['name'];
				// $y++;
			// }
		// }
	// }else{
		// $arrTab['field'][1] = $appId;
		// $arrTab['name'][1]  = $arrFields->__attributes['config']['name'];
		// for($x = 0;$x<(isset($arrCal[$x]['app']['app_id'])?count($arrCal[$x]['app']['app_id']):0);$x++){
			// $mainType = $arrCal[$x]['reference_field']['type'];
			// if($mainType == "app"){
				// $arrTab['field'][$k] = $arrCal[$x]['app']['app_id'];
				// $arrTab['name'][$k] = $arrCal[$x]['app']['name'];
				// $k++;
			// }
		// }
	// }
	for($i = 0;$i<count($arrFields->__attributes['fields']);$i++)
	{
		//echo $arrFields->__attributes['fields']->humanized_value();
		if($arrFields->__attributes['fields'][$i]->__attributes['status'] != "active") continue;

		  $type = $arrFields->__attributes['fields'][$i]->__attributes['type'];
		  $required = (isset($arrFields->__attributes['fields'][$i]->__attributes['config']['required']) && $arrFields->__attributes['fields'][$i]->__attributes['config']['required'] == 1)?"required":"";
		 // echo $type;
		if($type == "image" || $type == "" || $type == "" || $type == "embed")	continue;?>   
		
		<input type="hidden" name="dtype[<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>]" value="<?echo $type;?>" />
		<?if($type == "app"){
			//if($appLoadCount == 0)
			{
			// echo $arrFields->__attributes['fields'][$i]->__attributes['field_id'];
				$arrFieldValues = $this->excel_model->topFieldValues($arrFields->__attributes['fields'][$i]->__attributes['field_id']);
				$arrRefItems[$arrFields->__attributes['fields'][$i]->__attributes['external_id']] = $arrFieldValues;
				// print_r($arrRefItems);echo "<br/><br/><br/><br/><br/>";
				// foreach($arrFieldValues as $row2)
				// print_r(PodioItem::get_references( $row2['item_id'] ));
				
			}
			$appLoadCount++;?>
			<td><?//print_r($arrFields);?>
				 
				<select class="chosen-select-no-results" multiple="multiple"  id="<?echo $arrFields->__attributes['fields'][$i]->__attributes['field_id'];?>_R1_<?echo $i;?>" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['field_id'];?>[][<?echo $i;?>]" onchange="javascript:changeBtnColor();" <?echo $required;?> ">
					
					<?foreach($arrFieldValues as $row){?>
						<option value="<?echo $row['item_id'];?>"><?echo $row['title'];?></option>
					<?}?>
				</select>
			 
				
			</td>
		<?}
		//echo $arrFields->__attributes['fields'][$i]->__attributes['config']['label'];
		if($type == "number"){?>
			<td>
					<input type="number"  onchange="javascript:changeBtnColor();" onkeypress="return numericOnly(event);" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>" <?echo $required;?>  class='LargeText'/>
			</td>
		<?}
		else
		if($type == "date"){?>
			<td>
					Start&nbsp;<input type="date" readonly  onchange="javascript:changeBtnColor();" onblur="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" id="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>_1" <?echo $required;?>  class='SmallText2PX'/>
					End&nbsp;<input type="date" readonly  onchange="javascript:changeBtnColor();" onblur="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" id="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>_2" <?//echo $required;?>  class='SmallText2PX'/>
			</td>
				<script type="text/javascript">
					$(function(){
						$('*[id=<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>_1]').appendDtpicker({
								"closeOnSelected": true
						});
					});
					
				$(function(){
						$('*[id=<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>_2]').appendDtpicker({
								"closeOnSelected": true
						});
					});
					
				</script>
		<?}else
		if($type == "progress" || $type == "money"){?>
			<td>
					<input type="number"  onchange="javascript:changeBtnColor();" onkeypress="return numericOnly(event);" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>" <?echo $required;?>  class='<?echo $tmpClass;?>'/>
			</td>
		
		<?}
		else
		if($type == "duration")
		{
		?>
			<td>
					Hr&nbsp;<input type="number"  onchange="javascript:changeBtnColor();" onkeypress="return numericOnly(event);" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" <?echo $required;?>  class='tooSmallTextPX'/>
					Min&nbsp;<input type="number"  onchange="javascript:changeBtnColor();" onkeypress="return numericOnly(event);" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" <?echo $required;?>  class='tooSmallTextPX'/>
					Sec&nbsp;<input type="number"  onchange="javascript:changeBtnColor();" onkeypress="return numericOnly(event);" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" <?echo $required;?>  class='tooSmallTextPX'/>
			</td>
		<?	
		}else
		if($type == "calculation")
		{
			?>
			<td>
				<input type="text" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>" <?echo $required;?>  class='uk-form-danger <?echo $tmpClass;?>' readonly onchange="javascript:changeBtnColor();" />
			</td>
			<?
		}
		else
		if($type == "location"  || $type == "text"){?>
			<td>
				<input type="text"  onchange="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>" <?echo $required;?>  class='<?echo $tmpClass;?>'/>
			</td>
				
		<?}else	if($type == "category"){
			//if($categoryLoadCount == 0)
			{
				$categories = $this->excel_model->retrieveOptions($arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['options']);
				 
			}
			$categoryLoadCount++;
			$mul = "";
			$mulArr = "";
			//print_r($arrFields->__attributes['fields'][$i]->__attributes['config']['settings']);
			$mulArr = isset($arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['multiple'])?$arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['multiple']:"";
			if(isset($mulArr) && $mulArr == 1)	$mul = "multiple='multiple'";
	
			$arrCategoryMainValues[$arrFields->__attributes['fields'][$i]->__attributes['config']['label']] = $categories;?>
			<td>
			 
				<select <?echo $mul;?> <?echo $mul != ""?"":"";?> class="chosen-select-no-results" onchange="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" <?echo $required;?>   id="<?echo $arrFields->__attributes['fields'][$i]->__attributes['field_id'];?>_R1_<?echo $i;?>">
					<?if($mul == ""){?><option value="">[Select]</option><?}?>
					<?foreach($categories as $cat){?>
						<option value="<?echo $cat['id'];?>"><?echo $cat['text'];?></option>
					<?}?>
				</select>
				 
			</td>
		<?}else if($type == "contact"){
			//if($contactLoadCount == 0)
			{
				$arrConType = $arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['valid_types'];
				$myContacts = array();
				$myContacts = $this->excel_model->loadAllContacts($arrConType);
				$arrContactMainValues[$arrFields->__attributes['fields'][$i]->__attributes['external_id']] = $myContacts;
			}
		 
			$contactLoadCount++;?>
			<td> 
				<select  class="chosen-select-no-results LargeText" multiple='multiple'  onchange="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" <?echo $required;?> id="<?echo $arrFields->__attributes['fields'][$i]->__attributes['field_id'];?>_R1_<?echo $i;?>">
					<?/*?><option value="">[Select]</option><?*/?>
					<?foreach($myContacts as $contact){?>
						<option value='<?echo $contact['profile_id'];?>'><?echo $contact['name'];?></option>
					<?}?>
				</select>
			 
			 
				 
			</td>
		<?}else if($type == "state"){

			$stateLoadCount++;
			//echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];
			$field_id = $arrFields->__attributes['fields'][$i]->__attributes['field_id'];
			$stateValues = $this->excel_model->getStateValues($field_id,$arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['allowed_values']);
			$stateValuesArray[$arrFields->__attributes['fields'][$i]->__attributes['external_id']] = $stateValues;?>
			<td>
				<select  onchange="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>" <?echo $required;?> class="chosen-select-no-results">
					<?foreach($stateValues as $states){?>
						<option value='<?echo $states['value'];?>'><?echo $states['value'];?></option>
					<?}?>
				</select>
			</td>
		<?}else if($type == "question")	{
		//print_r($_POST);	
			$field_id = $arrFields->__attributes['fields'][$i]->__attributes['field_id'];
			$answerValues = $this->excel_model->getQuestionAsnwers($field_id,$arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['options']);
			$answerValuesArray[$arrFields->__attributes['fields'][$i]->__attributes['external_id']] = $answerValues;
			$mul = "";
			$mulArr = "";
			//print_r($arrFields->__attributes['fields'][$i]->__attributes['config']['settings']);
			$mulArr = isset($arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['multiple'])?$arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['multiple']:"";
			if(isset($mulArr) && $mulArr == 1)	$mul = "multiple";?>
			 <td>
				<select <?echo $mul;?> <?echo $mul != ""?"":"";?> class="chosen-select-no-results" onchange="javascript:changeBtnColor();" name="<?echo $arrFields->__attributes['fields'][$i]->__attributes['external_id'];?>[]" <?echo $required;?> id="<?echo $arrFields->__attributes['fields'][$i]->__attributes['field_id'];?>_R1_<?echo $i;?>">
					<?if($mul == ""){?><option value="">[Select]</option><?}?>
					<?foreach($answerValues as $answers){?>
						<option value='<?echo $answers['id'];?>'><?echo $answers['value'];?></option>
					<?}?>
				</select>
			 
			 </td><?
		} //if($i==0) break;
	}/*?>
	<div style="margin-left: 0px; color: rgb(255, 0, 0); font-size: 15px; border-bottom-width: 0px; margin-bottom: 12px; margin-top: 0px;">
		<?if(isset($error) && isset($error_description)){			//display error
			echo "There was an error. The API responded with the error type ".$error." and the mesage ".$error_description.".";
		}?>
	</div>

	<div style="margin-left: 0px; color: green; font-size: 15px; border-bottom-width: 0px; margin-bottom: 12px; margin-top: 0px;">
		<?if(isset($success)){			//display message
			echo $success;
		}?>
	</div><?*/
	
	// try
	// {
		// $space_id = $this->session->userdata('space_id');
		// $arrSpceRel = PodioApp::dependencies_space($space_id);
	// }
	// catch (PodioError $e) {
		// header('Location:'.site_url('index'));
	// }

	?>
	<div class="uk-grid" data-uk-grid-margin>
		 
		<div class="uk-width-medium-1-2">
			<ul class="uk-tab" data-uk-tab="" style="width: 200%;">
				<? 
					try
					{
						$space_id = $this->session->userdata('space_id');
						$arrSpceRel = PodioApp::dependencies_space($space_id);
						// var_dump($arrSpceRel);
						
					}
					catch (PodioError $e) 
					{
						//echo $e->body['error_description'];
					//	header('Location:'.site_url('index'));
					}
					$selTab  = "";
					/*
					$arrTabList = $this->excel_model->getRatedApps($arrSpceRel,$appId);
					for($j = 0;$j<count($arrSpceRel);$j++)
					{
						$class = "";
						if(!in_array($arrSpceRel[$j]->__attributes['app_id'],$arrTabList))
						continue;
						if($arrSpceRel[$j]->__attributes['app_id'] == $refId)
						{
							$selTab = $arrSpceRel[$j]->__attributes['name'];
							$class="class='uk-active'";
						}
						else
						if($arrSpceRel[$j]->__attributes['app_id'] == $appId && $refId == "")
						{
							$selTab = $arrSpceRel[$j]->__attributes['name'];
							$class="class='uk-active'";
						}

							$tab =$arrSpceRel[$j]->__attributes['name'];
						?> 
						<li <?echo $class;?>  id="tabs<?echo $j?>"><a onclick="displayTab(<?echo $j?>, <?echo $appId;?>, <?echo $arrSpceRel[$j]->__attributes['app_id'];?>);" href="#"><?echo $tab;?></a></li>
						<?
					}*/
					//$this->excel_model->getRatedApps($arrSpceRel,$selTab);

				?>
			</ul>
		</div>
	</div>
	 <?	//uk-button uk-button-danger
	echo "</tr>";
	echo "</table>";
	?>
		<br/>
		<div style="margin:auto;text-align:center;">
			<input type="submit"  onclick="javascript:save2Podio(<?echo $appId;?>)" title="" data-uk-tooltip="{pos:'Create <?echo $selTab;?>'}" class="uk-button uk-button-success" value= "Create <?echo $selTab;?>" id="btn001" data-cached-title="Click to save" style="text-align:center;">
			<input type="button" onclick="javascript:refresh()" class="uk-button uk-button-success" value= "Refresh <?echo $selTab;?>" id="btn003" style="text-align:center;">

		</div>
 
	
	</form>
	<form class="uk-form uk-margin" style="margin:0px;" onsubmit="return false;" method="POST" action="" name="formExcel2" action="">
		<input type="hidden" name="frmAction" value=""/>
		 
	<?
 

 
	try
	{
		$numrows = 0;
		if($refId != "")
		{
			$numrows = PodioItem::get_count( $refId );
		}
		else
		{
			$numrows = PodioItem::get_count( $appId );
		}
	}
	catch (PodioError $e) {
	?>
		<div style="margin-left: 0px; border-bottom-width: 0px; margin-top: 0px; text-align:center;" class="uk-form-danger">
			<?echo $e->body['error_description'];?>. <a href="<?echo site_url('reset_token');?>">click here</a> to update your api settings
		</div>
	<?
		return $e->body['error']."##@##".$e->body['error_description'];
	}
 // print_r($ItemCountArray);exit;
	$per_page	=  $this->recs_per_page==""?5:(int)$this->recs_per_page;
	$page 		= isset($_GET['page'])?$_GET['page']:1;
	$offset 	= ($page - 1) * $per_page;
	// $numrows 	= count($ItemCountArray['items']);
	
	$adjacents  	= 3; //gap between pages after number of adjacents
	$total_pages    = ceil($numrows/$per_page);
	$contentsArr = "<table border='1'><tr><td style='text-align:center;font-weight:bold;' colspan='".($colCount2-2)."'>".$selTab."</td></tr><tr>";
	
		if(($appId == $refId || $refId == "" )&& $this->session->userdata('view_id') != "")
		{
			$view_id = $this->session->userdata('view_id');
			$ItemIdArray = PodioItem::filter_by_view($appId,$view_id,$attributes = array("limit"=> $per_page, "offset"=> $offset));
			$ItemIdArray2 = (Array)PodioApp::get($appId,$attributes = array("limit"=> 1));
		}
		else{
			if($refId != "")
				{
					$ItemIdArray 	= PodioItem::filter($refId,$attributes = array("limit"=> $per_page, "offset"=> $offset));
					$ItemIdArray2 = (Array)PodioApp::get($refId,$attributes = array("limit"=> 1));
				}
			else
				{
					$ItemIdArray 	= PodioItem::filter($appId,$attributes = array("limit"=> $per_page, "offset"=> $offset));
					$ItemIdArray2 = (Array)PodioApp::get($appId,$attributes = array("limit"=> 1));
				}
		}
		
				
			
				$x = 0;
				 $arrFieldType = array(); $arrFieldExtId = array();$arrMulField = array();
				foreach($ItemIdArray2['__attributes']['fields'] as $field){
					 
					if($field->__attributes['config']['visible'] != "1")continue;
					if($field->__attributes["type"] == "embed" || $field->__attributes["type"] == "") continue;
					$tempFieldArray[$field->__attributes['config']["label"]] = $field->__attributes['config']["label"];
					$tempTypeArray[$field->__attributes['config']["label"]]  = $field->__attributes["type"];
					$tempExtArray[$field->__attributes['config']["label"]]   = $field->__attributes["external_id"];
					
					$maxfieldArray[$x]    = $field->__attributes['config']["label"];	
					$arrFieldType[$x] = $field->__attributes['type'];
					$arrFieldExtId[$x] = $field->__attributes['external_id'];
					$arrMulField[$x] = isset($field->__attributes['config']['settings']['multiple'])?$field->__attributes['config']['settings']['multiple']:"";
					$x++;
				}
		
	 
		
	
		 echo "<div align='center'><div id='loading4'></div></div>";
		
		 echo "<div class='' style='min-height:350px;'>";
		  ?>
		<table  align='center' border='1' class='uk-table table table-bordered' id='table002'>
		 <?
	 $ItemDetailArray = array();
	 $result = array();
	 /*--------------	New Code for reduct cals -------------------*/
	 $c=0; 
	  $ItemArray	=	array();
		 foreach($ItemIdArray["items"] as $Item){
				$ItemArray[] = $Item->__attributes["item_id"];
				foreach($Item->__attributes['fields'] as $test2)
					{

							$result[$c][$test2->__attributes["label"]]	=	$test2->humanized_value();
							// $ItemArray[]	  = $ItemId;
					}$c++; 
		}
		// print_r($ItemArray);exit;
		
		// print_r($result);exit;
		
		
	/*--------------	New Code for reduct cals -------------------*/
	 if(count($ItemIdArray) > 0)
	 {

		 $maxArrayValue	=	0;	
		 	 /*Extra Code */
		foreach($tempFieldArray as $labels)
		{
			if (in_array($labels, $maxfieldArray))continue;
			
			$maxfieldArray[$x]    = $tempFieldArray[$labels];
			$arrFieldType[$x] = $tempTypeArray[$labels];
			$arrFieldExtId[$x] = $tempExtArray[$labels];
			$x++;
		}
		//print_r($tempFieldArray);
		/**/
		 
		 echo "<tr>";
		?><th  width='1%' style="display:none;">&nbsp;</th><?
		 $y = -1;
		 if(!isset($maxfieldArray)){
			echo "No Items found!";exit;
		 }
		 foreach($maxfieldArray as $maxfield){
			$y++; 
			
			if($arrFieldType[$y] == "" || $arrFieldType[$y] == "image" || $arrFieldType[$y] == ""){continue;}
			$contentsArr .= "<td style='font-weight:bold;'>".$maxfield."</td>";
		$desc = "";
		// echo $arrFieldType[$y];
		$tmpStyle="";
		if($arrFieldType[$y]=='date')
			{
				$desc = '';
				$tmpStyle="style='width:290px;'";
			}
		else
		if($arrFieldType[$y]=='number')
		$desc = '';
		else
		if($arrFieldType[$y]=='progress')
		$desc = '';
		else
		if($arrFieldType[$y]=='duration')
		{
			$desc = '';
		}
		if($arrFieldType[$y] =='progress' || $arrFieldType[$y]=='number' || $arrFieldType[$y] == "money" || $arrFieldType[$y] == "calculation")
		$tabWidth = "2%";
		else
		if($arrFieldType[$y] =='date')
		{
			$tabWidth = "1%";
			$tmpStyle="style='width:290px;'";
		}
		else
		if($arrFieldType[$y]=='duration')
		{
			$tabWidth = "1%";
			$tmpStyle="style='width:204px;'";
		}
		else
		$tabWidth = "10%";
		/*width : <?echo $tabWidth;?>*/
		  	?><th style='color:#2c9eff;text-align: center;font-weight:normal;'><div <?echo $tmpStyle;?>><?echo $maxfield.$desc;?></div></th><?
		 }
		
		$contentsArr .= "</tr><tr>";
		 echo "</tr>"; 
		 
		 $i=0; 
		 //$arrRefItems = array();
		 $myContacts = array();
		 // print_r($result);
		 foreach($result as $res){
			 echo "<tr>";
		
			 	?><td style="display:none;">
				<input type="checkbox" name="item_id[<?echo $i;?>]" id="checkbox_<?echo $i;?>" value="<?echo $ItemArray[$i];?>"/></td>
				 <?
		
		
			 for($j=0;$j<count($maxfieldArray);$j++){ 
				
				if($arrFieldType[$j] == "" || $arrFieldType[$j] == "image"|| $arrFieldType[$j] == "") continue;
				//if($arrFields->__attributes['fields'][$i]->__attributes['status'] != "active") continue;
				 
			 	if($i == 0){
				   // $arrRefItems[$maxfieldArray[$j]] = $this->excel_model->retrieveRelatedAppItems($appId,$maxfieldArray[$j]);
					// echo $maxfieldArray[$j];
					// print_r($arrFields->__attributes['fields'][$i]->__attributes);
					// $arrConType = $arrFields->__attributes['fields'][$i]->__attributes['config']['settings']['valid_types'];
				   // $myContacts = array();
				   // $myContacts = $this->excel_model->loadAllContacts($arrConType);
				   $type2 = $arrFields->__attributes['fields'][$j]->__attributes['type'];
				   //var_dump($arrFields->__attributes['fields'][$j]);
					?>   
						<input type="hidden" name="dtype[]" value="<?echo $arrFieldType[$j];?>" />
					<?
				}
				
				if(isset($res[$maxfieldArray[$j]])){
					if(strlen($res[$maxfieldArray[$j]])>50){
		                            $post = $res[$maxfieldArray[$j]];
		                            $post = $post;
		                        }
		                        else	$post = isset($res[$maxfieldArray[$j]])?$res[$maxfieldArray[$j]]:"";
				}else		$post= "";
								
				if($arrFieldType[$j] == "money")
				{
 
					if(is_numeric(substr($post, 0,1)))
							 $post = (float)trim($post);
						else
							 $post = (float)trim(substr($post, 3));
				?><td><input type='text' name="<?echo $arrFieldExtId[$j];?>[]" value="<?echo $post;?>" onkeypress="return numericOnly(event);"class='LargeText' onchange="activateCheckBox(<?echo $i;?>)"/></td><?
				}
				else
				if($arrFieldType[$j] == "number"){
				?><td><input type='number' name="<?echo $arrFieldExtId[$j];?>[]" onkeypress="return numericOnly(event);" value="<?echo $post;?>" class='LargeText' onchange="activateCheckBox(<?echo $i;?>)"/></td><?}
				else
				if($arrFieldType[$j] == "progress")
				{
					$lastChar = substr($post,strlen($post)-1,strlen($post));
					if(!is_numeric($lastChar))
						  $post = substr($post, 0, -1);
					?><td><input type='number' name="<?echo $arrFieldExtId[$j];?>[]" onkeypress="return numericOnly(event);" value="<?echo $post;?>" class='LargeText' onchange="activateCheckBox(<?echo $i;?>)"/></td><?
				}else
				if($arrFieldType[$j] == "date")
				{
					$arrDates = explode(" - ",$post);
					$post1 = "";
					$post2 = "";
					if(isset($arrDates[0]) && isset($arrDates[1]))
					{
						$post1 = $arrDates[0];
						$post2 = $arrDates[1];
					}else
					if(isset($arrDates[0]))
					{
						$post1 = $arrDates[0];
						$arrDate1 = explode(" ",$post1);
						if(isset($arrDate1[1]) && $arrDate1[1]!="")
						{
							$arrTimes = explode("-",$arrDate1[1]);
							if(isset($arrTimes[0]) && $arrTimes[0] != ""){
								$post1 = $arrDate1[0] ." ". $arrTimes[0];
							}
							if(isset($arrTimes[1]) && $arrTimes[1] != ""){
								$post2 = $arrDate1[0] ." ". $arrTimes[1];
							}
						}
					}
					
					?><td>
					Start&nbsp;<input type='text' readonly name="<?echo $arrFieldExtId[$j];?>[]" value="<?echo $post1;?>" class='SmallText2PX' id="<?echo $arrFieldExtId[$j].'_'.$i;?>_1" onchange="activateCheckBox(<?echo $i;?>)" onblur="activateCheckBox(<?echo $i;?>)"/>
					End&nbsp;<input type='text' readonly name="<?echo $arrFieldExtId[$j];?>[]" value="<?echo $post2;?>" class='SmallText2PX' id="<?echo $arrFieldExtId[$j].'_'.$i;?>_2" onchange="activateCheckBox(<?echo $i;?>)" onblur="activateCheckBox(<?echo $i;?>)"/>
					</td>
					<script type="text/javascript">
					$(function(){
						$('*[id=<?echo $arrFieldExtId[$j].'_'.$i;?>_1]').appendDtpicker({
								"closeOnSelected": true
						});
					});
					
				$(function(){
						$('*[id=<?echo $arrFieldExtId[$j].'_'.$i;?>_2]').appendDtpicker({
								"closeOnSelected": true
						});
					});
					
				</script>
				
				<?
				}
				else
				if($arrFieldType[$j] == "location" || $arrFieldType[$j] == "text"){
					?><td><input type='text' name="<?echo $arrFieldExtId[$j];?>[]" value="<?echo $post;?>" class='<?echo $tmpClass;?>' onchange="activateCheckBox(<?echo $i;?>)"/></td><?}
 
			else if($arrFieldType[$j] == "calculation"){
					?><td><input type='text' name="<?echo $arrFieldExtId[$j];?>[]"  value="<?echo $post;?>"  class='uk-form-danger <?echo $tmpClass;?>' readonly onchange="activateCheckBox(<?echo $i;?>)"/></td><?}
				else
				if($arrFieldType[$j] == "duration"){
					if($post != "")
					$currentTime = gmdate("H:i:s", $post);
					else
					$currentTime = "";	
					$tmpTime = explode(":",$currentTime);
					$hr = isset($tmpTime[0])?$tmpTime[0]:"";
					$min = isset($tmpTime[1])?$tmpTime[1]:"";
					$sec = isset($tmpTime[2])?$tmpTime[2]:"";
					$contentsArr .= "<td>".$currentTime."</td>";
				?><td>
					Hr&nbsp;<input type='text' name="<?echo $arrFieldExtId[$j];?>[]"  value="<?echo $hr;?>"  onkeypress="return numericOnly(event);" class='tooSmallTextPX' onchange="activateCheckBox(<?echo $i;?>)"/>
					Min&nbsp;<input type='text' name="<?echo $arrFieldExtId[$j];?>[]"  value="<?echo $min;?>"  onkeypress="return numericOnly(event);" class='tooSmallTextPX' onchange="activateCheckBox(<?echo $i;?>)"/>
					Sec&nbsp;<input type='text' name="<?echo $arrFieldExtId[$j];?>[]"  value="<?echo $sec;?>"  onkeypress="return numericOnly(event);" class='tooSmallTextPX' onchange="activateCheckBox(<?echo $i;?>)"/>
					 
				</td><?}
				else if($arrFieldType[$j] == "app"){
					$arrItems = array();
					$arrItems2= array();
					$arrItems = explode(";",trim($post));
					foreach($arrItems as $itemTrm){
					 
					$arrItems2[] = trim($itemTrm);
					
					}
					// print_r($arrItems2);echo "<br/><br/><br/><br/><br/>";?>
				<td>
						<select multiple name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]"  id="<?echo $arrFieldExtId[$j];?>_<?echo $i;?>" onchange="activateCheckBox(<?echo $i;?>)" class="chosen-select-no-results">
							<option value="HID_ESC_CHK" selected style="display:none;"></option>
							<?
							foreach($arrRefItems[$arrFieldExtId[$j]] as $row){?>
								<option value='<?echo $row['item_id'];?>' <?echo (isset($arrItems2) && in_array(trim($row['title']), $arrItems2))?'selected class="ui-corner-all ui-state-hover"':'';?>><?echo $row['title'];?></option>
								
							<?
							}?>
						</select> 
					 
						<!--<div class="multiselect <?echo $tmpClass;?>">	
							<input checked name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" value ="HID_ESC_CHK" style="display:none;"/>
							<?$c = 0;foreach($arrRefItems[$arrFieldExtId[$j]] as $row){?>
							<label onclick="javascript:markAsSelected('<?echo $row['item_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" <?echo (isset($arrItems2) && in_array(trim($row['title']), $arrItems2))?'class="multiselect-on"':'';?> for="<?echo $row['item_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>" id="<?echo $row['item_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>_lab">
								<input id="<?echo $row['item_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>" type="checkbox" value="<?echo $row['item_id'];?>" <?echo (isset($arrItems2) && in_array(trim($row['title']), $arrItems2))?'checked':'';?> name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" onclick="javascript:markAsSelected('<?echo $row['item_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)"><?echo $row['title'];?>
							</label>
						<?	$c++; 	}?>
						</div>-->
					</td>
				<?}else if($arrFieldType[$j] == "contact"){
					$arrItems = array();
					$arrItems2= array();
					$arrItems = explode(";",trim($post));
					foreach($arrItems as $itemTrm)
					$arrItems2[] = trim($itemTrm);?>
					<td>
					 	<select multiple name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" id="<?echo $arrFieldExtId[$j];?>_<?echo $i;?>" onchange="activateCheckBox(<?echo $i;?>)" class="chosen-select-no-results LargeText">
							<option value="HID_ESC_CHK" selected style="display:none;"></option>
							<?foreach($arrContactMainValues[$arrFieldExtId[$j]] as $contact){?>
								<option value='<?echo $contact['profile_id'];?>' <?echo (isset($arrItems2) && in_array(trim($contact['name']), $arrItems2))?'selected class="ui-corner-all ui-state-hover"':'';?> ><?echo $contact['name'];?></option>
							<?}?>
						</select>  
						 
						
						<!--<div class="multiselect <?echo $tmpClass;?>">					
							<input checked name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" value ="HID_ESC_CHK" style="display:none;"/>
							<?$c = 0;
							 
							foreach($arrContactMainValues[$arrFieldExtId[$j]] as $contact){?>
							<label onclick="javascript:markAsSelected('<?echo $contact['profile_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" <?echo (isset($arrItems2) && in_array(trim($contact['name']), $arrItems2))?'class="multiselect-on"':'';?> id="<?echo $contact['profile_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>_lab" for="<?echo $contact['profile_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>">
								<input onclick="javascript:markAsSelected('<?echo $contact['profile_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" id="<?echo $contact['profile_id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>" type="checkbox" value="<?echo $contact['profile_id'];?>" <?echo (isset($arrItems2) && in_array(trim($contact['name']), $arrItems2))?'checked':'';?> name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]"><?echo $contact['name'];?>
							</label>
						<?	$c++; 	}?>
						</div>-->
						
					</td>
				<?}elseif($arrFieldType[$j] == "category"){
					$arrItems = array();
					$arrItems2= array();
					$arrItems = explode(";",trim($post));
					foreach($arrItems as $itemTrm)
					$arrItems2[] = trim($itemTrm);
				//echo $arrFields->__attributes['fields'][$j]->__attributes['config']['label'];
				$mul = "";
				$mulArr = "";
				//print_r($field->__attributes['config']['settings']);
				$mulArr = $arrMulField[$j];
				if(isset($mulArr) && $mulArr == 1)	$mul = "multiple";?>
					<td>
						<?if($mul=="multiple"){?>
							<!--<div class="multiselect <?echo $tmpClass;?>">	
							<input checked name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" value ="HID_ESC_CHK" style="display:none;"/>							
								<?$c = 0;


								foreach($arrCategoryMainValues[$maxfieldArray[$j]] as $catg){?>
								<label onclick="javascript:markAsSelected('<?echo $catg['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" <?echo (isset($arrItems2) && in_array(trim($catg['text']), $arrItems2))?'class="multiselect-on"':'';?> id="<?echo $catg['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>_lab" for="<?echo $catg['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>">
									<input onclick="javascript:markAsSelected('<?echo $catg['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" id="<?echo $catg['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>" type="checkbox" value="<?echo $catg['id'];?>" <?echo (isset($arrItems2) && in_array(trim($catg['text']), $arrItems2))?'checked':'';?> name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]"><?echo $catg['text'];?>
								</label>
								<?$c++;}?>
							</div>-->
						<?}?>
							<select class="chosen-select-no-results" <?echo $mul;?> <?echo $mul != ""?"":"";?> id="<?echo $arrFieldExtId[$j];?>_<?echo $i;?>" name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" onchange="activateCheckBox(<?echo $i;?>)" >
								<option value="">[Select]</option>
								<option value="HID_ESC_CHK" selected style="display:none;"></option>
								<?foreach($arrCategoryMainValues[$maxfieldArray[$j]] as $row){?>
									<option value="<?echo $row['id'];?>" <?echo $post==$row['text']?'selected':'';?>><?echo $row['text'];?></option>
								<?}?>
							</select>
							 
					</td>
				<?}else	if($arrFieldType[$j] == "state"){
		 
					$field_id = $arrFields->__attributes['fields'][$j]->__attributes['field_id'];
					   
					// print_r($stateValuesArray[$arrFields->__attributes['fields'][$j]->__attributes['external_id']]);
			
					//$required = (isset($arrFields->__attributes['fields'][$i]->__attributes['config']['required']) && $arrFields->__attributes['fields'][$i]->__attributes['config']['required'] == 1)?"required":"";?>
					<td><?//print_r($stateValuesArray[$arrFieldExtId[$j]]);?>
						<select name="<?echo $arrFieldExtId[$j];?>" <?echo $required;?> class="chosen-select-no-results" onchange="activateCheckBox(<?echo $i;?>)">
							<option value="">[Select]</option>
							<?foreach($stateValuesArray[$arrFieldExtId[$j]] as $states){?>
								<option value='<?echo $states['value'];?>' <?echo $post==$states['value']?'selected':'';?>><?echo $states['value'];?></option>
							<?}?>
						</select>
						
					</td>
				<?}else if($arrFieldType[$j] == "question"){
					$arrItems = array();
					$arrItems2= array();
					$arrItems = explode(";",trim($post));
					foreach($arrItems as $itemTrm)
					$arrItems2[] = trim($itemTrm);
					$mul = "";
					$mulArr = "";
					//print_r($arrFields->__attributes['fields'][$j]->__attributes['config']['settings']);
					$mulArr = isset($arrMulField[$j])?$arrMulField[$j]:"";
					if(isset($mulArr) && $mulArr == 1)	$mul = "multiple";?>
					<td style="text-align:left;">
						<?if($mul=="multiple"){?>
							<!--<div class="multiselect <?echo $tmpClass;?>">	
								<input checked name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" value ="HID_ESC_CHK" style="display:none;"/>
								<?$c = 0;
								foreach($answerValuesArray[$arrFieldExtId[$j]] as $answer){?>
								<label onclick="javascript:markAsSelected('<?echo $answer['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" <?echo (isset($arrItems2) && in_array(trim($answer['value']), $arrItems2))?'class="multiselect-on"':'';?> id="<?echo $answer['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>_lab" for="<?echo $answer['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>">
									<input onclick="javascript:markAsSelected('<?echo $answer['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>',<?echo $i;?>)" id="<?echo $answer['id'];?>_<?echo $arrFieldExtId[$j];?>_<?echo $i;?>_<?echo $c;?>" type="checkbox" value="<?echo $answer['id'];?>" <?echo (isset($arrItems2) && in_array(trim($answer['value']), $arrItems2))?'checked':'';?> name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]"><?echo $answer['value'];?>
								</label>
								<?$c++;}?>
							</div>-->
						<?}else{?>
							
						<?}?>
						<select class="chosen-select-no-results" <?echo $mul;?> <?echo $mul != ""?" ":"";?> id="<?echo $arrFieldExtId[$j];?>_<?echo $i;?>" name="<?echo $arrFieldExtId[$j];?>[<?echo $i;?>][]" <?echo $required;?> class="<?echo $tmpClass;?>" onchange="activateCheckBox(<?echo $i;?>)">
								<option value="">[Select]</option>
								<option value="HID_ESC_CHK" selected style="display:none;"></option>
								<?foreach($answerValuesArray[$arrFieldExtId[$j]] as $answer){?>
									<option value='<?echo $answer['id'];?>' <?echo $post==$answer['value']?'selected':'';?>><?echo $answer['value'];?></option>
								<?}?>
							</select>
						 
					</td><?
				}else		echo  "<td>",$post.$arrFieldType[$j]."</td>";
					if($arrFieldType[$j] != "duration"){
						$contentsArr .= "<td>".$post."</td>";
					}	
					 				
			  }
			  	$contentsArr .= "</tr><tr>";
			  echo "</tr>";
			  $i++;  
		 }
	 }else{
		 echo "No Items found!";
	 }
	 echo "</table><br/>";
	 if(isset($result) && count($result)>0)
	 {
		?>
		
		<div style="margin: auto;text-align: right; width: 80%;">
			<div style="width:25%;margin:auto;text-align:center;">
					 <select name="recs_per_page" style="float:left;margin-right:4px;">
						<option value="5" <?echo $this->recs_per_page == "5"?"selected":"";?>>5</option>
						<option value="10" <?echo $this->recs_per_page == "10"?"selected":"";?>>10</option>
						<option value="15" <?echo $this->recs_per_page == "15"?"selected":"";?>>15</option>
						<option value="20" <?echo $this->recs_per_page == "20"?"selected":"";?>>20</option>
						<option value="25" <?echo $this->recs_per_page == "25"?"selected":"";?>>25</option>
						<option value="50" <?echo $this->recs_per_page == "50"?"selected":"";?>>50</option>
					</select>
					<input type="button" onclick="javascript:reLoad()" id="btn004" class="uk-button uk-button-success" value= "Go" style="float:left;margin-right:4px;">
					
			</div>
			<div style="width:25%;margin:auto;">
				<?$this->excel_model->numlinks($page , $total_pages, $offset, '', '');?>
			</div>
			<br/>
			<div style="width:50%;margin:auto;;text-align:center;">
			<input type="submit" onclick="javascript:update2Podio(<?echo $per_page;?>)" title="" data-uk-tooltip="{pos:'Update <?echo $selTab;?>'}" class="uk-button uk-button-success" value= "Update <?echo $selTab;?>" id="btn002" data-cached-title="Click to Update">
			<input type="submit" onclick="javascript:export2Podio()" title="" data-uk-tooltip="{pos:'export <?echo $selTab;?>'}" class="uk-button uk-button-success" value= "Export <?echo $selTab;?>" id="btn005" data-cached-title="Click to Export">
			<input type="submit" onclick="javascript:export2Google()" title="" data-uk-tooltip="{pos:'export <?echo $selTab;?> to GDrive'}" class="uk-button uk-button-success" value= "Export <?echo $selTab;?> to GDrive" id="btn006" data-cached-title="Click to Export">
			</div>
		</div>
		
		<br/>
	
		
		<?
		
	 }else{
			?>
			<div style="margin: auto;text-align: center; width: 50%;">
				No Items found!
			</div><?
	 }?>
	 <br/><?echo "</div>";?>
 	 </div>
	
</form>
</div>
</div>
</div>
</div>
	<script src="<? echo base_url();?>briefcase/js/drag1/store.js"></script>
	<script src="<? echo base_url();?>briefcase/js/drag1/jquery.resizableColumns.min.js"></script>
	<link rel="stylesheet" href="<? echo base_url();?>briefcase/css/drag1/bootstrap-responsive.css">
	<link rel="stylesheet" href="<? echo base_url();?>briefcase/css/drag1/jquery.resizableColumns.css">
   <script type="text/javascript">
        $(function(){
          $("table").resizableColumns({
            store: store
          });
		 
        });
		      
	 
      </script>
 	<script type="text/javascript">
		 
		$(function()
		{
			$('.scroll-pane').jScrollPane();
		});
	</script>
<? $this->load->view('footer'); ?>
  <script type="text/javascript">
    var config = {
 
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
  <?

  if($this->exportAction!="" && $this->exportAction == "EXPORT_PODIO"){
$this->excel_model->exportCSV($contentsArr,$selTab);
}else
if($this->exportAction!="" && $this->exportAction == "EXPORT_GOOGLE")
{
$this->excel_model->export2Gdrive($contentsArr,$selTab);	
}?>