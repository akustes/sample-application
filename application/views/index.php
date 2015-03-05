<form action="<?= site_url('access/index')?>" class="form-signin" role="form" method="post">
<div align="center"><img src="<?= base_url()?>assets/themes/<?= $this->config->item('theme')?>/images/large_logo.png" alt="Verified Arrangements" /></div>
<div align="center" width="300px">
<? if(validation_errors() || $message):?>
<br /><br />
<div class="alert alert-danger">
<span class="glyphicon glyphicon-warning-sign"><strong><?= validation_errors()?> <?= ($message) ? $message : ''?></strong></span>
</div>
<? endif?>
</div>
<h4 align="center" class="form-signin-heading"><?= lang('login_title')?></h4>
<label for="username" id="username">Username</label><br />
<input type="text" name="username" class="form-control" placeholder="<?= lang('username')?>" required autofocus>
<label for="password" id="password">Password</label><br />
<input type="password" name="password" class="form-control" placeholder="<?= lang('password')?>" required>
<button class="btn btn-lg btn-custom btn-block" type="submit"><?= lang('login')?></button>
</form>

<p align="center"><strong>Not a Member?</strong> <a href="<?= site_url('signup')?>">Sign Up</a></p>