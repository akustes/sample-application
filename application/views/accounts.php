				<div class="page-header">
					
					<h1>
					<? if($section == 'form' && session('role_id') <= 2):?>
						<a href="<?= site_url('accounts')?>"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
					<? endif?>
					<?= ($section == 'list') ? lang('accounts') . ' (' . $total . ')' : lang('my_account')?>
					</h1>
				</div>
						
				<? if($section == 'list'):?>
					<? if(session('role_id') <= 2):?>
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6">
							<div class="btn-group">
							  <? if(permission_check('accounts', 'add')):?><a href="<?= site_url('accounts/manage/add')?>" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> <?= lang('add_account')?></a><? endif?>
							  <? if(permission_check('accounts', 'view')):?>
							  <a href="<?= site_url('accounts/index/active')?>" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> <?= lang('account_active')?></a>
							  <a href="<?= site_url('accounts/index/not_active')?>" class="btn btn-default"><span class="glyphicon glyphicon-minus"></span> <?= lang('account_not_active')?></a>
							  <a href="<?= site_url('accounts/index/deleted')?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> <?= lang('account_trash')?></a>
							  <? endif?>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6" align="right">
							<form action="<?= site_url('accounts/index/search_last_name')?>" method="post" role="form">
					  			<div class="input-group">
							      	<input type="text" id="keyword" name="keyword" class="form-control" placeholder="Last Name">
							      	<span class="input-group-btn">
							        	<input type="submit" class="btn btn-custom" value="<?= lang('account_search')?>" />
							      	</span>
				            	</div>
						    </form>
						</div>
					</div>
					<div class="row">&nbsp;</div>
					
					<div class="row"><?= (isset($pages)) ? $pages : ''?></div>
					
					<div class="row">&nbsp;</div>
					  
					  <table class="table table-striped table-hover">
						  <thead>
						  	 <tr>
						  	 	 <th class="table-header-flat-center"><?= lang('account_name')?></th>
				  			 	 <th class="table-header-flat-center"><?= lang('account_email')?></th>
				  			 	 <th class="table-header-flat-center"><?= lang('account_phone')?></th>
				  			 	 <th class="table-header-flat-center"><?= lang('account_action')?></th>
						  	 </tr>
						  </thead>
					  
						  <tbody>
			            	<? if($accounts):?>
							  	<? foreach($accounts as $account):?>
							  	<tr>
							  		<td align="center"><?= $account['account_last_name']?>, <?= $account['account_first_name']?> (<?= $account['account_username']?>)</td>	
									<td align="center"><a href="mailto:<?= $account['account_email']?>"><?= $account['account_email']?></a></td>
									<td align="center"><a href="tel:+1<?= $account['account_phone']?>"><?= $account['account_phone']?></a></td>
									<td align="center">
										<div class="btn-group">
										<? $active_action = ($account['account_active'] == 1) ? 'deactive' : 'active'?>
										<? $delete_action = ($account['account_deleted'] == 0) ? 'delete' : 'restore'?>
										<a href="#" data-href="<?= site_url('accounts/status/' . $account['account_id'] . '/' . $active_action)?>" data-toggle="modal" data-target="<?= ($account['account_active'] == 1) ? '#confirm-deactive' : '#confirm-active'?>" class="btn <?= ($account['account_active'] == 1) ? 'btn-info' : 'btn-success'?> btn-sm"><span class="glyphicon <?= ($account['account_active'] == 1) ? 'glyphicon-minus' : 'glyphicon-ok'?>" title="<?= lang('account_active_deactive')?>"></span><span class="hidden-xs hidden-sm"><?= ($account['account_active'] == 1) ? lang('account_deactive') : lang('account_active')?></span></a> 
										<? if(permission_check('accounts', 'edit')):?><a href="<?= site_url('accounts/manage/' . $account['account_id'] . '/edit')?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil" title="<?= lang('account_edit')?>"></span><span class="hidden-xs hidden-sm"><?= lang('account_edit')?></span></a> <? endif?>
										<? if(permission_check('accounts', 'delete')):?><a href="#" data-href="<?= site_url('accounts/status/' . $account['account_id'] . '/' . $delete_action)?>" class="btn <?= ($account['account_deleted'] == 1) ? 'btn-default' : 'btn-danger'?> btn-sm" data-toggle="modal" data-target="<?= ($account['account_deleted'] == 1) ? '#confirm-restore' : '#confirm-delete'?>" title="<?= lang('account_delete')?>"><span class="glyphicon <?= ($account['account_deleted'] == 1) ? 'glyphicon-share' : 'glyphicon-remove'?>"></span><span class="hidden-xs hidden-sm"><?= ($account['account_deleted'] == 1) ? lang('account_restore') : lang('account_delete')?></span></a><? endif?>
										</div>
									</td>		
							  	</tr>
							  	<? endforeach?>
						    <? else:?>
						    	<tr>
						    		<td colspan="5" align="center"><?= lang('account_no_results')?></td>
						    	</tr>
						    <? endif?>
							</tbody>
					  </table>
											
				   <div class="row"><?= (isset($pages)) ? $pages : ''?></div>
				
				<? endif?>
			
			<? endif?>
			
			<? if($section == 'form'):?>
			
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
					
					<? if($action == 'edit'):?>
					<div class="btn-group">
					  <a href="<?= site_url('accounts/billing/' . $accounts['account_id'] . '/view')?>" class="btn btn-default"><span class="glyphicon glyphicon-credit-card"></span> <?= lang('account_billing')?></a>
					  <a href="<?= site_url('accounts/password/' . $accounts['account_id'] . '/view')?>" class="btn btn-default"><span class="glyphicon glyphicon-lock"></span> <?= lang('account_change_password')?></a>
					</div>
					<br /><br />
					<? endif?>
					
					<? $post_url = ($action == 'add') ? 'accounts/manage/add' : 'accounts/manage/' . $accounts['account_id'] . '/edit'?>
					
					<form action="<?= site_url($post_url)?>" role="form" method="post" enctype="multipart/form-data">

					
						<? if($action == 'edit'):?>
						<input type="hidden" id="account_id" name="account_id" value="<?= (isset($accounts['account_id'])) ? $accounts['account_id'] : ''?>">
						<input type="hidden" name="original_image" value="<?= (isset($accounts['account_image'])) ? $accounts['account_image'] : ''?>" />
						<? endif?>
						
						<input type="hidden" id="action" name="action" value="<?= $action?>">
						
						<div class="form-group">
					  		<a href="#" data-href="<?= base_url()?>assets/images/accounts/<?= (isset($accounts['account_image'])) ? $accounts['account_image'] : 'no_image.png'?>" data-toggle="modal" data-target="#full-image" class="lgimage"><img src="<?= base_url()?>assets/images/accounts/thumbs/<?= (isset($accounts['account_image'])) ? $accounts['account_image'] : 'no_image.png'?>" class="img-responsive img-thumbnail"  /></a><br />
					  		<input type="file" class="form-control" id="userfile" name="userfile" /><br /><br />
					  	</div>

						   <div class="form-group">
						    <label for="role_id"><?= lang('account_role')?></label>
						    <?= form_dropdown('role_id', $roles, (isset($accounts['account_role_id'])) ? $accounts['account_role_id'] : '', 'class="form-control"')?>
						  </div>
	
						   <div class="form-group">
						    <label for="gender"><?= lang('account_gender')?></label>
						     <?= form_dropdown('gender', $genders, (isset($accounts['account_gender'])) ? $accounts['account_gender'] : '', 'class="form-control"')?>
						  </div>
						   <div class="form-group">
						    <label for="dob"><?= lang('account_dob')?></label>
						    <input type="date" class="form-control" id="dob" name="dob" placeholder="<?= lang('account_dob')?> (Format: dd/mm/yyyy)" title="DOB (Format: dd/mm/yyyy)" value="<?= (isset($accounts['account_dob'])) ? $accounts['account_dob'] : set_value('account_dob')?>">
						  </div>
						  <div class="form-group">
						    <label for="first_name"><?= lang('account_first_name')?></label>
						    <input type="text" class="form-control" id="first_name" name="first_name" pattern="[a-zA-Z0-9]+" placeholder="<?= lang('account_first_name')?>" value="<?= (isset($accounts['account_first_name'])) ? $accounts['account_first_name'] : set_value('account_first_name')?>">
						  </div>
						   <div class="form-group">
						    <label for="last_name"><?= lang('account_last_name')?></label>
						    <input type="text" class="form-control" id="last_name" name="last_name" pattern="[a-zA-Z0-9]+" placeholder="<?= lang('account_last_name')?>" value="<?= (isset($accounts['account_last_name'])) ? $accounts['account_last_name'] : set_value('account_last_name')?>">
						  </div>
						  <div class="form-group">
						    <label for="username"><?= lang('account_username')?></label>
						    <input type="text" class="form-control" id="username" name="username" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" placeholder="<?= lang('account_username')?> with 2-20 chars" title="<?= lang('account_username')?> with 2-20 chars" value="<?= (isset($accounts['account_username'])) ? $accounts['account_username'] : set_value('account_username')?>">
						  </div>
						  <? if($action == 'add'):?>
						  	<div class="form-group">
						    <label for="password"><?= lang('account_password')?></label>
						    	<input type="password" class="form-control" id="password" name="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="<?= lang('account_password')?> (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)" title="<?= lang('account_password')?> (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)">
						 	 </div>
						  <? endif?>
						  <div class="form-group">
						    <label for="email"><?= lang('account_email')?></label>
						    <input type="email" class="form-control" id="email" name="email" pattern="[^ @]*@[^ @]*" placeholder="<?= lang('account_email')?>" value="<?= (isset($accounts['account_email'])) ? $accounts['account_email'] : set_value('account_email')?>">
						  </div>
						  <div class="form-group">
						    <label for="phone"><?= lang('account_phone')?></label>
						    <input type="tel" class="form-control" id="phone" name="phone" pattern="\d{3}[\-]\d{3}[\-]\d{4}" placeholder="<?= lang('account_phone')?> (Format: 999-555-5551)" title="Phone (Format: 999-555-5551)" value="<?= (isset($accounts['account_phone'])) ? $accounts['account_phone'] : set_value('account_phone')?>">
						  </div>
						  <div class="form-group">
						    <label for="address"><?= lang('account_address')?></label>
						    <input type="text" class="form-control" id="address" name="address" placeholder="<?= lang('account_address')?>" value="<?= (isset($accounts['account_address'])) ? $accounts['account_address'] : set_value('account_address')?>">
						  </div>
						  <div class="form-group">
						    <label for="city"><?= lang('account_city')?></label>
						    <input type="text" class="form-control" id="city" name="city" placeholder="<?= lang('account_city')?>" value="<?= (isset($accounts['account_city'])) ? $accounts['account_city'] : set_value('account_city')?>">
						  </div>
						  <div class="form-group">
						    <label for="state"><?= lang('account_state')?></label>
						    	<?= form_dropdown('state', $states, (isset($accounts['account_state'])) ? $accounts['account_state'] : set_value('account_state'), 'class="form-control"')?>
						  </div>
						   <div class="form-group">
						    <label for="zip"><?= lang('account_zip')?></label>
						    	<input type="text" class="form-control" id="zip" name="zip" pattern="(\d{5}([\-]\d{4})?)" placeholder="<?= lang('account_zip')?>" value="<?= (isset($accounts['account_zip'])) ? $accounts['account_zip'] : set_value('account_zip')?>">
						  </div>
						 <div class="form-group">
						    <label for="county"><?= lang('account_county')?></label>
						    <input type="text" class="form-control" id="county" name="county" placeholder="<?= lang('account_county')?>" value="<?= (isset($accounts['account_county'])) ? $accounts['account_county'] : set_value('account_county')?>">
						  </div>
						  <div class="form-group">
						    <label for="country"><?= lang('account_country')?></label>
						    	<?= form_dropdown('country', $countries, (isset($accounts['account_country'])) ? $accounts['account_country'] : set_value('account_country'), 'class="form-control"')?>
						  </div>
						  
						  <div class="form-group">
						    <label for="active"><?= lang('account_active')?></label>
						    	<? if($action == 'edit'):?>
						    	<input type="checkbox" <?= ($accounts['account_active'] == 1) ? 'checked' : set_value('account_active')?> class="form-control" name="active" value="1" />
						    	<? else:?>
						    	<input type="checkbox" class="form-control" name="active" value="1" />
						    	<? endif?>
						  </div>

						  <div class="row">
						  	<? if($action == 'edit'):?>
						  	<? $delete_action = ($accounts['account_deleted'] == 1) ? 'restore' : 'delete'?>
						 	<div class="col-xs-3 col-md-6" align="center"><? if(isset($id)):?>
						 	<? if(permission_check('accounts', 'delete')):?>
						 		<a href="#" data-href="<?= site_url('accounts/status/' . $accounts['account_id'] . '/' . $delete_action)?>" class="btn <?= ($accounts['account_deleted'] == 1) ? 'btn-default' : 'btn-danger'?> btn-lg" data-toggle="modal" data-target="<?= ($accounts['account_deleted'] == 1) ? '#confirm-restore' : '#confirm-delete'?>" title="<?= ($accounts['account_deleted'] == 1) ? lang('account_restore') : lang('account_delete')?>"><span class="glyphicon <?= ($accounts['account_deleted'] == 1) ? 'glyphicon-share' : 'glyphicon-remove'?>"></span><span class="hidden-xs hidden-sm"><?= ($accounts['account_deleted'] == 1) ? lang('account_restore') : lang('account_delete')?></span></a>
						 	<? endif?>
						 	</div>
						 	<? endif?>
						 	
						  	<? endif?>
						  	<div class="col-xs-3 col-md-6" align="center"><input type="submit" class="btn btn-custom btn-lg" value="<?= ($action == 'add') ? lang('account_add') : lang('account_update')?>"></div>
						  </div>
						  
					
					
					</form>

			<? endif?>
			
			
			<? if($section == 'billing_form'):?>
			
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
					
					<form action="<?= site_url('accounts/billing')?>" role="form" method="post">
					
						<input type="hidden" id="account_id" name="account_id" value="<?= (isset($account['account_id'])) ? $account['account_id'] : set_value('account_id')?>">
						<input type="hidden" id="account_billing_id" name="account_billing_id" value="<?= (isset($account['account_billing_id'])) ? $account['account_billing_id'] : set_value('account_billing_id')?>">
						  <div class="form-group">
						    <label for="first_name"><?= lang('account_first_name')?></label>
						    <input type="text" class="form-control" id="first_name" name="first_name" pattern="[a-zA-Z0-9]+" placeholder="<?= lang('account_first_name')?>" value="<?= (isset($account['account_billing_first_name'])) ? $account['account_billing_first_name'] : set_value('account_billing_first_name')?>">
						  </div>
						   <div class="form-group">
						    <label for="last_name"><?= lang('account_last_name')?></label>
						    <input type="text" class="form-control" id="last_name" name="last_name" pattern="[a-zA-Z0-9]+" placeholder="<?= lang('account_last_name')?>" value="<?= (isset($account['account_billing_last_name'])) ? $account['account_billing_last_name'] : set_value('account_billing_last_name')?>">
						  </div>
						  <div class="form-group">
						    <label for="phone"><?= lang('account_phone')?></label>
						    <input type="tel" class="form-control" id="phone" name="phone" pattern="\d{3}[\-]\d{3}[\-]\d{4}" placeholder="<?= lang('account_phone')?> (Format: 999-555-5551)" title="Phone (Format: 999-555-5551)" value="<?= (isset($account['account_billing_phone'])) ? $account['account_billing_phone'] : set_value('account_billing_phone')?>">
						  </div>
						  <div class="form-group">
						    <label for="address"><?= lang('account_address')?></label>
						    <input type="text" class="form-control" id="address" name="address" placeholder="<?= lang('account_address')?>" value="<?= (isset($account['account_billing_address'])) ? $account['account_billing_address'] : set_value('account_billing_address')?>">
						  </div>
						  <div class="form-group">
						    <label for="city"><?= lang('account_city')?></label>
						    <input type="text" class="form-control" id="city" name="city" placeholder="<?= lang('account_city')?>" value="<?= (isset($account['account_billing_city'])) ? $account['account_billing_city'] : set_value('account_billing_city')?>">
						  </div>
						  <div class="form-group">
						    <label for="state"><?= lang('account_state')?></label>
						    	<?= form_dropdown('state', $states, (isset($account['account_billing_state'])) ? $account['account_billing_state'] : set_value('account_billing_state'), 'class="form-control"')?>
						  </div>
						   <div class="form-group">
						    <label for="zip"><?= lang('account_zip')?></label>
						    	<input type="text" class="form-control" id="zip" name="zip" pattern="(\d{5}([\-]\d{4})?)" placeholder="<?= lang('account_zip')?>" value="<?= (isset($account['account_billing_zip'])) ? $account['account_billing_zip'] : set_value('account_billing_zip')?>">
						  </div>
						  <div class="form-group">
						    <label for="country"><?= lang('account_country')?></label>
						    	<?= form_dropdown('country', $countries, (isset($account['account_billing_country'])) ? $account['account_billing_country'] : set_value('account_billing_zip'), 'class="form-control"')?>
						  </div>	
						
						  <div class="row">
						 	<div class="col-xs-3 col-md-6" align="center"></div>
						  	<div class="col-xs-3 col-md-6" align="center"><input type="submit" class="btn btn-custom btn-lg" value="<?= lang('account_update')?>"></div>
						  </div>
						  
					
					
					</form>
				
			<? endif?>
			
			
			<? if($section == 'password_form'):?>
			
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
					
					
					<form action="<?= site_url('accounts/password')?>" role="form" method="post">
					
						<input type="hidden" id="account_id" name="account_id" value="<?= $id?>">
						   
					  	<div class="form-group">
					    <label for="password"><?= lang('account_password')?></label>
					    	<input type="password" class="form-control" id="password" name="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Password (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)" title="Password (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)">
					 	</div>
					 	
					 	<div class="form-group">
					    <label for="password_confirm"><?= lang('account_confirm_password')?></label>
					    	<input type="password" class="form-control" id="password_confirm" name="password_confirm" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Password (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)" title="Password (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)">
					 	</div>
						
						<div class="row">
						   <div class="col-xs-3 col-md-6" align="center"></div>
						   <div class="col-xs-3 col-md-6" align="center"><input type="submit" class="btn btn-custom btn-lg" value="<?= lang('account_update')?>"></div>
					    </div>
					</form>
				
			<? endif?>	


				
<!-- MODALS -->				
 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="Modaldelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldelete"><?= lang('account_confirm_delete')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('account_confirm_delete_question')?></p>
                    <p><?= lang('account_proceed')?></p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('account_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('account_delete')?></a>
                </div>
            </div>
        </div>
    </div>
 
 
 <div class="modal fade" id="confirm-active" tabindex="-1" role="dialog" aria-labelledby="Modalactive" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalacitve"><?= lang('account_confirm_active')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('account_confirm_active_question')?></p>
                    <p><?= lang('account_proceed')?></p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('account_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('account_active')?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="confirm-deactive" tabindex="-1" role="dialog" aria-labelledby="Modaldeactive" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldeactive"><?= lang('account_confirm_deactive')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('account_confirm_deactive_question')?></p>
                    <p><?= lang('account_proceed')?></p>
                    <!--<p class="debug-url"></p>-->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('account_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('account_deactive')?></a>
                </div>
            </div>
        </div>
    </div>
    
     <div class="modal fade" id="confirm-restore" tabindex="-1" role="dialog" aria-labelledby="Modalrestore" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modalrestore"><?= lang('account_confirm_restore')?></h4>
                </div>
            
                <div class="modal-body">
                    <p><?= lang('account_confirm_restore_question')?></p>
                    <p><?= lang('account_proceed')?></p>
                    <!--<p class="debug-url"></p>-->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('account_cancel')?></button>
                    <a href="#" class="btn btn-danger danger"><?= lang('account_restore')?></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="full-image" tabindex="-1" role="dialog" aria-labelledby="Modalimage" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                </div>
            
                <div class="modal-body">
                    <div align="center"><img id="large_image" class="lgimage" src="" /></div>
                     <!--<p class="debug-url"></p>-->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('account_close')?></button>
                </div>
            </div>
        </div>
    </div>
