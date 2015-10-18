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
		.logo {
			display: block;
			text-align: center;
			font-family: Helvetica-neue;
			font-style: italic;
			color: black;
		}
		a.logo:hover {
			text-decoration: none;
			color: black;
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
			<div class="col-md-12">
				<a href="<?php echo site_url(); ?>" title="Packages for Mathematica" class="logo">
				    <h1>Mathematica Package Repository</h1>
				</a>
			</div>
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