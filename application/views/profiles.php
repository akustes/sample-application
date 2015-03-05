   		   
		   <div class="page-header">
				<h1><?= lang('profiles_title')?></h1>
		   </div>
		   
		   
		   <div class="row">
		   
		   <div class="col-xs-12">
			   <div class="btn-group visible-xs">
			   <? if($this->access->permission('profiles', 'view', $this->session->userdata('permissions'))):?>
				  <a href="<?= site_url('profiles/index')?>" class="btn btn-default"><span class="glyphicon glyphicon-heart"></span></a>
				  <a href="<?= site_url('profiles/favorites')?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></a>
			   <? endif?>
			   
			   <? if($this->access->permission('profiles', 'view', $this->session->userdata('permissions'))):?>
				  <a href="<?= site_url('profiles/search')?>" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></a>
			  <? endif?>
			  
			  <? if($this->access->permission('profiles', 'edit', $this->session->userdata('permissions'))):?>
				 <a href="<?= site_url('profiles/index')?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
			  <? endif?>
			  
			  <? if($this->access->permission('profiles', 'view', $this->session->userdata('permissions'))):?>
				  <a href="<?= site_url('profiles/edit')?>" class="btn btn-default"><span class="glyphicon glyphicon-question-sign"></span></a>
				  <a href="<?= site_url('members/viewedme')?>" class="btn btn-default"><span class="glyphicon glyphicon-list"></span></a>
				  <a href="<?= site_url('profiles/iviewed')?>" class="btn btn-default"><span class="glyphicon glyphicon-signal"></span></a>
		      <? endif?>
			   </div>
			</div>
		   </div>
		   		
		   <div class="row">&nbsp;</div>
		   
			<? if($section == 'list'):?>
	        	<? if($profiles):?>
	        	
	        		<?= $pages?>
	        		
	        		<? $i = 0?>
	        		
	        		<? foreach($profiles as $profile):?>
	        		
	        		<? if($i % 4 == 0):?>
	       				<div class="row">
	    			<? endif?>
	    				<div class="col-sm-3 col-md-3" align="center">
		                	<div class="member-wrap">
			                    <img class="img-responsive" src="<?= base_url()?>assets/images/accounts/medium/<?= $profile['account_image']?>" alt="<?= $profile['profile_name']?>, <?= $profile['profile_age']?>">
			                    <div class="overlay">
			                        <div class="member-inner">
			                            <h3><a href="<?= site_url('profiles/view/' . $profile['profile_id'])?>"><?= $profile['profile_name']?>, <?= $profile['profile_age']?></a> <small><span class="label <?= (account_online($profile['account_id'])) ? 'label-success' : 'label-default'?>"><?= (account_online($profile['account_id'])) ? lang('profiles_online') : lang('profiles_offline')?></span></small></h3>
			                            <p><?= word_limiter($profile['profile_bio'], 20)?></p>
			                            <a class="btn btn-custom" href="<?= site_url('profiles/view/' . $profile['profile_id'])?>" rel="prettyPhoto"><span class="glyphicon glyphicon-eye-open"></span> <?= lang('profiles_view_profile')?></a>
			                        </div> 
			                    </div>
		              		</div>
		              		<br />
		              	</div>
	
		                <? if($i % 4 == 4):?>
				             </div>
				        <? endif?>
				               
				      <? $i++;?>
	                <? endforeach?>
	                
	               </div>
	                
	     		   <?= $pages?>
	     		
	            <? endif?>
            <? endif?>
            
            
            <? if($section == 'view'):?>
            	
            	<div class="row">
            		
            		<? if($profiles):?>
            	
					<div class="col-sm-3 col-md-2 col-lg-2">
							<p><img class="thumbnail img-responsive" src="<?= base_url()?>assets/images/accounts/medium/<?= $profiles['account_image']?>" alt="<?= $profiles['profile_name']?>, <?= $profiles['profile_age']?>"></p>
							<div class="panel panel-default">
							  <div class="panel-body">
							  	<div class="btn-group-vertical" role="group">
							   		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#confirm-message"><span class="glyphicon glyphicon-envelope"></span> <?= lang('profiles_send_message')?> </button>
							   		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#confirm-favorite"><span class="glyphicon glyphicon-heart"></span> <?= lang('profiles_favorite')?> </button>
							   		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#confirm-blocked"><span class="glyphicon glyphicon-ban-circle"></span> <?= lang('profiles_member_block')?> </button>
							   	</div>
							  </div>
							</div>
							<p align="center"><span class="label <?= (account_online($profiles['account_id'])) ? 'label-success' : 'label-default'?>"><?= (account_online($profiles['account_id'])) ? lang('profiles_online') : lang('profiles_offline')?></span></p>
							<p>Last Login:<br /><?= convert_to_human($profiles['profile_last_login_date'], TRUE)?></p>
					</div>
						
					<div class="col-sm-9 col-md-10 col-lg-10">
							<div class="panel panel-default">
							  <div class="panel-heading">
							    <h3 class="panel-title"><strong><?= $profiles['profile_name']?></strong> <?= lang('profiles_age')?> <?= $profiles['profile_age']?> <?= lang('profiles_seeking')?> <?= $profiles['profile_seeking']?> <?= lang('profiles_from')?> <?= $profiles['profile_city']?>, <?= $profiles['profile_state']?></h3>
							  </div>
							  <div class="panel-body">
							    <p><?= $profiles['profile_bio']?></p>
							  </div>
							</div>
							
							<div class="panel panel-default">
								  <div class="panel-heading">
								    <h3 class="panel-title"><?= lang('profiles_member_attributes')?></h3>
								  </div>
								  <div class="panel-body">
									    <div role="tabpanel">
										  <!-- Nav tabs -->
										  <ul class="nav nav-tabs" role="tablist">
										    <li role="presentation" class="active"><a href="#stats" aria-controls="stats" role="tab" data-toggle="tab"><?= lang('profiles_stats')?></a></li>
										    <li role="presentation"><a href="#background" aria-controls="background" role="tab" data-toggle="tab"><?= lang('profiles_background')?></a></li>
										    <li role="presentation"><a href="#education" aria-controls="education" role="tab" data-toggle="tab"><?= lang('profiles_education')?></a></li>
										    <li role="presentation"><a href="#habits" aria-controls="habits" role="tab" data-toggle="tab"><?= lang('profiles_habits')?></a></li>
										  </ul>
										
										  <!-- Tab panes -->
										  <div class="tab-content">
										    <div role="tabpanel" class="tab-pane active" id="stats">
										    	<table class="table table-striped">
													<tr>
														<td width="15%"><strong><?= lang('profiles_height')?></strong></td>
														<td><?= $profiles['profile_height']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_body_type')?></strong></td>
														<td><?= $profiles['profile_body_type']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_eye_color')?></strong></td>
														<td><?= $profiles['profile_eye_color']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_hair_color')?></strong></td>
														<td><?= $profiles['profile_hair_color']?></td>
													</tr>
												</table>
										    </div>
										    <div role="tabpanel" class="tab-pane" id="background">
										    	<table class="table table-striped">
													<tr>
														<td width="15%"><strong><?= lang('profiles_ethnicity')?></strong></td>
														<td><?= $profiles['profile_ethnicity']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_language')?></strong></td>
														<td><?= $profiles['profile_language']?></td>
													</tr>
												</table>
										    </div>
										    <div role="tabpanel" class="tab-pane" id="education">
										    	<table class="table table-striped">
													<tr>
														<td width="15%"><strong><?= lang('profiles_marital_status')?></strong></td>
														<td><?= $profiles['profile_marital_status']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_education')?></strong></td>
														<td><?= $profiles['profile_education']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_occupation')?></strong></td>
														<td><?= $profiles['profile_occupation']?></td>
													</tr>
												</table>
										    </div>
										    <div role="tabpanel" class="tab-pane" id="habits">
										    	<table class="table table-striped">
													<tr>
														<td width="15%"><strong><?= lang('profiles_habit_smoking')?></strong></td>
														<td><?= $profiles['profile_habit_smoking']?></td>
													</tr>
													<tr>
														<td width="15%"><strong><?= lang('profiles_habit_drinking')?></strong></td>
														<td><?= $profiles['profile_habit_drinking']?></td>
													</tr>
												</table>
										    </div>
										  </div>
										
										</div>
								  </div>
							</div>
							
							<div class="panel panel-default">
								  <div class="panel-heading">
								    <h3 class="panel-title"><?= lang('profiles_member_photos')?></h3>
								  </div>
								  <div class="panel-body">
								  	
										<div class="owl-carousel-images">
			           
			                				<!-- php -->
			                				<? if($images):?>
			                					
			                					<? $i = 0; ?>
			                				
			                					
			                					<? foreach($images as $image):?>
			                					
			                					
			                					<? if($image['profile_image_file_name']):?>
			                						<?php $main_image1 = $image['profile_image_file_name']?>
			                						<? else:
			                						$main_image1 = 'no_image.jpg'?>
			                						<? endif; ?>
			                						
			                						<div class="item" data-hash="<?= $image['profile_image_id'] ?>">
			                				            <img class="open" data-image-source="<?= base_url()?>assets/images/profiles/<?= $main_image1 ?>" src="<?= base_url()?>assets/images/profiles/thumbs/<?= $main_image1 ?>" />
			                				        </div>

			                					<? $i++; ?>		
			                
			                					 <? endforeach?>
 
			                				 <? endif?>
			                				<!-- php -->
			                              
			              
			              
			                        </div><!-- owl-example -->
									   
							 	 </div>
						   </div>
					</div>
					
					<? else:?>
						<h2 align="center">Member Not Available or Does Not Exist</h2>
					<? endif?>
					
				</div>
            
            <? endif?>
            
            
            <? if($section == 'form'):?>
            	
            	
            
            <? endif?>
            
            



<!-- MODALS -->				
 <div class="modal fade" id="confirm-message" tabindex="-1" role="dialog" aria-labelledby="Modalmessage" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalmessage"><?= lang('profiles_send_message')?></h4>
                </div>
            
                <div class="modal-body">
                    	<form id="composeForm" role="form" method="post">
						<input type="hidden" name="from_account_id" value="<?= session('id')?>" />
						<input type="hidden" name="to_account_id" value="<?= $profiles['account_id']?>" />
										
							<div class="form-group">
								<label for="subject">Subject</label>
								<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" />
							</div>
							<div class="form-group">
								<label for="message">Message</label><br />
								<textarea class="form-control" name="message" rows="5"></textarea>
							</div>
					
						</form>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('profiles_cancel')?></button>
                    <button type="button" class="btn btn-custom" id="send-message"><?= lang('profiles_send')?></a>
                </div>
            </div>
        </div>
    </div>
 
 
 <div class="modal fade" id="confirm-favorite" tabindex="-1" role="dialog" aria-labelledby="Modalfavorite" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalfavorite"><?= lang('profiles_favorite')?></h4>
                </div>
            
                <div class="modal-body">
                   		<form id="favoriteForm" role="form" method="post">
						<input type="hidden" name="viewed_account_id" value="<?= $profiles['account_id']?>" />
						</form>
						<p><?= lang('profiles_confirm_favorite')?></p>
						<p><?= lang('profiles_proceed')?></p>
						
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('profiles_cancel')?></button>
                    <button type="button" class="btn btn-custom" id="favorite"><?= lang('profiles_confirm')?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="confirm-blocked" tabindex="-1" role="dialog" aria-labelledby="Modalblocked" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalblocked"><?= lang('profiles_confirm_blocked')?></h4>
                </div>
            
                <div class="modal-body">
                    	<form id="blockedForm" role="form" method="post">
						<input type="hidden" name="viewed_account_id" value="<?= $profiles['account_id']?>" />
						</form>
						<p><?= lang('profiles_confirm_blocked')?></p>
						<p><?= lang('profiles_proceed')?></p>
						
                    <!--<p class="debug-url"></p>-->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('profiles_cancel')?></button>
                    <button type="button" class="btn btn-danger" id="blocked"><?= lang('profiles_confirm')?></a>
                </div>
            </div>
        </div>
    </div>
    
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>     
          <div class="modal-body">        
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->