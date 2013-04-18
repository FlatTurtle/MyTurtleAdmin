<?php

$version_js = "1.0.9";

?>
            </div>
        </div>
    </div>
    <footer role="footer">
        <div class="container">
            <div class="row">
                <div class="span7">
                    &copy; <?= date('Y', time()) ?> <a href="https://flatturtle.com" target="_blank">FlatTurtle</a> &mdash; <?= lang('footer.rights') ?><br/>
<!--
                                                   Are you a developer who would like to know more about FlatTurtle?
                                                   Did you know you can control your FlatTurtle through an API?
                                                   Did you know you can write your own turtles and panes?
                                                   Get in touch with us at
                                                      http://dev.flatturtle.com
                                                   or mail us at
                                                      info@flatturtle.com
-->
                </div>
                <div class='span5 right-align'>
                    <?= lang('term.mailing_list')?> &mdash;  <a href='#mailChimp' data-toggle="modal"><?= strtolower(lang('mailing_list')) ?></a><br/>
                    Helpdesk &mdash; <a href='mailto:help@FlatTurtle.com'>help@FlatTurtle.com</a><br/>
                              <a href='tel:0032 2 6690999'>+32 (0) 2 669 09 99</a>
                <div>
            </div>
        </div>
    </footer>
    <script type="text/javascript">
        var lang = [];
<?php
        // Javascript translations
        if(isset($this->lang)){
            foreach($this->lang->language as $key => $value){
                echo "        lang['".$key ."'] =  \"". $value  . "\";\n";
            }
        }
?>
    </script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/script-min.js?v=<?= $version_js ?>"></script>
</body>
</html>


<!-- Mailchip modal -->
<form action="http://flatturtle.us6.list-manage1.com/subscribe/post?u=d82ed07d6d647a768b87d3e8d&amp;id=48d462a1ea" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate onsubmit="$('#mailChimp').modal('hide');">
    <div id="mailChimp" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="mailChimpLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="mailChimpLabel"><?= lang('term.mailing_list') ?></h3>
    </div>
    <div class="modal-body">
        <div id="mc_embed_signup">
            <p><?= lang('mailing_list')?></p>
            <input type="email" value="" name="EMAIL" class="email input-block-level" id="mce-EMAIL" placeholder="email address" required>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><?= lang('term.cancel') ?></button>
            <input type="submit" value="<?= lang('term.subscribe') ?>" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary" aria-hidden="true">
        </div>
    </div>
</form>