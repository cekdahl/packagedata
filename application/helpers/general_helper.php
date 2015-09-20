<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('oauth_link'))
{
	function oauth_link($m = NULL, $c = NULL)
	{
		$CI =& get_instance();
	
		$url = 'https://stackexchange.com/oauth?client_id=' . $CI->config->item('se_client_id') . '&scope=&redirect_uri=';
		$redirect_url = $CI->config->item('se_redirect_uri');
		
		if( $c !== NULL )
		{
			$redirect_url = $redirect_url . '&c=' . $c;
		}
		
		if( $m !== NULL )
		{
			$redirect_url = $redirect_url . '&m=' . $m;
		}
		
		$url = $url . urlencode($redirect_url);
				
		return $url;
	}   
}

if( ! function_exists('is_logged_in'))
{
	function is_logged_in()
	{
		return isset($_SESSION['logged_in']);
	}
}

if( ! function_exists('set_error_message'))
{
	function set_error_message($message)
	{
		$CI =& get_instance();
		$CI->session->set_flashdata('error_message', $message);
	}
}

if( ! function_exists('set_success_message'))
{
	function set_success_message($message, $redirect = FALSE)
	{
		$CI =& get_instance();
		$CI->session->set_flashdata('success_message', $message);
		
		if($redirect)
		{
			redirect($redirect);
		}
	}
}

if( ! function_exists('print_error_message'))
{
	function print_error_message()
	{
		if( isset($_SESSION['error_message']) ): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger">
							<?php echo $_SESSION['error_message']; ?>
						</div>
					</div>
				</div>
		<?php
		endif;
		
		unset($_SESSION['error_message']);
	}
}

if( ! function_exists('print_success_message'))
{
	function print_success_message()
	{
		if( isset($_SESSION['success_message']) ): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-success">
							<?php echo $_SESSION['success_message']; ?>
						</div>
					</div>
				</div>
		<?php
		endif;
		
		unset($_SESSION['error_message']);
	}
}

if( ! function_exists('print_messages'))
{
	function print_messages()
	{
		print_success_message();
		print_error_message();
	}
}

if( ! function_exists('load_template'))
{
	function load_template($view, $data)
	{
		$CI =& get_instance();
	
		$CI->load->view('header', $data);
		$CI->load->view($view, $data);
		$CI->load->view('footer', $data);
	}
}

if( ! function_exists('review_count'))
{
	function review_count()
	{
		$CI =& get_instance();
	
		$CI->load->model('review_model');
		echo $CI->review_model->count_all_pending();
	}
}

if( ! function_exists('get_review_count'))
{
	function get_review_count()
	{
		$CI =& get_instance();
	
		$CI->load->model('review_model');
		return $CI->review_model->count_all_pending();
	}
}

if( ! function_exists('packages_list_link'))
{
	function packages_list_link($sort, $keyword, $has_examples)
	{
		$args = array();
		if(isset($sort))
		{
			$args['sort'] = $sort;
		}
		if(isset($keyword))
		{
			$args['keyword'] = $keyword;
		}
		if(isset($has_examples))
		{
			$args['has_examples'] = $has_examples;
		}
		
		$link = '';
		foreach($args as $key => $value)
		{
			$link .= $key . '/' . $value . '/';
		}
		
		echo site_url('links/index/' . $link);
	}
}