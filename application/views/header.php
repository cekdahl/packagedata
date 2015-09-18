<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/favicon.png">

    <title>PackageData[]: Packages for Mathematica</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
   
	<style>
		@media (max-width: 992px) { 
			.left-col a, .left-col-div {
				margin-bottom: 20px;
			}
		}
	</style>
   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<script type="text/x-mathjax-config">
	MathJax.Hub.Config({
	  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
	});
	</script>
	<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  </head>

  <body id="body">       

    <div class="container">

		<div class="row">
			<div class="col-md-8">
				<a href="<?php echo site_url(); ?>" title="Packages for Mathematica"><img src="<?php echo base_url(); ?>assets/logo.png" style="margin-top: 25px;" alt="Packages for Mathematica"></a>
			</div>
			<?php if( is_logged_in() ): ?>
			<div class="col-md-4">
				<div class="list-group" style="margin-top: 20px;">
				  <a href="<?php echo site_url('review/pending_new'); ?>" class="list-group-item">Review queue <span class="badge"><?php review_count(); ?></span></a>
				  <a href="<?php echo site_url('account/logout'); ?>" class="list-group-item">Log out</a>
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-4">
				<p style="margin-top: 20px;"><i><a href="http://mathematica.stackexchange.com/" title="Mathematica.StackExchange">Mathematica.StackExchange</a></i> users with more than 2000 reputation points can authenticate themselves for additional functionality.</p>
				<div class="list-group">
				  <a href="<?php echo $oauth_link; ?>" class="list-group-item">Log in</a>
				</div>
			</div>
			<?php endif; ?>
		</div>
		
		<hr />