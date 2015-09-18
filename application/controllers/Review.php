<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if( !is_logged_in() )
		{
			redirect('links/');
		}
		
		$this->load->model('packages_model');
		$this->load->model('review_model');
		$this->load->library('form_validation');
	}
	
	public function pending_new()
	{
		$packages = $this->review_model->get_pending_new();
		
		$counts = array(
			'all' => $this->review_model->count_all_pending(),
			'new' => $this->review_model->count_pending_new(),
			'updates' => $this->review_model->count_pending_updates(),
			'delete_requests' => $this->review_model->count_pending_delete_requests()
		);
		
		$data = array(
			'packages' => $packages,
			'counts' => $counts
		);
	
		load_template('pending_new', $data);
	}
	
	public function pending_updates()
	{
		$packages = $this->review_model->get_pending_updates();
		
		$counts = array(
			'all' => $this->review_model->count_all_pending(),
			'new' => $this->review_model->count_pending_new(),
			'updates' => $this->review_model->count_pending_updates(),
			'delete_requests' => $this->review_model->count_pending_delete_requests()
		);
		
		$data = array(
			'packages' => $packages,
			'counts' => $counts
		);
	
		load_template('pending_updates', $data);
	}
	
	public function pending_delete_requests()
	{
		$requests = $this->review_model->get_pending_delete_requests();
		
		$counts = array(
			'all' => $this->review_model->count_all_pending(),
			'new' => $this->review_model->count_pending_new(),
			'updates' => $this->review_model->count_pending_updates(),
			'delete_requests' => $this->review_model->count_pending_delete_requests()
		);
		
		$data = array(
			'requests' => $requests,
			'counts' => $counts
		);
	
		load_template('pending_delete_requests', $data);
	}
	
	public function trash()
	{
		$packages = $this->review_model->get_deleted();
		
		$counts = array(
			'all' => $this->review_model->count_all_pending(),
			'new' => $this->review_model->count_pending_new(),
			'updates' => $this->review_model->count_pending_updates(),
			'delete_requests' => $this->review_model->count_pending_delete_requests()
		);
		
		$data = array(
			'packages' => $packages,
			'counts' => $counts
		);
	
		load_template('trash', $data);
	}

	public function publish($id)
	{	
		$is_first = $this->review_model->is_first_version($id);
		
		if( $is_first )
		{
			$parent_id = NULL;
		}
		else
		{
			$parent_id = $this->packages_model->get_package_parent_id($id);
		}
		
		if( $this->review_model->publish_link($id, $parent_id) )
		{
			set_success_message('Link has been published.');		
		}
		else
		{
			set_error_message('No link was affected by the request - try again.');	
		}
		
		if( $is_first )
		{
			redirect('review/pending_new');			
		}
		else
		{
			redirect('review/pending_updates');		
		}
	}
	
	public function republish($id)
	{	
		$is_first = $this->review_model->is_first_version($id);
		
		if( $is_first )
		{
			$parent_id = NULL;
		}
		else
		{
			$parent_id = $this->packages_model->get_package_parent_id($id);
		}
		
		if( $this->review_model->publish_link($id, $parent_id) )
		{
			set_success_message('Link has been published.');		
		}
		else
		{
			set_error_message('No link was affected by the request - try again.');	
		}
		
		redirect('review/trash');			
	}
	
	public function delete($id)
	{
		if( $this->review_model->delete_link($id) )
		{
			set_success_message('Link moved to trash.');
		}
		else
		{
			set_error_message('No link was affected by the request - try again.');	
		}
		
		if( $this->review_model->is_first_version($id) )
		{
			redirect('review/pending_new');			
		}
		else
		{
			redirect('review/pending_updates');		
		}
	}
	
	public function approve($id)
	{
		if( $this->review_model->approve_delete_request($id) )
		{
			set_success_message('Link moved to trash.');
		}
		else
		{
			set_error_message('No link was affected by the request - try again.');
		}
		
		redirect('review/pending_delete_requests');
	}
	
	public function reject($id)
	{
		if( $this->review_model->reject_delete_request($id) )
		{
			set_success_message('Delete request rejected.');
		}
		else
		{
			set_error_message('No link was affected by the request - try again.');
		}
		
		redirect('review/pending_delete_requests');
	}

}