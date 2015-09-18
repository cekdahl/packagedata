		<div class="row">
			<div class="col-md-12">
				<a href="<?php echo site_url('review/pending_new'); ?>" class="btn btn-default">New <span class="badge"><?php echo $counts['new']; ?></span></a>
				<a href="<?php echo site_url('review/pending_updates'); ?>" class="btn btn-default">Updates <span class="badge"><?php echo $counts['updates']; ?></span></a>
				<a href="<?php echo site_url('review/pending_delete_requests'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Delete requests <span class="badge"><?php echo $counts['delete_requests']; ?></span></a>
				<a href="<?php echo site_url('review/trash'); ?>" class="btn btn-default">Deleted links</a>	
			</div>
		</div>
		<hr />
		<?php print_success_message(); ?>
		<?php print_error_message(); ?>
		<?php if( count($requests) == 0 ): ?>
		<h2>There are no pending delete requests.</h2>
		<?php endif; ?>
		<?php foreach($requests as $request): ?>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<h2><a href="<?php echo $request['url']; ?>"><?php echo $request['name']; ?></a></h2>
				<p><?php echo $request['description']; ?></p>
				<div class="panel panel-primary">
					<div class="panel-heading">Reason for delete request:</div>
					<div class="panel-body"><?php echo $request['comment']; ?></div>
				</div>
				<p>
					<span class="label label-primary">Last updated <?php echo date('F j, Y', strtotime($request['timestamp'])); ?></span>
					<?php foreach($request['keywords'] as $keyword): ?>
						<span class="label label-default"><?php echo $keyword; ?></span>
					<?php endforeach; ?>
					<a href="<?php echo site_url('review/approve/' . $request['request_id']); ?>" class="btn btn-danger btn-xs pull-right" style="margin-left:5px;">Delete package</a>
					<a href="<?php echo site_url('review/reject/' . $request['request_id']); ?>" class="btn btn-primary btn-xs pull-right" style="margin-left:5px;">Reject request</a>
				</p>
			</div>
		</div>
		<hr />
		<?php endforeach; ?>