<div>
	<script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			jQuery('#clear-image-button').on('click', function( event ){
					$("#image-preview").attr('src', '<?php echo $this->options->getDefaultLogoUrl();?>');
					$("#image-attachemt-id").val(0);
			});
			jQuery('#upload-image-button').on('click', function( event ){
				event.preventDefault();
				// Create the media frame.
				fileFrame = wp.media.frames.file_frame = wp.media({
					title: '<?php _e('Select a image','sloth-logo-customizer');?>',
					button: {
						text: '<?php _e('Select');?>',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				
				fileFrame.on('select', function(){
					attachemt = fileFrame.state().get('selection').first().toJSON();
					$("#image-preview").attr('src', attachemt.url);
					$("#image-attachemt-id").val(attachemt.id);
				});
				
				fileFrame.open();
			});
		});
	</script>
	<style>
		legend.sloth{
                    font-size: x-large;
                    margin-top: 1em;
                    margin-bottom: 0.5em;
		}
		fieldset{
                    border: 1px solid gray;
                    padding: 1em;
                    margin-bottom: 1em;
                    width: 90%;
		}
		div#image-preview-wrapper{
			display: inline;
		}
		img#image-preview{
			width: 100px;
			height: 100px;
			max-height: 100px;
			max-width: 100px;
			border: 1px solid lightgray;
		}
	</style>
	
	<div>
	</div>
	
	<p></p>
	<div id="poweredBy">
		<form method="post">
			<fieldset>
				<!-- --------------------------------------- -->
				<legend class="sloth"><?php _e('Login Page', 'sloth-logo-customizer');?></legend>
				
				<label for="upload-image-button"><?php _e('Logo');?></label>
                                <img id="image-preview" src="<?php echo $this->options->getSiteLogoUrl();?>" class="dashicons dashicons-wordpress" />  <br />
				<input id="upload-image-button" type="button" class="button" value="<?php _e('Update'); ?>" />
				<input id="clear-image-button" type="button" class="button" value="<?php _e('Clear'); ?>" />
				<input type="hidden" name="imageAttachmentId" id="image-attachemt-id" value="<?php echo $this->options->getSiteLogoPostId();?>" />
				
			</fieldset>
				<!-- --------------------------------------- -->
			<fieldset>
				<legend class="sloth"><?php _e('Support Section', 'sloth-logo-customizer');?></legend>
				
				<label for="title"><?php _e('Support Title', 'sloth-logo-customizer');?></label>
				<input id="title" type="text" name="title"  value="<?php echo $this->options->getSiteSignatureTitle();?>" placeholder="<?php echo $this->options->getSiteSignatureTitlePlaceholder();?>">
				<span><?php _e('Empty for wordpress default values','sloth-logo-customizer');?></span><br />
				
				<label for="url"><?php _e('Support URL', 'sloth-logo-customizer');?></label>
				<input id="url" type="text" name="url" value="<?php echo $this->options->getSiteSignatureUrl();?>" placeholder="<?php echo $this->options->getSiteSignatureUrlPlaceholder();?>" dir="ltr">
				<span><?php _e('Empty for wordpress default values','sloth-logo-customizer');?></span><br />
				
				<input id="allow-override" type="checkbox" class="checkbox" name="allowOverride" value="true" <?php echo ($this->options->getAllowOverride())? 'checked="checked"': ''; ?> />
				<label for="allow-override"><?php _e('Allow blogs to override settings','sloth-logo-customizer');?></label>
				
				<input type="hidden" name="poweredBy" value="yes"><br />
			</fieldset>
                        <button class="button button-primary"><?php _e('Save Changes'); ?></button>
		</form>
	</div>
</div>
