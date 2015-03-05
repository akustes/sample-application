			
			</div>
		</div>
	      
	</div>
	
	<script type="text/javascript">
    	base_url = '<?= base_url()?>';
	</script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/bootstrap.min.js"></script>
    
    <? if($this->router->fetch_class() == 'dashboard'):?>
	    <script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/excanvas.min.js"></script>
	    <script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/jquery.flot.min.js"></script>
	    <script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/jquery.flot.resize.js"></script>
	    <script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/charts.js"></script>
    <? endif?>
    
    <? if(session('role_id') == 1):?>
    	<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/admin.js"></script>
    <? endif?> 
    
    <? if($this->router->fetch_class() == 'accounts'):?>
	 
	     <? if(active_module('accounts')):?>
	            <? if(permission_check('accounts', 'view')):?>
					<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/accounts.js"></script>
				<? endif?>
	     <? endif?>
	     
	 <? endif?>
	 
	 <? if($this->router->fetch_class() == 'events'):?>
	 
	     <? if(active_module('events')):?>
	            <? if(permission_check('events', 'view')):?>
	            	<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/jquery.datetimepicker.js"></script>
					<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/events.js"></script>
				<? endif?>
	     <? endif?>
	     
	 <? endif?>
	 
	  <? if($this->router->fetch_class() == 'messages'):?>
	 
	     <? if(active_module('messages')):?>
	            <? if(permission_check('messages', 'view')):?>
					<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/messages.js"></script>
				<? endif?>
	     <? endif?>
	     
	 <? endif?>
	 
	 
	<? if($this->router->fetch_class() == 'profiles'):?>
	 
	     <? if(active_module('profiles')):?>
	            <? if(permission_check('profiles', 'view')):?>
					<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/profiles.js"></script>
					<script src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/js/owl.carousel.js"></script>
				<? endif?>
	     <? endif?>
	     
	 <? endif?>


           
  </body>
</html>