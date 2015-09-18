<?php
class Review_model extends CI_Model {

	public function count_all_pending()
	{
		$this->db->from('packages')->where('status', 'pending');
		$links = $this->db->count_all_results();
		$this->db->from('delete_requests')->where('status', 'pending');
		$delete_requests = $this->db->count_all_results();
		
		return $links + $delete_requests;
	}

	public function count_pending_new()
	{
		$this->db->from('packages');
		$this->db->where("status = 'pending' AND id = parent_id");
		return $this->db->count_all_results();
	}
	
	public function count_pending_updates()
	{
		$this->db->from('packages');
		$this->db->where("status = 'pending' AND id != parent_id");
		return $this->db->count_all_results();
	}
	
	public function count_pending_delete_requests()
	{
		$this->db->from('delete_requests');
		$this->db->where(array('status' => 'pending'));
		return $this->db->count_all_results();
	}
	
	public function get_pending_new()
	{
		$packages = $this->db->get_where('packages', "status = 'pending' AND id = parent_id")->result_array();
		
		foreach($packages as &$package)
		{
			$package['keywords'] = $this->get_keywords($package['id']);
		}
		
		return $packages;
	}
	
	public function get_pending_updates()
	{
		$packages = $this->db->get_where('packages', "status = 'pending' AND id != parent_id")->result_array();
				
		foreach($packages as &$package)
		{
			$package['keywords'] = $this->get_keywords($package['id']);
		}
		
		return $packages;
	}
	
	public function get_pending_delete_requests()
	{
		$packages = $this->db
			->select('delete_requests.id AS request_id, delete_requests.comment AS comment, packages.*')
			->join('packages', 'packages.id = delete_requests.package_id', 'inner')
			->get_where('delete_requests', array('delete_requests.status' => 'pending'))
			->result_array();
			
		foreach($packages as &$package)
		{
			$package['keywords'] = $this->get_keywords($package['id']);
		}
		
		return $packages;
	}
	
	public function get_deleted()
	{
		$packages = $this->db->get_where('packages', array('status' => 'trash'))->result_array();
		
		foreach($packages as &$package)
		{
			$package['keywords'] = $this->get_keywords($package['id']);
		}
		
		return $packages;
	}
	
	public function publish_link($id, $parent_id = NULL)
	{
		if($parent_id !== NULL)
		{
			$this->db->where('parent_id', $parent_id)->where('status', 'published')->update('packages', array(
				'status' => 'superseded'
			));
		}
	
		$this->db->where('id', $id)->update('packages', array(
			'status' => 'published'
		));
		
		return ($this->db->affected_rows() > 0);
	}
	
	public function delete_link($id)
	{
		$this->db->where('id', $id)->update('packages', array('status' => 'trash'));
		
		return ($this->db->affected_rows() > 0);
	}
		
	public function approve_delete_request($id)
	{
		$request = $this->db->get_where('delete_requests', array('id' => $id))->row_array();
		$this->db->where('id', $id)->update('delete_requests', array('status' => 'approved'));
		$this->db->where('parent_id', $request['package_id'])->where('status', 'published')->update('packages', array('status' => 'trash'));
		
		return ($this->db->affected_rows() > 0);
	}
	
	public function reject_delete_request($id)
	{
		$this->db->where('id', $id)->update('delete_requests', array('status' => 'rejected'));
		
		return ($this->db->affected_rows() > 0);
	}
	
	public function is_pending($id)
	{
		return $this->db->get_where('packages', array('id' => $id, 'status' => 'pending'))->num_rows() > 0;
	}
	
	public function is_first_version($id)
	{
		return $this->db->get_where('packages', array('id' => $id, 'parent_id' => $id))->num_rows() > 0;
	}
	
	public function get_keywords($post_id)
	{
		$tbl_keywords = $this->db->dbprefix('keywords');
		$tbl_packages_keywords = $this->db->dbprefix('packages_keywords');
		$keywords = $this->db->query("SELECT $tbl_keywords.keyword 
			FROM $tbl_keywords
			INNER JOIN $tbl_packages_keywords
			ON $tbl_keywords.id = $tbl_packages_keywords.keyword_id
			WHERE $tbl_packages_keywords.package_id = ?", array($post_id))->result_array();
			
		$arr = array();
		foreach($keywords as $keyword)
		{
			$arr[] = $keyword['keyword'];
		}
		
		return $arr;
	}
}