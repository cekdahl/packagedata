<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	
		$this->load->model('packages_model');
	}

	public function packages()
	{
		$packages = $this->packages_model->list_packages();
		
		foreach($packages as &$package)
		{
			$package['id'] = $package['parent_id'];
			unset($package['parent_id']);
			unset($package['user_id']);
			unset($package['display_name']);
			unset($package['status']);
		}
		
		echo json_encode($packages);
	}
	
	public function history($id)
	{
		$packages = $this->packages_model->get_package_history($id);
		
		foreach($packages as &$package)
		{
			unset($package['id']);
			unset($package['user_id']);
			unset($package['display_name']);
			unset($package['status']);
		}
		
		echo json_encode($packages);
	}
	
	public function possible_duplicates($partial_name)
	{
		$possible_duplicates = $this->packages_model->list_possible_duplicates($partial_name);

		foreach($possible_duplicates as &$package)
		{
			unset($package['id']);
			unset($package['user_id']);
			unset($package['display_name']);
			unset($package['status']);
		}

		echo json_encode($possible_duplicates);
	}
}