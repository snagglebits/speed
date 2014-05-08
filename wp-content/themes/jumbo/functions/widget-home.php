<?php dynamic_sidebar('slider');
if (function_exists('dynamic_sidebar') && is_active_sidebar('homepage')) : ?>
	<div id="widget-block" class="clearfix">
		<ul class="widget-list clearfix" id="home_page_downs">
			<?php dynamic_sidebar('homepage'); ?>
		</ul>
		<?php if( is_active_sidebar('homepage-secondary') ) : // Sidebar 2 Column ?>
			<ul class="widget-list clearfix" id="home_page_sides">
				<?php dynamic_sidebar('homepage-secondary'); ?>
			</ul>
		<?php endif; ?>
		<?php if( is_active_sidebar('homepage-threecol') ) : // Sidebar 3 Column ?>
			<ul class="widget-list clearfix" id="home_page_three_column">
				<?php dynamic_sidebar('homepage-threecol'); ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endif; ?>