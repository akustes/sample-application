				<div class="page-header">
					<h1>
					<? if($section == 'detail'):?>
						<a href="<?= site_url('messages')?>"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
					<? endif?>
					
					<?= lang('message_title')?>
					</h1>
				</div>
				
				<? if($section == 'list'):?>
					
				<div class="row">
					<div class="col-sm-3 col-md-2 col-lg-2">
						<!--<button type="button" class="btn btn-primary btn-lg btn-block"  data-toggle="modal" data-target="#compose"><span class="glyphicon glyphicon-edit"></span> Compose</button>
						<br />
						-->
						<div class="panel panel-default">
						  <div class="panel-heading">
						    <h3 class="panel-title"><span class="glyphicon glyphicon-envelope"></span> <?= lang('message_mail')?></h3>
						  </div>
						  <div class="panel-body">
						    <ul class="list-group">
				            	<li class="list-group-item"><a href="<?= site_url('messages/index')?>"><span class="glyphicon glyphicon-inbox"></span> <?= lang('message_inbox')?> <span class="badge"><?= $unread?></span></a></li>
				            	<li class="list-group-item"><a href="<?= site_url('messages/index/outgoing')?>"><span class="glyphicon glyphicon-share-alt"></span> <?= lang('message_sent')?></a></li>
				            	<li class="list-group-item"><a href="<?= site_url('messages/index/deleted')?>"><span class="glyphicon glyphicon-trash"></span> <?= lang('message_trash')?></a></li>
				          	</ul>
						  </div>
						</div>
					</div>
					<div class="col-sm-9 col-md-10 col-lg-10">
						  <div class="row">
						  		<div class="col-sm-6 col-md-4 col-lg-2">
						  			  <div class="btn-group">
							  			<a href="<?= site_url('messages/index/unread')?>" class="btn btn-default"><?= lang('message_unread')?></a>
							 			<a href="<?= site_url('messages/index/read')?>" class="btn btn-default"><?= lang('message_read')?></a>
						  			  </div>
						  		</div>
						  		
						  		<div class="visible-sm visible-xs"><br /><br /></div>
						  		
						  		<div class="col-sm-6 col-md-8 col-lg-10">
						  			<form action="<?= site_url('messages/index/search')?>" method="post" role="form">
							  			<div class="input-group">
									      	<input type="text" id="keyword" name="keyword" class="form-control">
									      	<span class="input-group-btn">
									        	<input type="submit" class="btn btn-custom" value="<?= lang('message_search')?>" />
									      	</span>
						            	</div>
					            	</form>
						  </div>		
						
						  <br /><br /><br />
						   
						  <table class="table table-striped table-hover">
							  <thead>
							  	 <tr>
							  	 	 <th class="table-header-flat-center" width="50"></th>
							  	 	 <th class="table-header-flat-center"><?= ($type == 'outgoing') ?  lang('message_to') : lang('message_from')?></th>
					  			 	 <th class="table-header-flat-center"><?= lang('message_subject')?></th>
					  			 	 <th class="table-header-flat-center"><?= lang('message_date')?></th>
							  	 </tr>
							  </thead>
						  
							  <tbody>
				            	<? if($messages):?>
								  	<? foreach($messages as $message):?>
								  	<tr>
								  		<td align="center" width="50">
								  			<? $delete_action = ($message['message_deleted'] == 1) ? 'restore' : 'delete'?>
								  			<? if(permission_check('messages', 'delete')):?><a href="#" data-href="<?= site_url('messages/status/' . $message['message_id'] . '/' . $delete_action)?>" class="btn <?= ($message['message_deleted'] == 1) ? 'btn-default' : 'btn-danger'?> btn-sm" data-toggle="modal" data-target="<?= ($message['message_deleted'] == 1) ? '#confirm-restore' : '#confirm-delete'?>" title="<?= lang('message_delete')?>"><span class="glyphicon <?= ($message['message_deleted'] == 1) ? 'glyphicon-share' : 'glyphicon-remove'?>"></span><span class="hidden-xs hidden-sm"><?= ($message['message_deleted'] == 1) ? lang('message_restore') : lang('message_delete')?></span></a><? endif?>
								  		</td>	
								  		<td align="center"><?= $message['account_username']?> <span class="label <?= (account_online($message['message_from_account_id'])) ? 'label-success' : 'label-default'?>"><?= (account_online($message['message_from_account_id'])) ? lang('message_online') : lang('message_offline')?></span></td>	
										<td align="center"><span <?= ($message['message_read'] == 0) ? 'style="font-weight: bold;"' : ''?>><? if(permission_check('messages', 'view')):?><a href="<?= site_url('messages/detail/' . $message['message_id'] . '/' . $type)?>"><? endif?><?= word_limiter($message['message_subject'], 20)?> <? if(permission_check('messages', 'view')):?></a><? endif?></span></td>
										<td align="center"><?= unix_to_human($message['message_created_date'], TRUE, 'us')?> </td>
								  	</tr>
								  	<? endforeach?>
							    <? else:?>
							    	<tr>
							    		<td colspan="5" align="center"><?= lang('message_no_messages')?></td>
							    	</tr>
							    <? endif?>
								</tbody>
						  </table>
						
						
				</div>
				
				<div class="row"><?= (isset($pages)) ? $pages : ''?></div>
				
			<? endif?>
			
			<? if($section == 'detail'):?>
				
					<? if($message):?>
						<div class="alert alert-info alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<span class="glyphicon glyphicon-exclamation-sign"> <strong><?= $message?></strong></span>
						</div>
					<? endif?>
					
					<? if(validation_errors()):?>
						<div class="alert alert-warning">
						<span class="glyphicon glyphicon-warning-sign"><strong><?= validation_errors()?></strong></span>
						</div>
					<? endif?>

				
				<div class="row">
					<div class="well">
						<ul class="media-list">
						<? if($thread):?>
							
							
							<? 
								$to_id = (isset($thread['message_to_account_id'])) ? $thread['message_to_account_id'] : '';
								$from_id = (isset($thread['message_from_account_id'])) ? $thread['message_from_account_id'] : '';
								$subject = (isset($thread['message_subject'])) ? $thread['message_subject'] : '';
							?>
						
	  							<li class="media <?= ($from_id == session('id')) ? 'bubble-default' : 'bubble-gray'?>">
							    	<div class="<?= ($from_id == session('id')) ? 'pull-right' : 'pull-left'?>" href="#"><img class="media-object"  src="<?= base_url()?>assets/images/accounts/thumbs/<?= $thread['account_image']?>" width="100" height="75" alt=""><br />
							    	<?= $thread['account_username']?><br />
							    	<span class="label <?= (account_online($thread['message_from_account_id'])) ? 'label-success' : 'label-default'?>"><?= (account_online($thread['message_from_account_id'])) ? lang('message_online') : lang('message_offline')?></span>
									</div>
								  <div class="media-body">
								    <h4 class="media-heading"><?= $thread['message_subject']?></h4>
								    <?= (isset($thread['message_body'])) ? $thread['message_body'] : ''?> <i>@ <?= (isset($thread['message_created_date'])) ? unix_to_human($thread['message_created_date'], TRUE, 'us') : ''?></i>
								  </div>
							  </li>
					  
							
						<? endif?>
					</ul>
					
					
					<h3><?= lang('message_reply')?>:</h3>
					<? if($thread):?>
						<form action="<?= site_url('messages/detail/' . $id . '/view')?>" role="form" method="post">
						<input type="hidden" name="message_id" value="<?= $id?>" />
						<input type="hidden" name="from_account_id" value="<?= session('id')?>" />
						<input type="hidden" name="to_account_id" value="<?= $from_id?>" />
						<input type="hidden" name="subject" value="RE: <?= $subject?>" />
										
							<div class="form-group">
								<textarea class="form-control" name="reply_message" rows="5"></textarea>
							</div>
							<p align="right"><input type="submit" class="btn btn-custom btn-lg" value="<?= lang('message_send')?>"></p>
						</form>
					<? endif?>
					
					
				</div>
			
			<? endif?>
		
		
<!-- MODALS -->
	 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="Modaldelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldelete"><?= lang('message_confirm_delete')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('message_confirm_delete_question')?></p>
                    <p><?= lang('message_proceed')?></p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('message_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('message_delete')?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="confirm-restore" tabindex="-1" role="dialog" aria-labelledby="Modalrestore" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalrestore"><?= lang('message_confirm_restore')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('message_confirm_restore_question')?></p>
                    <p><?= lang('message_proceed')?></p>
                   <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('message_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('message_restore')?></a>
                </div>
            </div>
        </div>
    </div>
  		
 <div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="Modalcompose" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalcompose">Compose Message<?// lang('account_confirm_delete')?></h4>
                </div>
            
                <div class="modal-body">
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel<?// lang('account_cancel')?></button>
                    <a href="#" class="btn btn-primary primary">Send<?// lang('account_delete')?></a>
                </div>
            </div>
        </div>
  </div>	