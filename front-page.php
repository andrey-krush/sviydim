<?php get_header(); ?>
<?php (new Front_Page_Slider_Section() )->render(); ?>   
<?php (new Front_Page_Tell_Your_Story() )->render(); ?>
<?php (new Front_Page_Stories_You_Told() )->render(); ?>
<?php (new Front_Page_Base_Damage() )->render(); ?>
<?php (new Front_Page_Rebuilt_Posts() )->render(); ?>
<?php (new Front_Page_Help_Posts() )->render(); ?>
<?php (new Front_Page_Last_Added() )->render(); ?>
<?php get_footer(); ?>