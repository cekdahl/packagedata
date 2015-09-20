      <hr>

      <footer>
      	<div class="row">
      		<div class="col-md-6">
      			<h4>About</h4>
	  			<p>If you have question about this project, you can talk to <i>Mathematica.SE</i> users in the <i>Mathematica.SE</i> <a href="http://chat.stackexchange.com/rooms/2234/wolfram-mathematica">chat room</a>. You can also contact the administrator of this site at <a href="mailto:admin@packagedata.net">admin@packagedata.net</a>. The source code of this site is available at <a href="https://github.com/cekdahl/packagedata">Github</a>.
	  			</p>
      		</div>
      		<div class="col-md-6">
      			<h4>Installing Mathematica packages</h4>
      			<p>Best practice is to put packages (.m files and dependencies) in the directory <code>FileNameJoin[{$UserBaseDirectory, "Applications"}]</code>. <i>Mathematica</i> has a built-in tool for placing .m files or .zip files in that directory called "Install" under the menu "File". The main benefit of using said directory for packages is that when a new <i>Mathematica</i> version is installed, packages will automatically be available.</p>
      		</div>
      	</div>
      </footer>
      <hr />
    </div> <!-- /container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url(); ?>assets/ie10-viewport-bug-workaround.js"></script>
 	<script src='<?php echo base_url(); ?>assets/marked.js'></script>
 	
	<script type="text/javascript">
		$(document).ready(function() {
			prettyPrint();
			
			$('#preview').html(marked($('#examples').val()));
			
			$('#examples').on('input propertychange', function() {
			    $('#preview').html(marked($('#examples').val()));
			});
		});
	</script>
  </body>
</html>
