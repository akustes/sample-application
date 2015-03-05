				<div class="page-header">
					<h1><?= lang('account_signup')?></h1>
				</div>
				
				<? if($section == 'form'):?>
											
					<? if(validation_errors()):?>
						<div class="alert alert-warning">
						<span class="glyphicon glyphicon-warning-sign"><strong><?= validation_errors()?></strong></span>
						</div>
					<? endif?>
					
					<form action="<?= site_url('signup/index')?>" role="form" method="post" enctype="multipart/form-data">
					
						<input type="hidden" id="role_id" name="role_id" value="3">
						<input type="hidden" id="active" name="active" value="0">
						   
						  <div class="form-group">
						    <label for="gender">Gender</label>
						     <?= form_dropdown('gender', $genders, set_value('gender'), 'class="form-control"')?>
						  </div>
						   <div class="form-group">
						    <label for="dob">Date of Birth</label>
						    <input type="date" class="form-control" id="dob" name="dob" placeholder="Date Of Birth (Format: dd/mm/yyyy)" title="DOB (Format: dd/mm/yyyy)" value="<?= set_value('dob')?>">
						  </div>
						  <div class="form-group">
						    <label for="first_name">First Name</label>
						    <input type="text" class="form-control" id="first_name" name="first_name" pattern="[a-zA-Z0-9]+" placeholder="First Name" value="<?= set_value('first_name')?>">
						  </div>
						   <div class="form-group">
						    <label for="last_name">Last Name</label>
						    <input type="text" class="form-control" id="last_name" name="last_name" pattern="[a-zA-Z0-9]+" placeholder="Last Name" value="<?= set_value('last_name')?>">
						  </div>
						  <div class="form-group">
						    <label for="username">Username</label>
						    <input type="text" class="form-control" id="username" name="username" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" placeholder="Username with 2-20 chars" title="Username with 2-20 chars" value="<?= set_value('username')?>">
						  </div>
						  <div class="form-group">
						    <label for="password">Password</label>
						    	<input type="password" class="form-control" id="password" name="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Password (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)" title="Password (UpperCase, LowerCase, Number/SpecialChar and min 8 Chars)">
						 </div>
						  <div class="form-group">
						    <label for="email">Email</label>
						    <input type="email" class="form-control" id="email" name="email" pattern="[^ @]*@[^ @]*" placeholder="Email" value="<?= set_value('email')?>">
						  </div>
						  <div class="form-group">
						    <label for="phone">Phone</label>
						    <input type="tel" class="form-control" id="phone" name="phone" pattern="\d{3}[\-]\d{3}[\-]\d{4}" placeholder="Phone (Format: 999-555-5551)" title="Phone (Format: 999-555-5551)" value="<?= set_value('phone')?>">
						  </div>
						  <div class="form-group">
						    <label for="address">Address</label>
						    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= set_value('address')?>">
						  </div>
						  <div class="form-group">
						    <label for="city">City</label>
						    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?= set_value('city')?>">
						  </div>
						  <div class="form-group">
						    <label for="state">State</label>
						    	<?= form_dropdown('state', $states, set_value('state'), 'class="form-control"')?>
						  </div>
						   <div class="form-group">
						    <label for="zip">Zip</label>
						    	<input type="text" class="form-control" id="zip" name="zip" pattern="(\d{5}([\-]\d{4})?)" placeholder="Zip Code" value="<?= set_value('zip')?>">
						  </div>
						 <div class="form-group">
						    <label for="county">County</label>
						    <input type="text" class="form-control" id="county" name="county" placeholder="County" value="<?= set_value('county')?>">
						  </div>
						  <div class="form-group">
						    <label for="country">Country</label>
						    	<?= form_dropdown('country', $countries, set_value('country'), 'class="form-control"')?>
						  </div>
						  
						  <div class="form-group">
						  	<label for="userfile">Upload Account Picture</label>
					  		<input type="file" class="form-control" id="userfile" name="userfile" />
					  	  </div>	
	
						  <div class="row">
						 	<div class="col-xs-3 col-md-6" align="center">&nbsp;</div>
						  	<div class="col-xs-3 col-md-6" align="center"><input type="submit" class="btn btn-custom" value="<?= lang('account_submit')?>"></div>
						  </div>
						  
					
					
					</form>
			<? endif?>
			
			<? if($section == 'confirm'):?>
				
				<p class="lead">
				Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam sit amet elit vitae arcu interdum ullamcorper. Nullam ultrices, nisi quis scelerisque convallis, augue neque tempor enim, et mattis justo nibh eu elit. Quisque ultrices gravida pede. Mauris accumsan vulputate tellus. Phasellus condimentum bibendum dolor. Mauris sed ipsum. Phasellus in diam. Nam sapien ligula, consectetuer id, hendrerit in, cursus sed, leo. Nam tincidunt rhoncus urna. Aliquam id massa ut nibh bibendum imperdiet. Curabitur neque mauris, porta vel, lacinia quis, placerat ultrices, orci.
				</p>
			
			<? endif?>