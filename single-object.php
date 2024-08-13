<?php get_header(); ?>
<?php (new Single_Object_Content() )->render(); ?>
<?php (new Single_Object_Related_Posts() )->render(); ?>        
<?php get_footer(); ?>