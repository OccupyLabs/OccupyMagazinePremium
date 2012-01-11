<?php 
global $notin, $the_section_id;

$advanced = pbt_theme_option('basic_advanced');
if($advanced != 2 && is_home()) {
	echo '</div>';
	$loc = pbt_theme_option('sidebar_location1');
	if(($loc==2 || $loc==4)) {
		if(pbt_theme_option('sidebar_width1')!=0) get_sidebar(); // calling the First Sidebar
	}
	if(pbt_theme_option('sidebar_width2')!=0) 
		get_sidebar( "second" ); // calling the Second Sidebar
} else {	
	if(pbt_theme_option('activate_fpls')==1 || !is_home()) echo '</div> <!-- end #maincontent -->';

 	if(is_singular()) $sidebar_layout = get_post_meta($post->ID, 'pbt_single_layout', true); else $sidebar_layout = '';
	$loc = pbt_theme_option('sidebar_location1');
	if($sidebar_layout!=2) {
		if($loc==2 || $loc==4) {
			if((pbt_theme_option('activate_fpls')==1 && is_home()) || !is_home()) {
				if(pbt_theme_option('sidebar_width1')!=0) get_sidebar(); // calling the First Sidebar
			}
		}
		if(pbt_theme_option('sidebar_width2')!=0 && !is_home()) get_sidebar( "second" ); // calling the Second Sidebar
	}
	if(pbt_theme_option('activate_fpls')==1 || !is_home()) echo '<br class="clear" />';
	
    if(is_home()) {
   		if(pbt_theme_option('activate_fpls')==1) echo '<div id="lowersection">';
		get_template_part('loop', 'index-lower'); // calling the loop for the lower sections
		?>   
	</div> <!-- end #lowerright -->
    
	<?php
 		if(($loc==2 || $loc==4) && is_home() && pbt_theme_option('activate_fpls')!=1) {
			if(pbt_theme_option('sidebar_width1')!=0) get_sidebar(); // calling the First Sidebar
		}
    	if((pbt_theme_option('front_lower_sidebar')!=0 && pbt_theme_option('activate_fpls')!=2)  || (pbt_theme_option('sidebar_width2')!=0 && pbt_theme_option('activate_fpls')!=1)) 
			get_sidebar( "second" ); // calling the Second Sidebar
    } // end if is_home()
} //end Advanced if statement

	echo '<br class="clear" />';
	if(pbt_theme_option('display_imagebar')=="on") { 
	 ?>
    <div id="imagebar">
         <?php
		$imagebar = pbt_theme_option('fp_imagebar');
		echo "<h2>".get_cat_name($imagebar)."</h2>";
		echo "<ul>";
		$posts = array(
			'post__not_in'=>$notin,
			"posts_per_page"=>"5",
			"cat"=>$imagebar,
			'ignore_sticky_posts' => 1
		);
		$imagebarPosts = new WP_Query();
        $imagebarPosts->query($posts);
		$x = 1;
        while ($imagebarPosts->have_posts()) : $imagebarPosts->the_post(); ?>
            <li<?php if($x==5) echo ' class="lastimg"'; ?> style="width: <?php echo IMAGEBARWIDTH; ?>px;">
			<?php 
				if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
                    echo '<a href="'.get_permalink().'">';
					the_post_thumbnail('imagebar-thumb');
					echo '</a>';
				} else { 
					echo resize(IMAGEBARWIDTH,IMAGEBARWIDTH-60, ''); 
				}	
			?>
            <br /><h4 style="width: <?php $site = pbt_theme_option('site_width'); $width = round(($site/5)-($site/30)); echo $width; ?>px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4></li>
        <?php $x++; endwhile; ?>
        </ul>
    </div> <!-- end #imagebar -->
    <?php } ?>

<br class="clear" />
</div> <!-- end #body -->


<!-- begin footer -->
<div id="footer">
		<div class="custom_wrap">
	    <?php if(pbt_theme_option('extended_footer')!=2) get_sidebar( 'footer' ); // include the Extended Footer Bar ?>	
		
        <?php if(pbt_theme_option('footer_ad')) { ?>
        <div id="footerad">
            <?php echo stripslashes(pbt_theme_option('footer_ad')); ?>
        </div>
    	<?php } ?>    
        <?php if(pbt_theme_option('footer_text')) { 
			echo stripslashes(pbt_theme_option('footer_text'));
		} else {
			printf(__('&copy; %1$d %2$s Please feel free to distribute any of the original content on this site across the internet.', "magazine-premium"), date('Y'), '<span style="text-transform:uppercase">'.get_bloginfo('name').'</span>'); ?>
        <?php } ?>
        <div id="footer_creative_commons"></div>
	</div>
</div> <!-- end #footer -->


<?php wp_footer(); ?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery("object, embed, .format-video iframe").each(function() {
	var $origVideo = jQuery(this);
	var aspectRatio = $origVideo.attr("height") / $origVideo.attr("width");
	var wrapWidth = $origVideo.parents().find("p:last").width();
	if($origVideo.attr("width")>wrapWidth) {
		$origVideo
			.attr("width", wrapWidth)
			.attr("height", (wrapWidth * aspectRatio));
	}
});
<?php 
if(is_home()) {
	if(pbt_theme_option('slideshow')==1) { ?>
		jQuery("#featured").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
	<?php } ?>
<?php } ?>
jQuery("#mailinglist").submit(function()	{
	if(jQuery("#mailinglistemail").val()=="") {
		jQuery("#tabbed-3 .error").text("<?php _e('Please enter your email address.', "magazine-premium"); ?>");
		return false;
	} else {
		var email = jQuery('#mailinglistemail').val();
		if(email.indexOf("@") == -1 || email.indexOf(".") == -1) {
			jQuery("#tabbed-3 .error").text("<?php _e('Please enter a valid email address.', "magazine-premium"); ?>");
			return false;
		} else {
			var data = {
				action: 'save_mailinglist_options',
				option: jQuery(this).serialize()
			};
			jQuery("#mailinglistsubmit").hide();
			jQuery(".ajaxsave").show();
			jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data,
			function(response){
				jQuery(".ajaxsave").hide();
				jQuery("#mailinglistsubmit").show();
				jQuery("#tabbed-3 .message").html(response);
			});		
			return false;
		}
	} 
	
});
/* ]]> */
</script>
<!-- Magazine Premium theme designed by c.bavota - http://themes.bavotasan.com -->
</body>
</html>