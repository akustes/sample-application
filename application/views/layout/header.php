<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= lang('meta_title')?></title>

    <!-- Bootstrap -->
    <link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/style.css" rel="stylesheet">
    
    <!-- Custom CSS for Modules -->
	 
	 <? if($this->router->fetch_class() == 'profiles'):?>
	 
	      <? if(active_module('profiles')):?>
	            <? if(permission_check('profiles', 'view')):?>
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/profiles.css" rel="stylesheet">
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/owl.carousel.min.css" rel="stylesheet">
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/owl.theme.css" rel="stylesheet">
				<? endif?>
	     <? endif?>
	     
	 <? endif?>
	 
	 <? if($this->router->fetch_class() == 'messages'):?>
	 
	     <? if(active_module('messages')):?>
	            <? if(permission_check('messages', 'view')):?>
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/messages.css" rel="stylesheet">
				<? endif?>
	     <? endif?>
	     
	 <? endif?>
	 
	 <? if($this->router->fetch_class() == 'accounts'):?>
	 
	     <? if(active_module('accounts')):?>
	            <? if(permission_check('accounts', 'view')):?>
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/accounts.css" rel="stylesheet">
				<? endif?>
	     <? endif?>
	     
	 <? endif?>
	 
	  <? if($this->router->fetch_class() == 'events'):?>
	 
	     <? if(active_module('events')):?>
	            <? if(permission_check('events', 'view')):?>
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/events.css" rel="stylesheet">
					<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/jquery.datetimepicker.css" rel="stylesheet">
				<? endif?>
	     <? endif?>
	     
	 <? endif?>

	 
	 
	 <? if($this->router->fetch_class() == 'admin'):?>
	 
	     <? if(active_module('admin')):?>
	            <? if(permission_check('admin', 'view')):?>
	            	<link href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/css/admin.css" rel="stylesheet">
				<? endif?>
	     <? endif?>
	     
	 <? endif?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="shortcut icon" href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/ico/apple-touch-icon-57-precomposed.png">

    
  </head>
  <body role="document">
   
