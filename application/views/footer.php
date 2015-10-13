      <hr>

      <footer>
      	<div class="row">
      		<div class="col-md-6">
      			<h4>About</h4>
	  			<p>If you have question about this project, you can talk to <i>Mathematica.SE</i> users in the <i>Mathematica.SE</i> <a href="http://chat.stackexchange.com/rooms/2234/wolfram-mathematica">chat room</a> or contact the administrator at <a href="mailto:admin@packagedata.net">admin@packagedata.net</a>. The PHP source code of this site is available at <a href="https://github.com/cekdahl/packagedata">Github</a>.
	  			</p>
      		</div>
      		<div class="col-md-6">
      			<h4>Installing Mathematica packages</h4>
      			<p>Best practice is to put packages (.m/.wl files and dependencies) in the directory <code>FileNameJoin[{$UserBaseDirectory, "Applications"}]</code>. <i>Mathematica</i> has a built-in tool for placing .m files, .wl files or files in a .zip archive in that directory called "Install" under the menu "File". The main benefit of using said directory for packages is that when a new <i>Mathematica</i> version is installed, packages will automatically be available.</p>
      		</div>
      	</div>
	  	<hr />
      	<div class="row">
      		<div class="col-md-6">
      			<h4>API & RSS</h4>
      			<p>There are two API functions:
	      			<ul>
	      				<li><a href="<?php echo site_url('api/packages'); ?>"><?php echo site_url('api/packages'); ?></a> returns data about all the packages on the site.</li>
	      				<li><?php echo site_url('api/history/id'); ?> returns history information about a package, where id can be found out from the previous API function.</li>
	      			</ul>
      			</p>
      			<p>There are also two RSS feeds:
      				<ul>
      					<li><a href="<?php echo site_url('feed'); ?>"><?php echo site_url('feed'); ?></a> informs about all new packages.</li>
      					<li><a href="<?php echo site_url('feed'); ?>"><?php echo site_url('feed/weekly'); ?></a> updates once a week with a summary over what packages have been updated or have been added during the last week.</li>
      				</ul>
      			</p>
      		</div>
      		<div class="col-md-6">
      			<h4>Get involved</h4>
      			<p>This site was built from the ground up to make it as easy as possible for anonymous users to pitch in. You are strongly encouraged to submit links to any packages that you know of that's not in this list, or to submit updates to existing links. This can be a small improvement, or usage examples for a package that doesn't have any yet.</p>
      		</div>
      	</div>
      </footer>
      	<hr />
    </div> <!-- /container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery-fieldselection.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url(); ?>assets/ie10-viewport-bug-workaround.js"></script>
 	<script src='<?php echo base_url(); ?>assets/marked.js'></script>
 	
	<script type="text/javascript">
		$(document).ready(function() {
			prettyPrint();
			
			if($('#examples').length) {
				$('#preview').html(marked($('#examples').val()));
			
				$('#examples').on('input propertychange', function() {
				    $('#preview').html(marked($('#examples').val()));
				    MathJax.Hub.Typeset();
				});
			}
			
			$('#btncode').click(function() {
			    var textarea = $('#examples');
			    var selection = textarea.getSelection().text;
			    var result = '';
			    var lines = selection.split('\n');
			    var space = '     ';
			    for(var i = 0; i < lines.length; i++)
			    {
			        result += space + lines[i] + '\n';
			    }
			    var new_text = textarea.val().split(selection).join(result);
			    textarea.val(new_text);
			    $('#preview').html(marked($('#examples').val()));
			});
			
			$('#btnquote').click(function() {
			    var textarea = $('#examples');
			    var selection = textarea.getSelection().text;
			    var result = '';
			    var lines = selection.split('\n');
			    var space = ' > ';
			    for(var i = 0; i < lines.length; i++)
			    {
			        result += space + lines[i] + '\n';
			    }
			    var new_text = textarea.val().split(selection).join(result);
			    textarea.val(new_text);
			    $('#preview').html(marked($('#examples').val()));
			});
			
			$('#btnbold').click(function() {
			    var textarea = $('#examples');
			    var selection = textarea.getSelection().text;
			    var result = '**' + selection + '**';
			    var new_text = textarea.val().split(selection).join(result);
			    textarea.val(new_text);
			    $('#preview').html(marked($('#examples').val()));
			});
			
			$('#btnitalic').click(function() {
			    var textarea = $('#examples');
			    var selection = textarea.getSelection().text;
			    var result = '*' + selection + '*';
			    var new_text = textarea.val().split(selection).join(result);
			    textarea.val(new_text);
			    $('#preview').html(marked($('#examples').val()));
			});
			
			$('#btnlink').click(function() {
			    var textarea = $('#examples');
			    var selection = textarea.getSelection().text;
			    var result = '[' + selection + '](http://)';
			    var new_text = textarea.val().split(selection).join(result);
			    textarea.val(new_text);
			    $('#preview').html(marked($('#examples').val()));
			});
			
			$('.outlink').click(function(e) {
				var id = $(this).attr('data-id');
				$.get('<?php echo site_url('links/register_redirect'); ?>/'+id);
			});
			
			$('#package-name').on('input propertychange', function() {
			    var package_name = $('#package-name').val();
			    
			    if(package_name.length > 4) {
				    $.getJSON('<?php echo site_url('api/possible_duplicates'); ?>/'+package_name, function(data) {
				    	var items = [];
				    	$.each( data, function( key, package_data ) {
				    	  items.push( "<li><a href='<?php echo site_url('links/index/#package-'); ?>"+package_data.parent_id+"'>" + package_data.name + "</a></li>" );
				    	});
				    	
				    	if(data.length > 0) {
				    		$('#duplicates').show().html('<p><b>Possible duplicates:</b></p><ul>'+items.join( "" )+'</ul>');
				    	}
				    	else {
					    	$('#duplicates').hide();
				    	}
				    });
				}
				else {
					$('#duplicates').hide();
				}
			});
		});
	</script>
  </body>
</html>