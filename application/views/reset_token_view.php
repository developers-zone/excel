 <? $this->load->view('header');?>

<div id="main-wrapper">
	<br/>
	<form class="uk-form uk-form-stacked" name="frmManage" method="POST" onsubmit="return false;" action="">
			<input type="hidden" name="frmAction" value=""/>
	<div class="innerBox50">	 
		<div class="" style="height: 384px;">
			<div class="itemContainerLarge3"><br/>
				<label class="heading1">Manage your</label>
				<img style="width: 35px;margin-bottom:10px;" src="<?echo base_url();?>briefcase/images/podiologo.png">
				<label class="heading1">settings</label>
			</div><div style="clear:both;">
		</div><br/> 
		<div class="uk-panel uk-width-1-2 uk-container-center uk-text-center">
				 
				<div class="alert_message"></div>

				<div class="uk-form-row">
					<label class="uk-form-label" for="form-s-it">Client ID</label>
					<div class="uk-form-controls">
						<input type="text" id="clientId" name="clientId" required placeholder="Your Client Id" class="uk-form-large uk-form-width-large" value="">
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="form-s-it">Secret Key</label>
					<div class="uk-form-controls">
						<input type="password" id="secretKey" name="secretKey" required placeholder="Your Secret key" class="uk-form-large uk-form-width-large" value="">
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-danger" for="form-s-it">Warning :: Invalid entry of Client ID/ Secret key leads to failure of authentication during re-login.</label>
				</div>
				<br>
				<input type="submit" onclick="javascript:setupPodio();" class="uk-button uk-button-success" name="savesettings" value="Save">
				<input type="reset"  class="uk-button uk-button-primary" name="cancelsettings" value="Cancel">
			
		</div>
	</div></form>
</div>
 <? $this->load->view('footer'); ?>
 <script type="text/javascript">
 	function setupPodio(){
		var frm = document.frmManage;
		frm.frmAction.value = "PODIO_SETUP"; 
		frm.submit();
	}
 </script>
