<?
class excel_model extends CI_Model {

	public function retrieveOrganizations()
	{
		try
			{
			$attributes = array();
			$arrOrganaizationsDetails = PodioOrganization::get_all($attributes);
			$arrOrganaizations = array();
			foreach($arrOrganaizationsDetails as $row){
				$arrOrganaizations[$row->org_id] = array(
					"id" => $row->org_id,
					"name" => $row->name
				);
			}
			return $arrOrganaizations;
		}
		catch (PodioError $e) {
			$arrOrganaizations = array();
			return $arrOrganaizations;
		}
	}
	public function retrieveWorkSpace($org_id)
	{
		try
		{
		$workSpace = array();
		if($org_id == "" || $org_id == 0)return $workSpace;
		$master_workspaces  = 	PodioSpace::get_for_org($org_id); // get workspaces within a organization		
		
		
		foreach($master_workspaces as $row)
			$workSpace [$row->space_id] = array(
					'id' =>$row->space_id,
					'name' =>$row->name
			);
		 
		return $workSpace;
		}
		catch (PodioError $e) {
			$workSpace = array();
			return $workSpace;
		}
	}
	public function retrieveApps($space_id)
	{
		try
		{
			$arrApps = array();
			if($space_id == "" || $space_id == "0") return $arrApps;
			$workspaceApps = PodioApp::get_for_space( $space_id );  //all apps by space
			$arrApps = array();
			foreach($workspaceApps as $row)
			{
				 $arrApps[$row->id] = array(
					'id' => $row->id,
					'name' => $row->config['name']);
			}
			return $arrApps;
		}
		catch (PodioError $e) {
			$arrApps = array();
			return $arrApps;
		}
	}
	
	public function retrieveRelatedAppItems($app_id, $itemName)
	{

		try
		{
			$arr1 = PodioItem::get_app_values($app_id);
			$arrResult = array();
			foreach($arr1['fields'] as $fields)
			{
				if(isset($fields['values'][0]) && count($fields['values'][0]) > 0)
				{
					foreach($fields['values'] as $fieldItem)
					{ 
						if(isset($fieldItem['item_name']))
						{
							if(trim($itemName) == trim($fields['label']))
							{	
								foreach($fieldItem['items'] as $fieldValues)
								{
									$arrResult[$fieldValues['item_id']] = array(
									"title" => $fieldValues['title'],
									"item_id" =>$fieldValues['item_id']);
								}
							}
						}
					}
				}
			}
		return $arrResult;
		}
		catch (PodioError $e) {
			$arrResult = array();
			return $arrResult;
		}
	}
	
	public function loadAllContacts($contactType)
	{
		   $ctypes = implode(",",$contactType);
 
		if($ctypes == "user,space")
		$ctypes = "space";
		// $array = array("exclude_self"=>"false","order" => "name","type" => "full","contact_type"=>"user","limit"=>499);
		// $arrContacts = (Array)PodioContact::get_all($array);
		// for($i = 0;$i < count($arrContacts); $i++)
		// {
			// $arrContacts2 = (Array)$arrContacts[$i];
			// $arrContacts2 = $arrContacts2['__attributes'];
			// $arrMyContacts[] = array(
						// "name" => $arrContacts2['name'],
						// "profile_id" => $arrContacts2['profile_id'],
						// "user_id" => $arrContacts2['user_id']);
						
		// }
		// return $arrMyContacts;
		try
		{
			$array = array("exclude_self"=>"false","order" => "name","type" => "full","contact_type"=>$ctypes,"limit"=>499);
			 $space_id = $this->session->userdata('space_id');
			// if($space_id == "")
			// $arrContacts = (Array)PodioContact::get_all($array);
			// else
			// $arrContacts = (Array)PodioContact::get_for_space($space_id,$array);
			$arrContacts = (Array)PodioContact::get_for_space($space_id,$array);
			$arrMyContacts = array();
			for($i = 0;$i < count($arrContacts); $i++)
			{
				$arrContacts2 = (Array)$arrContacts[$i];
				$arrContacts2 = $arrContacts2['__attributes'];
				$arrMyContacts[] = array(
							"name" => $arrContacts2['name'],
							"profile_id" => $arrContacts2['profile_id'],
							"user_id" => $arrContacts2['user_id']);
							
			}
			return $arrMyContacts;
		}
		catch (PodioError $e) {
			$arrMyContacts = array();
			return $arrMyContacts;
		}
	}
	
	public function retrieveOptions($arrCategories)
	{
		$arrCats = array();
		for($i = 0;$i<count($arrCategories);$i++)
		{
			$arrCats[] = array(
				"text"=>$arrCategories[$i]['text'],
				"id"=>$arrCategories[$i]['id']);
				
		}
		return $arrCats;
		
	}
	
	public function topFieldValues($field_id)
	{
	
		try
		{
			$attributes = array("limit"=>499);
			$arrToptItms = PodioItem::get_top_values_by_field($field_id,$attributes);
			
			$arrItems = array();
			for($i=0;$i<count($arrToptItms);$i++)
			$arrItems[] = array(
				"title" => $arrToptItms[$i]->__attributes['title'],
				"item_id" => $arrToptItms[$i]->__attributes['item_id']
				);
			return $arrItems;
		}
		catch (PodioError $e) {
			$arrItems = array();
			return $arrItems;
		}
	}
	public function getStateValues($field_id,$arrFields){
		$arrResult = array();
		for($i = 0;$i<count($arrFields); $i++){
		 
						$arrResult[$i] = array(
							'id'=>$i,
							'value'=>$arrFields[$i]);
 
		}
		return $arrResult;
	}
	public function saveItemToApp($appId)
	{
 
		$fields = array();
		$i= 0 ;
		// print_r($_POST);exit;
		try{
			foreach($_POST as $key => $value)
			{ 
				
				if($key == "frmAction" || $key == "appId" || $key == "dtype" || $key == "calculation" || $value == "")continue;
				if(isset($_POST['dtype'][$key]) && $_POST['dtype'][$key] == "calculation") continue;
				if(is_numeric($key) || $_POST['dtype'][$key] == "app" || $_POST['dtype'][$key] == "contact" || $_POST['dtype'][$key] == "question" || $_POST['dtype'][$key] == "category")
				{
					$arr = array();
					// print_r($value);
					 echo "@@".$_POST['dtype'][$key];
					foreach($value as $r)
					{
						if(is_array($r))
						{
							foreach($r as $rows)
							{
								$tmpTValue = (int)$rows;
								if($tmpTValue != 0 && $tmpTValue != "0")
								$arr[] = $tmpTValue;
							}
						}
						else
						{
							$tmpTValue = (int)$r;
							if($tmpTValue != 0 && $tmpTValue != "0")
							$arr[] = $tmpTValue;
						}
						
					}
					$fields[$key] = $arr;
				}
				else
				if(($_POST['dtype'][$key] == "stage")){
					
					$tmpTValue = (int)$value;
					if($tmpTValue != 0 && $tmpTValue != "0")
					$fields[$key] = (int)$value;
				}
				else
				if($_POST['dtype'][$key] == "duration")
				{
					$h1 = isset($value[0])?$value[0]:0;
					$m1 = isset($value[1])?$value[1]:0;
					$s1 = isset($value[2])?$value[2]:0;	
					$sNumber = (3600*$h1) + (60*$m1) + $s1;
					$fields[$key] = $sNumber;
				}
				else if($_POST['dtype'][$key] == "amount"){
						$s = $value;
						 
						if(is_numeric(substr($s, 0,1)))
							 $fields[$key] = (float)trim($s);
						else
							 $fields[$key] = (float)trim(substr($s, 3));
				}else if($_POST['dtype'][$key] == "progress"){
						$s = $value;
						if(!is_numeric(substr($s, 0,strlen($s)-1)))
							 $fields[$key] = (int)substr($s, 0,strlen($s)-1);
						else
							 $fields[$key] = (int)$s;
				}else if($_POST['dtype'][$key] == "date"){

						$fromDate = isset($value[0])?$value[0]:"";
						$toDate = isset($value[1])?$value[1]:"";
						
						if($fromDate != "" && $toDate != "")
						{
							$fields[$key] = array(
								"start"=>$fromDate.":00",
								"end"=>$toDate.":00");
						}else
						if($fromDate != "")
						{
							$fields[$key] = array(
								"start"=>$fromDate.":00");
						}
						

				}
				else{
					$fields[$key] = (string)$value;
					$fields[$key] = trim($fields[$key]);
				}
	 
			}
 
			 //var_dump($fields);
			$attributes = array('fields' =>$fields);
			PodioItem::create($appId, $attributes);
			$msg = "Saved Successfully";
			return $msg;
		}catch (PodioError $e) {
			return $e->body['error']."##@##".$e->body['error_description'];
		}
	 
	}
	public function numlinks($pagenum, $maxpage, $pages_visible, $scriptname="", $get="") {

		echo '<table border="0" cellspacing="0" cellpadding="0" class="t-border"><tr>';
		if ($pagenum > 1) {
			echo '<td class="td-border"><a href="'.$this->page_name(1, $scriptname, $get).'" class="numlinks">&laquo;</a></td>';   // first page
		 	echo '<td class="td-border"><a href="'.$this->page_name(($pagenum-1), $scriptname, $get).'" class="numlinks">Previous</a></td>';   // prev page
		} else {
			echo '<td class="td-border numlinks-inactive">&laquo;</td>';   // first page
		 	echo '<td class="td-border numlinks-inactive">Previous</td>';   // prev page
		}	


	
		$i=1;
		while ($i <= $pages_visible){
			if ($pagenum-ceil($pages_visible/2) < 0) {  //wenn unterer Bereich
				if ($i == $pagenum) echo '<td class="td-border numhighlight">'.($pagenum).'</td>';
				else echo '<td class="td-border"><a href="'.$this->page_name($i, $scriptname, $get).'" class="numlinks">'.($i).'</a></td>';
			
			} else if ($pagenum+floor($pages_visible/2) > $maxpage) {  // wenn oberer bereich
				if($maxpage > $pages_visible) $j = $maxpage-$pages_visible+$i;
				else $j = $i;
			
				if ($j == $pagenum) echo '<td class="td-border numhighlight">'.($pagenum).'</td>';
				else echo '<td class="td-border"><a href="'.$this->page_name($j, $scriptname, $get).'" class="numlinks">'.$j.'</a></td>';

			
			} else {  // wenn mittlerer bereich
			    if ($i == ceil($pages_visible/2)) echo '<td class="td-border numhighlight">'.($pagenum).'</td>';
				else {
					$j = $pagenum-ceil($pages_visible/2)+$i;
					echo '<td class="td-border"><a href="'.$this->page_name($j, $scriptname, $get).'" class="numlinks">'.$j.'</a></td>';
				}
			}
			if ($i == $maxpage) break;
			$i++;
		}
	

	
	
		if ($pagenum < $maxpage){
			echo '<td class="td-border"><a href="'.$this->page_name(($pagenum+1), $scriptname, $get).'" class="numlinks">Next</a></td>';  // next page
			echo '<td class="td-border"><a href="'.$this->page_name($maxpage, $scriptname, $get).'" class="numlinks">&raquo;</a></td>';   // last page
		} else {
			echo '<td class="td-border numlinks-inactive">Next</td>';   // first page
		 	echo '<td class="td-border numlinks-inactive">&raquo;</td>';   // prev page
		}	
	
		echo '</tr></table>';
	}

	public function page_name($nr, $scriptname, $get="") {
		$scriptname.='?page='.$nr;
		if ($get != '') $scriptname.='&'.$get;
		return $scriptname;
	}
	
	function updatePodioItems()
	{
		  $item_id_post = isset($_POST['item_id'])?$_POST['item_id']:"";
		   // print_r($_POST);
		  try{
			  if($item_id_post != ""){
				$x = 0;
				foreach($item_id_post as $key2 => $item_id){
				 
					$fields = array();
					$j = 0;
					  $i  = $key2;
					foreach($_POST as $key => $value)
					{   
						
						if($key == "frmAction" || $key == "item_id" || $key == "dtype"|| $key == "recs_per_page")continue;
					
						if(is_array($_POST[$key]) && isset($_POST[$key][$i]))
						
							$findValue =  $_POST[$key][$i];
							
						else
							$findValue =  $_POST[$key];
					 
						// echo '@@@@@@@@@'.$key;
						// echo $_POST['dtype'][$j];
						if(is_numeric($key) || $_POST['dtype'][$j] == "app" || $_POST['dtype'][$j] == "contact" || $_POST['dtype'][$j] == "question" || $_POST['dtype'][$j] == "category")
						{
							$arrMultiApps = array();
							if(isset($_POST[$key][$i]) && is_Array($_POST[$key][$i])==1)
							{
								foreach($_POST[$key][$i] as $mulApps)
								{
									if($mulApps == "HID_ESC_CHK")continue;
									if($mulApps != 0 && $mulApps != "0")
									$arrMultiApps[] = (int)$mulApps;
								}
							}
								$fields[$key] = $arrMultiApps; 
						}
						else
						if($_POST['dtype'][$j] == "stage"){
							$findValue = (int)$findValue;
							if($findValue != 0 && $findValue != "0")
							$fields[$key] = (int)$findValue;
						 }
						else
						if($_POST['dtype'][$j] == "duration")
						{
							
							$indexd = (($i*3));
							 // print_r($_POST['duration']);
							// print_r($_POST['duration'][$indexd]);
							// print_r($_POST['duration'][$indexd+1]);
							// print_r($_POST['duration'][$indexd+2]);
							$h1 = isset($_POST[$key][$indexd])?$_POST[$key][$indexd]:0;
							$m1 = isset($_POST[$key][$indexd+1])?$_POST[$key][$indexd+1]:0;
							$s1 = isset($_POST[$key][$indexd+2])?$_POST[$key][$indexd+2]:0;	
							$sNumber = (3600*$h1) + (60*$m1) + $s1;
							$fields[$key] = $sNumber; 
							
						}
						else if($_POST['dtype'][$j] == "amount"){
							$s = $findValue;
							 
							if(is_numeric(substr($s, 0,1)))
								 $fields[$key] = (float)trim($s);
							else
								 $fields[$key] = (float)trim(substr($s, 3));
						}
						else if($_POST['dtype'][$j] == "progress"){
								$s = $findValue;
								if(!is_numeric(substr($s, 0,strlen($s)-1)))
									 $fields[$key] = (int)substr($s, 0,strlen($s)-1);
								else
									 $fields[$key] = (int)$s;
						}else 
						if($_POST['dtype'][$j] == "date"){
							$indexd = (($i*2));
							$fromDate = isset($_POST[$key][$indexd])?$_POST[$key][$indexd]:"";
							$toDate = isset($_POST[$key][$indexd+1])?$_POST[$key][$indexd+1]:"";
							 
							if($fromDate != "" && $toDate != "")
							{
								$arrChkTime1 = explode(" ",$fromDate);
								if(!isset($arrChkTime1[1]))
									$fromDate .= " 00:00";
								$arrChkTime2 = explode(" ",$toDate);
								if(!isset($arrChkTime2[1]))
									$toDate .= " 00:00";
								$fields[$key] = array(
									"start"=>$fromDate.":00",
									"end"=>$toDate.":00");
							}else
							if($fromDate != "")
							{
								$arrChkTime1 = explode(" ",$fromDate);
								if(!isset($arrChkTime1[1]))
									$fromDate .= " 00:00";
								$fields[$key] = array(
									"start"=>$fromDate.":00");
							}
							
						}else
						if($_POST['dtype'][$j] == "calculation")
						{
						
						}
						else
						if($findValue != "")
						{
						 	if(is_array($_POST[$key]))
							$fields[$key] = (string)$findValue;
							else
							$fields[$key] = (string)$_POST[$key];
							$fields[$key] = trim($fields[$key]);
						 
						}
						$j++;	
						$x++;						
					}
						//$i++;
					  //var_dump($fields);
					   PodioItem::update_values($item_id, $fields);
					}
			}
			$msg = "Updated Successfully";
			return $msg;		
 		}catch (PodioError $e) {
			return $e->body['error']."##@##".$e->body['error_description'];
		}
	}
	function isDateTime($date){
		 $dateArr = explode(" ", $date);
		 if(!isset($dateArr[1]))
		 	return 0;
		 else
			return 1;
	}
	
	public function getQuestionAsnwers($field_id,$arrFields){
		$arrResult = array();
		for($i = 0;$i<count($arrFields); $i++){
 
						  $arrResult[$i] = array(
							'id'=>$arrFields[$i]['id'],
							'value'=>$arrFields[$i]['text']);
 
		}
		return $arrResult;
	}
	public function getRatedApps($arrSpceRel,$appId)
	{
		 
		$arrResult = array();
		$arrResult[] = $appId;
		for($j = 0;$j<count($arrSpceRel);$j++)
		{
			try
			{
				$arrFieldsMain = PodioApp::get($arrSpceRel[$j]->__attributes['app_id'],$attributes = array("limit"=> 1));
				for($x = 0;$x<count($arrFieldsMain->__attributes['fields']);$x++)
				{
					$mainType = $arrFieldsMain->__attributes['fields'][$x]->__attributes['type'];
					if($mainType == "app")
					{
						if(isset($arrFieldsMain->__attributes['fields'][$x]->__attributes['config']['settings']['referenceable_types'][0]) && $arrFieldsMain->__attributes['fields'][$x]->__attributes['config']['settings']['referenceable_types'][0] !="")
						{
							if(in_array($appId,$arrFieldsMain->__attributes['fields'][$x]->__attributes['config']['settings']['referenceable_types']))
							{
								$arrResult[] = $arrSpceRel[$j]->__attributes['app_id'];
							}
						}
					}
				}
			}
			catch (PodioError $e) 
			{
			
			}

		}
		return $arrResult;
	}
	public function exportCSV($contentsArr,$name)
	{
		ob_end_clean();
		ob_start();
		$name =   str_replace(" ","-",$name);
		$test=$contentsArr;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=export-".$name.".xls");
		echo $test;
	}
	public function export2Gdrive($contentsArr,$name)
	{
		//$name = "testFiles";
		include "simple_html_dom.php";
		$table = $contentsArr;
		$html = str_get_html($table);
		$name .= '_'.date("d_m_Y__h_i_s");
		$fp = fopen('./tmp/'.$name.".xls", "w");
		foreach($html->find('tr') as $element)
		{
			$td = array();
			foreach( $element->find('td') as $row)  
			{
				$td [] = $row->plaintext;
				fputs($fp, $row->plaintext."\t");
			}
			 fputs($fp, "\n");
		}
		fclose($fp);
		 
	
	
	
	unset($_SESSION['my_url']);
	$_SESSION['my_url'] = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$_SESSION['my_name'] = $name;
	header('location:'.site_url('authenticate'));exit;

	}
}
?>
