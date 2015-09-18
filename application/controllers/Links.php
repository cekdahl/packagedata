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
					$sort = 'popularity';
			}
		}
		
	
		$data = array(
			'packages' => $this->packages_model->list_packages('published', $sort),
			'sort' => $sort,
			'oauth_link' => oauth_link()
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
			    'description' => ''
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
					'description' => $package_data['description']
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
	
}