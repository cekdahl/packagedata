<?php
class Github_model extends CI_Model {
		
	public function latest_release($url)
	{
		if(strpos($url, 'github') === FALSE)
		{
			return FALSE;
		}

		$trimmed = trim($url, ' /');
		$exploded = explode('/', $url);
		$reversed = array_reverse($exploded);
		
		if(count($reversed) < 2)
		{
			return FALSE;	
		}
		
		$repository_name = $reversed[0];
		$user_name = $reversed[1];
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_USERAGENT, 'cekdahl');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$user_name/$repository_name/releases/latest");
		
		$res = curl_exec($ch);
		curl_close($ch);

		$res = json_decode($res, TRUE);
		
		if(!isset($res['zipball_url']))
		{
			return FALSE;
		}
		
		return $res['zipball_url'];
	}
	
	public function update_release_data($package_id)
	{
		$url = $this->db->select('url')->from('packages')->where('id', $package_id)->get()->row()->url;
		$latest_release = $this->latest_release($url);

		if($latest_release === FALSE)
		{
			$this->db->where('id', $package_id)->update('packages', array(
				'latest_release' => NULL
			));
		
			return FALSE;
		}

		$this->db->where('id', $package_id)->update('packages', array(
			'latest_release' => $latest_release
		));
		
		return TRUE;
	}
	
	public function update_all_release_data()
	{
		$this->load->model('packages_model');
		$packages = $this->packages_model->list_packages();
		
		foreach($packages as $package)
		{
			$this->update_release_data($package['id']);
		}
	}
}
?>