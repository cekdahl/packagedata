<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="A large community edited collection of Mathematica packages. It is the perfect place to share and find Mathematica packages.">
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
		.label a {
			color: white;
		}
		#preview {
			background: #fafafa;
			margin-top: 15px;
			padding: 10px;
		}
		#duplicates {
			background: #fafafa;
			margin-top: 15px;
			padding: 10px;
			display: none;
		}
		#duplicates ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}
		#logo {
			background: url(<?php echo base_url(); ?>assets/Box_content.png);
			background-repeat: no-repeat;
			height: 64px;
			padding-top: 10px;
			padding-left: 80px;
			margin-top: 20px;
			margin-bottom: 0px;
		}
		
		#logo a h1 {
			font-size: 24px;
			margin-top: 0px;
			margin-bottom: 5px;
		}
		#logo h2 {
			font-size: 18px;
			margin-top: 0px;
			margin-bottom: 0px;
		}
		.tutorial h1, .tutorial h2, .tutorial h3 {
			border-bottom: 1px solid #eee;
			padding-bottom: 10px;
		}
		.tutorial ol {
			list-style-type: upper-roman;
		}
		.tutorial ol ol {
			list-style-type: lower-latin;
		}
	</style>
   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<link href="<?php echo base_url(); ?>assets/prettify/prettify.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/prettify/prettify-mma.css" type="text/css" rel="stylesheet">
	<script src='<?php echo base_url(); ?>assets/prettify/prettify.js'></script>
	<script src='<?php echo base_url(); ?>assets/prettify/lang-mma.js'></script>
		
	<script type="text/x-mathjax-config">
	MathJax.Hub.Config({
	  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
	});
	</script>
	<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
  </head>

  <body id="body">       
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-67305272-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
	
    <div class="container">

		<div class="row">
			<div class="col-md-8">
				<div id="logo">
					<a href="<?php echo site_url(); ?>" title="Packages for Mathematica">
						<h1>PackageData[]</h1>
					</a>
					<h2>Packages for Mathematica</h2>
				</div>
			</div>
			<?php if( is_logged_in() ): ?>
			<div class="col-md-4">
				<div class="list-group" style="margin-top: 20px;">
				  <a href="<?php echo site_url('review/pending_new'); ?>" class="list-group-item">Review queue <span class="badge <?php if(get_review_count() > 0) { echo 'progress-bar-warning'; }?>"><?php review_count(); ?></span></a>
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
		<?php if(isset($frontpage) && FALSE): ?>
		<div class="jumbotron">
		  <p>PackageData is a community moderated directory of Mathematica packages from all over the Internet.</p>
		  <p>
		  	<a class="btn btn-primary btn-lg left-col" href="<?php echo site_url('links/tutorial'); ?>" role="button">Learn how to make a package</a>
		  </p>
		</div>
		<?php endif; ?>
		
		<hr />