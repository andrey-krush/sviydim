<?php

class Theme_Option {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_add_options_page' ] );
        add_action( 'acf/init', [ __CLASS__, 'acf_add_local_field_group' ] );
    }

    public static function acf_add_options_page() {

        if ( ! function_exists('acf_add_options_page') ) return;

        acf_add_options_page(array(
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));

    }
    
    public static function acf_add_local_field_group() {
    
    }

}