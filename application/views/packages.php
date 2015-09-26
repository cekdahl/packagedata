		<div class="row">
			<?php print_success_message(); ?>
			<?php print_error_message(); ?>	
			<div class="col-md-10 left-col">
				<a href="<?php packages_list_link('alphabetically', $selected_keyword, $has_examples); ?>" class="btn btn-default">
					<?php if($sort == 'alphabetically') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?> Alphabetically
				</a>
				<a href="<?php packages_list_link('newest', $selected_keyword, $has_examples); ?>" class="btn btn-default">
					<?php if($sort == 'newest') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?> Newest
				</a>
				<a href="<?php packages_list_link('popular', $selected_keyword, $has_examples); ?>" class="btn btn-default">
					<?php if($sort == 'popular') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?> Most popular
				</a>
				<a href="<?php packages_list_link($sort, $selected_keyword, $has_examples == 'false' ? 'true' : 'false'); ?>" class="btn btn-default">
					<?php if($has_examples == 'true') echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?>
					Only with examples
				</a>
				<?php if(isset($selected_keyword)): ?>
				<a href="<?php packages_list_link($sort, NULL, $has_examples); ?>" class="btn btn-default">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					Remove keyword (<?php echo $selected_keyword; ?>)
				</a>
				<? endif; ?>
			</div>
			<div class="col-md-2">
				<a href="<?php echo site_url('links/add'); ?>" class="btn btn-default">Add package</a>
			</div>
		</div>

		<?php if($keyword_description): ?>
		<hr>
		<h3 style="margin: 0 auto; width: 60%; color: gray;"><?php echo $keyword_description; ?></h3>
		<?php endif; ?>

		<?php foreach($packages as $package): ?>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<h2 id="package-<?php echo $package['parent_id']; ?>"><a href="<?php echo $package['url']; ?>" class="outlink" data-id="<?php echo $package['parent_id']; ?>"><?php echo $package['name']; ?></a></h2>
				<p><?php echo $package['description']; ?></p>
				<?php if($package['has_examples']): ?>
				<p><a href="<?php echo site_url('links/examples/id/' . $package['parent_id']); ?>" class="btn btn-default">Usage examples</a></p>
				<?php endif; ?>
				<div class="row">
					<div class="col-md-8 left-col-div">
					<span class="label label-primary">Last updated <?php echo date('F j, Y', strtotime($package['timestamp'])); ?></span>
					<?php foreach($package['keywords'] as $keyword): ?>
						<span class="label label-default"><a href="<?php packages_list_link($sort, $keyword, $has_examples); ?>"><?php echo $keyword; ?></a></span>
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