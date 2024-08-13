<?php get_header(); ?>
<?php ( new Archive_Object_Content() )->render(); ?>
<?php ( new Archive_Object_Related_Posts() )->render(); ?>
<?php get_footer(); ?>