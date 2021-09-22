<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-inner">
	<div class="d-sm-flex align-items-center justify-content-between pd-b-20">
		<div class="pageheader pd-t-20 pd-b-0">
			<div class="d-flex justify-content-between">
				<div class="clearfix">
					<div class="breadcrumb pd-0 pd-b-10 mg-0">
						<a href="#" class="breadcrumb-item"><?=lang_line('ui_dashboard');?></a>
						<a href="#" class="breadcrumb-item"><?=lang_line('ui_media');?></a>
						<a href="#" class="breadcrumb-item"><?=lang_line('mod_title');?></a>
					</div>
					<h4 class="pd-0 mg-0 tx-20 tx-dark tx-spacing--1"><?=lang_line('mod_title');?></h4>
				</div>
			</div>
		</div>
		<div class="mg-t-15">
			<button type="button" class="btn btn-sm pd-x-15 btn-white btn-uppercase modal_add_album"><i data-feather="plus" class="mr-2"></i><?=lang_line('button_add_album');?></button>
		</div>
	</div>

	<div>
		<?=$this->alert->show($this->mod);?>
		<div class="ajax_alert" style="display:none;"></div>
	</div>

	<div class="card">
		<div class="card-header">
			<h6 class="lh-5 mg-b-0 text-uppercaseX"><i class="icon-bookmark  mr-2 tx-gray-600"></i> <?=lang_line('_all_album');?></h6>
		</div>
		<div class="card-body">
			<div class="row">
				<?php 
					foreach ($albums as $res_album):
						$res = $this->db
							->select('picture')
							->where('id_album', $res_album['id'])
							->limit(1)
							->order_by('id', 'DESC')
							->get('t_gallery')
							->row_array();

						$photosrc = post_images($res['picture'],'thumb',TRUE);
				?>
				<div id="gallery-item<?=$res_album['id'];?>" class="col-sm-6 col-md-4 col-lg-3 mb-3">
					<div class="card">
						<div class="card-body text-center">
							<p><?=$res_album['title']?></p>
							<div class="theme-img-card mb-2">
								<a href="<?=admin_url($this->mod.'/album/?id='.urlencode(encrypt($res_album['id'])));?>" title="<?=$res_album['title'];?>">
									<img src="<?=content_url('images/medium_noimage.jpg');?>" data-src="<?=$photosrc;?>" class="lazy" style="width:100%;">
								</a>
							</div>
							<div class="btn-group">
								<button class="btn btn-xs btn-white" onclick="location.href='<?=admin_url($this->mod.'/album/?id='.urlencode(encrypt($res_album['id'])));?>'"><i class="cificon licon-eye"></i></button>
								<button class="btn btn-xs btn-white delete_album" data-id="<?=encrypt($res_album['id']);?>"><i class="cificon licon-trash-2"></i></button>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>

<div id="modal_add_album" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?=form_open('','autocomplete="off"');?>
			<div class="modal-header">
				<h5 class="modal-title"><?=lang_line('dialog_title_add_album');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label><?=lang_line('_title_album');?> <small class="text-danger">*</small></label>
					<input type="text" name="title" class="form-control" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success"><?=lang_line('button_submit');?></button>
				<button type="reset" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang_line('button_cancel');?></button>
			</div>
			<?=form_close();?>
		</div>
	</div>
</div>
