<div class="row">
	<form class="form-signin" action="<?= site_url('login/do') ?>" method="post">
        <h3 class="form-signin-heading">Please sign in</h3>
        <input type="text" class="input-block-level" name="username" placeholder="Username" value="<?= $username ?>">
        <input type="password" class="input-block-level" name="password" placeholder="Password">
        <button class="btn" type="submit">Log in</button>
		<?
		if ($form_error) {
			?><br/><br/>
			<div class="alert nomargin">
				<?= $form_error; ?>
			</div>
			<?
		}
		?>
	</form>
</div>