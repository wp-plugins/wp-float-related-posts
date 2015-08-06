<div id="rp-admin">
	<h1>
		<span class="dashicons-before dashicons-feedback"></span>
		Related Posts
	</h1>
	<form name="wp-related-posts" id="wp-related-posts" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<?php wp_nonce_field( 'wprelatedpost-s', 'rpnonce' ); ?>
		<input type="hidden" name="action" value="update_options">
		<label for="rp-admin-title">Title</label>
		<input type="text" name="rp-title" id="rp-admin-title" value="<?php echo esc_attr( get_option('rp-title') ); ?>">
		<label for="rp-admin-read-more-text">Read more text</label>
		<input type="text" name="rp-read-more-text" id="rp-admin-read-more-text" value="<?php echo esc_attr( get_option('rp-read-more-text') ); ?>">
		<label for="rp-admin-mode">Mode</label>
		<select id="rp-admin-mode" name="rp-mode">
			<option value="timeout"<?php echo get_option('rp-mode') == 'timeout' ? ' selected="selected"' : ''; ?>>Timeout</option>
			<option value="scrolldown"<?php echo get_option('rp-mode') == 'scrolldown' ? ' selected="selected"' : ''; ?>>Scrolldown</option>
		</select>
		<div class="rpmode">
			<?php if( get_option('rp-mode') == 'timeout' ): ?>
			<label for="rp-admin-timeoutms">Timeout <i style="font-weight:100">(in ms, 1000ms = 1s )</i></label>
			<input type="text" name="rp-timeoutms" id="rp-admin-timeoutms" value="<?php echo esc_attr( get_option('rp-timeoutms') ); ?>">
			<?php else: ?>
				<label for="rp-admin-scrollpercent">Percent of scrolling</label>
				<input type="text" name="rp-scrollpercent" id="rp-admin-scrollpercent" value="<?php echo esc_attr( get_option('rp-scrollpercent') ); ?>">
			<?php endif; ?>
		</div>
		<label for="rp-admin-effect">Effect</label>
		<select id="rp-admin-effect" name="rp-effect">
			<option value="bounce"<?php echo get_option('rp-effect') == 'bounce' ? ' selected="selected"' : ''; ?>>Bounce</option>
			<option value="bounceIn"<?php echo get_option('rp-effect') == 'bounceIn' ? ' selected="selected"' : ''; ?>>BounceIn</option>
			<option value="bounceInDown"<?php echo get_option('rp-effect') == 'bounceInDown' ? ' selected="selected"' : ''; ?>>bounceInDown</option>
			<option value="bounceInLeft"<?php echo get_option('rp-effect') == 'bounceInLeft' ? ' selected="selected"' : ''; ?>>bounceInLeft</option>
			<option value="bounceInRight"<?php echo get_option('rp-effect') == 'bounceInRight' ? ' selected="selected"' : ''; ?>>bounceInRight</option>
			<option value="bounceInUp"<?php echo get_option('rp-effect') == 'bounceInUp' ? ' selected="selected"' : ''; ?>>bounceInUp</option>
			<option value="pulse"<?php echo get_option('rp-effect') == 'pulse' ? ' selected="selected"' : ''; ?>>Pulse</option>
			<option value="rubberBand"<?php echo get_option('rp-effect') == 'rubberBand' ? ' selected="selected"' : ''; ?>>rubberBand</option>
			<option value="shake"<?php echo get_option('rp-effect') == 'shake' ? ' selected="selected"' : ''; ?>>Shake</option>
			<option value="swing"<?php echo get_option('rp-effect') == 'swing' ? ' selected="selected"' : ''; ?>>Swing</option>
			<option value="tada"<?php echo get_option('rp-effect') == 'tada' ? ' selected="selected"' : ''; ?>>Tada</option>
			<option value="wobble"<?php echo get_option('rp-effect') == 'wobble' ? ' selected="selected"' : ''; ?>>Wobble</option>
			<option value="jello"<?php echo get_option('rp-effect') == 'jello' ? ' selected="selected"' : ''; ?>>Jello</option>
			<option value="fadeIn"<?php echo get_option('rp-effect') == 'fadeIn' ? ' selected="selected"' : ''; ?>>fadeIn</option>
			<option value="fadeInDown"<?php echo get_option('rp-effect') == 'fadeInDown' ? ' selected="selected"' : ''; ?>>fadeInDown</option>
			<option value="fadeInDownBig"<?php echo get_option('rp-effect') == 'fadeInDownBig' ? ' selected="selected"' : ''; ?>>fadeInDownBig</option>
			<option value="fadeInLeft"<?php echo get_option('rp-effect') == 'fadeInLeft' ? ' selected="selected"' : ''; ?>>fadeInLeft</option>
			<option value="fadeInLeftBig"<?php echo get_option('rp-effect') == 'fadeInLeftBig' ? ' selected="selected"' : ''; ?>>fadeInLeftBig</option>
			<option value="fadeInRight"<?php echo get_option('rp-effect') == 'fadeInRight' ? ' selected="selected"' : ''; ?>>fadeInRight</option>
			<option value="fadeInRightBig"<?php echo get_option('rp-effect') == 'fadeInRightBig' ? ' selected="selected"' : ''; ?>>fadeInRightBig</option>
			<option value="fadeInUp"<?php echo get_option('rp-effect') == 'fadeInUp' ? ' selected="selected"' : ''; ?>>fadeInUp</option>
			<option value="fadeInUpBig"<?php echo get_option('rp-effect') == 'fadeInUpBig' ? ' selected="selected"' : ''; ?>>fadeInUpBig</option>
		</select>
		<script>
			var rpmodes = {
				'timeout' : '<label for="rp-admin-timeoutms">Timeout <i style="font-weight:100">(in ms, 1000ms = 1s )</i></label><input type="text" name="rp-timeoutms" id="rp-admin-timeoutms" value="<?php echo esc_attr( get_option('rp-timeoutms') ); ?>">',
				'scrolldown' : '<label for="rp-admin-scrollpercent">Percent of scrolling</label><input type="text" name="rp-scrollpercent" id="rp-admin-scrollpercent" value="<?php echo esc_attr( get_option('rp-scrollpercent') ); ?>">'
			};
		</script>
		<label class="selectit">
			<input type="checkbox" name="rp-gatracking"<?php echo esc_attr( get_option('rp-gatracking') )==1 ? ' checked="checked"' : ''; ?>> Track clicks in Google Analytics
		</label>
		<label class="selectit">
			<input type="checkbox" name="rp-show-excerpt"<?php echo esc_attr( get_option('rp-show-excerpt') )==1 ? ' checked="checked"' : ''; ?>> Show excerpt instead
		</label>
		<label class="selectit">
			<input type="checkbox" name="rp-show-random"<?php echo esc_attr( get_option('rp-show-random') )==1 ? ' checked="checked"' : ''; ?>> Show random posts when there aren't related posts
		</label>
		<div style="text-align:right;margin-top:15px">
			<a class="rp-btn rp-btn-default rp-reset-options">
				Reset defaults
			</a>&nbsp;
			<button class="rp-btn">
				Save
			</button>
		</div>
	</form>
	<div style="float:left;width:49%;margin-top:-5%;max-width:650px">
		<img src="<?php echo plugins_url( '../img/box.png', __FILE__ ); ?>" alt="preview popup box" id="previewbox" class="previewbox animated <?php echo esc_attr( get_option('rp-effect') ); ?>">
	</div>
	<p class="infotext">Notifications are created with <a href="https://atanasovsky.wordpress.com/2015/07/19/web-notifications-for-better-user-experience/" target="_blank">NotifyJS</a></p>
	<p class="infotext" style="font-size:12px">If you like <strong>WP Float Related Posts</strong> please leave us a <a href="https://wordpress.org/support/view/plugin-reviews/wp-float-related-posts?filter=5#postform" target="_blank" class="wc-rating-link" data-rated="Thanks :)">★★★★★</a> rating. A huge thank you from me in advance!</p>
</div>