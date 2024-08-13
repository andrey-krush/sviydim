<?php /*  Template name: Questions page */ ?>

<?php 
get_header(); 
(new Questions_Page_Content())->render(); 
get_footer(); 
?>