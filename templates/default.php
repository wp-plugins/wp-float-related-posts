<script>
	var rpconfig = {
		"mode":"<?php echo esc_attr( get_option('rp-mode') ); ?>",
		"timeoutms":<?php echo esc_attr( get_option('rp-timeoutms') ); ?>,
		"scrollpercent":<?php echo esc_attr( get_option('rp-scrollpercent') ); ?>
	};
</script>
<div class="rp rp-backdrop hide"></div>
<div class="rp rp-popup-wrapper hide">
	<div class="rp-popup animated <?php echo esc_attr( get_option('rp-effect') ); ?>">
	<a href="javascript:;" class="rp-close">x</a>
	<h3 class="rp-title"><?php echo get_option('rp-title'); ?></h3>
	<div class="rp-content">
		<div class="rp-row">
		<?php  
		foreach( $relatedposts as $relatedpost ):
		$thumbsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $relatedpost->ID ), 'medium', true);
		$thumbsrc = $thumbsrc[0];
		$permalink = get_the_permalink($relatedpost->ID);
		if( get_option('rp-gatracking') == 1 )
		{
			$tracking = array();
			$tracking['utm_source'] 	= "WP Float Related Posts";
			$tracking['utm_medium'] 	= "Popup Banner";
			$tracking['utm_campaign'] 	= "wprp-" . date(dmY);
			
			$permalink .= strpos($permalink,"?")===false ? "?" : "&";
			$permalink .= http_build_query( $tracking );
		}
		?>
			<div class="rp-col-4">
				<a href="<?php echo $permalink; ?>">
					<span class="rp-thumb" style="background-image:url(<?php echo $thumbsrc; ?>)">
						<span class="rp-post-title">
							<?php echo $relatedpost->post_title; ?>
						</span>
					</span>
				</a>
				<div class="rp-snippet">
					<div class="rp-snippet-text">
						<?php 
							if( get_option( 'rp-show-excerpt' ) == 1 && has_excerpt( $relatedpost->ID ) )
							{
								the_excerpt();
							}else{
								echo mb_substr( strip_tags( $relatedpost->post_content ), 0, 145, 'utf-8' ) . '...';	
							}
						?>
					</div>
					<div class="text-right">
						<a href="<?php echo $permalink; ?>" class="rp-more-link"><?php echo get_option('rp-read-more-text'); ?></a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<div class="rp-popup-credits">powered by <a href="https://wordpress.org/plugins/wp-float-related-posts/" target="_blank">RelatedPosts</a></div>
	</div>
</div>