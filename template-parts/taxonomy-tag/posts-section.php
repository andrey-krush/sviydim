<?php

class Taxonomy_Tag_Posts_Section {

    public function __construct() {

        global $wpdb;

        $args = array(
            'post_type' => 'building',
            'post_status' => 'publish',
            'posts_per_page' => 12,
        );

        $this->paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args['paged'] = $this->paged;

        $args['tax_query'][] = [
            'taxonomy' => 'building_tag',
            'field' => 'slug',
            'terms' => get_queried_object()->slug,
        ];

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
            $settlement = $wpdb->get_results(" SELECT Name FROM wp_settlements WHERE ID=".$_GET['settlement']." ");
            $this->post_place_info['settlement_id'] = $_GET['settlement'];
            $this->post_place_info['settlement_name'] = $settlement[0]->Name;
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
                'taxonomy' => 'building_type',
                'field' => 'slug',
                'terms' => $_GET['build_type'],
            ];
            $args['tax_query']['relation'] = 'AND';
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
        $this->query = new WP_Query( $args );

    }

    public function render() {
        ?>

        <div class="article">
            <div class="article-header">
                <h2>Результатів: <?php echo $this->query->found_posts; ?></h2>
                <div class="filter-big text-button-slim">
                    <svg>
                        <use xlink:href="#app__filter"></use>
                    </svg> фільтр
                </div>
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
                                $build_type = get_terms(array(
                                    'taxonomy' => 'building_type',
                                    'hide_empty' => true,
                                    'childless' => true,
                                    'object_ids' => array( get_the_ID() )
                                ))[0];
                                ?>
                                <?php if( !empty( $build_type ) ) : ?>
                                    <?php $build_type_icon = get_field('category_icon', 'building_type_' . $build_type->term_id); ?>
                                    <?php if( !empty( $build_type_icon ) ) : ?>
                                        <div class="icon">
                                            <img src="<?php echo $build_type_icon; ?>">
                                        </div>
                                    <?php endif; ?>
                                    <p><?php echo $build_type->name; ?></p>
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
        <div class="modal" id="modal-history">
            <div class="modal-bg"></div>
            <div class="modal__wrapper">
            </div>
        </div>
        </div>
        </section>

        <?php

    }
}