				<div class="page-header">
					<h1><?= lang('accounts')?> (<?= $total?>)</h1>
				</div>
						
		
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6"><a class="btn btn-custom" href="<?= site_url('accounts/add')?>"><span class="glyphicon glyphicon-plus"></span> <?= lang('add_account')?></a></div>
					<div class="col-sm-6 col-md-6 col-lg-6" align="right">
						<form action="<?= site_url('accounts/search')?>" method="post" class="form-inline" role="form">
							 <div class="form-group">
								 <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Example: Last Name" />
							</div>
							
							<input type="submit" name="submit" class="btn btn-custom" value="Search" />
						</form>
					</div>
				</div>
				
				<div class="row">&nbsp;</div>
				
				<div class="table-responsive">
				  
				  <table class="table table-striped table-hover">
					  <thead>
					  	 <tr>
					  	 	 <th>Name</th>
			  			 	 <th>Email</th>
			  			 	 <th>Phone</th>
			  			 	 <th>City</th>
			  			 	 <th>State</th>
			  			 	 <th>Action</th>
					  	 </tr>
					  </thead>
				  
					  <tbody>
		            	<? if($accounts):?>
						  	<? foreach($accounts as $account):?>
						  	<tr>
						  		<td align="center"><?= $account->last_name?>, <?= $account->first_name?></td>	
								<td align="center"><?= $account->email?></td>
								<td align="center"><?= $account->phone?></td>
								<td align="center"><?= $account->city?></td>
								<td align="center"><?= $account->state?></td>
								<td align="center">
									<a href="<?= site_url('accounts/edit/' . $account->account_id)?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil" title="Edit"></span><span class="hidden-xs hidden-sm">Edit</span></a> 
									<a href="#" data-href="<?= site_url('accounts/delete/' . $account->account_id)?>" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete" title="Delete"><span class="glyphicon glyphicon-remove"></span><span class="hidden-xs hidden-sm">Delete</span></a>
								</td>		
						  	</tr>
						  	<? endforeach?>
					    <? else:?>
					    	<tr>
					    		<td colspan="6" align="center">No Accounts At This Time</td>
					    	</tr>
					    <? endif?>
						</tbody>
				  </table>
				  
	           </div>
										
			<?= (isset($pages)) ? $pages : ''?>
						
						
				
 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="Modaldelete" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modaldelete">Confirm Delete</h4>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete this user</p>
                    <p>Do you want to proceed?</p>
                    <!-- <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger danger">Delete</a>
                </div>
            </div>
        </div>
    </div>