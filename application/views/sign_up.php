<? $this->load->view('indexHeader');?>	
 
	<script type="text/javascript">
		function validateRegistration()
		{
			var frm = document.frmMain;
			frm.submitted.value=1;
			frm.form_action.value='REGISTER_NOW';
			frm.submit();	
		}
	</script>
	
	<form class="uk-form"  method="post" name="frmMain"  onsubmit="return false;">
		<input type="hidden" name="submitted" value="0" />
		<input type="hidden" name="form_action" value="" />
		<fieldset>
			<!--<?php if(!empty($message)) { ?>
			<div class="uk-alert uk-alert-danger" data-uk-alert="">
					<a href="" class="uk-alert-close uk-close"></a>
					<p><?php echo $message?></p>
			</div>
			<?php } ?>-->
			<div id="status"></div>
		
			<legend>Please enter your Podio email address to create an account.</legend>
			
			<p><input type="email" name="clsLogin_customer_email" id="clsLogin_customer_email" placeholder="Your Podio Email" class="uk-form-width-medium uk-form-large customtext" required/></p>
				<!-- <legend><input type="checkbox" name="join_space" id="join_space" value = '1' placeholder="Join Workspace"/>&nbsp;<label for="join_space">Join our support workspace</label></legend> -->
			
		    <p>
				<input type="submit" name="register" id="register" onclick="javascript:validateRegistration();" class="uk-button uk-button-primary uk-button-large" value="Register My Account"/>
				&nbsp; <a href="sign_in"> Already A Member? Click Here.</a>
			</p>
		</fieldset>
	 </form>



<? $this->load->view('indexFooter');?>	





















 <? //$this->load->view('header');?>
<!--
<script type="text/javascript">
function validateRegistration()
{
		var frm = document.frmMain;
		frm.submitted.value=1;
		frm.form_action.value='REGISTER_NOW';
		frm.submit();	
}
</script>

<div align="center" style="margin-top: 30px;"><img src="<?echo base_url();?>briefcase/images/TECHeGO.png" title="TECHeGO" alt="TECHeGO" style="width: 403px;"/><div> 
	<div class="wrap" style="width: 400px; height: 163px; margin-top: -120px;">
		<h2></h2>
		<div style="margin:auto;text-align:center;width:300px;font-weight:bold;color:red;"></div>

		<form action=""  method="post" name="frmMain" class="uk-form"  onsubmit="return false;">
			<input type="hidden" name="submitted" value="0" />
			<input type="hidden" name="form_action" value="" />

			<div class="login" style="margin-bottom:0px; margin-top: 34px;">
				<div  class="itemContainerLarge3">
					<?if(isset($_GET['code']) && $_SESSION['TXT_USER_EMAIL']!=""){?>
						<div id="msgSuccess"  style="color: green; width: 316px; margin-left: -32px; height: 28px; margin-top: -11px;">User : <?echo $_SESSION['TXT_USER_EMAIL'];?> successfully registered.</div>
						<?session_unset();
						unset($_SESSION['podio-php-session']);
					}?>
					<div style="width: 325px; margin-left: -35px;">
						<label for="email" class="label4">Email:</label>
						<input  class="mediumText"  id="clsLogin_customer_email"  name="clsLogin_customer_email" tabindex="1" required type="email" value="<?echo $this->sign_up_model->userName;?>" style="width:264px;"/>
					</div>
				</div><br/>
				<!--<div  class="itemContainerLarge3">
					<label for="password2" class="label4">Password:</label>
					<input  class="mediumText" id="clsLogin_customer_password" required  name="clsLogin_customer_password" tabindex="2" type="password" value="<?echo $this->sign_up_model->userPassword;?>"  >
				</div><br/>
				<div  class="itemContainerLarge3">
					<label for="client_id" class="label4">Client ID:</label>
					<input  class="mediumText" id="client_id"  required name="client_id" tabindex="3" type="text" value="<?echo $this->sign_up_model->client_id;?>" >
				</div><br/>
				<div  class="itemContainerLarge3">
					<label for="secret_key" class="label4">Secret Key:</label>
					<input  class="mediumText" id="secret_key"  required name="secret_key" tabindex="4" type="password" value="<?echo $this->sign_up_model->secret_key;?>"  >
				</div>-->
		<!--		<div class="submit">
					<a href="<?echo site_url('sign_in');?>">Already a member? Login here</a>
					<button type="submit" name="register"  class="uk-button uk-button-primary uk-button-small" tabindex="3" onclick="javascript:validateRegistration();">Register & Login</button>
				</div>
			</div>

		</form>	
</div> -->
 <? //$this->load->view('footer'); ?>
