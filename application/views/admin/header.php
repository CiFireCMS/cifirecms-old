<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="<?=get_setting('web_description');?>"/>
	<meta name="keyword" content="<?=get_setting('web_keyword');?>"/>
	<meta name="author"  content="<?=get_setting('web_author');?>"/>
	<title><?=$this->CI->meta_title;?></title>
	<!-- Favicon -->	
	<link rel="icon" href="<?=favicon();?>" type="image/x-icon"/>

	<!-- Feature CSS -->
	<link rel="stylesheet" href="<?=content_url('plugins/icomoon/styles.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/font-awesome/font-awesome.min.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/cifireicon-feather/cifireicon-feather.min.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/flag/flag-icon.min.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/themify/themify.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/datatable/datatables.min.css');?>"/>
	<link rel="stylesheet" href="<?=content_url('plugins/select2/select2.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/fancybox-2.1.7/jquery.fancybox.css');?>" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?=content_url('plugins/datetime/bootstrap-datetimepicker.min.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/sweetalert2/sweetalert2.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/notifications/noty.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/bootstrap-select/bootstrap-select.min.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/perfect-scrollbar/perfect-scrollbar.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/x-editable/x-editable.css');?>" type="text/css"/>

	<?php if ($this->mod === 'setting' || $this->mod == 'theme'): ?>
	<link rel="stylesheet" href="<?=content_url('plugins/codemirror/lib/codemirror.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/codemirror/theme/github.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/codemirror/addon/display/fullscreen.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/codemirror/addon/hint/show-hint.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/codemirror/addon/dialog/dialog.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/codemirror/addon/scroll/simplescrollbars.css');?>" type="text/css"/>
	<?php endif ?>

	<?php if ($this->uri->segment(2) == 'menumanager'): ?>
	<link rel="stylesheet" href="<?=content_url('plugins/menumanager/menu.css');?>" type="text/css"/>
	<?php endif ?>

	<link rel="stylesheet" href="<?=content_url('plugins/bootstrap/css/bootstrap.min.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('themes/admin/css/style.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('themes/admin/css/skin.light.css');?>" type="text/css"/>
	<link rel="stylesheet" href="<?=content_url('plugins/prism/prism.css');?>" type="text/css"/>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn"t work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Javascript -->
	
	<script>
		var site_url          = "<?=$a_site_url;?>";
		var content_url       = "<?=$a_content_url;?>";
		var admin_url         = "<?=$a_admin_url;?>";

		var a_mod             = "<?=$a_mod;?>";
		var a_act             = "<?=$a_act;?>";

		var lang_active       = "<?=lang_active();?>";
		var datatable_lang    = "<?=$a_datatable_lang;?>";
		
	    var csrfName          = '<?=$this->CI->security->get_csrf_token_name();?>';
	    var csrfToken         = '<?=$this->CI->security->get_csrf_hash();?>';
	    var csrfData          = {};
	    csrfData['<?=$this->CI->security->get_csrf_token_name();?>'] = '<?=$this->CI->security->get_csrf_hash();?>';
	</script>
	<script src="<?=content_url('plugins/jquery/jquery.min.js');?>"></script>
<body>
	<!-- Page Container Start -->
	<div class="page-container">
		<!-- Page Sidebar Start -->
		<div class="page-sidebar">
			<div class="logo">
				<a href="#" class="logo-img">
					<span class="desktop-logo text-logo">CiFire<span>CMS</span></span>
					<img class="small-logo" src="<?=content_url('themes/admin/images/logo.png');?>" alt="" />
				</a>			
				<a id="sidebar-toggle-button-close"><i class="wd-20" data-feather="x"></i> </a>
			</div>

			<!-- Sidebar Menu Start -->
			<div class="page-sidebar-inner">
				<div class="page-sidebar-menu">
					<?php 
						// $menu_groups = dashboard_menu_active(login_level('admin', true));
						echo $this->CI->menu->dashboard_menu(
							$group_id   = 1, 
							$ul_attr    = 'id="main-menu" class="accordion-menu"'
						);
					?>
				</div>
			</div>
			<!--/ Sidebar Menu End -->
		</div>
		<!--/ Page Sidebar End -->

		<!-- Page Content Start -->
		<div class="page-content">
			<!-- Content Header Start -->
			<div class="page-header">
				<nav class="navbar navbar-default navbar-fixed-top">
					<!-- Brand and Logo Start -->
					<div class="navbar-header">
						<div class="navbar-brand">
							<ul class="list-inline">
								<!-- Mobile Toggle and Logo -->
								<li class="list-inline-item"><a href="#" class="hidden-md hidden-lg mg-r-15"><img class="small-logo" src="<?=content_url('themes/admin/images/logo.png');?>" alt="Logo"></a></li>

								<li class="list-inline-item"><a class="hidden-md hidden-lg" href="#" id="sidebar-toggle-button"><i data-feather="menu" class="wd-20"></i></a></li>
								<!-- PC Toggle and Logo -->
								<li class="list-inline-item"><a class=" hidden-xs hidden-sm" href="#" id="collapsed-sidebar-toggle-button"><i data-feather="menu" class="wd-20"></i></a></li>
								<li class="list-inline-item">
									<a href="<?=admin_url('post/add');?>" id="sidebar-toggle-button" class="mg-l-15 tx-gray-600"><i data-feather="edit" class="wd-20"></i></a>
								</li>
							</ul>
						</div>
					</div>
					<!--/ Brand and Logo End -->

					<!-- Header Right Start -->
					<div class="header-right pull-right">
						<ul class="list-inline justify-content-end">

							<!-- comment Dropdown Start -->
							<li class="top-link list-inline-item dropdown hidden-xsX">
								<a href="<?=admin_url('comment');?>" class="message-icon top-link tx-gray-600">
									<i data-feather="message-square" class="wd-20"></i>
									<?php if ($this->CI->ds_notif('comment') > 0): ?>
									<span class="notification-count wave in"></span>
									<?php endif ?>
								</a>
							</li>
							<!--/ comment Dropdown End -->

							<!-- Mail Dropdown Start -->
							<li class="top-link list-inline-item dropdown hidden-xsX">
								<a href="<?=admin_url('mail');?>" class="notification-icon top-link tx-gray-600">
									<i data-feather="mail" class="wd-20"></i>
									<?php if ($this->CI->ds_notif('mail') > 0): ?>
									<span class="notification-count wave in"></span>
									<?php endif ?>
								</a>
							</li>
							<!--/ Mail Dropdown End -->

							<!-- Go to web -->
							<li class="top-link list-inline-item dropdown hidden-xsX" data-toggle="tooltip" data-placement="bottom" title="<?=lang_line('menu_view_web');?>">
								<a href="<?=site_url();?>" target="_blank" class="notification-icon top-link tx-gray-600"><i data-feather="globe" class="wd-20"></i></a>
							</li>
							<!--/ Go to web -->

							<!-- Profile Dropdown Start -->
							<li class="top-link list-inline-item dropdown">
								<a  href="#" class="top-link top-profile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=user_photo(data_login('photo'));?>" class="img-fluid wd-30 ht-30 rounded-circle"></a>

								<div class="dropdown-menu dropdown-menu-right dropdown-profile">
									<div class="user-profile-area">
										<div class="user-profile-heading">
											<div class="profile-thumbnail">
												<img src="<?=user_photo(data_login('photo'));?>" class="img-fluid wd-35 ht-35 rounded-circle" alt="">
											</div>
											<div class="profile-text">
												<h6><?=data_login('name');?></h6>
												<span><?=data_login('email');?></span>
											</div>
										</div>

										<a href="<?=admin_url('profile')?>" class="dropdown-item"><i data-feather="user" class="wd-16 mr-2"></i> <?=lang_line('menu_profile');?></a>
										<a href="<?=admin_url('profile/edit')?>" class="dropdown-item"><i data-feather="edit" class="wd-16 mr-2"></i> <?=lang_line('menu_edit_profile');?></a>
										<a href="<?=admin_url('setting')?>" class="dropdown-item"><i data-feather="settings" class="wd-16 mr-2"></i> <?=lang_line('menu_setting');?></a>

										<div class="dropdown-divider"></div>

										<a href="" class="dropdown-item"><i data-feather="life-buoy" class="wd-16 mr-2"></i> <?=lang_line('menu_help_center');?></a>
										<a href="<?=admin_url('logout')?>" class="dropdown-item"><i data-feather="log-out" class="wd-16 mr-2"></i> <?=lang_line('menu_logout');?></a>
									</div>
								</div>
							</li>
							<!-- Profile Dropdown End -->
						</ul>
					</div>
					<!--/ Header Right End -->
				</nav>
			</div>
			<!--/ Page Header End -->