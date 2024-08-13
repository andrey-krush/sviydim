<?php 

class Front_Page_Slider_Section {

    public function __construct() {
        $this->slider = get_field('slider_section')['posts']; 
    }

    public function render() {
        ?>
    <?php if( !empty( $this->slider ) ) : ?>
        <section class="main-slider">
            <div class="container">
                <div class="swiper-container">
                <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php foreach( $this->slider as $item ) : ?>
                            <a href="<?php echo get_the_permalink($item); ?>" class="swiper-slide main-swiper-slide">
                                <?php $post_thumbnail = get_the_post_thumbnail_url($item); ?>
                                <?php if( !empty( $post_thumbnail ) ) : ?>
                                    <div class="swiper-slide__img">
                                        <img src="<?php echo $post_thumbnail; ?>" />
                                    </div>
                                <?php endif; ?>
                                <div class="slide-info">
                                    <?php $building_type = get_terms( array(
                                        'taxonomy' => 'building_type',
                                        'object_ids' => array( $item )
                                    ) )[0]; ?>
                                    <?php if( !empty( $building_type ) ) : ?>
                                        <?php $building_type_icon = get_field( 'category_icon', 'building_type_' . $building_type->term_id ); ?>
                                        <?php if( !empty( $building_type_icon ) ) : ?>
                                            <div class="slide-info__icon">
                                                <img src="<?php echo $building_type_icon; ?>">
                                            </div>
                                        <?php endif; ?>
                                        <p><?php echo $building_type->name; ?></p>
                                    <?php endif;?>
                                    <h2><?php echo get_the_title($item); ?></h2>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev-main ">
                        <svg>
                        <use xlink:href="#app__arrow-slider-main"></use>
                        </svg>
                    </div>
                    <div class="swiper-button-next-main">
                        <svg>
                        <use xlink:href="#app__arrow-slider-main"></use>
                        </svg>
                    </div>
                    <div class="swiper-pagination swiper-pagination-main"></div>
                    <div class="swiper-counter">
                        <h2></h2>
                        <h4></h4>
                    </div>
                </div>
                <div class="main-slider-mobile">
                    <div class="slider-history2 swiper" id="slider-history2">
                    <div class=" slider-history__wrapper swiper-wrapper">
                    <?php foreach( $this->slider as $item ) : ?>
                        <div class="slider-history__slide swiper-slide ">
                            <a href="<?php echo get_the_permalink($item); ?>" class="list-cards__card ">
                                <div class="card-img">
                                    <img src="<?php echo get_the_post_thumbnail_url($item); ?>" />
                                </div>
                                <div class="card-info">
                                <?php $building_type = get_terms( array(
                                    'taxonomy'   => 'building_type',
                                    'object_ids' => array( $item )
                                ) )[0]; ?>
                                <?php if( !empty( $building_type ) ) : ?>
                                    <?php $building_type_icon = get_field( 'category_icon', 'building_type_' . $building_type->term_id ); ?>
                                    <?php if( !empty( $building_type_icon ) ) : ?>
                                        <div class="icon">
                                            <img src="<?php echo $building_type_icon; ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endif;?>
                                    <p><?php echo $building_type->name; ?></p>
                                <h3><?php echo get_the_title($item); ?></h3>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                        <div class="swiper-button-prev-main-mobile">
                            <svg>
                                <use xlink:href="#app__arrow-slider-main"></use>
                            </svg>
                        </div>
                        <div class="swiper-button-next-main-mobile">
                            <svg>
                                <use xlink:href="#app__arrow-slider-main"></use>
                            </svg>
                        </div>
                        <div class="swiper-pagination slider-history__swiper-pagination "></div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
        <?php
    }

}
