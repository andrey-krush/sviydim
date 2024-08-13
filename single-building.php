<?php get_header(); ?>
<?php (new Single_Building_Content() )->render(); ?>
<?php (new Single_Building_Related_Posts() )->render(); ?>
<?php get_footer(); ?>