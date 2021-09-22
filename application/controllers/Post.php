<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Web_controller {

	public $mod = 'post';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('paging');
		$this->load->model('web/post_model');
		$this->us = xss_filter($this->uri->segment(count($this->uri->segments)), 'xss');
		$this->seotitle = seotitle($this->us);
	}


	public function index()
	{
		if ( !empty($this->seotitle) && $this->post_model->cek_post($this->seotitle) == TRUE ) 
		{
			$id_post = $this->post_model->id_post($this->seotitle);
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' )  // Submit Komentar.
			{
				return $this->_submit_comment($id_post);
			}

			else
			{
				$data_post = $this->post_model->get_post($this->seotitle);
				
				$this->meta_title($data_post['post_title']);
				$this->meta_keywords($data_post['tag'].', '.get_setting('web_keyword'));
				$this->meta_description(cut($data_post['content'], 150));
				$this->meta_image(post_images($data_post['picture'], 'medium', TRUE));

				$xpcontent = explode('&lt;p&gt;&lt;!-- pagebreak --&gt;&lt;/p&gt;', $data_post['content']);
				$_url     = post_url($data_post['post_seotitle'])."?";
				$_page    = xss_filter($this->input->get('page'),'sql');
				$_index   = ($_page>0 ? $_page-1 : $_page);
				$_halaman = count($xpcontent);

				$this->vars['result_post']  = $data_post;

				// $this->vars['result_post']['content'] = html_entity_decode($xpcontent[$_index]);
				// $this->vars['content_paging'] = ($_halaman > 1 ? $this->paging->alink($_page, $_halaman, $_url) : '');

				$this->vars['result_post']['content'] = $this->_content($data_post);
				$this->vars['content_paging'] = $this->_content($data_post,'paging');				
				
				// link prev post & next post.
				$this->vars['prev_post'] = $this->_prev_post($id_post); 
				$this->vars['next_post'] = $this->_next_post($id_post);
				// related post
				$this->vars['related_post'] = $this->post_model->related_post($data_post['tag'], $data_post['post_id'], 3);

				$this->render_view('post', $this->vars);

				// set new hits.
				$set_hits = $data_post['hits'] + 1;
				$this->post_model->hits($id_post, $set_hits);
			}
		}
		else
		{
			$this->render_404();
		}
	}


	private function _content($data='', $param2='')
	{
		// $ex_content = explode('&lt;p&gt;&lt;!-- pagebreak --&gt;&lt;/p&gt;', $data['content']);
		$ex_content = explode('&lt;!-- pagebreak --&gt;', $data['content']);
		$_pageNum   = count($ex_content);
		$_urlPost   = post_url($data['post_seotitle'])."?";
		$_getPage   = xss_filter($this->input->get('page'),'sql');
		$_index     = ($_getPage>0 ? $_getPage-1 : $_getPage);

		$result_content = html_entity_decode($ex_content[$_index]);
		$result_paging  = ($_pageNum > 1 ? $this->paging->alink($_getPage, $_pageNum, $_urlPost) : '');

		if ($param2=='paging')
			return $result_paging;
		else
			return $result_content;
	}


	private function _submit_comment($id_post = 0)
	{
		if ( $this->captcha() == TRUE && googleCaptcha()->success == FALSE )
		{
			$this->alert->set('alert_comment', 'danger', 'Please complete the captcha');
			redirect(uri_string().'#form_comment');
		}

		else
		{
			$this->form_validation->set_rules(array(
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required|trim|min_length[4]|max_length[150]|regex_match[/^[a-zA-Z0-9-._ ]+$/]'
				),
				array(
				    'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|trim|max_length[60]|valid_email'
				),
				array(
				    'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'required|trim|min_length[6]|max_length[5000]'
				)
			));

			if ( $this->form_validation->run() ) 
			{
				$inputParent = xss_filter(decrypt($this->input->post('parent')), 'sql');
				$parent  = ( !empty($inputParent) ? $inputParent : 0 );

				$data_comment = array(
					'id_post' => xss_filter($id_post, 'sql'),
					'parent'  => $parent,
					'name'    => xss_filter($this->input->post('name', TRUE), 'xss'),
					'email'   => $this->input->post('email', TRUE),
					'comment' => xss_filter($this->input->post('comment', TRUE), 'xss'),
					'ip'      => $this->CI->input->ip_address(),
					'active'  => 'N'
				);

				$this->post_model->insert_comment($data_comment);
				$this->alert->set('alert_comment', 'success', 'Succes');
				redirect(selft_url().'#form_comment');
			}
			else 
			{
				$this->alert->set('alert_comment', 'danger', validation_errors());
				redirect(selft_url().'#form_comment');
			}
		}
	}


	private function _prev_post($id = 0) 
	{
		$data = $this->post_model->prev_post($id);

		if ( $data == FALSE )
		{
			return NULL;
		}

		else
		{
			$result = array(
				'title' => $data['title'], 
				'url'   => post_url($data['seotitle'])
			);

			return $result;
		}
	}


	private function _next_post($id = 0) 
	{
		$data = $this->post_model->next_post($id);
		
		if ( $data == FALSE )
		{
			return NULL;
		}
		else
		{	
			$result = array(
				'title' => $data['title'], 
				'url'   => post_url($data['seotitle'])
			);
			return $result;
		}
	}


	private function _cekpost()
	{
		if ( !empty($this->seotitle) && $this->post_model->cek_post($this->seotitle) == TRUE )
		{
			$this->id_post = $this->post_model->id_post($this->seotitle);
		}
		else
		{
			$this->render_404();
		}
	}
} // End class.