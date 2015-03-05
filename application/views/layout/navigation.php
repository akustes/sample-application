<!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/xs_logo.png" alt="Verified Arrangements" /></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="<?= current_module('dashboard')?>"><a href="<?= site_url('dashboard')?>"><span class="glyphicon glyphicon-dashboard"></span>  <?= lang('nav_dashboard')?></a></li>
            	        
	        <? if(active_module('profiles')):?>
	            <li class="dropdown <?= current_module('profiles')?>">
		          <a href="<?= site_url('profiles')?>"><span class="glyphicon glyphicon-user"></span> <?= lang('nav_profiles')?> <b class="caret hidden-xs"></b></a>
		          <ul class="dropdown-menu hidden-xs">
		          	<? if(permission_check('profiles', 'view')):?>
		          		<li><a href="<?= site_url('profiles/index')?>"><span class="glyphicon glyphicon-list-alt"></span> <?= lang('nav_view')?></a></li>
		            	<li><a href="<?= site_url('profiles/favorites')?>"><span class="glyphicon glyphicon-heart"></span> <?= lang('nav_favorites')?></a></li>
		           	 	<li><a href="<?= site_url('profiles/search')?>"><span class="glyphicon glyphicon-search"></span>  <?= lang('nav_search')?></a></li>
		            <? endif?>
		            <li class="divider"></li>
		            <li class="dropdown-header"><?= lang('nav_my_profile')?></li>
		            <? if(permission_check('profiles', 'view')):?>
		            <li><a href="<?= site_url('profiles/view/' . session('id'))?>"><span class="glyphicon glyphicon-list-alt"></span> <?= lang('nav_view')?></a></li>
		            <? endif?>
		            <? if(permission_check('profiles', 'edit')):?>
		            	<li><a href="<?= site_url('profiles/edit')?>"><span class="glyphicon glyphicon-pencil"></span> <?= lang('nav_edit')?></a></li>
		            <? endif?>
		            <? if(permission_check('profiles', 'view')):?>
		            	<li><a href="<?= site_url('members/viewedme')?>"><span class="glyphicon glyphicon-question-sign"></span> <?= lang('nav_who_viewed_me')?></a></li>
		            	<li><a href="<?= site_url('profiles/iviewed')?>"><span class="glyphicon glyphicon-list"></span> <?= lang('nav_who_i_viewed')?></a></li>
		            	<li><a href="<?= site_url('profiles/blocked')?>"><span class="glyphicon glyphicon-ban-circle"></span> <?= lang('nav_blocked')?></a></li>
		          	<? endif?>
		          </ul>
		        </li>
			<? endif?>
            
            <? if(active_module('messages')):?>
            
            <?
						$nav_messages = $this->messages_model->get_preview(session('id'));
						$unread = $this->messages_model->get_unread(session('id'));
            ?>
	            <? if(permission_check('messages', 'view')):?>
				<li class="drop down <?= current_module('messages')?>">
						<a href="<?= site_url('messages')?>" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-envelope"><span class="badge" style="background-color: #ff0000;"><?= $unread?></span></span>  <?= lang('nav_messages')?> <b class="caret hidden-xs"></b></a>
	                    <ul class="dropdown-menu message-dropdown hidden-xs">
	                        	<? if($nav_messages):?>
								  	<? foreach($nav_messages as $nav_message):?>
								  	 <li class="message-preview">
			                         <a href="<?= site_url('messages/detail/' . $nav_message['message_id'])?>">
			                                <div class="media">
			                                    <span class="pull-left">
			                                        <img class="media-object" src="<?= base_url()?>assets/images/accounts/thumbs/<?= $nav_message['account_image']?>" width="50" height="40" alt="">
			                                    </span>
			                                    <div class="media-body">
			                                        <h5 class="media-heading"><strong><?= $nav_message['account_username']?></strong> <span class="label <?= (account_online($nav_message['message_from_account_id'])) ? 'label-success' : 'label-default'?>"><?= (account_online($nav_message['message_from_account_id'])) ? lang('nav_online') : lang('nav_offline')?></span></h5>
			                                        <p class="small text-muted"><i class="glyphicon glyphicon-time"></i> <?= unix_to_human($nav_message['message_created_date'], TRUE, 'us')?> </p>
			                                        <p><strong><?= $nav_message['message_subject']?></strong></p>
			                                        <p><?= word_limiter($nav_message['message_body'], 20)?></p>
			                                    </div>
			                                </div>
			                            </a>
			                        </li>
								  	<? endforeach?>
							    <? else:?>
							    	<tr>
							    		<td colspan="5" align="center"><?= lang('message_no_messages')?></td>
							    	</tr>
							    <? endif?>
	                       	<li class="message-footer">
	                            <a href="<?= site_url('messages/index')?>"><strong><?= lang('nav_read_all_messages')?></strong></a>
	                        </li>
	                    </ul>
	               </li>
	          	<? endif?>
          	<? endif?>
          	
                    	
          	<? if(active_module('accounts')):?>
	            <li class="dropdown <?= current_module('accounts')?>">
		          <a href="<?= site_url('accounts/manage/' . session('id') . '/edit')?>"><span class="glyphicon glyphicon-cog"></span> <?= lang('nav_accounts')?> <b class="caret hidden-xs"></b></a>
		          <ul class="dropdown-menu hidden-xs">
		             <? if(session('role_id') <= 2):?>
			          	 <? if(permission_check('accounts', 'add')):?>
			          	 	<li><a href="<?= site_url('accounts/manage/add')?>"><span class="glyphicon glyphicon-plus"></span> <?= lang('nav_new')?></a></li>
			          	 	<li class="divider"></li>
			          	 <? endif?>
		          	 <? endif?>
		          	 <li class="dropdown-header"><?= lang('nav_information')?></li>
					 <? if(session('role_id') <= 2):?>
			          	 <? if(permission_check('accounts', 'view')):?>
			          	 	<li><a href="<?= site_url('accounts/index')?>"><span class="glyphicon glyphicon-list-alt"></span> <?= lang('nav_view')?></a></li>
			          	 <? endif?>
		          	 <? endif?>
		          	 <? if(permission_check('accounts', 'edit')):?>
		          		 <li><a href="<?= site_url('accounts/manage/' . session('id') . '/edit')?>"><span class="glyphicon glyphicon-pencil"></span> <?= lang('nav_edit')?></a></li>
		             	 <li><a href="<?= site_url('accounts/billing/' . session('id') . '/view')?>"><span class="glyphicon glyphicon-credit-card"></span> <?= lang('nav_billing')?></a></li>
		             <? endif?>
		             <li class="divider"></li>
		             <li class="dropdown-header"><?= lang('nav_security')?></li>
		             <? if(permission_check('accounts', 'edit')):?>
		             	<li><a href="<?= site_url('accounts/password/' . session('id') . '/view')?>"><span class="glyphicon glyphicon-lock"></span><?= lang('nav_change_password')?></a></li>
		             	
		          	<? endif?>
		          </ul>
		        </li>
	        <? endif?>
	       
            
            <li class="<?= current_module('logout')?>"><a href="<?= site_url('access/logout')?>"><span class="glyphicon glyphicon-off"></span>  <?= lang('nav_logout')?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
    <br />
    