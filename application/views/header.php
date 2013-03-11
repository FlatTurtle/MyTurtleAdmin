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

		<link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css" type="text/css" media="screen" />
		<link type="text/css" rel="stylesheet" href="https://fast.fonts.com/cssapi/66253153-9c89-413c-814d-60d3ba0d6ac2.css"/>

		<!--[if lte IE 8]><link rel="stylesheet" href="<?= base_url(); ?>assets/css/ie7-font-awesome.css" type="text/css" media="screen" /><![endif]-->

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
					<div class="span8">
						<header role="banner">
							<hgroup>
								<h1><a href='<?= site_url(''); ?>'><img src="<?= base_url(); ?>assets/img/logo_320_2x.gif" alt="FlatTurtle" /></a></h1>
							</hgroup>
						</header>
					</div>
					<div class="span4">
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
								<div class="btn-group">
  									<a href='<?= $this->lang->switch_uri('en'); ?>' class="btn <? echo ($this->lang->lang() == "en")? 'active':''; ?>">EN</a>
  									<a href='<?= $this->lang->switch_uri('nl'); ?>' class="btn <? echo ($this->lang->lang() == "nl")? 'active':''; ?>">NL</a>
  									<a href='<?= $this->lang->switch_uri('fr'); ?>' class="btn <? echo ($this->lang->lang() == "fr")? 'active':''; ?>">FR</a>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
			<div class="grey_wrapper">
				<div class="container">
