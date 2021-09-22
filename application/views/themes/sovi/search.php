<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- 
*******************************************************
	Include Header Template
******************************************************* 
-->
<?php $this->CI->render_view('header'); ?>
<!-- End Header -->

<!-- 
*******************************************************
	Insert Content
******************************************************* 
-->
<section id="page-title">
	<div class="container clearfix">
		<h1>Search</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=site_url(); ?>">Home</a></li>
			<li class="breadcrumb-item">Search</li>
			<li class="breadcrumb-item active" aria-current="page"><?=$keywords?></li>
		</ol>
	</div>
</section>
<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<div class="row">
				<div class="col-lg-8 nobottommargin clearfix">
					<div class="col-md-10" style="margin:10px auto !important;display:table;">
						<?=form_open('search');?>
						<div class="field-item">
							<input type="text" class="sm-form-control" name="kata" value="<?=$keywords?>" placeholder="Search...">
						</div>
						<button type="submit" class="button button-3d" style="margin:10px auto !important;display:table;">Search</button>
						<?=form_close()?>
					</div>
					<p class="text-center"><?='<strong>'.$num_post.'</strong> Search results for keywords "<strong>'.$keywords.'</strong>"'; ?></p>
					<hr>
					<div id="posts" class="small-thumbs">
						<!-- item -->
						<?php
							foreach ($search_post as $row):
								$category = $this->CI->db
									->where('id', $row['id_category'])
									->get('t_category')
									->row_array();
						?>
						<div class="entry clearfix">
							<div class="entry-image">
								<a href="<?=post_url($row['seotitle']);?>" title="<?=$row['title'];?>">
									<img class="image_fade" src="<?=post_images($row['picture'],'medium',TRUE);?>" alt="<?=$row['title'];?>">
								</a>
							</div>
							<div class="entry-c">
								<div class="entry-title">
									<h2>
										<a href="<?=post_url($row['seotitle']);?>"><?=$row['title'];?></a>
									</h2>
								</div>
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i> <?=ci_date($row['datepost'].$row['timepost'], 'l, d F Y');?></li>
									<li><i class="icon-folder-open"></i> <a href="<?=site_url('category/'.$category['seotitle']);?>"><?=$category['title'];?></a></li>
									<li><i class="icon-eye"></i> <?=$row['hits'];?></li>
								</ul>
								<div class="entry-content">
									<p><?=cut($row['content'],150);?>...</p>
									<a href="<?=post_url($row['seotitle']);?>" class="more-link">Read More</a>
								</div>
							</div>
						</div>
						<?php endforeach ?>
						<!--/ item -->
					</div>
					<!-- Pagination -->
					<div class="row mb-3">
						<div class="col-12">
							<ul class="pagination justify-content-center">
								<?=$page_link;?>
							</ul>
						</div>
					</div>
					<!--/ Pagination -->
				</div>

				<!-- Sidebar -->
				<div class="col-lg-4 nobottommargin col_last clearfix">
					<?php $this->CI->render_view('sidebar'); ?>
				</div>
				<!-- End Sidebar -->
			</div>
		</div>
	</div>
</section>
<!-- End Content -->

<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php $this->CI->render_view('footer'); ?>
<!-- End Footer -->