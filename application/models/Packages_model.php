<?php
class Packages_model extends CI_Model {

	public function __construct()
	{
	        parent::__construct();

	       $this->load->library('form_validation');
	}
	
	public function add_package($parent_id = NULL)
	{
		if( $parent_id !== NULL )
		{
			$package_data = $this->get_package_data($parent_id);
			if( !$package_data || $package_data['status'] == 'trash' || $package_data['status'] == 'pending' )
			{
				return FALSE;
			}
		}
		
		$this->form_validation->set_rules('name', 'package name', 'required|min_length[1]|max_length[100]');
		$this->form_validation->set_rules('url', 'package URL', 'required|max_length[100]|prep_url|valid_url');
		$this->form_validation->set_rules('description', 'package description', 'required|min_length[15]|max_length[10000]');
		$this->form_validation->set_rules('examples', 'package usage examples', 'max_length[10000]');
	
		if( $this->form_validation->run() )
		{
			$ins1 = FALSE;
			$ins2 = FALSE;
		
			$this->load->library('parsedown');
		
			$examples = $this->input->post('examples');
			if( strlen($examples) > 10 )
			{
				$has_examples = TRUE;
			}
			else
			{
				$has_examples = FALSE;
				$examples = NULL;
			}
			
			if( $has_examples )
			{
				$examples_rendered = $this->parsedown->text($examples);
				$examples_rendered = str_replace('<pre>', '<pre class="prettyprint lang-mma">', $examples_rendered);
			}
			else
			{
				$examples_rendered = NULL;
			}
		
			$description = $this->input->post('description');
			$description_rendered = $this->parsedown->text($description);
			
			if( isset($_SESSION['logged_in']) )
			{
				$ins1 = $this->db->insert('packages', array(
					'status' => 'published',
					'name' => $this->input->post('name'),
					'url' => $this->input->post('url'),
					'description' => $description,
					'description_rendered' => $description_rendered,
					'examples' => $examples,
					'examples_rendered' => $examples_rendered,
					'has_examples' => $has_examples,
					'user_id' => $_SESSION['user_id'],
					'display_name' => $_SESSION['display_name']
				));		 
			}
			else
			{
				$this->load->model('captcha_model');
				if( !$this->captcha_model->validate() )
				{
					return FALSE;
				}
				
				$ins2 = $this->db->insert('packages', array(
					'status' => 'pending',
					'name' => $this->input->post('name'),
					'url' => $this->input->post('url'),
					'description' => $this->input->post('description'),
					'description_rendered' => $description_rendered,
					'examples' => $examples,
					'examples_rendered' => $examples_rendered,
					'has_examples' => (strlen($this->input->post('examples')) > 10) ? 1 : 0
				));
			}
			
			if( $ins1 || $ins2 )
			{
				if(!isset($_SESSION['logged_in'])) {
					$admin_email = $this->config->item('admin_email');
					if($admin_email !== NULL) {
					    $headers = 'From: admin@packagedata.net' . "\r\n" .
					        'Reply-To: admin@packagedata.net' . "\r\n" .
					        'X-Mailer: PHP/' . phpversion();
					
					    mail($admin_email, 'New post', 'A new post (or edit to a post) has been submitted by an anonymous user.', $headers);
					}
				}
			
				$insert_id = $this->db->insert_id();
		
				if( $parent_id === NULL )
				{
				    $this->db->where('id', $insert_id)->update('packages', array(
				    	'parent_id' => $insert_id
				    ));
				    
				    $parent_id = $insert_id;
				}
				else
				{
					if( isset($_SESSION['logged_in']) )
					{
						$this->db->where('parent_id', $parent_id)->update('packages', array(
							'status' => 'superseded'
						));
					}
				
				    $this->db->where('id', $insert_id)->update('packages', array(
				    	'parent_id' => $parent_id
				    ));
				}
				
				if($ins1 && isset($_SESSION['logged_in']))
				{
					$this->db->where(array(
					'id !=' => $insert_id,
					'parent_id' => $parent_id,
					'user_id' => $_SESSION['user_id']
					))->where('TIMESTAMPDIFF(MINUTE, timestamp, NOW()) <= 5')->delete('packages');
				}
				
				$this->add_keywords( $insert_id );
								
				return TRUE;
			}
			
		}
		
		return FALSE;
	}
	
	public function add_keywords($package_id)
	{
		$keywords = $this->input->post('keywords');
		
		if( !$keywords )
		{
			return;
		}

		$keywords = explode(',', $keywords);
		$keywords = array_slice($keywords, 0, 5);
		$keywords = array_map('trim', $keywords);
		
		$keyword_ids = array();
		foreach($keywords as $keyword)
		{
			$q = $this->db->get_where('keywords', array(
				'keyword' => $keyword
			));
			
			if( $q->num_rows() > 0 )
			{
				$keyword_ids[] = $q->row()->id;
			}
			else
			{
				$this->db->insert('keywords', array(
					'keyword' => $keyword
				));
				
				$keyword_ids[] = $this->db->insert_id();
			}
		}
		
		foreach($keyword_ids as $keyword_id)
		{
			$this->db->insert('packages_keywords', array(
				'package_id' => $package_id,
				'keyword_id' => $keyword_id
			));
		}
	}

	public function list_packages($status = 'published', $sort = 'alphabetically', $keyword = NULL, $has_examples = 'false')
	{
		if($sort == 'alphabetically')
		{
			$this->db->order_by('name', 'ASC');
		}
		elseif($sort == 'newest')
		{
			$this->db->order_by('timestamp', 'DESC');
		}
		elseif($sort == 'popular')
		{
			$tbl_packages = $this->db->dbprefix('packages');
			$tbl_forwards = $this->db->dbprefix('forwards');
			$packages = $this->db->query("SELECT $tbl_packages.*
			FROM $tbl_packages
			LEFT JOIN $tbl_forwards
			ON $tbl_packages.id = $tbl_forwards.package_id
			WHERE $tbl_packages.status = ?
			ORDER BY $tbl_forwards.nr_of_forwards DESC", array($status))->result_array();
			
			foreach($packages as $key => $package)
			{
				$packages[$key]['keywords'] = $this->get_keywords($package['id']);
				if(isset($keyword) && !in_array($keyword, $packages[$key]['keywords']))
				{
					unset($packages[$key]);
				}
				
				if(isset($package['description_rendered']))
				{
				    $packages[$key]['description'] = $package['description_rendered'];
				}
			}
			
			return $packages;
		}
		else
		{
			$this->db->order_by('name', 'ASC');
		}
		
		$this->db->where('status', $status);
		
		$packages = $this->db->get('packages')->result_array();
		
		foreach($packages as $key => $package)
		{
			if(isset($package['description_rendered']))
			{
				$packages[$key]['description'] = $package['description_rendered'];
			}
		
		    $packages[$key]['keywords'] = $this->get_keywords($package['id']);
		    if(isset($keyword) && !in_array($keyword, $packages[$key]['keywords']))
		    {
		    	unset($packages[$key]);
		    }
		    elseif(!$packages[$key]['has_examples'] && $has_examples == 'true' )
		    {
				unset($packages[$key]);
		    }
		}
		
		return $packages;
	}
	
	public function get_package_data($package_id)
	{
			$q = $this->db->get_where('packages', array(
				'parent_id' => $package_id,
				'status' => 'published'
			));
			
			if( $q->num_rows() > 0 )
			{
				$package = $q->row_array();
				
				if(isset($package['description_rendered']))
				{
					$package['description'] = $package['description_rendered'];
				}
				
				return $package;
			}
			
			return FALSE;
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
	
	public function get_keywords_str($post_id)
	{
		$keywords = $this->get_keywords($post_id);		
		return implode($keywords, ', ');
	}
	
	public function get_package_url($package_id)
	{
		$q = $this->db->get_where('packages', array(
			'id' => $package_id
		))->row();
		
		return $q->url;
	}
	
	public function get_package_parent_id($package_id)
	{
		$q = $this->db->get_where('packages', array(
			'id' => $package_id
		))->row();
		
		return $q->parent_id;
	}
	
	public function get_package_history($package_id)
	{
		$tbl_packages = $this->db->dbprefix('packages');
		$tbl_delete_requests = $this->db->dbprefix('delete_requests');
		$packages = $this->db->query("(
		SELECT 'link' as `type`, `id`, `status`, `name`, `url`, `description`, `description_rendered`, `timestamp`
		FROM `$tbl_packages`
		WHERE parent_id = ?
		)
		UNION
		(
		SELECT 'request' as `type`, NULL, `status`, NULL AS `name`, NULL AS `url`, `comment` AS `description`, NULL AS `description_rendered`, `timestamp`
		FROM `$tbl_delete_requests`
		WHERE package_id = ?
		) ORDER BY `timestamp` DESC", array($package_id, $package_id))->result_array();
		
		foreach($packages as &$package)
		{
			if($package['type'] == 'link')
			{
				if(isset($package['description_rendered']))
				{
					$package['description'] = $package['description_rendered'];
				}
			
				$package['keywords'] = $this->get_keywords($package['id']);
			}
		}
		
		return $packages;
	}
	
	public function increment_forwards_count($package_id)
	{
		$q = $this->db->get_where('forwards_ips', array(
			'package_id' => $package_id,
			'ip' =>	$_SERVER['REMOTE_ADDR']
		));
		
		if( $q->num_rows() == 0 )
		{
			$this->db->insert('forwards_ips',  array(
				'package_id' => $package_id,
				'ip' =>	$_SERVER['REMOTE_ADDR']
			));
			
			$tbl_forwards = $this->db->dbprefix('forwards');
			$this->db->query("INSERT INTO $tbl_forwards (package_id, nr_of_forwards) VALUES (?, 1) 
			ON DUPLICATE KEY UPDATE nr_of_forwards = nr_of_forwards+1", array($package_id));
		}
		
		return TRUE;
	}

	public function add_delete_request()
	{
		$id = $this->input->post('parent_id');
		
		if( !$this->get_package_data($id) )
		{
			return FALSE;
		}
		
		if( !isset($_SESSION['logged_in']))
		{
			$this->load->model('captcha_model');
			if( !$this->captcha_model->validate() )
			{
			    return FALSE;
			}
		}
		
		$this->form_validation->set_rules('explanation', 'explanation', 'required|min_length[15]|max_length[10000]');
		
		if( $this->form_validation->run() )
		{			
			$this->db->insert('delete_requests', array(
				'package_id' => $id,
				'status' => isset($_SESSION['logged_in']) ? 'approved' : 'pending',
				'comment' => $this->input->post('explanation')
			));
			
			if( isset($_SESSION['logged_in']) )
			{
				$this->delete_package($id);
			
				$this->session->set_flashdata('success_message', 'The link has now been moved to the trash.');
				redirect('links/');
			}
			else
			{
			    $admin_email = $this->config->item('admin_email');
			    if($admin_email !== NULL) {
			        $headers = 'From: admin@packagedata.net' . "\r\n" .
			            'Reply-To: admin@packagedata.net' . "\r\n" .
			            'X-Mailer: PHP/' . phpversion();
			    
			        mail($admin_email, 'New delete request', 'A delete request has been made by an anonymous user.', $headers);
			    }
			
				$this->session->set_flashdata('success_message', 'Your request to delete a link is now pending review. You can see the status of the request by using the history button.');
				redirect('links/');
			}
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function delete_package($parent_id)
	{
		return $this->db->where('parent_id', $parent_id)->where('status', 'published')->update('packages', array(
			'status' => 'trash'
		));		
	}

}