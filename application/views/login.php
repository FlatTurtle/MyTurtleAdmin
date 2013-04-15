<div class="row">
    <form class="form-signin" action="<?= site_url('login/do') ?>" method="post">
        <h3 class="form-signin-heading"><?= lang('login.title') ?></h3>
        <input type="text" class="input-block-level" name="username" placeholder="<?= lang('term.username') ?>" value="<?= $username ?>">
        <input type="password" class="input-block-level" name="password" placeholder="<?= lang('term.password') ?>">
        <button class="btn" type="submit"><?= lang('term.log_in') ?></button>
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