<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<?=$this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>

	<div class="block-content">
		<div class="row">
			<div class="col-md-12">
				<div class="block-header">
					<h3><?=lang_line('mod_title');?></h3>
					<ol class="breadcrumb">
						<li><a href="<?=admin_url();?>"><?=lang_line('admin_link_home');?></a></li>
						<li><?=lang_line('mod_title');?></li>
						<li><?=lang_line('mod_title_reply');?></li>
					</ol>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo form_open(); ?>
					<div class="form-group">
						<label><?=lang_line('form_label_to');?> <span class="text-danger">*</span></label>
						<input type="text" value="<?=$mail['email']; ?>" class="form-control" disabled style="max-width:500px;"/>
						<input type="hidden" name="email" value="<?=$mail['email']; ?>" required/>
					</div>
					<div class="form-group">
						<label><?=lang_line('form_label_subject');?> <span class="text-danger">*</span></label>
						<input type="text" name="subject" value="<?=$mail['subject']; ?>" class="form-control" required style="max-width:500px;"/>
					</div>
					<div class="form-group">
						<label><?=lang_line('form_label_message');?> <span class="text-danger">*</span></label>
						<textarea id="Content" name="content" class="form-control">
							<?= set_value('content');?>
						</textarea>
						<div class="form-input-error"><?=form_error('content');?></div>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="block-actions">
		                <button type="submit" class="btn btn-md btn-primary text-b"><i class="fa fa-send"></i>&nbsp; <?=lang_line('button_send');?></button>
						<a href="<?=admin_url($this->mod);?>" class="pull-right btn btn-md btn-danger text-b"><i class="fa fa-times"></i>&nbsp; <?=lang_line('button_cancel');?></a>
						<div class="clearfix"></div>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>