		<div class="row">
			<div class="col-md-12">
				<h2>History</h2>
			</div>
		</div>
		
		<?php foreach($package_history as $package): ?>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<?php if( $package['type'] == 'link' ): ?>
				<h2><a href="<?php echo $package['url']; ?>"><?php echo $package['name']; ?></a></h2>
				<p><?php echo $package['description']; ?></p>
				<p>
					<span class="label label-primary">Submitted <?php echo date('F j, Y', strtotime($package['timestamp'])); ?></span>
					<?php foreach($package['keywords'] as $keyword): ?>
						<span class="label label-default"><?php echo $keyword; ?></span>
					<?php endforeach; ?>
					
					<span class="label label-<?php echo $package['status_color']; ?> pull-right"><?php echo $package['status']; ?></span>
				</p>
				<?php elseif( $package['type'] == 'request' ): ?>
				<h2>Delete request</h2>
				<p><?php echo $package['description']; ?></p>
				<p>
					<span class="label label-primary">Submitted <?php echo date('F j, Y', strtotime($package['timestamp'])); ?></span>
					<span class="label label-<?php echo $package['status_color']; ?> pull-right"><?php echo $package['status']; ?></span>
				</p>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>