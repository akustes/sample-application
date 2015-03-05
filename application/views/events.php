				<div class="page-header">
					<h1>
					<? if($section == 'form' || $section == 'view'):?>
						<a href="<?= site_url('events')?>"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
					<? endif?>

					<?= ($section == 'list') ? lang('events') . ' (' . $total . ')' : lang('my_event')?></h1>
				</div>
						
				<? if($section == 'list'):?>
				
				<? if(permission_check('events', 'edit')):?>
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6">
						<div class="btn-group">
						  <? if(permission_check('events', 'add')):?><a href="<?= site_url('events/manage/add')?>" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> <?= lang('events_add')?></a><? endif?>
						  <a href="<?= site_url('events/index/active')?>" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> <?= lang('events_active')?></a>
						  <a href="<?= site_url('events/index/not_active')?>" class="btn btn-default"><span class="glyphicon glyphicon-minus"></span> <?= lang('events_not_active')?></a>
						  <a href="<?= site_url('events/index/completed')?>" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> <?= lang('events_completed')?></a>
						  <a href="<?= site_url('events/index/deleted')?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> <?= lang('events_trash')?></a>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6" align="right">
						<form action="<?= site_url('events/index/search')?>" method="post" role="form">
				  			<div class="input-group">
						      	<input type="text" id="keyword" name="keyword" class="form-control" placeholder="Event Name">
						      	<span class="input-group-btn">
						        	<input type="submit" class="btn btn-custom" value="<?= lang('events_search')?>" />
						      	</span>
			            	</div>
					    </form>
					</div>
				</div>
				<? endif?>
				
				<div class="row">&nbsp;</div>
				
				<div class="row"><?= (isset($pages)) ? $pages : ''?></div>
				
				<div class="row">&nbsp;</div>
				
				  <table class="table table-striped table-hover">
					  <thead>
					  	 <tr>
					  	 	 <th class="table-header-flat-center"><?= lang('events_date')?></th>
			  			 	 <th class="table-header-flat-center"><?= lang('events_name')?></th>
			  			 	 <th class="table-header-flat-center"><?= lang('events_status')?></th>
			  			 	 <th class="table-header-flat-center">&nbsp;</th>
					  	 </tr>
					  </thead>
				  
					  <tbody>
		            	<? if($events):?>
						  	<? foreach($events as $event):?>
						  	
						  	<?
								switch($event['event_invite_status'])
								{
									case 'attending':
										$label_class = 'label-success';
									break;
									case 'invited':
										$label_class = 'label-warning';
									break;
									case 'invite':
										$label_class = 'label-primary';
									break;
									case 'not_attending':
										$label_class = 'label-default';
									break;
									case 'cancelled':
										$label_class = 'label-danger';
									break;
									default:
										$label_class = 'label-default';
								}
							?>

						  	<tr>
						  		<td align="center"><?= unix_to_human($event['event_start_date'], TRUE, 'us')?></td>	
								<td align="center"><?= $event['event_name']?></td>
								<td align="center"><span class="label <?= $label_class?>"><?= ucfirst($event['event_invite_status'])?></span></td>
								
								<td>
								<!-- Split button -->
								<div class="btn-group">
								<? if(session('role_id') <= 2):?>
									<button class="btn btn-custom dropdown-toggle" type="button" data-toggle="dropdown">
    								<?= lang('events_action')?> <span class="caret"></span>
  							     	</button>
								  	<ul class="dropdown-menu" role="menu">
								   	<? if(permission_check('events', 'view')):?>
										<li><a href="<?= site_url('events/view/' . $event['event_id'])?>"><span class="glyphicon glyphicon-eye-open" title="<?= lang('events_view')?>"></span> <?= lang('events_view')?></a></li>
									<? endif?>
									<? if(permission_check('events', 'edit')):?>
										<? $active_action = ($event['event_active'] == 1) ? 'deactive' : 'active'?>
										<? $completed_action = ($event['event_completed'] == 1) ? 'not_completed' : 'completed'?>
										<? $delete_action = ($event['event_deleted'] == 0) ? 'delete' : 'restore'?>
										<li><a href="#" data-href="<?= site_url('events/status/' . $event['event_id'] . '/' . $active_action)?>" data-toggle="modal" data-target="<?= ($event['event_active'] == 1) ? '#confirm-deactive' : '#confirm-active'?>"><span class="glyphicon <?= ($event['event_active'] == 1) ? 'glyphicon-minus' : 'glyphicon-ok'?>" title="<?= lang('events_active_deactive')?>"></span> <?= ($event['event_active'] == 1) ? lang('events_deactive') : lang('events_active')?></a> </li>
										<li><a href="#" data-href="<?= site_url('events/status/' . $event['event_id'] . '/' . $completed_action)?>" data-toggle="modal" data-target="<?= ($event['event_completed'] == 1) ? '#confirm-not-completed' : '#confirm-completed'?>"><span class="glyphicon <?= ($event['event_completed'] == 1) ? 'glyphicon-minus' : 'glyphicon-ok'?>" title="<?= lang('events_completed')?>"></span> <?= ($event['event_completed'] == 1) ? lang('events_not_completed') : lang('events_completed')?></a> </li>
										<li><a href="<?= site_url('events/manage/' . $event['event_id'] . '/edit')?>"><span class="glyphicon glyphicon-pencil" title="<?= lang('events_edit')?>"></span> <?= lang('events_edit')?></a></li>
										<? if(permission_check('events', 'delete')):?><li><a href="#" data-href="<?= site_url('events/status/' . $event['event_id'] . '/' . $delete_action)?>" data-toggle="modal" data-target="<?= ($event['event_deleted'] == 1) ? '#confirm-restore' : '#confirm-delete'?>" title="<?= lang('events_delete')?>"><span class="glyphicon <?= ($event['event_deleted'] == 1) ? 'glyphicon-share' : 'glyphicon-remove'?>"></span> <?= ($event['event_deleted'] == 1) ? lang('events_restore') : lang('events_delete')?></a></li><? endif?>
									<? endif?>
								  </ul>

								 <? else:?>
								    <? if(permission_check('events', 'view')):?>
											<a href="<?= site_url('events/view/' . $event['event_id'])?>" class="btn btn-custom"><span class="glyphicon glyphicon-eye-open" title="<?= lang('events_view')?>"></span> <?= lang('events_view')?></a></li>
								    <? endif?>								  
								  <? endif?>
								</div>
								</td>
								
						  	</tr>
						  	<? endforeach?>
					    <? else:?>
					    	<tr>
					    		<td colspan="5" align="center"><?= lang('events_no_results')?></td>
					    	</tr>
					    <? endif?>
						</tbody>
				  </table>
										
			   <div class="row"><?= (isset($pages)) ? $pages : ''?></div>
			
			<? endif?>
			
			<? if($section == 'form'):?>
			
					<? if($message):?>
						<div class="alert alert-info alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('events_close')?></span></button>
							<span class="glyphicon glyphicon-exclamation-sign"> <strong><?= $message?></strong></span>
						</div>
					<? endif?>
					
					<? if(validation_errors()):?>
						<div class="alert alert-warning">
						<span class="glyphicon glyphicon-warning-sign"><strong><?= validation_errors()?></strong></span>
						</div>
					<? endif?>
										
					<? $post_url = ($action == 'add') ? 'events/manage' : 'events/manage/' . $events['event_id'] . '/edit'?>
					
					<form action="<?= site_url($post_url)?>" role="form" method="post">

					
						<? if($action == 'edit'):?>
						<input type="hidden" id="event_id" name="event_id" value="<?= $events['event_id']?>">
						<? endif?>
						
						<input type="hidden" id="action" name="action" value="<?= $action?>">
						   
						  <div class="form-group">
						  	<label for="start_date"><?= lang('events_start_date')?></label>
						  	<div class="input-group date" id="start-date">
                    			<input type="text" id="start_date" name="start_date" class="form-control" value="<?= (isset($events['event_start_date'])) ? unix_to_human($events['event_start_date'], TRUE, 'us') : ''?>" />
                    			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                		  	</div>
						  </div>
						  <div class="form-group">
						  	<label for="end_date"><?= lang('events_end_date')?></label>
						  	<div class="input-group date" id="end-date">
                    			<input type="text" id="end_date" name="end_date" class="form-control" value="<?= (isset($events['event_end_date'])) ? unix_to_human($events['event_end_date'], TRUE, 'us') : ''?>" />
                    			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                		  	</div>
						  </div>
						  <div class="form-group">
						    <label for="name"><?= lang('events_name')?></label>
						    <input type="text" class="form-control" id="name" name="name"  placeholder="<?= lang('event_name')?>" value="<?= (isset($events['event_name'])) ? $events['event_name'] : ''?>">
						  </div>
						  <div class="form-group">
						    <label for="last_name"><?= lang('events_description')?></label>
						    <textarea class="form-control" id="description" name="description" rows="5"><?= (isset($events['event_description'])) ? $events['event_description'] : ''?></textarea>
						  </div>
						  <div class="form-group">
						    <label for="phone"><?= lang('events_phone')?></label>
						    <input type="tel" class="form-control" id="phone" name="phone" pattern="\d{3}[\-]\d{3}[\-]\d{4}" placeholder="<?= lang('event_phone')?> (Format: 999-555-5551)" title="<?= lang('event_phone')?> (Format: 999-555-5551)" value="<?= (isset($events['account_phone'])) ? $events['account_phone'] : ''?>">
						  </div>
						  <div class="form-group">
						    <label for="address"><?= lang('events_address')?></label>
						    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= (isset($events['event_address'])) ? $events['event_address'] : ''?>">
						  </div>
						  <div class="form-group">
						    <label for="city"><?= lang('events_city')?></label>
						    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?= (isset($events['event_city'])) ? $events['event_city'] : ''?>">
						  </div>
						  <div class="form-group">
						    <label for="state"><?= lang('events_state')?></label>
						    	<?= form_dropdown('state', $states, (isset($events['event_state'])) ? $events['event_state'] : '', 'class="form-control"')?>
						  </div>
						   <div class="form-group">
						    <label for="zip"><?= lang('events_zip')?></label>
						    	<input type="text" class="form-control" id="zip" name="zip" pattern="(\d{5}([\-]\d{4})?)" placeholder="<?= lang('events_zip')?>" value="<?= (isset($events['event_zip'])) ? $events['event_zip'] : ''?>">
						  </div>
						  <div class="form-group">
						    <label for="country"><?= lang('events_country')?></label>
						    	<?= form_dropdown('country', $countries, (isset($events['event_country'])) ? $events['event_country'] : '', 'class="form-control"')?>
						  </div>
						  
						  <div class="form-group">
						    <label for="active"><?= lang('events_active')?></label>
						    	<? if($action == 'edit'):?>
						    	<input type="checkbox" <?= ($events['event_active'] == 1) ? 'checked' : ''?> class="form-control" name="active" value="1" />
						    	<? else:?>
						    	<input type="checkbox" class="form-control" name="active" value="1" />
						    	<? endif?>
						  </div>
						  
						  <div class="form-group">
						    <label for="completed"><?= lang('events_completed')?></label>
						    	<? if($action == 'edit'):?>
						    	<input type="checkbox" <?= ($events['event_completed'] == 1) ? 'checked' : ''?> class="form-control" name="completed" value="1" />
						    	<? else:?>
						    	<input type="checkbox" class="form-control" name="completed" value="1" />
						    	<? endif?>
						  </div>
						  
						  <div class="form-group">
							  <div class="btn-group" data-toggle="buttons">
							  <? if($action == 'edit'):?>
							  <label class="btn btn-default <? if (isset($events['event_invite_type']) && $events['event_invite_type'] == 'none'){echo 'active';} ?>">
							  <? else:?>
							   <label class="btn btn-default active">
							  <? endif?>
							    <input type="radio" name="invite_type" value="none"> None
							  </label>
							  <label class="btn btn-default <? if (isset($events['event_invite_type']) && $events['event_invite_type'] == 'both'){echo 'active';} ?>">
							    <input type="radio" name="invite_type" value="both"> Both
							  </label>
							  <label class="btn btn-default <? if (isset($events['event_invite_type']) && $events['event_invite_type'] == 'male'){echo 'active';} ?>">
							    <input type="radio" name="invite_type" value="male"> Males Only
							  </label>
							  <label class="btn btn-default <? if (isset($events['event_invite_type']) && $events['event_invite_type'] == 'female'){echo 'active';} ?>">
							    <input type="radio" name="invite_type" value="female"> Females Only
							  </label>
							</div>
							
						  </div>
						  <? if($action == 'edit'):?>
						   <div class="form-group">
						    	<label for="completed"><?= lang('events_resend_invites')?></label>
						    	<input type="checkbox" class="form-control" name="resend_invites" value="1" />
						   </div>
						  <? endif?>				  
						  
						  <div class="row">
						  	<? if($action == 'edit'):?>
						 	<div class="col-xs-3 col-md-6" align="center">
						 	<? if(permission_check('events', 'delete')):?>
						 	<? $delete_action = (isset($events['event_deleted']) == 1) ? 'restore' : 'delete'?>
						 	<a href="#" data-href="<?= site_url('events/status/' . $events['event_id'] . '/' . $delete_action)?>" class="btn <?= ($events['event_deleted'] == 1) ? 'btn-default' : 'btn-danger'?> btn-lg" data-toggle="modal" data-target="<?= ($events['event_deleted'] == 1) ? '#confirm-restore' : '#confirm-delete'?>" title="<?= lang('events_delete')?>"><span class="glyphicon <?= ($events['event_deleted'] == 1) ? 'glyphicon-share' : 'glyphicon-remove'?>"></span><span class="hidden-xs hidden-sm"><?= ($events['event_deleted'] == 1) ? lang('events_restore') : lang('events_delete')?></span></a>
						 	<? endif?>
						 	</div>
						 	<? endif?>
						 	
						  	<div class="col-xs-3 col-md-6" align="center"><input type="submit" class="btn btn-custom btn-lg" value="<?= ($action == 'add') ? lang('events_add') : lang('events_update')?>"></div>
						  </div>

					</form>

			<? endif?>
			
			
			<? if($section == 'view'):?>
			
				<? if($message):?>
						<div class="alert alert-info alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"><?= lang('events_close')?></span></button>
							<span class="glyphicon glyphicon-exclamation-sign"> <strong><?= $message?></strong></span>
						</div>
				<? endif?>
					
				<h3><?= $events['event_name']?></h3>
				<p><strong>Starts</strong> <?= (isset($events['event_start_date'])) ? unix_to_human($events['event_start_date'], TRUE, 'us') : ''?><br />
				<strong>Ends</strong> <?= (isset($events['event_end_date'])) ? unix_to_human($events['event_end_date'], TRUE, 'us') : ''?>
				</p>
				<p><?= $events['event_description']?></p>
				<hr>
				<? if(session('role_id') <= 2):?>
				<h4>Attendees:</h4>
					<? if($attendees):?>
						<? foreach($attendees as $attendee):?>
							<?= $attendee['account_name']?>, 
						<? endforeach?>
					<? else:?>
						<p><?= lang('no_attendees')?></p>
					<? endif?>
				<? endif?>
				
				<? if(session('role_id') > 2):?>
				<form action="<?= site_url('events/view/' . $events['event_id'])?>" role="form" method="post">
					 <input type="hidden" name="event_invite_event_id" value="<?= $events['event_id']?>" />
					 <input type="hidden" name="event_invite_account_id" value="<?= session('id')?>" />
					 <div class="form-group">
						   <label for="country"><?= lang('events_rsvp')?></label>
						   <?= form_dropdown('response', $response, '', 'class="form-control"')?>
				     </div>
				     <div align="right"><input type="submit" class="btn btn-custom btn-lg" value="<?= lang('events_update')?>"></div>
				</form>
				<? endif?>
			<? endif?>
			

				
<!-- MODALS -->				
 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="Modaldelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldelete"><?= lang('events_confirm_delete')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('events_confirm_delete_question')?></p>
                    <p><?= lang('events_proceed')?></p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('events_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('events_delete')?></a>
                </div>
            </div>
        </div>
    </div>
 
 
 <div class="modal fade" id="confirm-active" tabindex="-1" role="dialog" aria-labelledby="Modalactive" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalacitve"><?= lang('events_confirm_active')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('events_confirm_active_question')?></p>
                    <p><?= lang('events_proceed')?></p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('events_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('events_active')?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="confirm-deactive" tabindex="-1" role="dialog" aria-labelledby="Modaldeactive" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldeactive"><?= lang('events_confirm_deactive')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('events_confirm_deactive_question')?></p>
                    <p><?= lang('events_proceed')?></p>
                    <!--<p class="debug-url"></p>-->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('events_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('events_deactive')?></a>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="confirm-completed" tabindex="-1" role="dialog" aria-labelledby="Modalcompleted" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalcompleted"><?= lang('events_confirm_completed')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('events_confirm_completed_question')?></p>
                    <p><?= lang('events_proceed')?></p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('events_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('events_completed')?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="confirm-not-completed" tabindex="-1" role="dialog" aria-labelledby="Modaldenotcompleted" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldenotcompleted"><?= lang('events_confirm_not_completed')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('events_confirm_not_completed_question')?></p>
                    <p><?= lang('events_proceed')?></p>
                    <!--<p class="debug-url"></p>-->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('events_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('events_not_completed')?></a>
                </div>
            </div>
        </div>
    </div>

    
    
     <div class="modal fade" id="confirm-restore" tabindex="-1" role="dialog" aria-labelledby="Modalrestore" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalrestore"><?= lang('events_confirm_restore')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('events_confirm_restore_question')?></p>
                    <p><?= lang('events_proceed')?></p>
                   <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('events_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('events_restore')?></a>
                </div>
            </div>
        </div>
    </div>