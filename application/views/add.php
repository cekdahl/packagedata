		<div class="row">
			<div class="col-md-12">
			<?php print_success_message(); ?>
			<?php print_error_message(); ?>
			<?php echo validation_errors(); ?>
			<?php if( !is_logged_in() ): ?>
			<div class="alert alert-info">Submissions go through a review, so it can take a couple of hours before the submission appears on the site.</div>
			<?php endif; ?>
			<form action="<?php echo site_url('links/add'); ?>" method="POST">
				<?php if( $package ): ?>
					<input type="hidden" name="parent_id" value="<?php echo $package['parent_id']; ?>" autocomplete="off" />
				<?php endif; ?>
			    <div class="form-group">
			    	<label for="name">Package name</label>
			    	<input type="text" name="name" class="form-control" id="package-name" value="<?php echo set_value('name', $package['name']); ?>" placeholder="Name">
			    	<div id="duplicates"></div>
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
			    	<p>Only use this text field for examples — otherwise leave it empty. A sentence or two is not enough to warrant the use of this field, the content of which will be displayed on its own page separate from the package list. Markdown, MathJax ($\LaTeX$) equations and HTML may be used to style the post.</p>
			    	<p id="editorToolbar"><div class="btn-toolbar">
			    		<div class="btn-group">
			    			<button type="button" class="btn btn-default" title="Code" id="btncode"><span class="glyphicon glyphicon-console"></span></button>
			    			<button type="button" class="btn btn-default" title="Quote" id="btnquote"><span class="glyphicon glyphicon-comment"></span></button>
			    			<button type="button" class="btn btn-default" title="Bold" id="btnbold"><span class="glyphicon glyphicon-bold"></span></button>
			    			<button type="button" class="btn btn-default" title="Italic" id="btnitalic"><span class="glyphicon glyphicon-italic"></span></button>
			    			<button type="button" class="btn btn-default" title="Link" id="btnlink"><span class="glyphicon glyphicon-link"></span></button>
			    			<button type="button" class="btn btn-default" title="Upload image" id="btnlink" data-toggle="modal" data-target="#uploadImageModal"><span class="glyphicon glyphicon-picture"></span></button>
			    		</div>
			    	</div></p>
			    	
			    	<textarea class="form-control" name="examples" id="examples" rows="5" placeholder=""><?php echo set_value('examples', $package['examples']); ?></textarea>
			    	<div id="preview"></div>
			    </div>
			    
			    <?php if( !is_logged_in() ): ?>
					<p><div id="recaptcha1" class="g-recaptcha" data-sitekey="<?php echo $this->config->item('captcha_key'); ?>"></div></p>
				<?php endif; ?>
			    
			    <div class="form-group">
			    	<input type="submit" class="btn btn-default" value="Submit">
			    </div>
			<form>
			
			<form action="javascript:alert(grecaptcha.getResponse(recaptcha2));">
				<div class="modal fade" id="uploadImageModal" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
								<h4 class="modal-title">Upload image</h4>
							</div>
							<div class="modal-body"><div id="selectFileArea">
								<p><input type="file" id="selectImageFile"></p>
								<div id="dropZone" class="panel panel-default">
									<div class="panel-body">
									  <h3>Or drop file here</h3>
									</div>
								</div></div>
								<p><div id="recaptcha2" class="g-recaptcha" data-sitekey="<?php echo $this->config->item('captcha_key'); ?>"></div></p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" id="submitImageUpload" class="btn btn-primary" disabled="true">Upload image</button>
							</div>
						</div>
					<div>
				</div>
			</form>
		</div>

		</div>