 <? $this->load->view('header');?>
 <script type="text/javascript">
 
 function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	  {
	  // Firefox, Opera 8.0+, Safari
	  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
	  // Internet Explorer
	  try
		{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
	  catch (e)
		{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	  }
	return xmlHttp;
} 

function getworkspaces(orgId){
	 
		document.body.style.cursor='wait';
		var ajxaction = "GET_WORKSPACE";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}

		var url="<?echo site_url("ajax");?>";
		 url=url+"?orgId="+orgId+"&ajxaction="+ajxaction;
 		url = html_entity_decode(url);
		
	 	xmlHttp.onreadystatechange=stateChanged4WorkSpace;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		return false;
 }
 function stateChanged4WorkSpace()
{
	if (xmlHttp.readyState==4)
	{ 
		 
		document.body.style.cursor='auto';
		var result = trimNew(xmlHttp.responseText);
document.getElementById('workspace_div').innerHTML = result;
	}
}
 

function loadSpaceApps(space_id){
	 
	 document.body.style.cursor='wait';
		var ajxaction = "GET_SPACE_APPS";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}

		var url="<?echo site_url("ajax");?>";
		 url=url+"?space_id="+space_id+"&ajxaction="+ajxaction;
 		url = html_entity_decode(url);
		
	 	xmlHttp.onreadystatechange=stateChanged4SpaceApps;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		return false;
 }
 function stateChanged4SpaceApps()
{
	if (xmlHttp.readyState==4)
	{ 
		 
		document.body.style.cursor='auto';
		var result = trimNew(xmlHttp.responseText);
		document.getElementById('apps_div').innerHTML = result;
	}
}

function loadViews(app_id){
	 
		document.body.style.cursor='wait';
		var ajxaction = "GET_APP_VIEWS";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}

		var url="<?echo site_url("ajax");?>";
		 url=url+"?app_id="+app_id+"&ajxaction="+ajxaction;
 		url = html_entity_decode(url);
		
	 	xmlHttp.onreadystatechange=loadViewsResult;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		return false;
 }
 function loadViewsResult()
{
	if (xmlHttp.readyState==4)
	{ 
		 
		document.body.style.cursor='auto';
		var result = trimNew(xmlHttp.responseText);
		document.getElementById('view_div').innerHTML = result;
	}
}
function gotoNextPage(){
	var frm = document.formExcel;
	//alert(frm.space_apps.value);
	errorEnabled = false;
	if(frm.organization.value == "")
	{
		document.getElementById('organization').required =true;
		errorEnabled = true;
	}
	if(frm.workspace.value == "")
	{
		document.getElementById('workspace').required =true;
		errorEnabled = true;
	}
	if(frm.space_apps.value == "")
	{
		document.getElementById('space_apps').required =true;
		errorEnabled = true;
	}
	if(errorEnabled == true)return false;
	var string_vid = "";
	if(frm.view_apps.value != "")
		string_vid = "?vid="+frm.view_apps.value;
	window.location = "<?echo site_url('excel');?>/index/"+frm.space_apps.value+string_vid;
}
</script>
	
	<div id="main-wrapper">
	 <br/>
		<div class="innerBox50">	 
			<form class="uk-form uk-margin uk-form-horizontal" style="margin:0px;" onsubmit="return false;" method="POST" action="<?echo site_url('excel_sheet');?>" name="formExcel" action="">
				<input type="hidden" name="pack_id" value=""/>
				<div class="">
					 <div class="itemContainerLarge3" style="padding-top: 21px;">
						<label class="heading1">Filter your</label>
						<!-- <img style="width: 35px;margin-bottom:10px;" src="<?echo base_url();?>briefcase/images/podiologo.png"> -->
						<label class="heading1"> Podio items</label>
					</div><div style="clear:both;"></div>
					<br/><br/>
					<div class="itemContainerLarge3">
						<label for="organizations" class="label4"><b>Organization</b><span class="red"> (required)</span><br/><span class="smallLabel">Select your desired organization.</span></label>
					 
						<select id="organization" class="mediumText" required name="organization" onchange="getworkspaces(this.value)">
							<option value="">[Select Organization]</option>
							<?foreach($arrOrganaizations as $row)
							{?>
								<option value="<?echo $row['id'];?>"><?echo $row['name'];?></option>
							<?}?>
						</select>
					</div>
					<div style="clear:both;"></div>	<br/>
					<div class="itemContainerLarge3">
						<label for="workspace" class="label4"><b>Workspace</b><span class="red"> (required)</span><br/><span class="smallLabel">Select your desired workspace.</span></label>
						<div id="workspace_div">
							<select id="workspace" class="mediumText" required name="workspace" onchange="loadSpaceApps(this.value)">
								<option value="">[Select WorkSpace]</option>
							</select>
						</div>
					</div>
					
					<div style="clear:both;"></div>	<br/>
					<div class="itemContainerLarge3">
						<label for="space_apps" class="label4"><b>Application</b><span class="red"> (required)</span><br/><span class="smallLabel">Select your desired app.</span></label>
						<div id="apps_div"><select id="space_apps" class="mediumText" required name="space_apps" onchange="loadViews(this.value)">
							<option value="">[Select Application]</option>
						</select></div>
					</div>
					
						<div style="clear:both;"></div>	<br/>
					<div class="itemContainerLarge3">
						<label for="space_apps" class="label4"><b>View</b><span class="grey"> (optional)</span><br/><span class="smallLabel">Select a premade view to fiter items to your selection which <br/>allows you to trigger off a subset of items in your app</span></label>
						<div id="view_div"><select id="view_apps" class="mediumText" name="view_apps">
							<option value="">[Select View]</option>
						</select></div>
					</div>
					
					
					<div style="clear:both;"></div>	<br/>
					<div class="itemContainerLarge3">
						 <button type="submit" onclick="javascript:gotoNextPage();" class="uk-button uk-button-primary uk-button-small">Continue</button>
					</div>
					<div style="clear:both;"></div>	<br/>	<br/>
</div>

				</div>
			</form>
			 
		</div>
 
 
 
 <? $this->load->view('footer'); ?>
