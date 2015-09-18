		<div class="row">
			<?php print_success_message(); ?>
			<?php print_error_message(); ?>	
			<div class="col-md-10 left-col">
				<a href="<?php echo site_url('links/index/sort/alphabetically'); ?>" class="btn btn-default"><?php if($sort == 'alphabetically') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?> Alphabetically</a>
				<a href="<?php echo site_url('links/index/sort/newest'); ?>" class="btn btn-default"><?php if($sort == 'newest') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?> Newest</a>
				<a href="<?php echo site_url('links/index/sort/popular'); ?>" class="btn btn-default"><?php if($sort == 'popularity') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?> Most popular</a>
			</div>	
			<div class="col-md-2">
				<a href="<?php echo site_url('links/add'); ?>" class="btn btn-default">Add package</a>
			</div>
		</div>

		<?php foreach($packages as $package): ?>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<h2><a href="<?php echo site_url('links/redirect_to/' . $package['id'] . '/' . $package['parent_id']); ?>"><?php echo $package['name']; ?></a></h2>
				<p><?php echo $package['description']; ?></p>
				<div class="row">
					<div class="col-md-8 left-col-div">
					<span class="label label-primary">Last updated <?php echo date('F j, Y', strtotime($package['timestamp'])); ?></span>
					<?php foreach($package['keywords'] as $keyword): ?>
						<span class="label label-default"><?php echo $keyword; ?></span>
					<?php endforeach; ?>
					</div>
					<div class="col-md-4">
					<a href="<?php echo site_url('links/history/id/' . $package['parent_id']); ?>" class="btn btn-default btn-xs pull-right" style="margin-left:5px;">History</a>
					<a href="<?php echo site_url('links/delete/id/' . $package['parent_id']); ?>" class="btn btn-default btn-xs pull-right" style="margin-left:5px;">Delete</a>
					<a href="<?php echo site_url('links/add/id/' . $package['parent_id']); ?>" class="btn btn-default btn-xs pull-right">Edit</a>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>