		<div class="row">
			<div class="col-md-12">
			<?php echo validation_errors(); ?>
			<?php if( !is_logged_in() ): ?>
			<div class="alert alert-info">Delete requests will go through a review process to be accepted or rejected.</div>
			<?php endif; ?>
			<form action="<?php echo site_url('links/delete/id/' . $parent_id); ?>" method="POST">
				<input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />

			    <div class="form-group">
			    	<label for="explanation">Explain why the link needs to be deleted</label>
			    	<textarea class="form-control" name="explanation" id="explanation" rows="5" placeholder="Explanation"><?php echo set_value('explanation', ''); ?></textarea>
			    </div>
			    
			    <?php if( !is_logged_in() ): ?>
					<p><div id="recaptcha1" class="g-recaptcha" data-sitekey="<?php echo $this->config->item('captcha_key'); ?>"></div></p>
				<?php endif; ?>
			    
			    <div class="form-group">
			    	<input type="submit" class="btn btn-default" value="Submit">
			    </div>
			<form>
		</div>

		</div>