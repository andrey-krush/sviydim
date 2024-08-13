<?php

class Author_Page_Content {

    public function __construct() {
        
        $author_object = get_queried_object();
        $author_info = get_field('author_info', 'user_' . $author_object->data->ID);
        $this->author_link = get_author_posts_url($author_object->data->ID);

        $this->title = 'Усі матеріали';

        if( $_GET['filter'] == 'object' ) : 
            $this->title = 'База зруйнованого';
        elseif( $_GET['filter'] == 'stories' ) : 
            $this->title = 'Історії';
        elseif( $_GET['filter'] == 'rebuilt' ) : 
            $this->title = 'Відбудовано';
        elseif( $_GET['filter'] == 'help' ) : 
            $this->title = 'Допомога';
        endif;


        $this->author_name = $author_object->data->display_name;
        $this->author_image = $author_info['author_image'];
        $this->description_title = $author_info['description_title'];
        $this->description_text = $author_info['description_text'];
        $this->facebook_link = $author_info['facebook_link'];
        $this->instagram_link = $author_info['instagram_link'];
        $this->tiktok_link = $author_info['tiktok_link'];
        $this->user_role_display = $author_info['user_role_display'];

        global $wp_query;           
        $this->query = $wp_query;
        $this->paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        
        
    }

    public function render() {
        ?>

            <section class="author">
                <div class="container">
                    <div class="author__wrapper">
                        <div class="author-category" data-url-author="<?php echo $this->author_link; ?>">
                            <h3>Категорії</h3>
                            <div class="author-category__one" data-name="">
                            <p>усі матеріали</p>
                            </div>
                            <div class="author-category__one" data-name="stories">
                            <p>історії</p>
                            </div>
                            <div class="author-category__one" data-name="rebuilt">
                            <p>відбудова</p>
                            </div>
                            <div class="author-category__one" data-name="object">
                            <p>база зруйнованого</p>
                            </div>
                            <div class="author-category__one" data-name="help">
                            <p>допомога</p>
                            </div>
                        </div>
                        <?php if( $this->query->have_posts() ) : ?>
                            <div class="author-result">
                                <h2><?php echo $this->title; ?></h2>
                                    <div class="filter-big text-button-slim">
                                    <svg>
                                        <use xlink:href="#app__filter"></use>
                                    </svg> фільтр
                                    </div>
                                    <?php if( wp_is_mobile() ) : ?>
                                        <div class="author-result__list-mobile">
                                            <?php while( $this->query->have_posts() ) : $this->query->the_post(); ?>
                                                <?php $story_type =''; ?>
                                                <div class="line"></div>
                                                <a href="<?php echo get_the_permalink(); ?>" class="author-result-mobile__one">
                                                <?php if( 'object' == get_post_type( get_the_ID() ) ) : ?>
                                                    <h5>база зруйнованого</h5>
                                                <?php else : ?>
                                                    <?php $story_type = get_terms( array(
                                                        'taxonomy' => 'story_type',
                                                        'object_ids' => array( get_the_ID() )
                                                    ) )[0]; ?>
                                                <?php endif; ?>
                                                <?php if( !empty( $story_type ) ) : ?>
                                                    <h5><?php echo $story_type->name; ?></h5>
                                                <?php endif; ?>
                                                <h3><?php echo get_the_title(); ?></h3>
                                                </a>
                                            <?php endwhile; ?>
                                            <div class="line"></div>
                                        </div>
                                    <?php else : ?>
                                        <div class="author-result__list">
                                            <?php while( $this->query->have_posts() ) : $this->query->the_post(); ?>
                                                <?php $story_type =''; ?>
                                                <a href="<?php echo get_the_permalink(); ?>" class="author-result__one">
                                                    <?php if( 'object' == get_post_type( get_the_ID() ) ) : ?>
                                                        <h5>база зруйнованого</h5>
                                                    <?php else : ?>
                                                        <?php $story_type = get_terms( array(
                                                            'taxonomy' => 'story_type',
                                                            'object_ids' => array( get_the_ID() )
                                                        ) )[0]; ?>
                                                    <?php endif; ?>
                                                    <?php if( !empty( $story_type ) ) : ?>
                                                        <h5><?php echo $story_type->name; ?></h5>
                                                    <?php endif; ?>
                                                    <h4><?php echo get_the_title(); ?></h4>
                                                </a>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
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
                        <?php else : ?>
                            <div class="author-result">
                                <h2>За цими параметрами постів не знайдено</h2>
                            </div>
                        <?php endif; ?>
                        <div class="author-info">
                            <div class="author-info__bg"></div>
                            <div class="author-info__about">
                            <?php if( !empty( $this->author_image ) ) :  ?>
                                <div class="avatar">
                                    <img src="<?php echo $this->author_image; ?>" />
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $this->author_name ) ) : ?>
                                <h2><?php echo $this->author_name; ?></h2>
                            <?php endif; ?>
                            <?php if( !empty( $this->user_role_display ) ) : ?>
                                <h3><?php echo $this->user_role_display;  ?></h3>
                            <?php endif; ?>
                            <div class="line"></div>
                            <?php if( !empty( $this->description_title ) ) : ?>
                                <h4><?php echo $this->description_title; ?></h4>
                            <?php endif; ?>
                            <?php if( !empty( $this->description_text ) ) : ?>
                                <p><?php echo $this->description_text; ?></p>
                            <?php endif; ?>
                            <h4>Соцмережі</h4>
                            <div class="header-social">
                                <?php if( !empty( $this->facebook_link ) ) : ?>
                                    <a class="header-social__icon" href="<?php echo $this->facebook_link; ?>" target="_blank">
                                    <svg>
                                        <use xlink:href="#app__icon-facebook"></use>
                                    </svg>
                                    </a>
                                <?php endif; ?>
                                <?php if( !empty( $this->instagram_link ) ) : ?>
                                    <a class="header-social__icon" href="<?php echo $this->instagram_link; ?>" target="_blank">
                                    <svg>
                                        <use xlink:href="#app__icon_instagram"></use>
                                    </svg>
                                    </a>
                                <?php endif; ?>
                                <?php if( !empty( $this->tiktok_link ) ) : ?>
                                    <a class="header-social__icon" href="<?php echo $this->tiktok_link; ?>" target="_blank">
                                    <svg>
                                        <use xlink:href="#app__icon-tik"></use>
                                    </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="modal-history">
                        <div class="modal-bg"></div>
                        <div class="modal__wrapper">
                        <div class="main-search-filter__mobile">
                            <form class="filter-form" id="filter-form" data-url-author="https://dev.sviydim.sheep.fish/author/admin/">
                                <label class="radio-container">
                                <p>усі матеріали</p>
                                <input type="radio" checked="checked" name="filter" value="">
                                <span class="checkmark"></span>
                                </label>
                                <label class="radio-container">
                                <p>історії</p>
                                <input type="radio" name="filter" value="stories">
                                <span class="checkmark"></span>
                                </label>
                                <label class="radio-container">
                                <p>відбудова</p>
                                <input type="radio" name="filter" value="rebuilt">
                                <span class="checkmark"></span>
                                </label>
                                <label class="radio-container">
                                <p>допомога</p>
                                <input type="radio" name="filter" value="help">
                                <span class="checkmark"></span>
                                </label>
                                <label class="radio-container">
                                <p>база зруйнованого</p>
                                    <input type="radio" name="filter" value="object">
                                    <span class="checkmark"></span>
                                </label>
                                <button class="button-primary button-search text-button-bold">
                                <h4>застосувати</h4>
                                </button>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </section>

        <?php
    }

}