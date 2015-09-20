		<div class="row">
			<div class="col-md-12">
			<?php print_success_message(); ?>
			<?php print_error_message(); ?>
			<?php echo validation_errors(); ?>
			<?php if( !is_logged_in() ): ?>
			<div class="alert alert-info"><b>You are not authenticated!</b> Users who are authenticated as members of <i>Mathematica.StackExchange</i> with more than <b>2000 reputation points</b> can post packages that show up immediately without having to go through the review system that most submissions have to go through. <a href="<?php echo $oauth_link; ?>">Click here to be authenticated.</a></div>
			<?php endif; ?>
			<form action="<?php echo site_url('links/add'); ?>" method="POST">
				<?php if( $package ): ?>
					<input type="hidden" name="parent_id" value="<?php echo $package['parent_id']; ?>" />
				<?php endif; ?>
			    <div class="form-group">
			    	<label for="name">Package name</label>
			    	<input type="text" name="name" class="form-control" id="name" value="<?php echo set_value('name', $package['name']); ?>" placeholder="Name">
			    </div>
			    <div class="form-group">
			    	<label for="url">URL</label>
			    	<input type="text" name="url" class="form-control" id="url" value="<?php echo set_value('url', $package['url']); ?>" placeholder="URL">
			    </div>
			    <div class="form-group">
			    	<label for="keywords">Keywords</label> (<i>no more than five</i>)
			    	<input type="text" name="keywords" class="form-control" id="keywords" value="<?php echo set_value('keywords', $package['keywords']); ?>" placeholder="keyword1, keyword2, keyword3...">
			    </div>
			    <div class="form-group">
			    	<label for="description">Description</label>
			    	<textarea class="form-control" name="description" id="description" rows="5" placeholder="Description"><?php echo set_value('description', $package['description']); ?></textarea>
			    </div>
			    
			    <div class="form-group">
			    	<label for="description">Usage examples</label>
			    	<p>Only use this text field for examples — otherwise leave it empty. A sentence or two is not enough to warrant the use of this field, the content of which will be displayed on its own page separate from the package list.</p>
			    	<p>The use of images is encouraged. Use an image host that is reliable, such as <a href="http://imgur.com/">imgur.com</a>. Images can be uploaded directly from <i>Mathematica</i> to imgur with the <a href="https://github.com/halirutan/Mathematica-SE-Tools"><i>Mathematica Tools</i> for Stack Exchange</a> package.</p>
			    	<p>Markdown, MathJax ($\LaTeX$) equations and HTML may be used to style the post.</p>
			    	<textarea class="form-control" name="examples" id="examples" rows="5" placeholder=""><?php echo set_value('examples', $package['examples']); ?></textarea>
			    	<div id="preview"></div>
			    </div>
			    
			    <?php if( !is_logged_in() ): ?>
					<p><div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('captcha_key'); ?>"></div></p>
				<?php endif; ?>
			    
			    <div class="form-group">
			    	<input type="submit" class="btn btn-default" value="Submit">
			    </div>
			<form>
		</div>

		</div>