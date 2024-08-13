<?php /*  Template name: Contacts page */ ?>
<?php 
get_header();
(new Contacts_Page_Content())->render();
get_footer(); 
?>