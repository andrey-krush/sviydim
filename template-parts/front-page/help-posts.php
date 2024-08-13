<?php

class Front_Page_Help_Posts {

    public function __construct() {
        
        $query = new WP_Query(array(
            'post_type' => 'building',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'tax_query' => array(
                array(
                    'taxonomy' => 'story_type',
                    'field' => 'slug',
                    'terms' => array( 'help' )
                )
            )   
        ));

        $this->help_term = get_term_by( 'slug', 'help', 'story_type');
        $this->help_term_link = get_term_link( 'help', 'story_type' );
        $this->posts = $query->posts;

    }   

    public function render() {
        ?>
        <?php if( !empty( $this->posts ) ) : ?>
            <section class="main-history">
                <div class="container">
                    <div class="main-history__wrapper">
                        <div class="history-title">
                            <h2><?php echo $this->help_term->name; ?></h2>
                            <a href="<?php echo $this->help_term_link; ?>">
                                <p>всі матеріали</p>
                            </a>
                        </div>
                        <div class="slider-history swiper slider-1" id="slider-1">
                            <div class=" slider-history__wrapper swiper-wrapper">
                            <!--                     list-cards-->
                            <?php foreach( $this->posts as $item ) : ?>
                                <div class="slider-history__slide swiper-slide ">
                                    <a href="<?php echo get_the_permalink($item->ID); ?>" class="list-cards__card ">
                                    <?php $post_thumbnail = get_the_post_thumbnail_url($item->ID); ?>
                                    <?php if( !empty( $post_thumbnail ) ) : ?>
                                        <div class="card-img">
                                            <img src="<?php echo $post_thumbnail; ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <?php $building_type = get_terms(array(
                                        'taxonomy' => 'building_type',
                                        'object_ids' => array( $item->ID )
                                    ))[0]; ?>
                                    <div class="card-info">
                                        <?php if( !empty( $building_type ) ) : ?>
                                            <?php $building_type_icon = get_field('category_icon', 'building_type_' . $building_type->term_id); ?>
                                            <?php if( !empty( $building_type_icon ) ) : ?>
                                                <div class="icon">
                                                    <img src="<?php echo $building_type_icon; ?>" />
                                                </div>
                                            <?php endif; ?>
                                            <p><?php echo $building_type->name; ?></p>
                                        <?php endif; ?>
                                        <h3><?php echo get_the_title($item->ID); ?></h3>
                                    </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="swiper-pagination slider-1__swiper-pagination "></div>
                        </div>
                        <div class="history-button">
                            <a href="<?php echo $this->help_term_link; ?>" class="button-primary button-secondary">
                                <p class="text-button-bold">всі матеріали</p>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php
    }
}