<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('packages_model');
        
        $this->load->helper('xml');
    }
    
    public function index()
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'PackageData.net';
        $data['feed_url'] = 'http://packagedata.net';
        $data['page_description'] = 'New packages added to PackageData.net';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'admin@packagedata.net';
        $data['posts'] = $this->packages_model->list_packages('published', 'newest');    

        $this->output->set_content_type('application/rss+xml');
        
        $this->load->view('rss', $data);
    }
    
    public function weekly()
    {
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = 'PackageData.net';
        $data['feed_url'] = 'http://packagedata.net';
        $data['page_description'] = 'New packages added to PackageData.net (weekly report)';
        $data['page_language'] = 'en-ca';
        $data['creator_email'] = 'admin@packagedata.net';
        $data['packages'] = $this->packages_model->list_packages_weekly();    

        $this->output->set_content_type('application/rss+xml');
        
        $this->load->view('rss_weekly', $data);
    }
}

?>