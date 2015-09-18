<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function login()
	{		
		if( empty($_GET['code']) )
		{
			exit('Missing the code parameter');
		}
	
		$se_code = $_GET['code'];

		$redirect_uri = $this->config->item('se_redirect_uri');
		if( isset($_GET['c']) && isset($_GET['m']) )
		{
			$redirect_uri = $this->config->item('se_redirect_uri') . '?c=' . $_GET['c'] .'&m=' . $_GET['m'];
		}
	
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(
			'client_id' => $this->config->item('se_client_id'),
			'client_secret' => $this->config->item('se_client_secret'),
			'code' => $se_code,
			'redirect_uri' => $redirect_uri
		));
		curl_setopt($ch, CURLOPT_URL, 'https://stackexchange.com/oauth/access_token');
		
		$res = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close($ch);
		
		if( $http_code == 400 )
		{
			$res = json_decode($res);
			$this->session->set_flashdata('error_message', $res->error->message);
		}
		else
		{
			parse_str($res);

			$url = 'https://api.stackexchange.com/2.2/me?site=mathematica&access_token=' . $access_token . '&key=' . $this->config->item('se_key');
			
			//Because the API sends back compressed data
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_ENCODING , 'gzip');
			$me = curl_exec ($ch);
			
			$me = json_decode($me, TRUE);
			$me = $me['items'][0];
			
			if( isset($me['reputation']) && $me['reputation'] > 2000 )
			{
				$_SESSION['logged_in'] = TRUE;
				$_SESSION['user_id'] = $me['user_id'];
				$_SESSION['display_name'] = $me['display_name'];
				$this->session->set_flashdata('success_message', 'You have been successfully authenticated.');
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Only <i>Mathematica.StackExchange</i> users with more than 2000 reputation points can be logged in. You can still add packages, it only means that someone else will have to approve them before they show up on the site.');
			}
		}
		
		if( isset($_GET['c']) && isset($_GET['m']) )
	    {
	    	redirect($_GET['c'] . '/' . $_GET['m']);
	    }
	    else
	    {
	    	redirect('links');
	    }
		
	}
	
	public function logout()
	{
		unset($_SESSION['logged_in']);
		redirect('links');
	}
	
}