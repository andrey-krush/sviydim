<?php get_header(); ?>
<?php ( new Taxonomy_Story_Page_Filters_Section() )->render();?>
<?php ( new Taxonomy_Story_Page_Posts_Section() )->render();?>
                
<?php get_footer(); ?>       