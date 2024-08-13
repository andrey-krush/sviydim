<?php 

class Archive_Object_Content {

    public function __construct() {

        global $wpdb;

        $this->areas = $wpdb->get_results( "SELECT * FROM wp_areas ORDER BY name ");

        $this->main_page_link = get_the_permalink(get_option('page_on_front'));
        $this->database_link = get_post_type_archive_link('object');

        $this->object_types = get_terms(array(
            'taxonomy' => 'object_type',
	        'hide_empty' => true,
        ));

        $args = array(
            'post_type' => 'object',
            'post_status' => 'publish',
            'posts_per_page' => 12,        
        );

        $this->paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
        $args['paged'] = $this->paged;

        $args['meta_query']['relation'] = 'AND'; 
        if( isset( $_GET['area'] ) ) :
            $this->post_place_info['area_id']  = $_GET['area'];
            $this->post_place_info['area_name'] = $wpdb->get_results(" SELECT Name FROM wp_areas WHERE ID=".$_GET['area']." ")[0]->Name;
            $args['meta_query'][] = array(
                'key' => 'area_id',
                'value' => $_GET['area'],
            ); 
        endif;

        if( isset( $_GET['region'] ) ) : 
          $this->post_place_info['region_id']  = $_GET['region'];
          $this->post_place_info['region_name'] = $wpdb->get_results(" SELECT Name FROM wp_regions WHERE ID=".$_GET['region']." ")[0]->Name;
            $args['meta_query'][] = [
                'key' => 'region_id',
                'value' => $_GET['region']
            ]; 
        endif;

        if( isset( $_GET['settlement'] ) ) :
            $settlement = $wpdb->get_results(" SELECT Name, Ref FROM wp_settlements WHERE ID=".$_GET['settlement']." ");
            $this->post_place_info['settlement_id'] = $_GET['settlement'];
            $this->post_place_info['settlement_name'] = $settlement[0]->Name;
            $this->post_place_info['settlement_ref'] = $settlement[0]->Ref;
            $args['meta_query'][] = [
                'key' => 'settlement_id',
                'value' => $_GET['settlement']
            ]; 
        endif;

        if( isset( $_GET['street'] ) ) : 
            $this->post_place_info['street'] = $_GET['street'];
            $args['meta_query'][] = [
                'key' => 'street',
                'value' => $_GET['street']
            ]; 
        endif;

        if( isset( $_GET['number'] ) ) : 
            $this->post_place_info['building_number'] = $_GET['number'];
            $args['meta_query'][] = [
                'key' => 'building_number',
                'value' => $_GET['number']
            ]; 
        endif;

        if( isset( $_GET['start_date'] ) and isset( $_GET['end_date'] ) ) :
            $this->post_place_info['start_date'] =  $_GET['start_date'];
            $this->post_place_info['end_date'] =  $_GET['end_date'];

            $start_date = date("Y-m-d", strtotime($_GET['start_date']) );
            $end_date = date("Y-m-d", strtotime($_GET['end_date']) );

            $args['meta_query'][] = [
                'key' => 'post_info_ruin_date',
                'value' => array($start_date, $end_date),
                'compare' => 'BETWEEN',
                'type' => 'DATE',
            ];
        elseif( isset( $_GET['start_date'] ) and !isset( $_GET['end_date'] )  ) : 
            $this->post_place_info['start_date'] =  $_GET['start_date'];

            $start_date = date("Y-m-d", strtotime($_GET['start_date']) );
            $args['meta_query'][] = [
                'key' => 'post_info_ruin_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE',
            ];
        elseif( !isset( $_GET['start_date'] ) and isset( $_GET['end_date'] ) ) : 
            $this->post_place_info['end_date'] =  $_GET['end_date'];

            $end_date = date("Y-m-d", strtotime($_GET['end_date']) );
            $args['meta_query'][] = [
                'key' => 'post_info_ruin_date',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE',
            ];
        endif;

        if( isset( $_GET['build_type'] ) ) :
            $this->post_place_info['build_type'] = $_GET['build_type'];
            $args['tax_query'][] = [
                'taxonomy' => 'object_type',
                'field' => 'slug',
                'terms' => $_GET['build_type'],
            ];
        endif;

        if(  $_GET['sort_type'] == 'dp' ) :
            
            $args['orderby'] = 'date';
            if( $_GET['sort_lay'] == 'down' ) : 
                $args['order'] = 'DESC';
            else:   
                $args['order'] = 'ASC';
            endif;

        elseif( $_GET['sort_type'] == 'dr' ) :

            $args['orderby'] =  'meta_value';
	        $args['meta_key'] = 'post_info_ruin_date';

            if( $_GET['sort_lay'] == 'down' ) : 
                $args['order'] = 'DESC';
            else:   
                $args['order'] = 'ASC';
            endif;

        endif;

        ?>
        <script>let post_place_info = '<?php echo json_encode($this->post_place_info); ?>';</script>
        <?php

        $this->query = new WP_Query($args);
        

    }

    public function render() {
        ?>
        
        <section class="base-damages">
            <div class="container">
                <div class="base-damages-header">
                    <div class="base-damages-header__wrapper">
                        <?php if( !wp_is_mobile() ) : ?>
                            <h1 class="desc">База пошкодженого та знищеного внаслідок бойових дій майна</h1>
                        <?php else : ?>
                            <h1 class="mobile">база зруйнованого</h1>
                        <?php endif; ?>
                        <div class="navigator">
                        <h5><a href="<?php echo $this->main_page_link; ?>">головна</a> <span>/</span> база зруйнованого</h5>
                        </div>
                    </div>
                    <h4>Тут ви можете знайти інформацію, фото та відео зруйнованих повністю або частково житла, підприємств, закладів, об’єктів інфраструктури</h4>
                </div>
                <div class="base-damages-search" >
                    <div class="base-damages-search__wrapper">
                        <form id="base-dameges" class="form-objects" data-page_link="<?php echo $this->database_link; ?>" >
                        <div class="base-title">
                            <h2>Знайти об‘єкти</h2>
                            <?php if( $this->query->found_posts < 99 and $this->query->found_posts != 0 ) : ?>
                                <div class="count-posts">
                                    <h5><?php echo $this->query->found_posts; ?></h5>
                                </div>
                            <?php elseif( $this->query->found_posts == 0 ) : ?>
                                <div class="count-posts count-posts-error">
                                    <?php // тут червоним зробити ?>
                                    <h5>0</h5>
                                </div>
                            <?php else : ?>
                                <div class="count-posts">
                                    <h5>>99</h5>
                                </div>
                            <?php endif; ?>
                            <div class="button-primary button-clear-all">
                                <h5>очистити все</h5>
                            </div>
                        </div>
                        <div class="form-objects__inputs">
                            <div class="form-objects__inputs-wrapper">
                            <div class="base-select vw-26">
                                <label for="select-area">
                                <p>Область</p>
                                </label>
                                <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                                <select class="select2-base-damages" id="select-area" name="area" data-placeholder="введіть назву області">
                                <option></option>
                                <?php foreach( $this->areas as $item ) : ?>
                                    <option value="<?php echo $item->ID; ?>"><?php echo $item->name; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="base-select vw-25">
                                <label for="select-region">
                                    <p>Район</p>
                                </label>
                                <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
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
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
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
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                                <select class="select2-base-damages" id="select-street" name="street" data-placeholder="введіть назву вулиця">
                                    <option></option>
                                </select>
                            </div>
                            <div class="base-select vw-9">
                                <label for="select-number-home">
                                    <p>№ будинку</p>
                                </label>
                                <input type="text" id="select-number-home" name="number"/>
                            </div>
                            </div>
                            <div class="form-objects__inputs-wrapper">
                            <div class="base-select vw-30">
                                <label for="select-type">
                                <p>Тип будови</p>
                                </label>
                                <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                                <select class="select2-base-damages" id="select-type" name="build_type" data-placeholder="всі типи будови">
                                <option></option>
                                <?php foreach( $this->object_types as $item ) : ?>
                                    <option value="<?php echo $item->slug; ?>"><?php echo $item->name; ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="datepicker1">
                                <p>Ймовірний період руйнування</p>
                            </label>
                            <div class="base-datapicker">
                                <div class="base-datapicker_one">
                                <input type="text" readonly id="datepicker1" name="start_date" class="calendar" placeholder="з">
                                </div>
                                <div class="base-datapicker_one">
                                <input type="text" readonly id="datepicker2" name="end_date" class="calendar" placeholder="до">
                                </div>
                            </div>
                            </div>
                            <div class="form-objects__inputs-button">
                            <button class="button-three button-base-dameges text-button-bold">
                                <h4>застосувати</h4>
                            </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="base-damages-article">
                    <div class="article">
                        <div class="article-header">
                            <?php if( $this->query->found_posts > 0 ) : ?>
                                <h2>Результатів: <?php echo $this->query->found_posts; ?></h2>
                            <?php else : ?>
                                <h2 style="color: red">За цими параметрами об'єктів не знайдено</h2>
                            <?php endif; ?>
                            <div class="date-publish">
                                <select class="select2-data-publich" name="date-publish" data-placeholder="дата публікації">
                                    <option value="dp">дата публікації</option>
                                    <option value="dr">дата руйнування</option>
                                </select>

                                <?php if( $_GET['sort_lay'] == 'down' ) : ?>
                                    <?php $up_class = 'date-publish-button';?>
                                    <?php $down_class = 'date-publish-button active'; ?>
                                <?php elseif( $_GET['sort_lay'] == 'up' ) : ?>
                                    <?php $up_class = 'date-publish-button active';?>
                                    <?php $down_class = 'date-publish-button'; ?>
                                <?php elseif( !isset( $_GET['sort_lay'] ) ) : ?>
                                    <?php $up_class = 'date-publish-button';?>
                                    <?php $down_class = 'date-publish-button active'; ?>
                                <?php endif; ?>

                                <div class="<?php echo $down_class; ?>" id="date-publish-down">
                                    <svg>
                                        <use xlink:href="#app__arrow-up"></use>
                                    </svg>
                                </div>
                                <div class="<?php echo $up_class; ?>" id="date-publish-up">
                                    <svg>
                                        <use xlink:href="#app__arrow-up"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <?php if ( $this->query->have_posts() ) : ?>
                            <div class="article__wrapper">
                                <?php while ( $this->query->have_posts() ) : $this->query->the_post(); ?>
                                    <a href="<?php echo get_the_permalink(); ?>" class="list-cards__card">
                                        <div class="card-img">
                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" />
                                        </div>
                                        <div class="card-info">
                                        <?php 
                                        $object_type = get_terms(array(
                                                'taxonomy' => 'object_type',
                                                'hide_empty' => true,
                                                'childless' => true,
                                                'object_ids' => array( get_the_ID() )
                                            ))[0]; 
                                        ?>
                                            <?php if( !empty( $object_type ) ) : ?>
                                                <?php $object_type_icon = get_field('category_icon', 'object_type_' . $object_type->term_id); ?>
                                                <?php if( !empty( $object_type_icon ) ) : ?>
                                                    <div class="icon">
                                                        <img src="<?php echo $object_type_icon; ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <p><?php echo $object_type->name; ?></p>
                                            <?php endif;?>
                                            <h3><?php echo get_the_title(); ?></h3>
                                        </div>
                                    </a>
                                <?php endwhile; ?>
                                <div class="help-pagination">
                                <?php echo paginate_links(array(
                                            'total' => $this->query->max_num_pages,
                                            'current' => $this->paged,
                                            'prev_text' => '<svg width="6" height="12" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 13L7 7L1 1" stroke="#465558" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>',
                                            'next_text' => '<svg width="6" height="12" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 13L7 7L1 1" stroke="#465558" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>',
                                            'end_size' => 1,
                                            'mid_size' => 1,
                                        )); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php 
    }

}