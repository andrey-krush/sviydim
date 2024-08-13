<?php /*  Template name: Search page */ ?>
<?php get_header(); ?>
<?php (new Search_Page_Search_Section() )->render(); ?>
<?php (new Search_Page_Latest_Stories() )->render(); ?>        
<?php get_footer(); ?>