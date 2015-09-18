<?php
class Captcha_model extends CI_Model {
	
	public function validate()
	{
		$response = $this->input->post('g-recaptcha-response');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		if( $response === NULL )
		{
			return FALSE;
		}
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(
			'secret' => $this->config->item('captcha_secret'),
			'response' => $response,
			'code' => $ip,
		));
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
		
		$res = curl_exec($ch);
		curl_close($ch);
		
		if( $res === NULL )
		{
			return FALSE;
		}
				
		return json_decode($res)->success;
	}
	
}