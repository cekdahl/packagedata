      <hr>

      <footer>
      	<div class="row">
      		<div class="col-md-6">
      			<h4>About</h4>
	  			<p>If you have question about this project, you can talk to <i>Mathematica.SE</i> users in the <i>Mathematica.SE</i> <a href="http://chat.stackexchange.com/rooms/29579/packagedata-net">chat room</a> or contact the administrator at <a href="mailto:admin@packagedata.net">admin@packagedata.net</a>. The PHP source code of this site is available at <a href="https://github.com/cekdahl/packagedata">Github</a>.
	  			</p>
      			<p>This site was built from the ground up to make it as easy as possible for anonymous users to pitch in. You are strongly encouraged to submit links to any packages that you know of that are not in this list, or to submit updates to existing links. This can be a small improvement, or usage examples for a package that doesn't have any yet.</p>
      		</div>
			<?php if( is_logged_in() ): ?>
			<div class="col-md-6">
				<div class="list-group" style="margin-top: 20px;">
				  <a href="<?php echo site_url('review/pending_new'); ?>" class="list-group-item">Review queue <span class="badge <?php if(get_review_count() > 0) { echo 'progress-bar-warning'; }?>"><?php review_count(); ?></span></a>
				  <a href="<?php echo site_url('account/logout'); ?>" class="list-group-item">Log out</a>
				</div>
			</div>
			<?php else: ?>
			<div class="col-md-6">
				<p style="margin-top: 20px;"><i><a href="http://mathematica.stackexchange.com/" title="Mathematica.StackExchange">Mathematica.StackExchange</a></i> users with more than 2000 reputation points can authenticate themselves for additional functionality.</p>
				<div class="list-group">
				  <a href="<?php echo $oauth_link; ?>" class="list-group-item">Log in</a>
				</div>
			</div>
			<?php endif; ?>
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
      			<h4>Installing Mathematica packages</h4>
      			<p>Best practice is to put packages (.m/.wl files and dependencies) in the directory <code>FileNameJoin[{$UserBaseDirectory, "Applications"}]</code>. <i>Mathematica</i> has a built-in tool for placing .m files, .wl files or files in a .zip archive in that directory, called "Install" under the menu "File". The main benefit of using said directory for packages is that when a new <i>Mathematica</i> version is installed, packages will automatically be available.</p>
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
 	
 	<script src='https://www.google.com/recaptcha/api.js?render=explicit&onload=CaptchaCallback'></script>
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
						
			$('.modal-body').on('dragover', '#dropZone', function(event) {
			    event.preventDefault();  
			    event.stopPropagation();
			    $(this).find(".panel-body h3").html("Drop file now");
			});
			
			$('.modal-body').on('dragleave', '#dropZone', function(event) {
			    event.preventDefault();  
			    event.stopPropagation();
			    $(this).find(".panel-body h3").html("Drop file here");
			});
			
			$('.modal-body').on('drop', '#dropZone', function(event) {
			    event.preventDefault();
			    event.stopPropagation();
			    var files = event.originalEvent.dataTransfer.files;
			    file = files[0];
			    $("#selectFileArea").html('<div class="alert alert-success">Selected '+file.name+'</div>');
			    $("#submitImageUpload").removeClass("disabled").removeAttr("disabled");
			});
	
			$('.modal-body').on('change', '#selectImageFile', function() {
				file = this.files[0];
			    $("#selectFileArea").html('<div class="alert alert-success">Selected '+file.name+'</div>');
			    $("#submitImageUpload").removeClass("disabled").removeAttr("disabled");
			});
	
			$('#uploadImageModal').on('shown.bs.modal', function () {
			    recaptcha2 = grecaptcha.render('recaptcha2', {'sitekey' : '<?php echo $this->config->item('captcha_key'); ?>'});
			});
			
			$('#uploadImageModal').on('hide.bs.modal', function () {
			    $("#recaptcha2").empty();
			});
			
			$('#submitImageUpload').click(function() {
			    $("#submitImageUpload").text('Uploading...').addClass("disabled").attr("disabled","true");
			
				var formdata = new FormData();
				formdata.append('g-recaptcha-response', grecaptcha.getResponse(recaptcha2));
				formdata.append('file', file);
			
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('links/upload_image'); ?>',
					data: formdata,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'json',
					success: function(data) {
					console.log(data);
				    	if(!data.error) {
				    		new_text = $('#examples').val() + '![title](<?php echo base_url('uploads/images') . '/'; ?>'+data.name+')';
				    		$('#examples').val(new_text);
				    		$('#preview').html(marked(new_text));
				    	}
				    	else {
				    		$('#editorToolbar').append('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+data.error+'</div>');
				    	}
				    	
				    	$("#uploadImageModal").modal('hide');
				    	
						$("#submitImageUpload").text('Upload image');
						$("#selectFileArea").html('<p><input type="file" id="selectImageFile"></p><div id="dropZone" class="panel panel-default"><div class="panel-body"><h3>Or drop file here</h3></div></div>');
					}
				});
				
			});

			/* $('.package-toolbar').hide();
			
			$('.package').hover(function() {
				$(this).find('.package-toolbar').stop().fadeIn();
			}, function() {
				$(this).find('.package-toolbar').stop().fadeOut();
			}); */

		});
		
		var CaptchaCallback = function() {
			recaptcha1 = grecaptcha.render('recaptcha1', {'sitekey' : '<?php echo $this->config->item('captcha_key'); ?>'});
		}
	</script>
  </body>
</html>