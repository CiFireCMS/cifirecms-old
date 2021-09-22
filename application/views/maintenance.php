<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="Copyright" content="<?=$this->settings->website('web_name');?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content=" Under Maintenance" />
    <meta name="keywords" content="<?=$this->settings->website('meta_keyword');?>" />
    <meta name="generator" content="CiFireCMS" />
    <meta name="author" content="<?=$this->settings->website('web_name');?>" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$this->settings->website('web_name');?> - Under Construction</title>
    <link rel="shortcut icon" href="<?=favicon();?>" />
	<link href="http://fonts.googleapis.com/css?family=Lato:300,700,400,700italic,400italic" rel="stylesheet" type="text/css" />
	<link type="text/css" rel="stylesheet" href="<?=site_url('views/maintenance/css/bootstrap.min.css');?>" />
	<link type="text/css" rel="stylesheet" href="<?=site_url('views/maintenance/css/maintenance.css');?>" />
</head>
<body>
	<section id="intro">
		<div class="container">
			<div class="intro">
				<h2>Site Under Construction</h2>
				<p class="lead">The website will be ready in...</p>
			</div>
		</div>
	</section>
	<section id="countdown">
		<div class="container">
			<div class="row countdown text-center">
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-days"></span> <br> <span class="ce-days-label"></span>
				</div>
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-hours"></span> <br> <span class="ce-hours-label"></span>
				</div>
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-minutes"></span> <br> <span class="ce-minutes-label"></span>
				</div>
				<div class="countdown-wrap col-sm-3 col-xs-6">
					<span class="timer ce-seconds"></span> <br> <span class="ce-seconds-label"></span>
				</div>
			</div>
		</div>
		<div id="message"></div>
	</section>
	<section id="footer">
		<div class="container"><p>Copyright &copy; 2013. All Rights Reserved</p></div>
	</section>

	<script type="text/javascript" src="<?=site_url('views/maintenance/js/jquery-1.11.0.min.js');?>"></script>
	<script type="text/javascript" src="<?=site_url('views/maintenance/js/jquery.counteverest.min.js');?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var currentDate = new Date();
			
			$('.countdown').countEverest({
				day: <?=$tanggal;?>,
				month: <?=$bulan;?>,
				year: <?=$tahun;?>,
				hour: <?=$jam;?>,
				minute: <?=$menit;?>,
				onComplete: function() {
					$('#message').text('Complete').addClass('complete');

					// redirect too
					// window.location.replace('https://counteverest.anacoda.de/jquery-plugin/doc/');
				}
			});
		});
	</script>
</body>
</html>