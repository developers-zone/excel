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

function getReferences(){
	 
		document.body.style.cursor='wait';
		var ajxaction = "GET_REL_APPS";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}
		space_id = document.getElementById('space_id').value;
		appId = document.getElementById('appId').value;
		var url="<?echo site_url("ajax");?>";
		 url=url+"?space_id="+space_id+"&ajxaction="+ajxaction+"&app_id="+appId;
 		url = html_entity_decode(url);
		
	 	xmlHttp.onreadystatechange=stateChanged4References;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		return false;
 }
 function stateChanged4References()
{
	if (xmlHttp.readyState==4)
	{ 
		 
		document.body.style.cursor='auto';
		var result = trimNew(xmlHttp.responseText);
		document.getElementById('getRelApp').innerHTML = result;
		    var config = {
 
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	}
}

 var totalRows = 0;
	function showOptions(selectedValue)
	{
		
		if(selectedValue == "category" || selectedValue == "question"){
			document.getElementById('options1').style.display = "block";
			document.getElementById('options2').style.display = "none";
			document.getElementById('options3').style.display = "none";
			document.getElementById('options4').style.display = "none";
		}
		else
		if(selectedValue == "app")
		{
			 getReferences();
			document.getElementById('options2').style.display = "block";
			document.getElementById('options1').style.display = "none";
			document.getElementById('options3').style.display = "none";
			document.getElementById('options4').style.display = "none";
		}else
		if(selectedValue == "money")
		{
			document.getElementById('options2').style.display = "none";
			document.getElementById('options1').style.display = "none";
			document.getElementById('options3').style.display = "block";
			document.getElementById('options4').style.display = "none";
		}
		else
		if(selectedValue == "contact")
		{
			document.getElementById('options2').style.display = "none";
			document.getElementById('options1').style.display = "none";
			document.getElementById('options3').style.display = "none";
			document.getElementById('options4').style.display = "block";
		}
		else
		{
			document.getElementById('options1').style.display = "none";
			document.getElementById('options2').style.display = "none";
			document.getElementById('options3').style.display = "none";
			document.getElementById('options4').style.display = "none";
		}
		//money, calculation, app reference
	}
	function submitForm()
	{
			var frm =  document.formFields;
			frm.formAction.value = "CREATE_NEW_FIELD";
			frm.submit();
	}

	function addRow(tableID) {
			rowsInserted = 0;
            var table = document.getElementById(tableID);
			totalRows = totalRows + rowsInserted;
			 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
      
            var cell1 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "checkbox";
            element1.name="chkbox[]";
			 
			element1.style.margin = "3px";
            cell1.appendChild(element1);
 
 
            var cell3 = row.insertCell(1);
			cell3.style.width ="80%";
            var element2 = document.createElement("input");
            element2.type = "text";
            element2.name = "optionValues[]";
			element2.required = true;
			element2.id = "optionValues_"+(rowCount + 1);
			element2.style.width ="98%";
			element2.style.margin = "2px";
			element2.className= "color";
			
            cell3.appendChild(element2);
			loadColors();
 
        }
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
        }
	
 
</script>

		<script src="<? echo base_url();?>briefcase/chooson/chosen.jquery.js" type="text/javascript"></script>
		<script src="<? echo base_url();?>briefcase/chooson/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="<? echo base_url();?>briefcase/chooson/chosen.css">
		 <?
			@session_start();
			$space_id = $this->session->userdata('space_id');
			$appId = $this->uri->segment(3);	
		?>
		<input type="hidden" name="space_id" id="space_id" value = "<?echo $space_id;?>" />
		<input type="hidden" name="appId" id="appId" value = "<?echo $appId;?>" />
 	<div id="main-wrapper">
	 <br/>
		<div class="innerBox50">	 
		
			<form class="uk-form uk-margin uk-form-horizontal" style="margin:0px;" onsubmit="return false;" method="POST" action="" name="formFields" action="">
				<input type="hidden" name="formAction" value=""/>
				<div class="">
			 <br/>
					 <div class="itemContainerLarge3">
						<label class="heading1">Create new</label>
						<img style="width: 35px;margin-bottom:10px;" src="<?echo base_url();?>briefcase/images/podiologo.png">
						<label class="heading1">field</label>
					</div><div style="clear:both;"></div>
					<br/>
	<?/*?><div style="margin-left: 0px; color: rgb(255, 0, 0); font-size: 15px; border-bottom-width: 0px; margin-bottom: 12px; margin-top: 0px;">
		<?if(isset($error) && isset($error_description)){			//display error
			echo "There was an error. The API responded with the error type ".$error." and the mesage ".$error_description.".";
		}else if(isset($error)){
			echo $error;
		}?>
	</div>
	<div style="margin-left: 0px; color: green; font-size: 15px; border-bottom-width: 0px; margin-bottom: 12px; margin-top: 0px;">
		<?if(isset($success)){			//display message
			echo $success;
		}?>
	</div><?*/?><br/>
					<div class="itemContainerLarge3">
						<label for="organizations" class="label4"><b>Field Type</b><span class="red"> (required)</span>
						</label>
					 <br/>
						<select id="field_type" class="mediumText" required name="field_type" onchange="showOptions(this.value)">
							<option value="">[Select Field Type]</option>
							<option <?echo $this->new_field_model->field_type =="text"?"selected":"";?> value="text">Text</option>
							<option <?echo $this->new_field_model->field_type =="contact"?"selected":"";?> value="contact">Contact</option>
							<option <?echo $this->new_field_model->field_type =="category"?"selected":"";?> value="category">Category</option>
							<option <?echo $this->new_field_model->field_type =="date"?"selected":"";?> value="date">Date</option>
							<!--<option <?echo $this->new_field_model->field_type =="link"?"selected":"";?> value="link">Link</option>-->
							<!--<option <?echo $this->new_field_model->field_type =="image"?"selected":"";?> value="image">Image</option>-->
							<!--<option <?echo $this->new_field_model->field_type =="google"?"selected":"";?> value="google maps">Google Maps</option>-->
							<option <?echo $this->new_field_model->field_type =="question"?"selected":"";?> value="question">Question</option>
							<option <?echo $this->new_field_model->field_type =="number"?"selected":"";?> value="number">Number</option>
							<option <?echo $this->new_field_model->field_type =="money"?"selected":"";?> value="money">Money</option>
							<option <?echo $this->new_field_model->field_type =="duration"?"selected":"";?> value="duration">Duration</option>
							<option <?echo $this->new_field_model->field_type =="progress"?"selected":"";?> value="progress">Progress Slider</option>
							<!--<option <?echo $this->new_field_model->field_type =="calculation"?"selected":"";?> value="calculation">Calculation</option>-->
							<option <?echo $this->new_field_model->field_type =="app"?"selected":"";?> value="app">App Reference</option>
						</select>
					</div>
					<div class="itemContainerLarge3">
						<label for="organizations" class="label4"><b>Field Name</b><span class="red"> (required)</span>
						</label>
					 <br/>
						 <input type="text" name="field_name" value="<?echo $this->new_field_model->field_name;?>" required class="mediumText"/>
					</div>
					<div class="itemContainerLarge3">
						<label for="organizations" class="label4"><b>Description</b><span class="grey"> (optional)</span>
						</label>
					 <br/>
						 <textarea name="description" class="mediumText"><?echo $this->new_field_model->description;?></textarea>
					</div>
					<div class="itemContainerLarge3">
						<label for="organizations" class="label4"><b>Order of the field (Position in app)</b>
						</label>
					 <br/>
						 <input type="text" name="delta" value="<?echo $this->new_field_model->delta;?>" onkeypress="return numericOnly(event);" class="mediumText"/>
					</div>
					<div class="itemContainerLarge3">
						<label for="organizations" class="label4"><b>Required</b><span class="grey"> (optional)</span>
						</label>
					 <br/>
						 <input type="checkbox" name="required_val" value = "1" class="mediumText"/><br/>
					</div>
					<div style="clear:both;"></div>	<br/>
					<div class="itemContainerLarge3" id="options1" style="display:none;width:352px;">
						<table id="optionsTab" width="100%" border="1">
						 
						</table>
						<label for="organizations" class="label4"><b>Multiple Choice</b><span class="grey"> (optional)</span>
						</label>
					 <br/>
						 <input type="checkbox" name="multi_choice" value = "1" class="mediumText"/><br/>
						 
						 

						<button type="button" onclick="javascript:addRow('optionsTab');" class="uk-button uk-button-primary uk-button-small">Add Row</button>
						<button type="button" onclick="javascript:deleteRow('optionsTab');" class="uk-button uk-button-primary uk-button-small">Delete Row</button>
					</div>
					<div class="itemContainerLarge3" id="options2" style="display:none;width:352px;">
							<label for="organizations" class="label4"><b>Choose an app to reference</b><span class="red"> (required)</span>
						</label>
						<br/>
						<div id="getRelApp">
							<img src="<? echo base_url();?>briefcase/images/loader.gif" alt="Loading..."> 
						</div>
						
					</div>
					<div class="itemContainerLarge3" id="options4" style="display:none;width:352px;">
							<label for="organizations" class="label4"><b>Contact Type</b>
						</label>
						<br/>
						 
							  <input type="radio" name="contact_type" value = "space_users" id="space_users" checked class=""/><label for="space_users">Workspace Members</label>
							  <input type="radio" name="contact_type" value = "space_contacts" id="space_contacts" class=""/><label for="space_contacts">Workspace Contact</label>
						 
						
					</div>
					
					<div class="itemContainerLarge3" id="options3" style="display:none;width:352px;">
							<label for="organizations" class="label4"><b>Allowed Currencies</b>
						</label>
						<br/>
						<select size="5" name="allowedCurrecies[]" multiple="multiple" class="chosen-select-no-results">
							<option selected="selected" value="EUR">Euro (EUR)</option>
							<option selected="selected" value="DKK">Danish Krone (DKK)</option>
							<option selected="selected" value="USD">U.S. Dollar (USD)</option>
							<option value="AFA">Afghanistani Afghani (AFA)</option>
							<option value="ALL">Albanian Lek (ALL)</option>
							<option value="DZD">Algerian Dinar (DZD)</option>
							<option value="AOA">Angolan Kwanza (AOA)</option>
							<option value="ARS">Argentine Peso (ARS)</option>
							<option value="AMD">Armenian Dram (AMD)</option>
							<option value="AWG">Aruba Florin (AWG)</option>
							<option value="AUD">Australian Dollar (AUD)</option>
							<option value="AZN">Azerbaijan New Maneat (AZN)</option>
							<option value="BSD">Bahamian Dollar (BSD)</option>
							<option value="BHD">Bahraini Dinar (BHD)</option>
							<option value="BDT">Bangladeshi Taka (BDT)</option>
							<option value="BBD">Barbadian Dollar (BBD)</option>
							<option value="BYR">Belarus Ruble (BYR)</option>
							<option value="BZD">Belize Dollar (BZD)</option>
							<option value="BMD">Bermuda Dollar (BMD)</option>
							<option value="BTN">Bhutanese Ngultrum (BTN)</option>
							<option value="BOB">Bolivian Boliviano (BOB)</option>
							<option value="BAM">Bosnia and Herzegovina Convertible Marka (BAM)</option>
							<option value="BWP">Botswana Pula (BWP)</option>
							<option value="BRL">Brazilian Real (BRL)</option>
							<option value="GBP">British Pound (GBP)</option>
							<option value="BND">Brunei Dollar (BND)</option>
							<option value="BGN">Bulgarian Lev (BGN)</option>
							<option value="BIF">Burundi Franc (BIF)</option>
							<option value="KHR">Cambodia Riel (KHR)</option>
							<option value="CAD">Canadian Dollar (CAD)</option>
							<option value="CVE">Cape Verdean Escudo (CVE)</option>
							<option value="KYD">Cayman Islands Dollar (KYD)</option>
							<option value="XOF">CFA Franc (BCEAO) (XOF)</option>
							<option value="XAF">CFA Franc (BEAC) (XAF)</option>
							<option value="CLP">Chilean Peso (CLP)</option>
							<option value="CNY">Chinese Yuan (CNY)</option>
							<option value="COP">Colombian Peso (COP)</option>
							<option value="KMF">Comoros Franc (KMF)</option>
							<option value="CRC">Costa Rica Colon (CRC)</option>
							<option value="HRK">Croatian Kuna (HRK)</option>
							<option value="CUP">Cuban Peso (CUP)</option>
							<option value="CYP">Cyprus Pound (CYP)</option>
							<option value="CZK">Czech Koruna (CZK)</option>
							<option value="DJF">Dijiboutian Franc (DJF)</option>
							<option value="DOP">Dominican Peso (DOP)</option>
							<option value="XCD">East Caribbean Dollar (XCD)</option>
							<option value="EGP">Egyptian Pound (EGP)</option>
							<option value="SVC">El Salvador Colon (SVC)</option>
							<option value="ERN">Eritrean Nakfa (ERN)</option>
							<option value="EEK">Estonian Kroon (EEK)</option>
							<option value="ETB">Ethiopian Birr (ETB)</option>
							<option value="FKP">Falkland Islands Pound (FKP)</option>
							<option value="FJD">Fiji Dollar (FJD)</option>
							<option value="GMD">Gambian Dalasi (GMD)</option>
							<option value="GHC">Ghanian Cedi (GHC)</option>
							<option value="GIP">Gibraltar Pound (GIP)</option>
							<option value="XAU">Gold Ounces (XAU)</option>
							<option value="GTQ">Guatemala Quetzal (GTQ)</option>
							<option value="GGP">Guernsey Pound (GGP)</option>
							<option value="GNF">Guinea Franc (GNF)</option>
							<option value="GYD">Guyana Dollar (GYD)</option>
							<option value="HTG">Haiti Gourde (HTG)</option>
							<option value="HNL">Honduras Lempira (HNL)</option>
							<option value="HKD">Hong Kong Dollar (HKD)</option>
							<option value="HUF">Hungarian Forint (HUF)</option>
							<option value="ISK">Iceland Krona (ISK)</option>
							<option value="INR">Indian Rupee (INR)</option>
							<option value="IDR">Indonesian Rupiah (IDR)</option>
							<option value="IRR">Iran Rial (IRR)</option>
							<option value="IQD">Iraqi Dinar (IQD)</option>
							<option value="ILS">Israeli Shekel (ILS)</option>
							<option value="JMD">Jamaican Dollar (JMD)</option>
							<option value="JPY">Japanese Yen (JPY)</option>
							<option value="JOD">Jordanian Dinar (JOD)</option>
							<option value="KZT">Kazakhstan Tenge (KZT)</option>
							<option value="KES">Kenyan Shilling (KES)</option>
							<option value="KRW">Korean Won (KRW)</option>
							<option value="KWD">Kuwaiti Dinar (KWD)</option>
							<option value="KGS">Kyrgyzstan Som (KGS)</option>
							<option value="LAK">Lao Kip (LAK)</option>
							<option value="LVL">Latvian Lat (LVL)</option>
							<option value="LBP">Lebanese Pound (LBP)</option>
							<option value="LSL">Lesotho Loti (LSL)</option>
							<option value="LRD">Liberian Dollar (LRD)</option>
							<option value="LYD">Libyan Dinar (LYD)</option>
							<option value="LTL">Lithuanian Lita (LTL)</option>
							<option value="MOP">Macau Pataca (MOP)</option>
							<option value="MKD">Macedonian Denar (MKD)</option>
							<option value="MGA">iraimbilanja</option>
							<option value="MWK">Malawian Kwacha (MWK)</option>
							<option value="MYR">Malaysian Ringgit (MYR)</option>
							<option value="MVR">Maldives Rufiyaa (MVR)</option>
							<option value="MGA">Malagasy Ariary (MGA)</option>
							<option value="MTL">Maltese Lira (MTL)</option>
							<option value="MRO">Mauritania Ougulya (MRO)</option>
							<option value="MUR">Mauritius Rupee (MUR)</option>
							<option value="MXN">Mexican Peso (MXN)</option>
							<option value="MDL">Moldovan Leu (MDL)</option>
							<option value="MNT">Mongolian Tugrik (MNT)</option>
							<option value="MAD">Moroccan Dirham (MAD)</option>
							<option value="MZM">Mozambique Metical (MZM)</option>
							<option value="MMK">Myanmar Kyat (MMK)</option>
							<option value="NAD">Namibian Dollar (NAD)</option>
							<option value="NPR">Nepalese Rupee (NPR)</option>
							<option value="ANG">Neth Antilles Guilder (ANG)</option>
							<option value="NZD">New Zealand Dollar (NZD)</option>
							<option value="NIO">Nicaragua Cordoba (NIO)</option>
							<option value="NGN">Nigerian Naira (NGN)</option>
							<option value="KPW">North Korean Won (KPW)</option>
							<option value="NOK">Norwegian Krone (NOK)</option>
							<option value="OMR">Omani Rial (OMR)</option>
							<option value="XPF">Pacific Franc (XPF)</option>
							<option value="PKR">Pakistani Rupee (PKR)</option>
							<option value="XPD">Palladium Ounces (XPD)</option>
							<option value="PAB">Panama Balboa (PAB)</option>
							<option value="PGK">Papua New Guinea Kina (PGK)</option>
							<option value="PYG">Paraguayan Guarani (PYG)</option>
							<option value="PEN">Peruvian Nuevo Sol (PEN)</option>
							<option value="PHP">Philippine Peso (PHP)</option>
							<option value="XPT">Platinum Ounces (XPT)</option>
							<option value="PLN">Polish Zloty (PLN)</option>
							<option value="QAR">Qatar Rial (QAR)</option>
							<option value="RON">Romanian Leu (RON)</option>
							<option value="RUB">Russian Rouble (RUB)</option>
							<option value="RWF">Rwandese Franc (RWF)</option>
							<option value="WST">Samoan Tala (WST)</option>
							<option value="STD">Sao Tome Dobra (STD)</option>
							<option value="SAR">Saudi Arabian Riyal (SAR)</option>
							<option value="SCR">Seychelles Rupee (SCR)</option>
							<option value="RSD">Serbian Dinar (RSD)</option>
							<option value="SLL">Sierra Leone Leone (SLL)</option>
							<option value="XAG">Silver Ounces (XAG)</option>
							<option value="SGD">Singapore Dollar (SGD)</option>
							<option value="SKK">Slovak Koruna (SKK)</option>
							<option value="SBD">Solomon Islands Dollar (SBD)</option>
							<option value="SOS">Somali Shilling (SOS)</option>
							<option value="ZAR">South African Rand (ZAR)</option>
							<option value="LKR">Sri Lanka Rupee (LKR)</option>
							<option value="SHP">St Helena Pound (SHP)</option>
							<option value="SDD">Sudanese Dinar (SDD)</option>
							<option value="SRD">Surinam Dollar (SRD)</option>
							<option value="SZL">Swaziland Lilageni (SZL)</option>
							<option value="SEK">Swedish Krona (SEK)</option>
							<option value="CHF">Swiss Franc (CHF)</option>
							<option value="SYP">Syrian Pound (SYP)</option>
							<option value="TWD">Taiwan Dollar (TWD)</option>
							<option value="TZS">Tanzanian Shilling (TZS)</option>
							<option value="THB">Thai Baht (THB)</option>
							<option value="TOP">Tonga Pa'anga (TOP)</option>
							<option value="TTD">Trinidad &amp; Tobago Dollar (TTD)</option>
							<option value="TND">Tunisian Dinar (TND)</option>
							<option value="TRY">Turkish Lira (TRY)</option>
							<option value="AED">UAE Dirham (AED)</option>
							<option value="UGX">Ugandan Shilling (UGX)</option>
							<option value="UAH">Ukraine Hryvnia (UAH)</option>
							<option value="UYU">Uruguayan New Peso (UYU)</option>
							<option value="UZS">Uzbekistan Sum (UZS)</option>
							<option value="VUV">Vanuatu Vatu (VUV)</option>
							<option value="VEB">Venezuelan Bolivar (VEB)</option>
							<option value="VND">Vietnam Dong (VND)</option>
							<option value="YER">Yemen Riyal (YER)</option>
							<option value="YUM">Yugoslav Dinar (YUM)</option>
							<option value="ZMK">Zambian Kwacha (ZMK)</option>
							<option value="ZWD">Zimbabwe Dollar (ZWD)</option>
						</select>
						
					</div>
					<div style="clear:both;"></div>	<br/>
				 
					 
					
					<div style="clear:both;"></div>	<br/>
					<div class="itemContainerLarge3">
						 <button type="submit" onclick="javascript:submitForm();" class="uk-button uk-button-primary uk-button-small">Create</button>
					</div>
					<div style="clear:both;"></div>	<br/>	<br/>
</div>

				</div>
			</form>
			 
		</div>
 	  <script type="text/javascript">
    var config = {
 
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>	

 
 <? $this->load->view('footer'); ?>
