<?php

define( 'TEMPLATE_PATH', get_template_directory_uri() );

require_once __DIR__ .'/includes/theme/autoloader.php';
Theme_AutoLoader::init();

add_theme_support('post-thumbnails');

function building_place_meta_box() {
    add_meta_box('building_place_meta_box', 'Місцезнаходження будівлі', 'building_place_callback', ['building', 'object'], 'normal', 'high');
}

add_action('add_meta_boxes', 'building_place_meta_box');
function building_place_callback($post) {

    global $wpdb;

    $post_place_info['area_name'] = get_post_meta($post->ID, 'area_name')[0];
    $post_place_info['area_id']  = get_post_meta($post->ID, 'area_id')[0];
    $post_place_info['region_name']  = get_post_meta($post->ID, 'region_name')[0];
    $post_place_info['region_id']  = get_post_meta($post->ID, 'region_id')[0];
    $post_place_info['settlement_name']  = get_post_meta($post->ID, 'settlement_name')[0];
    $settlement_id  = get_post_meta($post->ID, 'settlement_id')[0];
    $post_place_info['settlement_id'] = $settlement_id;

    $post_place_info['street']  = get_post_meta($post->ID, 'street')[0];
    $post_place_info['building_number']  = get_post_meta($post->ID, 'building_number')[0];

    $post_place_info = array_filter($post_place_info);
    ?>
    
    <script> let post_place_info = '<?php echo json_encode($post_place_info); ?>';</script>
    <?php 
    $html =  '
    <form id="base-dameges1" class="form-objects">
        <div class="base-title">
            <h3>Знайти історію</h3>
        </div>
    <div class="form-objects__inputs form__input-admin">
        <div class="form-objects__inputs-wrapper wpadmin-form">
            <div class="base-select vw-26">
                <label for="select-area">
                    <p>Область</p>
                </label>
                <span class="clear-select-filter">
                     <img src="' . TEMPLATE_PATH . '/static/app/img/x.svg"/>
                </span>
                <select class="select2-base-damages" id="select-area" name="area" data-placeholder="введіть назву області">
                    <option></option>';

                $areas = $wpdb->get_results( "SELECT * FROM wp_areas");
                foreach( $areas as $item ) : 
                    $html .= '<option value="'.$item->name.'" data-id="'.$item->ID.'">'.$item->name.'</option>';
                endforeach;
    $html .= '
                </select>
            </div>
            <div class="base-select vw-25">
                <label for="select-region">
                <p>Район</p>
                </label>
                 <span class="clear-select-filter">
                        <img src="' . TEMPLATE_PATH . '/static/app/img/x.svg"/>

                 </span>
                <select class="select2-base-damages" id="select-region" name="region" data-placeholder="введіть назву району">
                <option></option>
                </select>
            </div>
            <div class="base-select vw-26">
                <label for="select-settlement">
                <p>Населений пункт</p>
                </label>
                 <span class="clear-select-filter">
                    <img src="' . TEMPLATE_PATH . '/static/app/img/x.svg"/>
                 </span>
                <select class="select2-base-damages" id="select-settlement" name="settlement" data-placeholder="введіть назву міста">
                <option></option>
                </select>
            </div>
            <div class="base-select vw-25">
                <label for="select-street">
                <p>Вулиця</p>
                </label>
                 <span class="clear-select-filter">
                      <img src="' . TEMPLATE_PATH . '/static/app/img/x.svg"/>
                 </span>
                <select class="select2-base-damages" id="select-street" name="street" data-placeholder="введіть назву вулиця">
                <option></option>
                </select>
            </div>
            <div class="base-select vw-9">
                <label for="select-number-home">
                <p>№ будинку</p>
                </label>
                 <span class="clear-select-filter">
                    <img src="' . TEMPLATE_PATH . '/static/app/img/x.svg"/>
                </span>
                <input type="text" id="select-number-home" name="number"/>
            </div>
        </div>
    </form>
    ';

    echo $html;
}


function add_building_place_meta($post_id) {


    global $wpdb;

    $area_name = str_replace( '\\' , '', $_POST['area']);
    $region_name =  str_replace( '\\', '', $_POST['region']);
    $settlement_name = str_replace( '\\', '', $_POST['settlement']);
    $street_name = str_replace( '\\', '', $_POST['street']);
    $number = $_POST['number'];


    if( !empty($_POST['area'])  ) :

        $area = $wpdb->get_results( 'SELECT ID FROM wp_areas WHERE name = "'.$area_name.'" ');
        
        if( !empty( $area ) ) : 

            $area_id = $area[0]->ID; 

        else : 
            
            $wpdb->insert( "wp_areas", array(
                'name' => $area_name
            ) );
            $area_id = $wpdb->get_results( 'SELECT ID FROM wp_areas WHERE name = "'.$area_name.'" ')[0]->ID;
        
        endif;

        update_post_meta($post_id, 'area_id', $area_id);
        update_post_meta($post_id, 'area_name', $area_name);

    elseif( isset( $_POST['area'] ) and empty( $_POST['area'] ) ) : 

        delete_metadata( 'post', $post_id, 'area_id' );
        delete_metadata( 'post', $post_id, 'area_name' );

    endif;

    if( !empty($_POST['region'])  ) :

        $regions = $wpdb->get_results( 'SELECT ID, area_id FROM wp_regions WHERE Name = "'.$region_name.'" ');
        
        if( !empty( $regions ) ) : 

            foreach( $regions as $item ) : 

                $regions_areas_ids[] = $item->area_id;

                if( $area_id == $item->area_id ) : 

                    $region_id = $item->ID; 

                endif;  

            endforeach;

            if( !in_array( $area_id, $regions_areas_ids ) ) : 

                $wpdb->insert( "wp_regions", array(
                    'Name' => $region_name,
                    'area_id' => $area_id
                ) );
                $region_id = $wpdb->get_results( 'SELECT ID FROM wp_regions WHERE Name = "'.$region_name.'" ')[0]->ID;    

            endif;

        else : 
            
            $wpdb->insert( "wp_regions", array(
                'Name' => $region_name,
                'area_id' => $area_id
            ) );
            $region_id = $wpdb->get_results( 'SELECT ID FROM wp_regions WHERE Name = "'.$region_name.'" ')[0]->ID;    
        
        endif;

        update_post_meta($post_id, 'region_id', $region_id);
        update_post_meta($post_id, 'region_name', $region_name);

    elseif( isset( $_POST['region'] ) and empty( $_POST['region'] ) ) :  

        delete_metadata( 'post', $post_id, 'region_id' );
        delete_metadata( 'post', $post_id, 'region_name' );

    endif;


    if( !empty($_POST['settlement']) ) :


        $settlements = $wpdb->get_results( 'SELECT ID, region_id FROM wp_settlements WHERE Name = "'.$settlement_name.'" ');
        if( !empty( $settlements ) ) : 

            foreach( $settlements as $item ) : 

                $settlemenets_regions_ids[] = $item->region_id;

                if( $region_id == $item->region_id ) : 

                    $settlement_id = $item->ID; 

                endif;  

            endforeach;

            if( !in_array( $region_id, $settlemenets_regions_ids ) ) : 

                $wpdb->insert( "wp_settlements", array(
                    'Name' => $settlement_name,
                    'region_id' => $region_id
                ) );
                $settlement_id = $wpdb->get_results( 'SELECT ID FROM wp_settlements WHERE Name = "'.$settlement_name.'" ')[0]->ID;    

            endif;

        else : 
            
            $wpdb->insert( "wp_settlements", array(
                'Name' => $settlement_name,
                'region_id' => $region_id
            ) );
            $settlement_id = $wpdb->get_results( 'SELECT ID FROM wp_settlements WHERE Name = "'.$settlement_name.'" ')[0]->ID;    
        
        endif;

        update_post_meta($post_id, 'settlement_id', $settlement_id);
        update_post_meta($post_id, 'settlement_name', $settlement_name);

    elseif( isset( $_POST['settlement'] ) and empty( $_POST['settlement'] ) ) : 

        delete_metadata( 'post', $post_id, 'settlement_id' );
        delete_metadata( 'post', $post_id, 'settlement_name' );

    endif;

    if( !empty($_POST['street']) ) :


        $streets = $wpdb->get_results( 'SELECT ID, settlement_id FROM wp_streets WHERE Name = "'.$street_name.'" ');
        
        if( !empty( $streets ) ) : 

            foreach( $streets as $item ) : 

                $streets_settlements_ids[] = $item->settlement_id;

                if( $settlement_id == $item->settlement_id ) : 

                    $street_id = $item->ID; 

                endif;  

            endforeach;

            if( !in_array( $settlement_id, $streets_settlements_ids ) ) :

                $wpdb->insert( "wp_streets", array(
                    'Name' => $street_name,
                    'settlement_id' => $settlement_id
                ) );

                $street_id = $wpdb->get_results( 'SELECT ID FROM wp_streets WHERE Name = "'.$street_name.'" ')[0]->ID;    

            endif;

        else : 
            
            $wpdb->insert( "wp_streets", array(
                'Name' => $street_name,
                'settlement_id' => $settlement_id
            ) );

            $street_id = $wpdb->get_results( 'SELECT ID FROM wp_streets WHERE Name = "'.$street_name.'" ')[0]->ID;  

        endif;

        update_post_meta($post_id, 'street_id', $street_id);
        update_post_meta($post_id, 'street', $street_name);

    elseif( isset( $_POST['street'] ) and empty( $_POST['street'] ) ) : 

        delete_metadata( 'post', $post_id, 'street_id' );
        delete_metadata( 'post', $post_id, 'street' );

    endif;

    if( !empty($_POST['number']) ) :
        update_post_meta($post_id, 'building_number', $number);
    elseif( isset( $_POST['number'] ) and empty( $_POST['number'] ) ) : 
        delete_metadata( 'post', $post_id, 'building_number' );
    endif;

}

add_action('save_post', 'add_building_place_meta');

function enqueue_custom_admin_script($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {

        wp_enqueue_style('custom-admin-style', get_template_directory_uri() . '/styles/app.css');
        wp_enqueue_style('custom-cdn-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
        wp_enqueue_script('admin-cdn-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '1.0', true);
        wp_enqueue_script('admin-apiServer-js', get_template_directory_uri() . '/scripts/apiServer.js', array('jquery'), '1.0', true );
        wp_enqueue_script('admin-hkkyky-js', get_template_directory_uri() . '/scripts/swiper.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script('admin-app-js', get_template_directory_uri() . '/scripts/app.js', array('jquery'), '1.0', true );


        }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_script');


function month_localization( $en_monthname ) {

    $monthnames = [
        'January' => 'січень',
        'February' => 'лютий',
        'March' => 'березень',
        'April' => 'квітень',
        'May' => 'травень',
        'June' => 'червень',
        'July' => 'липень',
        'August' => 'серпень',
        'September' => 'вересень',
        'October' => 'жовтень',
        'November' => 'листопад',
        'December' => 'грудень'
    ];

    return $monthnames[$en_monthname];
}

function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length($length){ 
    return 30; 
} 
add_filter('excerpt_length', 'new_excerpt_length');

function author_pre_get_post( $query ) {

    // if( $query->is_tax( 'story_type' ) ) : 
    //     $query->set( 'posts_per_page', 1 );
    // endif;

    if ( $query->is_author() && $query->is_main_query() ) :
        
        if( $_GET['filter'] == 'object' ) : 

            $query->set( 'post_type', array('object') );
        
        elseif( $_GET['filter'] == 'help' or $_GET['filter'] == 'rebuilt' or $_GET['filter'] == 'stories' ) :

            $query->set( 'post_type', array('building') );
            $tax_query = array(
                array(
                    'taxonomy' => 'story_type',
                    'field' => 'slug',
                    'terms' => array( $_GET['filter'] )
                )
            );
            $query->set( 'tax_query', $tax_query );

        else : 

            $query->set( 'post_type', array('building', 'object') );

        endif;  

        $query->set( 'posts_per_page', 5 );
        $query->set( 'post_status', 'publish' );
        $query->set( 'orderby', 'date' );

    endif;
}
add_action( 'pre_get_posts', 'author_pre_get_post' );

add_filter( 'allowed_http_origins', 'add_allowed_origins' );

function add_allowed_origins( $origins ) {

    $origins[] = 'https://dev.sviydim.sheep.fish';
    return $origins;
    
}

function change_rss_post_type( $query ) { 

    if( $query->is_feed() ) :
        
        $query->set( 'post_type', array( 'building' ) );
        
    endif;
}

add_filter( 'pre_get_posts', 'change_rss_post_type' );

add_action('template_redirect', 'test');

function test() {

    if( isset( $_GET['test'] ) ) :
        global $wp_query;
        var_dump(is_tax());
        var_dump($wp_query);die;
    endif;
}

