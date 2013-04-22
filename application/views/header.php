<?php

$version_css = "1.0.5"

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= lang('title') ?></title>

        <!-- For iPhone 4 -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://www.flatturtle.com/themes/site/img/apple-touch-icon-114.png">
        <!-- For iPad 1-->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://www.flatturtle.com/themes/site/img/apple-touch-icon-72.png">
        <!-- For everything else -->
        <link rel="shortcut icon" href="https://www.flatturtle.com/themes/site/img/favicon.ico">

        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css?v=<?= $version_css ?>" type="text/css" media="screen" />
        <link type="text/css" rel="stylesheet" href="https://fast.fonts.com/cssapi/66253153-9c89-413c-814d-60d3ba0d6ac2.css"/>

        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?= base_url(); ?>assets/css/ie7-font-awesome.css" type="text/css" media="screen" />
            <link href="<?= base_url(); ?>assets/css/introjs-ie.css" rel="stylesheet" type="text/css">
        <!-- <![endif]-->

        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
        <script type="text/javascript">
            if (typeof jQuery == 'undefined'){
                document.write(unescape("%3Cscript src='<?= base_url(); ?>assets/js/jquery-min.js' type='text/javascript'%3E%3C/script%3E"));
            }
            !window.jQuery.ui && document.write(unescape("%3Cscript src='<?= base_url(); ?>assets/js/jquery-ui-min.js type='text/javascript'%3E%3C/script%3E"))
        </script>
        <script src='<?= base_url(); ?>assets/js/jquery-ui-touch-punch-min.js' type='text/javascript'></script>
        <script type="text/javascript">
          var uvOptions = {};
          (function() {
            var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
            uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/3vteHtGxmCQCGMzqWw.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
          })();
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span6">
                        <header role="banner">
                            <hgroup>
                                <h1><a href='<?= site_url(''); ?>'><img src="<?= base_url(); ?>assets/img/logo_320_2x.gif" alt="FlatTurtle" /></a></h1>
                            </hgroup>
                        </header>
                    </div>
                    <div class="span6">
                        <nav role="navigation">
                            <? if ($this->session->userdata('logged_in')) { ?>
                                <h4>
                                    <i class='icon-user'></i>&nbsp;&nbsp;<?= lang('greeting') ?>, <?php echo ucfirst($this->session->userdata('username')); ?>!
                                </h4>
                                <a href="<?= site_url('/logout') ?>" alt="<?= lang('term.log_out') ?>" class="btn btn-small">
                                    <?= lang('term.log_out') ?>
                                </a>
                            <? } ?>
                            <div class="language_switcher btn-toolbar">
                                <div class="btn-group"
                                    <?php
                                        // Show language help only on the homepage
                                        if(!$this->uri->segment(2))
                                            echo 'data-step="1" data-intro="'.lang('help.language_selector').'" data-position="left"';
                                    ?>
                                >
                                    <a href='<?= $this->lang->switch_uri('en'); ?>' class="btn <? echo ($this->lang->lang() == "en")? 'active':''; ?>">EN</a>
                                    <a href='<?= $this->lang->switch_uri('nl'); ?>' class="btn <? echo ($this->lang->lang() == "nl")? 'active':''; ?>">NL</a>
                                    <a href='<?= $this->lang->switch_uri('fr'); ?>' class="btn <? echo ($this->lang->lang() == "fr")? 'active':''; ?>">FR</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <?
                // Highlight correct navigation
                $nav_screens = $nav_users = false;
                switch($this->uri->segment(2)){
                    case "users":
                        $nav_users = true;
                        break;
                    default:
                        $nav_screens = true;
                        break;
                }


                if ($this->session->userdata('logged_in')) {
            ?>
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <ul class="nav">
                                <li class="dropdown <?php if($nav_screens) echo 'active' ?>">
                                    <?php
                                        if(count($infoscreens) > 1){
                                    ?>
                                        <a href="<?php echo site_url('') ?>" class="dropdown-toggle" data-toggle="dropdown">
                                            <?= lang('term.infoscreens') ?>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            $reached_inactive = false;
                                            foreach($infoscreens as $screen){
                                                if(!$reached_inactive && empty($screen->hostname)){
                                                    $reached_inactive = true;
                                                    echo '<li class="divider"></li>';
                                                }
                                            ?>
                                                <li class="<?php if($screen->alias == $this->uri->segment(2)) echo 'active' ?>">
                                                    <a tabindex="-1" href="<?php echo site_url($screen->alias) ?>"><?php echo $screen->title ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php
                                        }else{
                                    ?>
                                        <a href="<?php echo site_url('') ?>">
                                            <?= lang('term.infoscreens') ?>
                                        </a>
                                    <?php
                                        }
                                    ?>
                                </li>
                                <?
                                // Show this only for superadmins
                                if ($this->session->userdata('rights') == 1) {
                                ?>
                                    <li><a href="#">Users</a></li>
                                <?
                                }
                                ?>
                            </ul>
                            <div class="pull-right">
                                <a id="help" href="" class="pull-left hide"><i class='icon-question-sign'></i></a>
                                <?
                                    // Show search only on homepage
                                    if (count($infoscreens) > 5 && !$this->uri->segment(2)) {
                                ?>
                                        <form class="navbar-search">
                                            <i class='icon-search'></i>
                                            <input type="text" class="search-query" placeholder="" tabindex="1">
                                        </form>
                                <?
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?
                }
            ?>
            <div class="grey_wrapper">
                <div class="container">
