<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		<br/>
		</div>
		<!--/ Page Content End -->
	</div>
	<!--/ Page Container End -->

	<!-- Scroll To Top Start-->
	<a href="javascript:void(0)" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
	<!--/ Scroll To Top End -->



	<!-- Javascript -->
	<!---->
	<script src="<?=content_url('plugins/pace/pace.min.js');?>"></script>
	
	<script src="<?=content_url('plugins/feather/feather.min.js');?>"></script>
	<script src="<?=content_url('plugins/jquery-ui/jquery-ui.js');?>"></script>
	<script src="<?=content_url('plugins/popper/popper.js');?>"></script>
	<script src="<?=content_url('plugins/bootstrap/js/bootstrap.min.js');?>"></script>
	<script src="<?=content_url('plugins/prism/prism.js');?>"></script>
	
	<!-- slimscroll -->
	<script src="<?=content_url('plugins/slimscroll/jquery.slimscroll.min.js');?>"></script>
	<!-- perfect-scrollbar -->
	<script src="<?=content_url('plugins/perfect-scrollbar/perfect-scrollbar.js');?>"></script>

	<!-- datatable -->
	<script src="<?=content_url('plugins/datatable/datatables.min.js');?>"></script>
	<!-- tinymce -->
	<script src="<?=content_url('plugins/tinymce/tinymce.min.js');?>"></script>
	<!-- notifications -->
	<script src="<?=content_url('plugins/notifications/noty.min.js');?>"></script>
	<!-- sweetalert2 -->
	<script src="<?=content_url('plugins/sweetalert2/sweetalert2.min.js');?>"></script>
	<!-- selects2 -->
	<script src="<?=content_url('plugins/select2/select2.min.js');?>"></script>

	<!-- bootstrap-select -->
	<script src="<?=content_url('plugins/bootstrap-select/bootstrap-select.min.js');?>"></script>

	<!-- tagsinput-->
	<script src="<?=content_url('plugins/tagsinput/bootstrap-tagsinput.js');?>"></script>
	<script src="<?=content_url('plugins/typeahead/typeahead.js');?>"></script>
	<script src="<?=content_url('plugins/typeahead/typeahead-active.js');?>"></script>
	

	<!-- Add fancyBox main JS and CSS files -->
	<script src="<?=content_url('plugins/fancybox-2.1.7/jquery.fancybox.pack.js');?>"></script>

	<!-- Add Media helper (this is optional) -->
	<script src="<?=content_url('plugins/fancybox-2.1.7/jquery.fancybox-media.js');?>"></script>

	<!-- datetimepicker -->
	<script src="<?=content_url('plugins/datetime/moment.js');?>"></script>
	<script src="<?=content_url('plugins/datetime/bootstrap-datetimepicker.js');?>"></script>

	<!-- jquery validator -->
	<script src="<?=content_url('plugins/jquery-validator/jquery-validator.min.js');?>"></script>
	<!-- x-editable -->
	<script src="<?=content_url('plugins/x-editable/x-editable.js');?>"></script>

	<?php if ( $this->mod == 'theme' || $this->mod == 'setting'): ?>
	<!-- codemirror -->
	<script src="<?=content_url('plugins/codemirror/lib/codemirror.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/fold/xml-fold.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/edit/matchtags.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/edit/closetag.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/edit/closebrackets.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/selection/active-line.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/display/fullscreen.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/hint/show-hint.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/hint/xml-hint.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/hint/html-hint.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/dialog/dialog.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/search/searchcursor.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/search/search.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/addon/scroll/simplescrollbars.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/mode/clike/clike.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/mode/css/css.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/mode/htmlmixed/htmlmixed.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/mode/javascript/javascript.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/mode/php/php.js');?>"></script>
	<script src="<?=content_url('plugins/codemirror/mode/xml/xml.js');?>"></script>
	<?php endif ?>

	<!-- menumanager -->
	<?php if ($this->mod == "menumanager"): ?>
	<script src="<?=content_url('plugins/menumanager/jquery-1.7.2.js');?>"></script>
	<script src="<?=content_url('plugins/menumanager/iutil.js');?>"></script>
	<script src="<?=content_url('plugins/menumanager/idrag.js');?>"></script>
	<script src="<?=content_url('plugins/menumanager/idrop.js');?>"></script>
	<script src="<?=content_url('plugins/menumanager/isortables.js');?>"></script>
	<script src="<?=content_url('plugins/menumanager/inestedsortable.js');?>"></script>
	<?php endif ?>

	<?php if ($this->mod == "cogen"): ?>
	<script src="<?=content_url('plugins/wizards/steps.min.js');?>"></script>
	<?php endif ?>

	<!-- Required Script -->
	<script src="<?=content_url('themes/admin/js/app.js');?>"></script>
	<script src="<?=content_url('themes/admin/js/customs.js');?>"></script>

	<!-- Include Modjs -->
	<?php if (file_exists(CONTENTPATH . 'modjs/'.$this->mod.'.js')): ?>
	<script src="<?= content_url('modjs/'.$this->mod.'.js');?>"></script> 
	<?php endif ?>

	<!-- script -->
	<?php
		if (file_exists(VIEWPATH . 'mod/'.$this->mod.'/script.php')):
			require_once(VIEWPATH . 'mod/'.$this->mod.'/script.php');
	?>

	<?php endif ?>

</body>
</html>