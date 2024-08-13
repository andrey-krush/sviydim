<?php get_header(); ?>
<?php ( new Taxonomy_Tag_Sidebar_Section() )->render();?>
<?php ( new Taxonomy_Tag_Posts_Section() )->render();?>

<?php get_footer(); ?>