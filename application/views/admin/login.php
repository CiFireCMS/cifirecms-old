<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administrator Log In | <?=$this->settings->website('web_name'); ?></title>
	<!-- Global stylesheet -->
	<link href="<?=content_url('plugins/icomoon/styles.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=content_url('plugins/font-awesome/font-awesome.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=content_url('plugins/dashboard/css/bootstrap.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=content_url('plugins/dashboard/css/bootstrap_limitless.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=content_url('plugins/dashboard/css/layout.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=content_url('plugins/dashboard/css/components.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=content_url('plugins/dashboard/css/colors.css')?>" rel="stylesheet" type="text/css">
	<!--/ Global stylesheet -->
	<!-- favicon -->
	<link rel="shortcut icon" href="<?=favicon()?>" />
	<script src="<?=content_url('plugins/jquery/jquery-2.2.4.min.js')?>"></script>
	<script src="<?=content_url('plugins/dashboard/js/bootstrap.bundle.min.js')?>"></script>
	<!-- Core JS files
	<script src="<?=content_url('plugins/loaders/blockui.min.js')?>"></script> -->
	<!-- /core JS files -->
	<!-- JS files
	<script src="<?=content_url('plugins/uniform/uniform.min.js')?>"></script>
	<script src="<?=content_url('plugins/dashboard/js/app.js')?>"></script> -->
	<!--/  JS files -->
	<script type="text/javascript">
		<?php
			$jxUrl = admin_url('login/ajax-cek');
		?>
		var _URL = '<?php echo $jxUrl ?>';
		var _UNAME = '<?php echo $input_uname ?>';
		var _PSWD = '<?php echo $input_pwd ?>';
	</script>
</head>
<body>
	<!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">
				<!-- Login card -->
				<?= form_open('', 'id="form-login" class="login-form" autocomplete="off"'); ?>
					<div class="text-center">
						<img src="<?=favicon('logo');?>" class="logo mb-3" style="width:70px;"/>
					</div>
					<div class="text-center mb-3">
						<h5 class="mb-0">Sign in to Administrtor</h5>
					</div>
					<div class="card mb-0">
						<div class="card-body">
							<?= $this->alert->show('login'); ?>
							<div class="form-group">
								<label for="username">Username</label>
								<input id="username" type="text" name="<?=$input_uname;?>" class="form-control input-username" maxlength="20">
							</div>
							<div class="input-password"></div>
						</div>
					</div>
					<p class="mt-3 text-center login-copyright">Copyright &copy; <a href="<?=site_url();?>" target="_blank"><?=$this->settings->website('web_name');?></a> 2019</p>
				<?=form_close(); ?>
				<!-- /login card -->
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->


	<script type="text/javascript">
		$('input:not(textarea)').keydown(function(event){
			var kc = event.witch || event.keyCode;
			if(kc == 13){
			event.preventDefault();
				return false;
			}
		});

		$('.input-username').on('input', function(){
			var ref = $(this);
		    var val = $(this).val();
		    var maxChar = 20;
			var _htmlPass = '<div class="form-group mt-3"><label for="password">Password</label> <input type="password" name="'+ _PSWD +'" id="password" class="form-control" required autofocus></div> </div><div class="form-group mb-0"> <button type="submit" class="button btn-primary btn-block mt-3">Sign in <i class="icon-circle-right2 ml-2"></i></button> </div>';

			// limit username length char
		    if ( val.length >= maxChar ) {
		        ref.val(function() {
		            console.log(val.substr(0, maxChar))
		            return val.substr(0, maxChar);       
		        });
		    }

			$.ajax({
				url: _URL,
				type: 'POST',
				data: {
					'data': val
				},
				dataType: 'json',
				cache: false,
				success:function(response){
					var _ints = response;
					if (_ints == '1') {
						$('.input-password').html(_htmlPass);
						$("#password").focus();
					} else{
						$('.input-password').html('');
					};
					
				}
			});

		});
	</script>
</body>
</html>
