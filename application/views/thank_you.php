 <? $this->load->view('header');
 
 ?>
 
 
	<div id="main-wrapper">
	 <br/>
		<div class="innerBoxMed2"><div class="headerCurv">Congragulations!!! Shipped Successfully.</div>	<br/><br/><br/><br/><br/><br/>
		 
		<h2 class="heading1">Thank you for using this service.</h2>
		<p class="label3">Your Tracking id is : <?echo $track_id;?>
		<p class="label3">
		
		<?if($fid != 0){?>
		<a href="https://files.podio.com/<?echo $fid;?>" target="_blank">View your label</a>
		<?}
		else{?>
			<a href="<?echo base_url();?>labels/shipexpresslabel<?echo $track_id;?>.pdf" target="_blank">View your label</a>
		<?}?>
		</div>
	
	</div>
 <? $this->load->view('footer'); ?>