<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Github extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	
		if(!is_cli())
		{
			exit('No public requests allowed');
		}
		
		$this->load->model('github_model');
	}
	
	public function synchronize()
	{
		$this->github_model->update_all_release_data();
		echo 'Done!';
	}
}