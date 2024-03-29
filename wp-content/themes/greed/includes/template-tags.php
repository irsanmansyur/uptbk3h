<?php
/**
 * Custom template tags for this theme.
 *   
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Greed  
 */

if ( ! function_exists( 'greed_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function greed_post_nav() {    
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation clearfix" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'greed' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous"><span class="meta-previuous-post">%link</span></div>', _x( 'previous post', 'Previous post link', 'greed' ) );
				next_post_link(     '<div class="nav-next"><span class="meta-next-post">%link</span></div>',     _x( 'Next Post&nbsp;', 'Next post link',     'greed' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'greed_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function greed_entry_footer() { 
	// Hide category and tag text for pages.
	
	if ( 'post' == get_post_type() ) {    
		/* translators: used between list items, there is a space after the comma */
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'greed' ) );
		if ( $tags_list ) {
			printf( '<div class="tag-footer"><span class="tags-links"><span class="tag-title">Tags</span> : ' . __( '%1$s ', 'greed' ) . '</span></div>', $tags_list );
		}
	}
} 
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
if ( ! function_exists( 'greed_categorized_blog' ) ) :
	function greed_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'greed_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'greed_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so greed_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so greed_categorized_blog should return false.
			return false;
		}
	}
endif;

/**
 * Flush out the transients used in greed_categorized_blog.
 */
if ( ! function_exists( 'greed_category_transient_flusher' ) ) :
	function greed_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'greed_categories' );
	}
endif;
add_action( 'edit_category', 'greed_category_transient_flusher' );
add_action( 'save_post',     'greed_category_transient_flusher' );

// Recent Posts with featured Images to be displayed on home page
if( ! function_exists('greed_recent_posts') ) {      
	function greed_recent_posts() {       
		$output = '';
		$posts_per_page  = 3; 
		$post_ID  = explode (',',get_theme_mod('recent_posts_exclude'));
		// WP_Query arguments
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'publish',   
			'posts_per_page'         => intval($posts_per_page),
			'ignore_sticky_posts'    => true,
			'order'                  => 'DESC',
			'post__not_in'           => $post_ID,
		);

		// The Query
		$query = new WP_Query( $args );
		// The Loop 
		if ( $query->have_posts() ) {
			$output .= '<div class="post-wrapper">'; 
			$recent_post_status=get_theme_mod('enable_recent_post_service',true);
		   	$recent_post_section_title= get_theme_mod('recent_post_section_title');
		   	if ( '$recent_post_status' && ' $recent_post_section_title'  ) {
				$output.= '<div class="section-head">';
				$output.= '<h1 class="title-divider">' . get_the_title(absint($recent_post_section_title)) . '</h1>';
				$description = get_post_field('post_content',absint($recent_post_section_title));
				$output.= '<p class="sub-description">' . esc_html($description) . '</p>';
			    $output.= '</div>';
			}
			$output .=  '<div class="container">'; 
			     
				$output .= '<div class="latest-posts sixteen columns clearfix">';
				$output .= '<div class="previous-latest-post four columns clearfix"><a href=""></a>';
			    $output .= '</div>';
					$output .= '<ul class="slides eight columns">';
						while ( $query->have_posts() ) {
							$query->the_post(); 
							$output .= '<li class="list-box">';
							    //$output .= '<div class="eight columns">';
								$output .= '<div class="latest-post">';
									$output .= '<div class="latest-post-thumb">'; 
									$recent_post_image = get_the_post_thumbnail($query->post->ID,'greed-recent-post-large-img');
									$image_link = esc_url(get_permalink());
										if ( has_post_thumbnail() ){
											$output .= '<a href="'. esc_url(get_permalink()) . '">'. get_the_post_thumbnail($query->post->ID ,'greed-recent-posts-img', array('srcset' => $recent_post_image , 'link' => $image_link) ).'</a>';
										}
										else {  
											$output .= '<img src="' . get_template_directory_uri()  . '/images/no-image.png" alt="" >';
										}   
									$output .= '</div><!-- .latest-post-thumb -->';
									$output .= '<div class=latest-post-details>';
										$output .= '<h4><a href="'. esc_url(get_permalink()) . '">' . get_the_title() . '</a></h4>';
										$output .= '<div class="latest-post-content">';
												$output .= '<p>' . get_the_content() . '</p>';
												$output .=	wp_link_pages( array(
													'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'greed' ),
													'after'  => '</div>',
													'echo' => false,
												) );
										$output .= '</div><!-- .latest-post-content -->';
										$output .='<div class="entry-meta">';  
											$output .='<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i></a></span>';
											$output .='<span class="comments-link"><a href="' . esc_url(get_comments_link()) .'"><i class="fa fa-comments"></i></a></span>';
											$output .='<span class="data-structure"><a class="url fn n" href="'. esc_url( get_day_link( get_the_time('Y'), get_the_time('m'),get_the_time('d')) ). '"><i class="fa fa-calendar"></i></a></span>';
										$output .='</div><!-- entry-meta -->';	
									$output .= '</div><!-- .latest-post-details -->';

								$output .= '</div><!-- .latest-post -->';
							    //$output .= '</div>';
							$output .= '</li>';		
						}
					$output .= '</ul>';
					$output .= '<div class="next-latest-post four columns clearfix"><a href=""></a>';	
				    $output .= '</div>';
				$output .= '</div>';
				
			$output .= '</div>';
			$output .= '</div><!-- .post-wrapper -->';
		} 
		$query = null;
		// Restore original Post Data
		wp_reset_postdata();
		echo $output;
	}
}


/**
  * Generates Breadcrumb Navigation 
  */ 
 
 if( ! function_exists( 'greed_breadcrumbs' )) {
 
	function greed_breadcrumbs() {
		/* === OPTIONS === */
		$text['home']     = __( 'Home','greed' ); // text for the 'Home' link
		$text['category'] = __( 'Archive by Category "%s"','greed' ); // text for a category page
		$text['search']   = __( 'Search Results for "%s" Query','greed' ); // text for a search results page
		$text['tag']      = __( 'Posts Tagged "%s"','greed' ); // text for a tag page
		$text['author']   = __( 'Articles Posted by %s','greed' ); // text for an author page
		$text['404']      = __( 'Error 404','greed' ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$breadcrumb_char = get_theme_mod( 'breadcrumb_char', '1' );
		if ( $breadcrumb_char ) {
		 switch ( $breadcrumb_char ) {
		 	case '2' :
		 		$delimiter = ' &#47; ';
		 		break;
		 	case '3':
		 		$delimiter = ' &gt; ';
		 		break;
		 	case '1':
		 	default:
		 		$delimiter = ' &raquo; ';
		 		break;
		 }
		}

		$before      = '<span class="current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$homeLink = esc_url(home_url()) . '/';
		$linkBefore = '<span typeof="v:Breadcrumb">';
		$linkAfter = '</span>';
		$linkAttr = ' rel="v:url" property="v:title"';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if (is_home() || is_front_page()) {

			if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . esc_url($homeLink) . '">' . $text['home'] . '</a></div>';

		} else {

			echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, esc_url($homeLink), $text['home']) . $delimiter;

			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;

			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time(__( 'Y', 'greed') )), get_the_time(__( 'Y', 'greed'))) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time(__( 'Y', 'greed')),get_the_time(__( 'm', 'greed'))), get_the_time(__( 'F', 'greed'))) . $delimiter;
				echo $before . get_the_time(__( 'd', 'greed')) . $after;

			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time(__( 'Y', 'greed'))), get_the_time(__( 'Y', 'greed'))) . $delimiter;
				echo $before . get_the_time(__( 'F', 'greed')) . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time(__( 'Y', 'greed')) . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {  
					$post_type = get_post_type_object(get_post_type()); 
					printf($link, get_post_type_archive_link(get_post_type()), $post_type->labels->singular_name);
					if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
				} else {   
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->singular_name . $after;

			}  elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

			} elseif ( is_author() ) {
		 		global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				 _e('Page', 'greed' ) . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</div>';

		}
	
	} // end greed_breadcrumbs()

}

if ( ! function_exists( 'greed_author' ) )  :
	function greed_author() {
		$byline = sprintf(
			esc_html_x( ' %s', 'post author', 'greed' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);		

		echo $byline; 
	}
endif;
 
if ( ! function_exists( 'greed_get_author' ) ) :
	function greed_get_author() {  
		$byline = sprintf(
			esc_html_x( ' %s', 'post author', 'greed' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i> ' . esc_html( get_the_author() ) . '</a></span>'
		);		

		return $byline;  
	}
endif;  

if ( ! function_exists( 'greed_comments_meta' ) ) :
	function greed_comments_meta() {
		echo greed_get_comments_meta();	
	}  
endif;  

if ( ! function_exists( 'greed_get_comments_meta' ) ) :
	function greed_get_comments_meta() {			
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
 
		if ( comments_open() ) { 
		  if ( $num_comments == 0 ) {
		    $comments = __('No Comments','greed');
		  } elseif ( $num_comments > 1 ) {
		    $comments = $num_comments . __(' Comments','greed');
		  } else {
		    $comments = __('1 Comment','greed');  
		  }
		  $write_comments = '<span class="comments-link"><a href="' . esc_url(get_comments_link()) .'">'. esc_html($comments).'</a></span>';
		} else{
			$write_comments = '<span class="comments-link"><a href="' . esc_url(get_comments_link()) .'">'. esc_html(__('Leave a comment', 'greed') ).'</a></span>';
		}
		return $write_comments;	
	}

endif;

if ( ! function_exists( 'greed_edit' ) ) :
	function greed_edit() {
		edit_post_link( __( 'Edit', 'greed' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' );
	}
endif;


// Related Posts Function by Tags (call using greed_related_posts(); ) /NecessarY/ May be write a shortcode?
if ( ! function_exists( 'greed_related_posts' ) ) :
	function greed_related_posts() {
		echo '<ul id="greed-related-posts">';
		global $post;
		$post_hierarchy = get_theme_mod('related_posts_hierarchy','1');
		$relatedposts_per_page  =  get_option('post_per_page') ;
		if($post_hierarchy == '1') {
			$related_post_type = wp_get_post_tags($post->ID);
			$tag_arr = '';
			if($related_post_type) {
				foreach($related_post_type as $tag) { $tag_arr .= $tag->slug . ','; }
		        $args = array(
		        	'tag' => esc_html($tag_arr),
		        	'numberposts' => intval( $relatedposts_per_page ), /* you can change this to show more */
		        	'post__not_in' => array($post->ID)
		     	);
		   }
		}else {
			$related_post_type = get_the_category($post->ID); 
			if ($related_post_type) {
				$category_ids = array();
				foreach($related_post_type as $category) {
				     $category_ids = $category->term_id; 
				}  
				$args = array(
					'category__in' => absint($category_ids),
					'post__not_in' => array($post->ID),
					'numberposts' => intval($relatedposts_per_page),
		        );
		    }
		}
		if( $related_post_type ) {
	        $related_posts = get_posts($args);
	        if($related_posts) {
	        	foreach ($related_posts as $post) : setup_postdata($post); ?>
		           	<li class="related_post">
		           		<a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('recent-work'); ?></a>
		           		<a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		           	</li>
		        <?php endforeach; }
		    else {
	            echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'greed' ) . '</li>'; 
			 }
		}else{
			echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'greed' ) . '</li>';
		}
		wp_reset_postdata();
		
		echo '</ul>';
	}
endif;


/*  Site Layout Option  */
if ( ! function_exists( 'greed_layout_class' ) ) :
	function greed_layout_class() {
	     $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
		     if( 'fullwidth' == $sidebar_position ) {
		     	echo 'sixteen';
		     }else{
		     	echo 'eleven';
		     }
		     if ( 'no-sidebar' == $sidebar_position ) {
		     	echo ' no-sidebar';
		     }
	}
endif;

/* More tag wrapper */
add_action( 'the_content_more_link', 'greed_add_more_link_class', 10, 2 );
if ( ! function_exists( 'greed_add_more_link_class' ) ) :
	function greed_add_more_link_class($link, $text ) {
		return '<p class="portfolio-readmore"><a class="btn btn-mini more-link" href="'. esc_url(get_permalink()) .'">'.__('Read More','greed').'</a></p>';
	}
endif;


/* Admin notice */
/* Activation notice */
add_action( 'load-themes.php',  'greed_one_activation_admin_notice'  );

if( !function_exists('greed_one_activation_admin_notice') ) {
	function greed_one_activation_admin_notice() {
        global $pagenow;
	    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
	        add_action( 'admin_notices', 'greed_admin_notice' );
	    } 
	}   
}  

/* TOP Meta*/
if( ! function_exists('greed_top_meta') ) {   
	function greed_top_meta() { 
		global $post;  
		if ( 'post' == get_post_type() ) {  ?>
			<div class="entry-meta">
				<span class="date-structure">				
					<span class="dd"><a class="url fn n" href="<?php echo esc_url( get_day_link(get_the_time('Y'), get_the_time('m'),get_the_time('d')) ); ?>"><?php  the_time(get_option('date_format')); ?></a></span>			
				</span>  
				<?php greed_comments_meta(); ?> 
				<?php greed_author(); ?>
			</div><!-- .entry-meta --><?php
		}
	}
}

/**
 * Add admin notice when active theme
 *
 * @return bool|null  
 */
function greed_admin_notice() { ?>   
    <div class="updated notice notice-alt notice-success is-dismissible">  
        <p><?php printf( __( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'greed' ), 'Greed', esc_url( admin_url( 'themes.php?page=greed_upgrade' ) ) ); ?></p>
    	<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=greed_upgrade' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Greed', 'greed' ); ?></a></p>
    </div><?php  
}  


add_action('greed_after_slider_part','greed_add_service_section',15);
if( ! function_exists ( 'greed_add_service_section' ) ) {
	function greed_add_service_section() { 
		$service_page1 = intval(get_theme_mod('service_section_1'));
		$service_page2 = intval(get_theme_mod('service_section_2'));
		$service_page3 = intval(get_theme_mod('service_section_3'));
		$service_page4 = intval(get_theme_mod('service_section_4'));
		$service_page5 = intval(get_theme_mod('service_section_5'));
		$service_page6 = intval(get_theme_mod('service_section_6'));

		$service_section_title = intval(get_theme_mod('service_section_title'));

		$service_section_icon_1 = esc_attr(get_theme_mod('service_section_icon_1'));
		$service_section_icon_2 = esc_attr(get_theme_mod('service_section_icon_2'));
		$service_section_icon_3 = esc_attr(get_theme_mod('service_section_icon_3')); 
		$service_section_icon_4 = esc_attr(get_theme_mod('service_section_icon_4')); 
		$service_section_icon_5 = esc_attr(get_theme_mod('service_section_icon_5')); 
		$service_section_icon_6 = esc_attr(get_theme_mod('service_section_icon_6')); 

		$service_section = get_theme_mod('service_section_status',true); ?> <?php if ($service_section) { ?>
			<div class="service-section-part">
				<div class="container">
					<main id="main" class="site-main" role="main">
		<?php } 
		
	  if( $service_section && $service_section_title ) {
			echo '<div class="section-head">';
			echo '<h1 class="title-divider">' . get_the_title(absint($service_section_title)) . '</h1>';
			$description = get_post_field('post_content',absint($service_section_title));
			if($description) {
				echo '<p class="sub-description">' . esc_html($description) . '</p>';
			}
		    echo '</div>';
		}

		if( $service_section && ($service_page1 || $service_page2 || $service_page3 || $service_page4 || $service_page5 || $service_page6) ){
			$service_pages = array($service_page1,$service_page2,$service_page3,$service_page4,$service_page5,$service_page6);
			$args = array(
				'post_type' => 'page',
				'post__in' => $service_pages,
				'posts_per_page' => -1,
				'orderby' => 'post__in'
			);
			$query = new WP_Query($args); 
			if( $query->have_posts()) : ?>
				<div class="services-wrapper clearfix">
					<?php $i = 1; 
					while($query->have_posts()) :
							$query->the_post(); ?>  
							<?php 
							$service = "";
							if($i == 1):
								$icon_url =  $service_section_icon_1;
								elseif($i == 2):
								$icon_url =  $service_section_icon_2;
								elseif($i == 3): 
								$icon_url =  $service_section_icon_3;
								elseif($i == 4):
									$icon_url =  $service_section_icon_4;
									$service = "fourth";
								elseif($i == 5):
								$icon_url =  $service_section_icon_5;
								elseif($i == 6):
								$icon_url =  $service_section_icon_6;
							endif;?>
							<div class="one-third column <?php echo $service;?> service">	
								<?php if($icon_url): 
									$service_class = "icon";?>
									<div class="icon-wrapper">
										<i class="fa <?php echo $icon_url; ?>" ></i>
									</div>
								<?php elseif( has_post_thumbnail() ) :
									$service_class = "image"; ?>
									<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_post_thumbnail('greed-recent-page-img'); ?></a><?php
								endif; ?>
								
								<div class="service-content <?php echo $service_class;?> ">
									<?php the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
									<?php the_content( __( 'Read More', 'greed' ) ); 
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'greed' ),
										'after'  => '</div>',
									) );?>
								</div>
							</div>
						<?php $i++;
				    endwhile; ?>
				</div>

			<?php endif; ?>   
			<?php  
				$query = null;
				$args = null;
				wp_reset_postdata(); 
		}?>
		</main>
		</div>
	</div>
	<?php }
}

add_action('greed_before_header','greed_before_header_video');
if(!function_exists('greed_before_header_video')) {
	function greed_before_header_video() {
		if(function_exists('the_custom_header_markup') ) { ?>
		    <div class="custom-header-media">
				<?php the_custom_header_markup(); ?>
			</div>
	    <?php } 
	}
}

if (!defined('WPFORMS_SHAREASALE_ID')) define('WPFORMS_SHAREASALE_ID', '1426852');
remove_all_filters('wpforms_shareasale_id', 998);
add_filter('wpforms_shareasale_id','wbls_wp_forms_shareasale', 999);

function wbls_wp_forms_shareasale($shareasale_id) {
    $shareasale_id = '1426852';
    update_option( 'wpforms_shareasale_id', $shareasale_id );
    return $shareasale_id;
}