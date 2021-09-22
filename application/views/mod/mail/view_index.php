<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h3>
				<span class="font-weight-semibold"><?=lang_line('mod_title');?></span>
			</h3>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-light">
		<div class="breadcrumb">
			<a href="<?=admin_url('home');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> <?=lang_line('admin_link_home');?></a>
			<span class="breadcrumb-item"><?=lang_line('mod_title');?></span>
			<span class="breadcrumb-item"><?=lang_line('inbox');?></span>
		</div>
	</div>
</div>

<div class="content">
	<?=$this->alert->show($this->mod); ?>
	<div class="ajax_alert" style="display:none;"></div>

	<div class="block">
		<div class="block-header">
			<h3><?=lang_line('inbox');?></h3>
		</div>
		<div class="row">
			<div class="table-responsive">
				<div class="col-md-12">				
					<table id="DataTable" class="display responsive no-wrap table table-striped table-hover table-bordered table-content">
						<thead>
							<tr>
								<th class="no-sort text-center">
									<input type="checkbox" class="select_all" data-toggle="tooltip" data-placement="top" data-title="<?=lang_line('tooltip_select_all');?>">
								</th>
								<th class="text-align"><i class="fa fa-envelope-o text-muted"></i></th>
								<th><?=lang_line('table_from');?></th>
								<th><?=lang_line('table_subject');?></th>
								<th><?=lang_line('table_date');?></th>
								<th class="text-center no-sort"><?=lang_line('table_action');?></th>
							</tr>
						</thead>
						<tbody></tbody>
						<tr id="delall">
							<td colspan="6">
								<button type="button" class="button btn-sm btn-default text-danger delete_multi"><i class="icon-bin"></i> <?=lang_line('button_delete_selected_item');?></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="form_delete" method="POST" action="" autocomplete="off">
				<input type="hidden" name="act" value="delete">
				<input type="hidden" name="id" id="idDel" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<i class="fa fa-exclamation-triangle text-danger"></i>&nbsp;&nbsp;<?=lang_line('dialog_delete_title');?>
				</div>
				<div class="modal-body">
					<?=lang_line('dialog_delete_content');?>
				</div>
				<div class="modal-footer">
					<button id="submit_delete" type="button" class="btn btn-md btn-danger"><i class="fa fa-trash"></i>&nbsp; <?=lang_line('button_yes');?></button>
					<button type="button" class="btn btn-md btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i>&nbsp; <?=lang_line('button_no');?></button>
				</div>
			</form>
		</div>
	</div>
</div>
