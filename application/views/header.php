<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<title>Your FlatTurtle</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css" type="text/css" media="screen" />
		<!--[if lte IE 8]><link rel="stylesheet" href="<?= base_url(); ?>assets/css/ie7-font-awesome.css" type="text/css" media="screen" /><![endif]-->

		<!--Enables media queries in some unsupported browsers-->
		<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap.js"></script>

		<!-- For iPhone 4 -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://www.flatturtle.com/themes/site/img/apple-touch-icon-114.png">
		<!-- For iPad 1-->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://www.flatturtle.com/themes/site/img/apple-touch-icon-72.png">
		<!-- For everything else -->
		<link rel="shortcut icon" href="https://www.flatturtle.com/themes/site/img/favicon.ico">
	</head>
	<body>
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="span8">
						<header role="banner">
							<hgroup>
								<h1><img src="<?= base_url(); ?>assets/img/logo_320_2x.gif" alt="FlatTurtle" /></h1>
							</hgroup>
						</header>
					</div>
					<div class="span4">
						<? if ($this->session->userdata('logged_in')) { ?>
							<nav role="navigation">
								<h4>
									<i class='icon-user'></i>&nbsp;&nbsp;Hi, <?= $this->session->userdata('username') ?>!
								</h4>
								<a href="<?= site_url('/logout') ?>" alt="Log out" class="btn btn-small">
									Log out
								</a>
							</nav>
						<? } ?>
					</div>
				</div>
			</div>
			<div class="grey_wrapper">
				<div class="container">