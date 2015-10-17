<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Links extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('packages_model');
	}

	public function index()
	{
		$uri = $this->uri->uri_to_assoc();

		$sort = 'alphabetically';
		if( isset($uri['sort']) )
		{
			switch( $uri['sort'] )
			{
				case 'alphabetically':
					$sort = 'alphabetically';
					break;
				case 'newest':
					$sort = 'newest';
					break;
				case 'popular':
					$sort = 'popular';
			}
		}
		
		$keyword = NULL;
		$keyword_description = FALSE;
		if(isset($uri['keyword']))
		{
			$keyword = urldecode($uri['keyword']);
			
			$this->config->load('keyword_descriptions');
			$descriptions = $this->config->item('keyword_descriptions');
			
			if(isset($descriptions[$keyword]))
			{
				$keyword_description = $descriptions[$keyword];
			}
		}
		
		$has_examples = isset($uri['has_examples']) ? $uri['has_examples'] : 'false';
		$has_download = isset($uri['has_download']) ? $uri['has_download'] : 'false';
		$packages = $this->packages_model->list_packages('published', $sort, $keyword, $has_examples, $has_download);
	
		$data = array(
			'packages' => $packages,
			'sort' => $sort,
			'selected_keyword' => $keyword,
			'has_examples' => $has_examples,
			'has_download' => $has_download,
			'oauth_link' => oauth_link(),
			'keyword_description' => $keyword_description,
			'frontpage' => TRUE
		);
		
		load_template('packages', $data);
	}
	
	public function add()
	{	
		$package_id = is_numeric($this->input->post('parent_id')) ? $this->input->post('parent_id') : NULL;
	
		if( $this->packages_model->add_package($package_id) )
		{
			if( $package_id === NULL )
			{
				if( is_logged_in() )
				{
					set_success_message('The package link has been successfully added.', 'links/');
				}
				else
				{
					set_success_message('The package link that you submitted is now under review. If it is approved it will be visible shortly.', 'links/');
				}
			}
			else
			{
				if( is_logged_in() )
				{
					set_success_message('The package link has been successfully updated.', 'links/');
				}
				else
				{
					set_success_message('The update to the package link that you submitted is now under review. It will be visible in the list shortly.', 'links/');
				}
			}
		}
		
		$data = array(
			'oauth_link' => oauth_link(),
			'package' => array(
			    'parent_id' => FALSE,
			    'name' => '',
			    'url' => '',
			    'keywords' => '',
			    'description' => '',
			    'examples' => '',
			    'has_examples' => FALSE
			));

		$uri = $this->uri->uri_to_assoc();
		if( isset($uri['id']) )
		{
			$package_data = $this->packages_model->get_package_data($uri['id']);
			
			if( $package_data )
			{
				$data['package'] = array(
					'parent_id' => $package_data['parent_id'],
					'name' => $package_data['name'],
					'url' => $package_data['url'],
					'keywords' => $this->packages_model->get_keywords_str($package_data['id']),
					'description' => $package_data['description'],
					'examples' => $package_data['examples'],
					'has_examples' => $package_data['has_examples']
				);
			}
		}
		
		load_template('add', $data);
	}
	
	public function delete()
	{
		$uri = $this->uri->uri_to_assoc();
		
		if( !isset($uri['id']) )
		{
			redirect('links/');
		}
		
		if( $this->packages_model->add_delete_request() )
		{
			set_success_message('The delete request has been submitted review.', 'links/');
		}
		
		$data = array(
				'oauth_link' => oauth_link(),
				'parent_id' => $uri['id']
			);
		
		load_template('delete', $data);
	}
	
	public function history()
	{
		$uri = $this->uri->uri_to_assoc();
		
		if( !isset($uri['id']) )
		{
			redirect('links/');
		}
		
		$package_history = $this->packages_model->get_package_history($uri['id']);
		
		foreach($package_history as &$package)
		{
			switch($package['status'])
			{
				case 'published':
					$package['status_color'] = 'success';
					break;
				case 'superseded':
					$package['status_color'] = 'default';
					break;
				case 'pending':
					$package['status_color'] = 'primary';
					break;
				case 'trash':
					$package['status_color'] = 'danger';
					break;
				case 'approved':
					$package['status_color'] = 'success';
					break;
				case 'rejected':
					$package['status_color'] = 'danger';
					break;
				default:
					$package['status_color'] = 'default'; 
			}
		}
		
		$data = array(
				'oauth_link' => oauth_link(),
				'package_history' => $package_history
			);
		
		load_template('history', $data);
	}
	
	public function examples()
	{
		$uri = $this->uri->uri_to_assoc();
		
		if( !isset($uri['id']) )
		{
			redirect('links/');
		}
		
		$data = array(
				'oauth_link' => oauth_link(),
				'package' => $this->packages_model->get_package_data($uri['id'])
			);
		
		load_template('examples', $data);
	}
	
	public function examples_history()
	{
		$uri = $this->uri->uri_to_assoc();
		
		if( !isset($uri['id']) )
		{
			redirect('links/');
		}
		
		$data = array(
				'oauth_link' => oauth_link(),
				'package' => $this->packages_model->get_package_data($uri['id'], FALSE)
			);
		
		load_template('examples', $data);
	}
	
	public function redirect_to($package_id = FALSE, $parent_id = FALSE)
	{
		if( $package_id === FALSE || $parent_id === FALSE )
		{
			redirect('links/');
		}
		
		$this->packages_model->increment_forwards_count($parent_id);
		$url = $this->packages_model->get_package_url($package_id);
		
		if($url)
		{
			redirect($url);
		}
		
		redirect('links/');
	}
	
	public function register_redirect($parent_id)
	{
		$this->packages_model->increment_forwards_count($parent_id);
	}
	
	public function tutorial()
	{
		load_template('tutorial', array('oauth_link' => oauth_link()));
	}
	
	public function upload_image()
	{
		$this->load->model('captcha_model');
		if( !$this->captcha_model->validate() )
		{
		    echo json_encode(array(
		    	'error' => 'reCaptcha could not be validated.'
		    ));
		}
		else
		{
			$config['upload_path'] = './uploads/images';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']     = '2000';
			$config['max_width'] = '1024';
			$config['max_height'] = '768';
			$config['encrypt_name'] = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('file'))
			{
				echo json_encode(array(
					'error' => $this->upload->display_errors()
				));
			}
			else
			{
				echo json_encode(array(
				    'error' => FALSE,
				    'name' => $this->upload->data('file_name')
				));
			}
		}
	}
}
