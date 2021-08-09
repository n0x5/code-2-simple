<?php get_header(); ?>
<div id="wrapper">



<body <?php body_class(); ?>>
<section class="content">
	
	
<?php if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>

<h2> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php the_time('F jS, Y') ?></h2>

<?php the_content('-> read more'); ?>

<?php endwhile; ?>
<?php endif; ?>
</section>

<?php get_sidebar(); ?>
<div id="nav">
<?php next_posts_link(__('&laquo; Previous Entries', 'code-2')) ?><br>
<?php previous_posts_link(__('Newer Entries &raquo;','code-2')); ?>
</div>
</div>

<?php get_footer(); ?>
