<?php
/*
 * Template Name: List Post Template
 */
get_header(); ?>

<div id="site-content" class="site-content clearfix">
	<?php 
	if ( get_query_var('paged') ) {
       $paged = get_query_var('paged');
    } else {
       $paged = 1;
    }
    $showposts = get_option('posts_per_page');

	$query = new WP_Query(
		array(
			'post_type'=>'post',  
				'post_status'=>'publish', 
				'posts_per_page'=> $showposts,
				'paged' => $paged
			)); 

		if ( $query->have_posts() ) : ?>
	  	<div id="list-post-panel">
		    <?php while ( $query->have_posts() ) : 
		       	$query->the_post(); ?>
	       		<article>
	          		<h2 class="post-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	          		<div class="post-meta">
	          			<?php
	          				printf( '<span class="post-by-author item"><a class="name" href="%1$s" title="%2$s">%3$s</a></span>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								esc_attr( sprintf( esc_html__( 'View all posts by %s', 'twentytwenty' ), get_the_author() ) ),
								get_the_author()
							);

							printf( '<span class="post-date item"><span class="entry-date">%1$s</span></span>',
								get_the_date()
							);
	          			?>
	          		</div>
	          	</article>
		        
		    <?php endwhile;

		    $total_pages = $query->max_num_pages;
		    if ($total_pages > 1){

		        $current_page = max(1, get_query_var('paged'));

		        echo paginate_links(array(
		            'base' => get_pagenum_link(1) . '%_%',
		            'format' => '/page/%#%',
		            'current' => $current_page,
		            'total' => $total_pages,
		            'prev_text'    => __('< Previous'),
		            'next_text'    => __('Next >'),
		        ));
		    } ?>
	    	<?php wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
	  	<p><?php _e( 'There no posts to display.' ); ?></p>
	<?php endif; ?>
</div><!-- /#site-content -->

<?php get_footer(); ?>
