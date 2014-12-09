
<? $this->load->view('indexHeader');?>		
		 
	<script  type="text/javascript">
		function forgotPassword(){
			var frm = document.frmMain;
			frm.submitted.value=1;
			frm.form_action.value='FORGET_MAIL';
			frm.submit()
		}
	</script>
	
	<form class="uk-form"  method="post" name="frmMain" action="" onsubmit="return false;">
		<input type="hidden" name="submitted" value="0" />
		<input type="hidden" name="form_action" value="" />
		<fieldset>
			<!--<div id="status">
				<?php 
				if(!empty($message)) { ?>
					<div class="uk-alert uk-alert-danger" data-uk-alert="">
							<a href="" class="uk-alert-close uk-close"></a>
							<p><?php echo $message?></p>
					</div>
				<?php } ?>
			</div>-->
		
			<legend>Forgot your password?</legend>
			<p><input type="email" name="txtforgotuserEmail" id="txtforgotuserEmail" placeholder="Please enter your email" class="uk-form-width-medium uk-form-large customtext" required/>
			</p>
			<p>
				<input type="submit" name="forgot_password" id="forgot_password" class="uk-button uk-button-primary uk-button-large" onclick="forgotPassword()" value="Recover Password"/>
				<!-- <input type="reset" name="cancel_password" id="cancel_password" class="uk-button uk-button-primary uk-button-large" value="Cancel"/> -->
				&nbsp; &nbsp; &nbsp; <span><a href="<?php echo base_url();?>sign_in">Back to login? Click Here.</a></span>
			</p>
		</fieldset>
	</form>
			
<? $this->load->view('indexFooter');?>		
			
