<?php 

class Search_Page_Latest_Stories {

    public function __construct() {

        $this->query = new WP_Query(array(
            'post_type' => 'building',
            'posts_per_page' => 4,
            'tax_query' => array(
                array(
                    'taxonomy' => 'story_type',
                    'field' => 'slug',
                    'terms' => array( 'stories' )
                )
            )
        ));
        $this->stories_link = get_term_link( 'stories', 'story_type' );
    }

    public function render() {
        ?>
            <?php if( $this->query->have_posts() ) : ?>
                <section class="main-history" style="background: #F1F3F4">
                    <div class="container">
                        <div class="main-history__wrapper">
                            <div class="history-title history-title-last">
                                <h2>Останні додані історії</h2>
                                    <a href="<?php echo $this->stories_link; ?>">
                                    <p>всі історії</p>
                                </a>
                            </div>
                            <div class="slider-history swiper slider-3 last-add-wrapper-swiper" id="slider-3">
                                <div class=" slider-history__wrapper swiper-wrapper last-add-wrapper">
                                    <?php while( $this->query->have_posts() ) : $this->query->the_post(); ?>
                                    <div class="slider-history__slide swiper-slide ">
                                        <a href="<?php echo get_the_permalink(); ?>" class="list-cards__card ">
                                            <?php $post_thumbnail = get_the_post_thumbnail_url(); ?>
                                            <?php if( !empty( $post_thumbnail ) ) : ?>
                                                <div class="card-img">
                                                    <img src="<?php echo $post_thumbnail; ?>" />
                                                </div>
                                            <?php endif; ?>
                                            <?php $building_type = get_terms(array(
                                                'taxonomy' => 'building_type',
                                                'object_ids' => array( get_the_ID() )
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
                                                <h3><?php echo get_the_title(); ?></h3>
                                            </div>
                                        </a>
                                </div>
                                    <?php endwhile; ?>
                                </div>
                                <div class="swiper-pagination slider-3__swiper-pagination"></div>
                            </div>
                            <!-- <div class="history-button">
                                <a href="#" class="button-secondary">
                                <p class="text-button-bold">показати ще</p>
                                </a>
                            </div> -->
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php
    }
}