<!--<link rel="stylesheet" href="outils/filepicker/assets/css/vendor/bootstrap.css">-->
<!--<link rel="stylesheet" href="outils/filepicker/assets/css/vendor/jquery.Jcrop.css">-->
<link rel="stylesheet" href="outils/filepicker/assets/css/filepicker.css">
<!--<link rel="stylesheet" href="outils/filepicker/assets/css/demo.css">-->
   <!-- Start Filepicker -->
				<div class="btnAction fileinput">
					{$datas_lang.parcourir}
					<input type="file" name="files[]" multiple>
				</div>
               
				<div class="progress clear w100" style="display:none">
					<div class="progress-bar  active"></div>
				</div>

				<div class="drop-window fade">
					<div class="drop-window-content">
						<h3>Drop files to upload</h3>
					</div>
				</div>
			<ul class="files clear"></ul>


    
	<script src="outils/filepicker/assets/js/vendor/bootstrap.js"></script>
	<!--<script src="outils/filepicker/assets/js/vendor/jquery.Jcrop.js"></script>-->
	<script src="outils/filepicker/assets/js/jquery.filepicker.js"> </script>
	<!--<script src="outils/filepicker/assets/js/plugins/crop.js"></script>-->

    <script>
function FilepickerSuccessAll(filePicker, callback) {
            var added = 0;
            var success = 0;

            filePicker.on('filepicker.add', function(e, file) {
                        added++;
            }).on('filepicker.success', function(e, file) {
                        if (file.error) {
                                   added--;
                                   return;
                        }

                        success++;

                        if (added === success) {
                                   added = success = 0;
                                   callback();
                        }
            });
}

		jQuery(document).ready(function($) {
			// Initialize the plugin.
			var FP = $('#formMaj').filePicker({
                debug:true,
				url: 'outils/filepicker/uploader/index.php',
                formData: function() { 
                    return {
                        path: '{$path}',
                        fileExt: '{$extensionsAuthorized}',
						{if $dimThumbs !=""}
                        thumbnails: '{$dimThumbs}',
                        thumbnailsFolders: '{$path}',
                        svig: '{$myAdmin->suffixeVignettes}',
						{/if}
                        wMax: '{$wMax}',
                        hMax: '{$hMax}',
                        maxSize: '{$poidsmax}',
                    } 
                }
			})
			.on('filepicker.send', function(e, file) {
				$('.progress').show();
                $('.files').html('');
			})
			.on('filepicker.progress', function(e, file) {
				var percentage  = Math.floor((file.progress.loaded / file.progress.total) * 100);
				$('.progress-bar').text(percentage + '%').css('width', percentage + '%');
			})
			.on('filepicker.success', function(e, file) {
				//$('.progress').hide();

				if (file.error) {
					alert(file.error);
                    $('.progress').hide();
				} else {
					$('.files').append('<li>' + file.name + '</li>');
					//console.log(file);
                    //
				}

				/*if (file.imageFileType) {
					// Update the file.
					$('.crop').data('file', file);
					// Show crop if is image.
					$('.crop').show();
				}*/
			})
            
            FilepickerSuccessAll(FP, function() {
                 reloadBrowse();
            });

			// Crop success event.
			/*.on('filepicker.cropsuccess', function(e, file) {
				// Update the file back.
				$('.crop').data('file', file);
				console.log(file);
			});*/

			// Filepicker crop plugin.
			/*FilepickerCrop(FP, {
				container: $('#crop-modal'),
				cropBtn: $('.crop'),
			});*/
		});
	</script>