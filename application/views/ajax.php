<?php
 
	$orgId=  isset($_GET["orgId"])?$_GET["orgId"]:"0";
	$space_id=  isset($_GET["space_id"])?$_GET["space_id"]:"0";
	$app_id=  isset($_GET["app_id"])?$_GET["app_id"]:"0";
	$ajxaction=  isset($_GET["ajxaction"])?$_GET["ajxaction"]:"";
	
	$this->load->view('podio_includes');
	$this->load->model('home_model');
	 
	if($ajxaction == "GET_WORKSPACE")
	{
		try
		{
			$workSpaces = $this->home_model->retrieveWorkSpace($orgId);
		}
		catch (PodioError $e) {
			$workSpaces = array();
		}
		$returnResult = "<select id='workspace' class='mediumText' required name='workspace' onchange='loadSpaceApps(this.value)'>
							<option value=''>[Select WorkSpace]</option>"; 
		foreach($workSpaces as $row)
		{
			$returnResult .= "<option value=".$row['id'].">".$row['name']."</option>";
		}
		$returnResult .= "</select>";
		echo $returnResult;
	}
	else
	if($ajxaction == "GET_SPACE_APPS")
	{  
		try
		{
			$this->session->set_userdata('space_id', $space_id);
			$spaceApps = $this->home_model->retrieveApps($space_id);
		}
		catch (PodioError $e) {
			$spaceApps = array();
		}
		$returnResult = "<select id='space_apps' class='mediumText' required name='space_apps' onchange='loadViews(this.value)'>
							<option value=''>[Select Application]</option>"; 
		foreach($spaceApps as $row)
		{
		 $returnResult .= "<option value=".$row['id'].">".$row['name']."</option>";
		}
		$returnResult .= "</select>";
		echo $returnResult;

	} 
	else
	if($ajxaction == "GET_APP_VIEWS")
	{ 
		try
		{
			$arrViews = $this->home_model->retrieveViews($app_id);
		}
		catch (PodioError $e) {
			$spaceApps = array();
		}
		$returnResult = "<select id='view_apps' class='mediumText' name='view_apps'>
							<option value=''>[Select View]</option>"; 
		foreach($arrViews as $row)
		{
		 $returnResult .= "<option value=".$row['view_id'].">".$row['name']."</option>";
		}
		$returnResult .= "</select>";
		echo $returnResult;
	} 	
	else
	if($ajxaction == "GET_REL_APPS")
	{ 
		try
		{
			$arrSpceRel = PodioApp::dependencies_space($space_id);
		}
		catch (PodioError $e) {
			$arrSpceRel = array();
		}
		$returnResult = "<select name='references[]' required  class='chosen-select-no-results' multiple=''>"; 
		for($j = 0;$j<count($arrSpceRel);$j++)
		{	
			if($arrSpceRel[$j]->__attributes['app_id'] == $app_id)continue;
			$returnResult .= "<option value=".$arrSpceRel[$j]->__attributes['app_id'].">".$arrSpceRel[$j]->__attributes['name']."</option>";
		} 
		$returnResult .= "</select>";
		echo $returnResult;
	} 
?>


						
						</select>