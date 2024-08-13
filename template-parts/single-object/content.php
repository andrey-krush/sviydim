<?php 

class Single_Object_Content {

    public function __construct() {

        $this->title = get_the_title();

        $this->settlement_name = get_post_meta(get_the_ID(), 'settlement_name')[0];
        $settlement_id = get_post_meta(get_the_ID(), 'settlement_id')[0];
        $this->region_name = get_post_meta(get_the_ID(), 'region_name')[0];
        $region_id = get_post_meta(get_the_ID(), 'region_id')[0];
        $this->area_name = get_post_meta(get_the_ID(), 'area_name')[0];
        $area_id = get_post_meta(get_the_ID(), 'area_id')[0];
        $this->street = get_post_meta(get_the_ID(), 'street')[0];
        $this->building_number = get_post_meta(get_the_ID(), 'building_number')[0];

        $this->main_page_link = get_the_permalink(get_option('page_on_front'));
        $this->content = apply_filters( 'the_content', get_the_content() );
        $this->post_thumbnail = get_the_post_thumbnail_url();

        $this->database_link = get_post_type_archive_link('object');
        $this->database_link_with_settlement = get_post_type_archive_link('object') . '?area=' . $area_id . '&region=' . $region_id . '&settlement=' . $settlement_id;

        $this->object_type = get_terms(array(
            'taxonomy' => 'object_type',
            'object_ids' => array( get_the_ID() )
        ))[0]; 
        
        $this->object_type_name = $this->object_type->name;
        $this->object_type_icon = get_field( 'category_icon', 'object_type_' . $this->object_type->term_id );
            
        $post_info = get_field('post_info');
        $this->slider = $post_info['slider'];
        $this->slider_rectangle = $post_info['slider_rectangle'];
        $this->is_rectangle = $post_info['slider_choose'];
        
        $this->post_date = get_the_date('d.m.Y');
        $this->ruin_date = month_localization(date("F", strtotime($post_info['ruin_date']) )) . ' ' . date("Y", strtotime($post_info['ruin_date']) );
        $this->related_stories = $post_info['related_posts'];
    }

    public function render() { 
        ?>

        <section class="base-damages-one-post">
            <div class="container">
                <div class="base-damages-header">
                    <div class="base-damages-header__wrapper">
                        <strong class="desc">База пошкодженого та знищеного внаслідок бойових дій майна</strong>
                        <strong class="mobile">база зруйнованого</strong>
                        <div class="navigator">
                        <strong><a href="<?php echo $this->main_page_link; ?>">головна</a> / <a href="<?php echo $this->database_link; ?>">база зруйнованого</a> / <a href="<?php echo $this->database_link_with_settlement; ?>"><?php echo $this->settlement_name; ?></a></strong>
                        </div>
                    </div>
                    <strong>Тут ви можете знайти інформацію, фото та відео зруйнованих повністю або частково житла, підприємств, закладів, об’єктів інфраструктури</strong>
                </div>
                <div class="base-damages-one-post__main">
                    <?php if( !$this->is_rectangle and !empty( $this->slider ) ) : ?>
                        <div class="base-damages-one-post__img">
                            <?php if( count( $this->slider ) == 1 ) : ?>
                                <img src="<?php echo $this->slider[0]['image']; ?>">
                            <?php else : ?>
                                <div class="base-damages-slider swiper" id="slider1">
                                    <div class="swiper-wrapper">
                                        <?php foreach( $this->slider as $item ) : ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo $item['image']; ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-button-prev-damages1" id="slider2">
                                        <svg>
                                        <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next-damages1" id="slider3">
                                        <svg>
                                        <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div thumbsSlider="" class="swiper base-damages-gallery" id="slider4">
                                    <div class="swiper-wrapper">
                                        <?php foreach( $this->slider as $item ) : ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo $item['image']; ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-button-prev-gallery" id="slider5">
                                        <svg>
                                        <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next-gallery" id="slider6">
                                        <svg>
                                        <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif( $this->is_rectangle and !empty( $this->slider_rectangle ) ) : ?>
                        <div class="article__img">
                            <?php if( count( $this->slider_rectangle ) == 1 ) : ?>
                                <div class="base-damages-slider swiper">
                                    <img src="<?php echo $this->slider_rectangle[0]['image']; ?>">
                                </div>
                            <?php else : ?>
                                <div class="base-damages-slider swiper" id="slider1">
                                    <div class="swiper-wrapper">
                                        <?php foreach( $this->slider_rectangle as $item ) : ?>
                                            <div class="swiper-slide">
                                                <img src="<?php echo $item['image']; ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-button-prev-damages1" id="slider2">
                                        <svg>
                                            <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next-damages1" id="slider3">
                                        <svg>
                                            <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div thumbsSlider="" class="swiper base-damages-gallery" id="slider4">
                                    <div class="swiper-wrapper">
                                        <?php foreach( $this->slider_rectangle as $item ) : ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $item['image']; ?>" />
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <div class="swiper-button-prev-gallery" id="slider5">
                                        <svg>
                                            <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next-gallery" id="slider6">
                                        <svg>
                                            <use xlink:href="#app__arrow-slider-main"></use>
                                        </svg>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                   
                    <div class="base-damages-card">
                        <div class="base-damages-card__wrapper">
                        <div class="card-title">
                            <?php if( !empty( $this->object_type_icon ) ) : ?>
                                <div class="icon">
                                    <img src="<?php echo $this->object_type_icon; ?>" />
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $this->object_type_name ) ) : ?>
                                <strong><?php echo $this->object_type_name ?></strong>
                            <?php endif; ?>
                            <?php if( !wp_is_mobile() ) : ?>
                                <h1><?php echo $this->title; ?></h1>
                            <?php endif; ?>
                        </div>
                        <div class="card-info">
                            <div class="card-info__wrapper">
                                <?php if( !empty( $this->ruin_date ) and ( $this->ruin_date !==  'січень 1970' ) ) : ?>
                                    <h4>Дата руйнування: </h4>
                                    <p><?php echo $this->ruin_date; ?></p>
                                <?php endif; ?>
                                <h4>Дата публікації:</h4>
                                <p><?php echo $this->post_date; ?></p>
                            </div>
                            <div class="card-info__line"></div>
                                <div class="card-info__wrapper">
                                    <h4>Адреса:</h4>
                                    <?php if( !empty( $this->area_name  ) ) : ?>
                                        <p><?php echo $this->area_name; ?> область
                                    <?php endif; ?>
                                    <?php if( !empty( $this->region_name  ) ) : ?>
                                        , <?php echo $this->region_name; ?> район
                                    <?php endif; ?>
                                    <?php if( !empty( $this->settlement_name ) ) : ?>
                                        , <?php echo $this->settlement_name; ?>
                                    <?php endif; ?>
                                <?php if( !empty( $this->street ) ) : ?>
                                    , <p>вул. <?php echo $this->street; ?>
                                    <?php if( !empty( $this->building_number ) ) : ?>
                                        , <?php echo $this->building_number; ?>
                                    <?php endif; ?>
                                </p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if( !$this->is_rectangle and !empty( $this->slider ) ) : ?>
                        <div class="slider-history1 swiper" id="slider-history">
                            <div class=" slider-history__wrapper swiper-wrapper">
                                <?php foreach( $this->slider as $item ) : ?>
                                    <div class="slider-history__slide swiper-slide ">
                                        <a class="list-cards__card ">
                                        <div class="card-img">
                                            <img src="<?php echo $item['image']; ?>" />
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
                    <?php elseif( $this->is_rectangle and !empty( $this->slider_rectangle ) ) : ?>
                        <div class="slider-history1 swiper" id="slider-history">
                            <div class=" slider-history__wrapper swiper-wrapper">
                                <?php foreach( $this->slider_rectangle as $item ) : ?>
                                    <div class="slider-history__slide swiper-slide ">
                                        <a class="list-cards__card ">
                                        <div class="card-img">
                                            <img src="<?php echo $item['image']; ?>" />
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
                    <?php endif; ?>
                    <div class="article-info">
                        <div class="card-info">
                        <?php if( !empty( $this->object_type_icon ) ) : ?>
                            <div class="icon">
                                <img src="<?php echo $this->object_type_icon; ?>" />
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $this->object_type_name ) ) : ?>
                            <p><?php echo $this->object_type_name ?></p>
                        <?php endif; ?>
                        </div>
                        <?php if( wp_is_mobile() ) : ?>
                            <h2><?php echo $this->title; ?></h2>
                        <?php endif; ?>
                        <?php if( !empty( $this->ruin_date ) and ( $this->ruin_date !==  'січень 1970' ) ) : ?>
                            <h4>Дата руйнування: </h4>
                            <p><?php echo $this->ruin_date; ?></p>
                        <?php endif; ?>
                        <h4>Дата публікації:</h4>
                        <p><?php echo $this->post_date; ?></p>
                        <div class="line"></div>
                        <h4>Адреса:</h4>
                        <?php if( !empty( $this->area_name  ) ) : ?>
                            <p><?php echo $this->area_name; ?> область
                        <?php endif; ?>
                        <?php if( !empty( $this->region_name  ) ) : ?>
                            , <?php echo $this->region_name; ?> район
                        <?php endif; ?>
                        <?php if( !empty( $this->settlement_name ) ) : ?>
                            , <?php echo $this->settlement_name; ?>
                        <?php endif; ?>
                        <?php if( !empty( $this->street ) ) : ?>
                           <span> / </span><p>вул. <?php echo $this->street; ?>
                            <?php if( !empty( $this->building_number ) ) : ?>
                                , <?php echo $this->building_number; ?>
                            <?php endif; ?>   
                        <?php endif; ?>
                    </div>
                </div>
                <div class="base-damages_info">
                    <?php if( !empty( $this->content ) ) : ?>
                        <div class="base-damages_info__video">
                            <?php echo $this->content; ?>
                        </div>
                    <?php endif; ?>
                    <?php if( !empty( $this->related_stories ) ) : ?>
                        <div class="base-damages_info__history">
                            <h3>Пов’язані історії</h3>
                            <div class="another-history">
                            <?php foreach( $this->related_stories as $item ) : ?>
                                <?php $building_type = ''; ?>
                                <a href="<?php echo get_the_permalink($item); ?>" class="list-cards__card">
                                    <?php $post_thumbnail = get_the_post_thumbnail_url($item); ?>
                                    <?php if( !empty( $post_thumbnail ) ) : ?>
                                        <div class="card-img">
                                            <img src="<?php echo $post_thumbnail; ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <?php $building_type = get_terms(array(
                                        'taxonomy' => 'building_type',
                                        'object_ids' => array( $item )
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
                                    <h3><?php echo get_the_title( $item ); ?></h3>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php
    }
}