<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if(theme_option('seo')!=2) { // New SEO options ?>
<?php if((is_home() && ($paged < 2 )) || is_single() || is_page()) { echo '<meta name="robots" content="index,follow" />'; } else { echo '<meta name="robots" content="noindex,follow" />'; } ?>

<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php
	$meta_title_value = get_post_meta($post->ID, 'pbt_meta_title_value', true);
	$meta_desc_value = get_post_meta($post->ID, 'pbt_meta_desc_value', true);
	$meta_keywords_value = get_post_meta($post->ID, 'pbt_meta_keywords_value', true);
?>
<meta name="description" content="<?php if(!empty($meta_desc_value)) echo $meta_desc_value; else metaDesc(); ?>" />
<meta name="keywords" content="<?php if(!empty($meta_keywords_value)) echo $meta_keywords_value; else csv_tags(); ?>" />
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php if(theme_option('site_description')) { echo trim(stripslashes(theme_option('site_description'))); } else { bloginfo('description'); } ?>" />
<meta name="keywords" content="<?php if(theme_option('keywords')) { echo trim(stripslashes(theme_option('keywords'))); } else { echo 'wordpress,c.bavota,magazine basic,custom theme,themes.bavotasan.com,premium themes'; } ?>" />
<?php endif; ?>
<title><?php if(!empty($meta_title_value)) echo $meta_title_value; else { wp_title(''); ?><?php if(wp_title('', false)) { echo ' | '; } ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } } ?></title>
<?php } else { ?>
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' | '; } ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } ?></title>
<?php } // end SEO options ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php if(theme_option('font_face')!=2) { ?>
<link rel="stylesheet" href="<?php echo THEME_URL; ?>/admin/css/fonts.css" type="text/css" media="screen" />
<?php } ?>
<?php pbt_header_css(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL; ?>/iestyles.css" />
<![endif]-->
<?php if(is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
<?php wp_enqueue_script('effects_js'); ?>
<?php if(theme_option('slideshow')==2 && is_home()) { wp_enqueue_script('sliderota_js'); } ?>
<?php if(theme_option('slideshow')==3 && is_home()) { wp_enqueue_script('scrollerota_js'); } ?>

<?php wp_head(); ?>
<?php if(theme_option('google_analytics')) { echo stripslashes(theme_option('google_analytics')); } ?>
</head>

<body <?php body_class(); ?>>
<!-- begin header -->
<?php if(theme_option('user_login')!="2") { ?>
<div id="toppanel">
	<?php global $user_ID, $user_identity, $user_level ?>
	<div id="panel">
		<div class="content clearfix">
			<div class="left right">
				<?php echo stripslashes(theme_option('login_panel_text')); ?>
			</div>
			<div class="left">
	            <?php if ( $user_ID ) : ?>
                <div class="paneltitle"><?php _e('Control panel', "magazine-premium"); ?></div>
                <ul>
                    <li><?php _e('Logged in as: ', "magazine-premium"); ?><strong><?php echo $user_identity; ?></strong></li>
                    <li><a href="<?php echo admin_url(); ?>"><?php _e('Dashboard', "magazine-premium"); ?></a></li>
        
                    <?php if ( $user_level >= 1 ) : ?>
                    <li><a href="<?php echo admin_url('post-new.php'); ?>"><?php _e('Write', "magazine-premium"); ?></a></li>
                    <?php endif // $user_level >= 1 ?>
        
                    <li><a href="<?php echo admin_url('profile.php'); ?>"><?php _e('Profile', "magazine-premium"); ?></a></li>
                </ul>
				<a class="bt_logout" href="<?php echo wp_logout_url() ?>&amp;redirect_to=<?php echo urlencode(curPageURL()); ?>"><?php _e('Log Out', "magazine-premium"); ?></a>        
                <?php else : ?>
				<!-- Login Form -->
				<form action="<?php echo site_url(); ?>/wp-login.php" method="post">
					<div class="paneltitle">Member Login</div>
					<label class="grey">Username:</label>
					<input class="field" type="text" name="log" id="log" value="<?php if(isset($user_login)) echo esc_html(stripslashes($user_login), 1) ?>" size="23" />
					<label class="grey">Password:</label>
					<input class="field" type="password" name="pwd" id="pwd" size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
                    <input type="hidden" name="redirect_to" value="<?php echo curPageURL(); ?>"/>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<a class="lost-pwd" href="<?php echo site_url(); ?>/wp-login.php?action=lostpassword">Lost your password?</a>
				</form>
                <?php endif ?>

			</div>
            <?php if ( get_option('users_can_register') && !$user_ID) { ?>
			<div class="left">			
				<!-- Register Form -->
				<form action="<?php echo site_url(); ?>/wp-login.php?action=register" method="post">
					<div class="paneltitle">Not a member yet? Sign Up!</div>				
					<label class="grey">Username:</label>
					<input class="field" type="text" name="user_login" id="user_login" value="" size="23" />
					<label class="grey">Email:</label>
					<input class="field" type="text" name="user_email" id="user_email" size="23" />
					<label>A password will be e-mailed to you.</label>
					<input type="submit" name="wp-submit" id="wp-submit" value="Register" class="bt_register" />
				</form>
			</div>
            <?php } ?>
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
        <div class="wrap">
            <ul class="login">
                <li class="left">&nbsp;</li>
                <li id="toggle">
                    <a id="open" class="open" href="javascript: void(0)"><?php if ( $user_ID ) { _e("Welcome","magazine-premium"); echo " ".$user_identity; } else { _e("Hello Guest!", "magazine-premium"); } ?></a>
                    <a id="close" style="display: none;" class="close" href="javascript: void(0)"><?php _e("Close", "magazine-premium"); ?></a>			
                </li>
                <li class="right">&nbsp;</li>
            </ul> 
        </div>
	</div> <!-- / top -->
	
</div> <!--panel -->
<?php } // end login ?>
<div id="body">
<div id="header">
    <?php 
	$headeralign = theme_option('logo_location');
	if($headeralign=="fl") $adfloat = ' class="fr"';
	if($headeralign=="fr") $adfloat = ' class="fl"';
	if($headeralign=="aligncenter") $adfloat = ' class="aligncenter"';
	if(theme_option('header_ad')) { ?>
        <div id="headerad"<?php echo $adfloat; ?>>
            <?php echo stripslashes(theme_option('header_ad')); ?>
        </div>
    <?php } ?>
	<?php 
	$float = ' class="'.$headeralign.'"';
	if (theme_option('logo_header')) { ?>
        <div id="title"<?php echo $float; ?>>
		   	<a href="<?php echo home_url(); ?>/" class="headerimage"><img src="<?php echo theme_option('logo_header'); ?>" alt="<?php bloginfo('name'); ?>" /></a>
    	</div>
	<?php } else { ?>
        <div id="title"<?php echo $float; ?>>
            <?php if(is_home()) echo '<h1>'; else echo '<h2>'; ?><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a><?php if(is_home()) echo '</h1>'; else echo '</h2>'; ?>
        </div>
    <?php } ?>
    <div id="description"<?php echo $float; ?>>
        <?php if(theme_option('tag_line')!=2) bloginfo('description'); ?>
    </div>
    <?php
    if(function_exists('wp_nav_menu')) {
		 wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'sf-menu', 'sort_column' => 'menu_order', 'container_class' => 'main-navigation', 'fallback_cb' => 'display_home' ) ); 
		 wp_nav_menu( array( 'theme_location' => 'sub', 'menu_class' => 'sf-menu', 'sort_column' => 'menu_order', 'container_class' => 'sub-navigation', 'fallback_cb' => 'display_none' ) ); 
	} else {
		echo '<div class="main-navigation"><ul class="sf-menu"><li><a href="'.get_bloginfo('url').'">Home</a></li>';
		wp_list_categories('title_li=');
		echo '</ul></div>';
	}
	?>
</div>
<!-- end header -->
	<?php
        $sidebar_layout = get_post_meta($post->ID, 'pbt_single_layout', true);
		$loc = theme_option('sidebar_location1');
        if($sidebar_layout==2 && is_singular()) {
			// nothing
		} else {
            if($loc==1 || $loc==3 || $loc==5) {
                if(theme_option('sidebar_width1')!=0) get_sidebar(); // calling the First Sidebar
            }
        }
    ?>
	<div id="maincontent">