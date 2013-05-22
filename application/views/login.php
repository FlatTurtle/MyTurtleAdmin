<div class="row">
    <form class="form-signin" action="<?= site_url('login/do') ?>" method="post">
        <h3 class="form-signin-heading"><?= lang('login_title') ?></h3>
        <input type="text" class="input-block-level" name="username" placeholder="<?= lang('term_username') ?>" value="<?= $username ?>">
        <input type="password" class="input-block-level" name="password" placeholder="<?= lang('term_password') ?>">
        <button class="btn" type="submit"><?= lang('term_log_in') ?></button>
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