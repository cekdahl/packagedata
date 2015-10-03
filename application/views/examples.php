		<div class="row">
			<div class="col-md-6 left-col">
				<h2><?php echo $package['name']; ?></h2>
			</div>
			<div class="col-md-4">
				<?php if($package['latest_release']): ?>
				<a href="<?php echo $package['latest_release']; ?>" class="btn btn-default" style="margin-top: 15px;">Download package</a>		
				<?php endif; ?>
				<a href="<?php echo $package['url']; ?>" class="btn btn-default" style="margin-top: 15px;">Visit package website</a>
			</div>
			<div class="col-md-2">
				<a href="<?php echo site_url('links/add/id/' . $package['parent_id']); ?>" class="btn btn-default" style="margin-top: 15px;">Edit</a>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<?php echo $package['description_rendered']; ?>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<?php echo $package['examples_rendered']; ?>
			</div>
		</div>