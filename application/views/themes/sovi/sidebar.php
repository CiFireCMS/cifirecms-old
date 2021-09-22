<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="sidebar-widgets-wrap clearfix">

	<div class="widget clearfix">
		<div class="col_one_third nobottommargin">
			<a href="#" class="social-icon si-dark si-colored si-facebook nobottommargin" style="margin-right: 10px;">
				<i class="icon-facebook"></i>
				<i class="icon-facebook"></i>
			</a>
			<small style="display: block; margin-top: 3px;">
				<strong>
					<div class="counter counter-inherit">
						<span data-from="10" data-to="58742" data-refresh-interval="100" data-speed="3000" data-comma="true"></span>
					</div>
				</strong>
				Facebook
			</small>
		</div>

		<div class="col_one_third nobottommargin">
			<a href="#" class="social-icon si-dark si-colored si-twitter nobottommargin" style="margin-right: 10px;">
				<i class="icon-twitter"></i>
				<i class="icon-twitter"></i>
			</a>
			<small style="display: block; margin-top: 3px;">
				<strong>
					<div class="counter counter-inherit">
						<span data-from="10" data-to="58742" data-refresh-interval="100" data-speed="3000" data-comma="true"></span>
					</div>
				</strong>
				Twitter
			</small>
		</div>

		<div class="col_one_third nobottommargin col_last">
			<a href="#" class="social-icon si-dark si-colored si-rss nobottommargin" style="margin-right: 10px;">
				<i class="icon-rss"></i>
				<i class="icon-rss"></i>
			</a>
			<small style="display: block; margin-top: 3px;">
				<strong>
					<div class="counter counter-inherit">
						<span data-from="10" data-to="58742" data-refresh-interval="100" data-speed="3000" data-comma="true"></span>
					</div>
				</strong>
				Subsciber
			</small>
		</div>
	</div>
	
	<!-- Popular, Latest -->
	<div class="widget clearfix">
		<div class="tabs nobottommargin clearfix" id="sidebar-tabs">
			<ul class="tab-nav clearfix">
				<li><a href="#tabs-1"><i class="icon-star"></i>&nbsp; Popular</a></li>
				<li><a href="#tabs-2"><i class="icon-clock"></i>&nbsp; Latest</a></li>
			</ul>
			<div class="tab-container">
				<!-- Popular -->
				<div class="tab-content clearfix" id="tabs-1">
					<div id="popular-post-list-sidebar">
						<?php
							// interval = all, week, month, year
							foreach ($this->CI->web->popular_post('all', 5) as $popular_post):
						?>
						<div class="spost clearfix">
							<div class="entry-image">
								<a href="<?=post_url($popular_post['post_seotitle']);?>" title="<?=$popular_post['post_title'];?>" class="nobg">
									<img class="rounded-circle" src="<?=post_images($popular_post['post_picture'], 'thumb', TRUE);?>">
								</a>
							</div>
							<div class="entry-c">
								<div class="entry-title">
									<h4>
										<a href="<?=post_url($popular_post['post_seotitle']);?>" title="<?=$popular_post['post_title'];?>"><?=$popular_post['post_title'];?></a>
									</h4>
								</div>
								<ul class="entry-meta">
									<li><i class="icon-calendar3"></i> <?=ci_date($popular_post['post_datepost'].$popular_post['post_timepost'], 'd F Y');?></li>
									<li><i class="icon-folder-open"></i> <a href="<?=site_url('category/'.$popular_post['category_seotitle']);?>"><?=$popular_post['category_title'];?></a></li>
									<li><i class="icon-eye"></i> <?=$popular_post['post_hits'];?></li>
								</ul>
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>
				<!--/ Popular -->
				<!-- Latest -->
				<div class="tab-content clearfix" id="tabs-2">
					<div id="recent-post-list-sidebar">
						<?php
							foreach ($this->CI->web->latest_post() as $latest_post):
						?>
						<div class="spost clearfix">
							<div class="entry-image">
								<a href="<?=post_url($latest_post['post_seotitle']);?>" title="<?=$latest_post['post_title'];?>" class="nobg">
									<img class="rounded-circle" src="<?=post_images($latest_post['post_picture'], 'thumb', TRUE);?>">
								</a>
							</div>
							<div class="entry-c">
								<div class="entry-title">
									<h4>
										<a href="<?=post_url($latest_post['post_seotitle']);?>" title="<?=$latest_post['post_title'];?>"><?=$latest_post['post_title'];?></a>
									</h4>
								</div>
								<ul class="entry-meta">
									<li><i class="icon-clock"></i> <?=ci_timeago($latest_post['post_datepost'].$latest_post['post_timepost']);?></li>
									<li><i class="icon-folder-open"></i> <a href="<?=site_url('category/'.$latest_post['category_seotitle']);?>"><?=$latest_post['category_title'];?></a></li>
									<li><i class="icon-eye"></i> <?=$latest_post['post_hits'];?></li>
								</ul>
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>
				<!--/ Latest -->
			</div>
		</div>
	</div>
	<!--/ Popular, Latest -->

	<!-- Category -->
	<div class="widget widget_links clearfix">
		<h4>Category</h4>
		<div class="col_half nobottommargin col_last">
			<ul>
				<?php
					$sidebar_category = $this->CI->db
						->select('id_category,COUNT(*)')
						->from('t_post')
						->where('active','Y')
						->group_by('id_category')
						->order_by('COUNT(*)','DESC')
						->get()
						->result_array();
					foreach ($sidebar_category as $rescount):
						$row_scategory = $this->CI->db
							->select('id,title,seotitle')
							->where('id',$rescount['id_category'])
							->where('id >','1')
							->where('active','Y')
							->get('t_category')
							->row_array();

						$num_spost = $this->CI->db
							->select('id')
							->where('id_category',$rescount['id_category'])
							->where('active','Y')
							->get('t_post')
							->num_rows();
						
						if ( is_null($row_scategory['id']) || $num_spost < 1 )
							continue;
				?>
				<li><a href="<?=site_url('category/'.$row_scategory['seotitle']);?>"><?=$row_scategory['title'];?> <span>(<?=$num_spost;?>)</span></a></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<!--/ Category -->

	<!-- Tags -->
	<div id="tags" class="widget clearfix">
		<h4 class="highlight-me">Tags</h4>
		<div class="tagcloud">
			<?php
				$side_tags = $this->CI->db
					->select('
							  t_tag.title, 
							  t_tag.seotitle, 
							  COUNT(t_post.id) AS tag_count
							')
					->from('t_tag')
					->join('t_post', "t_post.tag LIKE CONCAT('%',t_tag.seotitle,'%')", 'LEFT')
					->group_by('t_tag.id')
					->get()
					->result_array();
				foreach ( $side_tags as $row_stag ):
					if ( $row_stag['tag_count'] == 0 )
						continue;
			?>
			<a href="<?=site_url('tag/'.$row_stag['seotitle']);?>"><?=$row_stag['title'];?></a>
			<?php endforeach ?>
		</div>
	</div>
	<!--/ Tags -->
</div>