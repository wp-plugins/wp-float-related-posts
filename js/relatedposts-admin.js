jQuery(document).ready(function() {
   jQuery('#wp-related-posts').submit(function() { 
      jQuery(this).ajaxSubmit({
         success: function(resp){
			notify.create("Your settings was successfully updated");
         }
      }); 
      return false; 
   });
   jQuery('.rp-reset-options').click(function(){
		if( confirm('Are you sure?') === true )
		{
			jQuery.post(ajaxurl, {'action':'reset_options'},function(){
				window.location.reload(true);
			});
		}
   });
   jQuery('#rp-admin-mode').change(function(){
		jQuery('.rpmode').html(rpmodes[this.value]);
   });
   jQuery('#rp-admin-effect').change(function(){
		jQuery('#previewbox').attr('class','previewbox animated '+this.value);
   });
});