<?php

class Single_Building_Content
{

    public function __construct()
    {

        $this->settlement_name = get_post_meta(get_the_ID(), 'settlement_name')[0];
        $this->region_name = get_post_meta(get_the_ID(), 'region_name')[0];
        $this->area_name = get_post_meta(get_the_ID(), 'area_name')[0];
        $this->street = get_post_meta(get_the_ID(), 'street')[0];
        $this->building_number = get_post_meta(get_the_ID(), 'building_number')[0];

        $this->main_page_link = get_the_permalink(get_option('page_on_front'));

        $story_type = get_terms(array(
            'taxonomy' => 'story_type',
            'hide_empty' => true,
            'object_ids' => array(get_the_ID())
        ))[0];

        $this->story_type_link = get_term_link($story_type->term_id, 'story_type');
        $this->story_type_name = $story_type->name;

        $building_type = get_terms(array(
            'taxonomy' => 'building_type',
            'hide_empty' => true,
            'object_ids' => array(get_the_ID())
        ))[0];

        $this->building_type_icon = get_field('category_icon', 'building_type_' . $building_type->term_id);
        $this->building_type_name = $building_type->name;

        $this->title = get_the_title();
        $this->content = apply_filters('the_content', get_the_content());
        $this->post_thumbnail = get_the_post_thumbnail_url();
        $this->permalink = get_the_permalink();
        $this->post_date = get_the_date('d.m.Y');

        $this->post_date_mobile = get_the_date('d') . ' ' . month_localization(date("F", strtotime(get_the_date('d.m.Y')))) . ' ' . get_the_date('Y');

        $post_info = get_field('post_info');
        $this->slider_images = $post_info['slider_images'];
        $this->slider_images_rectangle = $post_info['slider_images_rectangle'];
        $this->is_rectangle = $post_info['slider_choose'];

        $this->ruin_date = month_localization(date("F", strtotime($post_info['ruin_date']))) . ' ' . date("Y", strtotime($post_info['ruin_date']));

        $this->tags = get_the_terms( get_the_ID(), 'building_tag' );

        $author_id = get_post_field('post_author');
        $this->author_name = get_the_author_meta('display_name', $author_id);
        $this->author_link = get_author_posts_url($author_id);

    }

    public function render()
    {
        ?>

        <section class="article-page article">
            <div class="container">
                <div class="article-page__header">
                    <strong><?php echo $this->story_type_name; ?></strong>
                    <p><a href="<?php echo $this->main_page_link; ?>">головна</a>
                        <span>/</span> <a
                                href="<?php echo $this->story_type_link; ?>"><?php echo $this->story_type_name; ?></a>
                        <?php if (!empty($this->settlement_name)) : ?>
                            <span>/</span> <?php echo $this->settlement_name; ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="article-page__header-mobile">
                    <strong><?php echo $this->story_type_name; ?></strong>
                </div>
                <div class="article-page__wrapper article">
                    <div class="article__main">
                        <?php if (!$this->is_rectangle and !empty($this->slider_images)) : ?>

                            <?php if (count($this->slider_images) == 1) : ?>
                                <div class="article__img-single">
                                    <img src="<?php echo $this->slider_images[0]['image']; ?>">
                                </div>
                            <?php else : ?>
                                <div class="article__img">
                                    <div class="base-damages-slider swiper" id="slider1">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($this->slider_images as $item) : ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $item['image']; ?>"/>
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
                                            <?php foreach ($this->slider_images as $item) : ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $item['image']; ?>"/>
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
                                </div>
                            <?php endif; ?>

                        <?php elseif ($this->is_rectangle and !empty($this->slider_images_rectangle)) : ?>


                            <?php if (count($this->slider_images_rectangle) == 1) : ?>
                                <div class="base-damages-single">
                                    <img src="<?php echo $this->slider_images_rectangle[0]['image']; ?>">
                                </div>
                            <?php else : ?>
                                <div class="base-damages-one-post__img">
                                    <div class="base-damages-slider swiper " id="slider1">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($this->slider_images_rectangle as $item) : ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $item['image']; ?>"/>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="swiper-button-prev-damages1 " id="slider2">
                                            <svg>
                                                <use xlink:href="#app__arrow-slider-main"></use>
                                            </svg>
                                        </div>
                                        <div class="swiper-button-next-damages1 " id="slider3">
                                            <svg>
                                                <use xlink:href="#app__arrow-slider-main"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div thumbsSlider="" class="swiper base-damages-gallery " id="slider4">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($this->slider_images_rectangle as $item) : ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo $item['image']; ?>"/>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="swiper-button-prev-gallery " id="slider5">
                                            <svg>
                                                <use xlink:href="#app__arrow-slider-main"></use>
                                            </svg>
                                        </div>
                                        <div class="swiper-button-next-gallery " id="slider6">
                                            <svg>
                                                <use xlink:href="#app__arrow-slider-main"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>


                        <?php endif; ?>
                        <div class="base-damages-card">
                            <div class="base-damages-card__wrapper">
                                <div class="card-title">
                                    <?php if (!empty($this->building_type_icon)) : ?>
                                        <div class="icon">
                                            <img src="<?php echo $this->building_type_icon; ?>"/>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($this->building_type_name)) : ?>
                                        <strong><?php echo $this->building_type_name; ?></strong>
                                    <?php endif; ?>
                                    <?php if (!wp_is_mobile()) : ?>
                                        <h1><?php echo $this->title; ?></h1>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="base-damages-card__info">
                                <?php if (!empty($this->ruin_date) and ($this->ruin_date !== 'січень 1970')) : ?>
                                <h5>зруйновано: <?php echo $this->ruin_date; ?> <span>/</span>
                                    <?php else : ?>
                                    <h5>
                                        <?php endif; ?>
                                        <?php if (!empty($this->area_name)) : ?>
                                            <?php echo $this->area_name; ?> область
                                        <?php endif; ?>
                                        <?php if (!empty($this->region_name)) : ?>
                                            , <?php echo $this->region_name; ?> район
                                        <?php endif; ?>
                                        <?php if (!empty($this->settlement_name)) : ?>
                                            , <?php echo $this->settlement_name; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($this->street)) : ?>
                                            <span>/</span> <?php echo $this->street; ?>
                                            <?php if (!empty($this->building_number)) : ?>
                                                , <?php echo $this->building_number; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </h5>
                            </div>
                        </div>
                    </div>
                    <div class="slider-history1 swiper" id="slider-history">
                        <div class=" slider-history__wrapper swiper-wrapper">
                            <!--                     list-cards-->
                            <?php foreach ($this->slider_images as $item) : ?>
                                <div class="slider-history__slide swiper-slide ">
                                    <a class="list-cards__card ">
                                        <div class="card-img">
                                            <img src="<?php echo $item['image']; ?>"/>
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
                    <div class="article-info">
                        <div class="card-info">
                            <?php if (!empty($this->building_type_icon)) : ?>
                                <div class="icon">
                                    <img src="<?php echo $this->building_type_icon; ?>"/>
                                </div>
                            <?php endif; ?>
                            <p><?php echo $this->building_type_name; ?></p>
                        </div>
                        <?php if (wp_is_mobile()) : ?>
                            <h1><?php echo $this->title; ?></h1>
                        <?php endif; ?>
                        <?php if (!empty($this->ruin_date) and ($this->ruin_date !== 'січень 1970')) : ?>
                            <h4>Дата руйнування: </h4>
                            <p><?php echo $this->ruin_date; ?></p>
                        <?php endif; ?>
                        <h4>Дата додавання до бази:</h4>
                        <p><?php echo $this->post_date_mobile; ?></p>
                        <div class="line"></div>
                        <h4>Адреса:</h4>
                        <?php if (!empty($this->area_name)) : ?>
                        <p><?php echo $this->area_name; ?> область
                            <?php endif; ?>
                            <?php if (!empty($this->region_name)) : ?>
                            ,
                        <p> <?php echo $this->region_name; ?> район
                            <?php endif; ?>
                            <?php if (!empty($this->settlement_name)) : ?>
                                , <?php echo $this->settlement_name; ?>
                            <?php endif; ?>
                            <?php if (!empty($this->street)) : ?>
                            ,
                        <p><?php echo $this->street; ?>
                            <?php if (!empty($this->building_number)) : ?>
                                , <?php echo $this->building_number; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="article-page-card">
                    <div class="article-page-card__wrapper">
                        <?php echo $this->content; ?>
                        <div class="article-page__footer">
                            <p><a href="<?php echo $this->author_link; ?>"><?php echo $this->author_name; ?></a>
                                <span>/</span> <?php echo $this->post_date; ?></p>
                            <?php if (!empty($this->tags) and is_user_logged_in() ) : ?>
                                <p>
                                    <?php foreach ($this->tags as $key => $item) : ?>
                                        <?php if ($key == 0) : ?>
                                            <?php echo $item->name; ?>
                                        <?php else : ?>
                                            <span>/</span><?php echo $item->name; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="article-share">
                        <h4>поділитись у соцмережах</h4>
                        <div class="header-social">
                            <a class="header-social__icon"
                               href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>"
                               target="_blank">
                                <svg>
                                    <use xlink:href="#app__icon-facebook"></use>
                                </svg>
                            </a>
                            <a class="header-social__icon"
                               href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_the_permalink(); ?>"
                               target="_blank">
                                <svg width="26" height="25" viewBox="0 0 26 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_2884_11077)">
                                        <path d="M0.0623501 0L10.1007 13.7878L0 25H2.27318L11.1165 15.1836L18.2608 25H25.9974L15.3979 10.4356L24.7998 0H22.5266L14.3821 9.03971L7.79896 0H0.0623501ZM3.40588 1.72147H6.95983L22.6539 23.2812H19.1025L3.40588 1.72147Z"
                                              fill="#465558"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_2884_11077">
                                            <rect width="26" height="25" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <div class="header-social__icon copy_link"
                                 data-copy_link="<?php echo get_the_permalink(); ?>">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.5 10H5C3.62125 10 2.5 11.1212 2.5 12.5V25C2.5 26.3787 3.62125 27.5 5 27.5H17.5C18.8787 27.5 20 26.3787 20 25V12.5C20 11.1212 18.8787 10 17.5 10Z"
                                          fill="#465558"/>
                                    <path d="M25 2.5H12.5C11.837 2.5 11.2011 2.76339 10.7322 3.23223C10.2634 3.70107 10 4.33696 10 5V7.5H20C20.663 7.5 21.2989 7.76339 21.7678 8.23223C22.2366 8.70107 22.5 9.33696 22.5 10V20H25C25.663 20 26.2989 19.7366 26.7678 19.2678C27.2366 18.7989 27.5 18.163 27.5 17.5V5C27.5 4.33696 27.2366 3.70107 26.7678 3.23223C26.2989 2.76339 25.663 2.5 25 2.5Z"
                                          fill="#465558"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}