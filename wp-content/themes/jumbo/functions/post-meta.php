<?php
// Meta Arguments
if(!is_page()) :
	$social = get_option("ocmx_meta_social_post");
	$tags = get_option("ocmx_meta_tags");
	$social_code = get_option("ocmx_social_tag");
else :
	$social = get_option("ocmx_meta_social_page");
endif;

if(isset($tags) && $tags !="false" || $social != "false") : ?>
	<ul class="post-meta">
		<?php if( isset($tags) && $tags != "false" ) : // Show tags if enabled in Theme Options ?>
			<li class="meta-block tags">
				<ul>
					<?php the_tags('<li>Tags &raquo;</li><li>','</li><li>','</li>'); ?>
				</ul>
			</li>
		<?php endif; ?>
		<?php if(isset($social_code) && $social_code !="" ) : ?>
			<span class="social"><?php echo get_option("ocmx_social_tag"); ?></span>
		<?php elseif( $social != "false" ) : // Show sharing if enabled in Theme Options ?>
			<li class="meta-block social">
				<!-- AddThis Button BEGIN : Customize at http://www.addthis.com -->
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-507462e4620a0fff"></script>
				<!-- AddThis Button END -->
			</li>
		<?php endif; ?>
	</ul>
	<?php if(!is_page() && get_option( "ocmx_meta_post_links" ) != "false" ) : //Show the Post Nav unless unchecked in Theme Options ?>            
        <ul class="next-prev-post-nav">
            <li>
                <?php if ( get_adjacent_post( false, '', true ) ): // if there are older posts ?>
                    &larr;  <span><?php previous_post_link("%link", "%title"); ?></span>
                <?php else : ?>
                    &nbsp;
                <?php endif; ?>
            </li>
            <li>
                <?php if ( get_adjacent_post( false, '', false ) ): // if there are newer posts ?>
                    <span><?php next_post_link("%link", "%title"); ?></span> &rarr;
                <?php else : ?>
                    &nbsp;
                <?php endif; ?>    
            </li>
        </ul>
    <?php endif; ?>
<?php endif; ?>