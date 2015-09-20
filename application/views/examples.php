		<div class="row">
			<div class="col-md-10 left-col">
				<h2><a href="<?php echo $package['url']; ?>"><?php echo $package['name']; ?></a></h2>
			</div>
			<div class="col-md-2">
				<a href="<?php echo site_url('links/add/id/' . $package['parent_id']); ?>" class="btn btn-default" style="margin-top: 15px;">Edit</a>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<?php echo $package['description']; ?>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<?php echo $package['examples_rendered']; ?>
			</div>
		</div>