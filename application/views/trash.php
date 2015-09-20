		<div class="row">
			<div class="col-md-12">
				<a href="<?php echo site_url('review/pending_new'); ?>" class="btn btn-default">New <span class="badge"><?php echo $counts['new']; ?></span></a>
				<a href="<?php echo site_url('review/pending_updates'); ?>" class="btn btn-default">Updates <span class="badge"><?php echo $counts['updates']; ?></span></a>
				<a href="<?php echo site_url('review/pending_delete_requests'); ?>" class="btn btn-default">Delete requests <span class="badge"><?php echo $counts['delete_requests']; ?></span></a>
				<a href="<?php echo site_url('review/trash'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Deleted links</a>
			</div>
		</div>
		<hr />
		<?php print_success_message(); ?>
		<?php print_error_message(); ?>
		<?php if( count($packages) == 0 ): ?>
		<h2>There are no deleted links.</h2>
		<?php endif; ?>
		<?php foreach($packages as $package): ?>
		<div class="row">
			<div class="col-md-12">
				<h2><a href="<?php echo $package['url']; ?>"><?php echo $package['name']; ?></a></h2>
				<p><?php echo $package['description']; ?></p>
				<?php if($package['has_examples']): ?>
				<p><a href="<?php echo site_url('review/examples/id/' . $package['id']); ?>" class="btn btn-default">Usage examples</a></p>
				<?php endif; ?>
				<p>
					<span class="label label-primary">Last updated <?php echo date('F j, Y', strtotime($package['timestamp'])); ?></span>
					<?php foreach($package['keywords'] as $keyword): ?>
						<span class="label label-default"><?php echo $keyword; ?></span>
					<?php endforeach; ?>
					<a href="<?php echo site_url('review/republish/' . $package['id']); ?>" class="btn btn-primary btn-xs pull-right" style="margin-left:5px;">Republish</a>
				</p>
			</div>
		</div>
		<hr />
		<?php endforeach; ?>