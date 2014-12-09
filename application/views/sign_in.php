<? $this->load->view('indexHeader');?>
			
			
	<script type="text/javascript">
		<?if(!isset($_GET['reg'])){?>
			$(function() {
					$("#userName").focus();
				});
		<?}else{?>
			$(function() {
					$("#userPassword").focus();
				});
		<?}?>

		function validateLogin()
		{
				var frm = document.frmMain;
				frm.submitted.value=1;
				frm.form_action.value='LOGIN_NOW';
				frm.submit();	
		}
	</script> 
	<?$loadEmail = "";
	if(isset($_GET['reg'])){
		$loadEmail = $_GET['reg'];?>
		<div class="uk-alert" data-uk-alert="">
			<a href="" class="uk-alert-close uk-close"></a>
			<p>Congratulations!&nbsp; You have successfully registered in Spreadsheet for Podio.<br/>
			Your account password has been sent to your email, <?echo $loadEmail; ?>. Please check your email.
			</p>
		</div> 
		<?session_unset();
		unset($_SESSION['podio-php-session']);
	}?>
	<div class="left">
		<form class="uk-form" onsubmit="return false;" method="POST" name="frmMain" action="">
			<input type="hidden" name="submitted" value="0" />
			<input type="hidden" name="form_action" value="" />
			<fieldset>
				<!--<div id="status">
					<?php if(!empty($message)) { ?>
						<div class="uk-alert uk-alert-danger" data-uk-alert="">
								<a href="" class="uk-alert-close uk-close"></a>
								<p><?php echo "kjgjhg"?></p>
						</div>
					<?php } ?>
				</div>-->
				
				<legend>Sign-in with your account</legend>
				<p><input type="email" name="userName" id="userName" placeholder="Email" class="uk-form-width-medium uk-form-large customtext" 
					required value="<?echo $loadEmail;?>"/>
				</p>
				<p><input type="password" name="userPassword" id="userPassword" placeholder="Password" required  class="uk-form-width-medium uk-form-large customtext"/></p>
				<p>
					<input type="submit" name="sign_in" id="sign_in" class="uk-button uk-button-primary uk-button-large" value="Sign-in" onclick="javascript:validateLogin()"/>
					<span><a href="<?php echo base_url();?>forget">Forgot your password?</a></span>
				</p>
			</fieldset>
		</form>
	</div>
	<div class="right">
		<form class="uk-form"  method="post" id="frm-backup" action="<? echo base_url();?>sign_up">
			<fieldset>
				<legend>Create an account</legend>
				<p class="content">
				Spreadsheet Podio is a complete app solution for your Podio data. Please register your details by clicking the below button.
				</p>
				<p><input type="submit" name="create-backup" id="create-backup" class="uk-button uk-button-primary uk-button-large" value="Create an account"/></p>
			</fieldset>
		</form>
	</div> 
			
<? $this->load->view('indexFooter');?>		
			
			
		
 
 
 
 
 
 <?// $this->load->view('header');?>
<!--<script type="text/javascript">
<?if(!isset($_GET['reg'])){?>
    $(function() {
            $("#userName").focus();
        });
<?}else{?>
	$(function() {
            $("#userPassword").focus();
        });
<?}?>

function validateLogin()
{
	 
		var frm = document.frmMain;

 
		frm.submitted.value=1;
		frm.form_action.value='LOGIN_NOW';
		frm.submit();	
}
</script> 
   
 <div id="login-wrapper"  style="margin-top: 85px;">

            <div align="center"><img src="<? echo base_url();?>briefcase/images/TECHeGO.png" title="TechEgo" alt="TechEgo" /></div>	
            <br />
            
            <div id="form-wrapper">
            
            	
            
			<form class="uk-form uk-margin uk-form-horizontal" style="margin:0px;" onsubmit="return false;" method="POST" name="frmMain" action="">
                                        
                <input type="hidden" name="submitted" value="0" />
                <input type="hidden" name="form_action" value="" />
					<?$loadEmail = "";
					if(isset($_GET['reg'])){
						$loadEmail = $_GET['reg'];?>
						<div id="msgSuccess"  style="color: green; width: 316px; margin-left: -2px; height: 55px; margin-top: -11px;">
							An email has been sent to <?echo $loadEmail;?> <br />containing an auto-generated password.
						</div>
						<?session_unset();
						unset($_SESSION['podio-php-session']);
					}?>
					
                    <div class="login" style="background:none">
                        <div class="email">
                            <label for="email">Email:</label>
                            <input class="uk-form-width-large uk-form-large" id="userName" 
                                name="userName" tabindex="1" type="text" required value="<?echo $loadEmail;?>" />
                        </div>
                        <br />
                        <div class="password">
                            <label for="password">Password:</label>
                            <input  class="uk-form-width-large uk-form-large" id="userPassword" 
                                name="userPassword" tabindex="2" required type="password" value=""  >
								
                        </div>
                    </div>
                    <div class="submit" style="width: 367px;">
			<a href="<?echo site_url('sign_up');?>">Register Now</a>
		        <button type="submit" name="commit"  style="border-left-width: 1px; margin-left: 212px;" onclick="javascript:validateLogin()" class="uk-button uk-button-primary uk-button-small" tabindex="3">Login</button>
		    </div>

                </form>
               </div>
                                    
 </div>-->
 <?// $this->load->view('footer'); ?> 
