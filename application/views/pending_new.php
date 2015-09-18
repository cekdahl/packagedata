		<div class="row">
			<div class="col-md-12">
				<a href="<?php echo site_url('review/pending_new'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> New <span class="badge"><?php echo $counts['new']; ?></span></a>
				<a href="<?php echo site_url('review/pending_updates'); ?>" class="btn btn-default">Updates <span class="badge"><?php echo $counts['updates']; ?></span></a>
				<a href="<?php echo site_url('review/pending_delete_requests'); ?>" class="btn btn-default">Delete requests <span class="badge"><?php echo $counts['delete_requests']; ?></span></a>
				<a href="<?php echo site_url('review/trash'); ?>" class="btn btn-default">Deleted links</a>
			</div>
		</div>
		<hr />
		<?php print_success_message(); ?>
		<?php print_error_message(); ?>
		<?php if( count($packages) == 0 ): ?>
		<h2>There are no pending new links.</h2>
		<?php endif; ?>
		<?php foreach($packages as $package): ?>
		<div class="row">
			<div class="col-md-12">
				<h2><a href="<?php echo $package['url']; ?>"><?php echo $package['name']; ?></a></h2>
				<p><?php echo $package['description']; ?></p>
				<p>
					<span class="label label-primary">Last updated <?php echo date('F j, Y', strtotime($package['timestamp'])); ?></span>
					<?php foreach($package['keywords'] as $keyword): ?>
						<span class="label label-default"><?php echo $keyword; ?></span>
					<?php endforeach; ?>
					<a href="<?php echo site_url('review/delete/' . $package['id']); ?>" class="btn btn-danger btn-xs pull-right" style="margin-left:5px;">Move to trash</a>
					<a href="<?php echo site_url('review/publish/' . $package['id']); ?>" class="btn btn-primary btn-xs pull-right" style="margin-left:5px;">Publish</a>
				</p>
			</div>
		</div>
		<hr />
		<?php endforeach; ?>