<?php $footer = get_field('footer', 'option'); 
$footer_logo = $footer['footer_logo'];
$footer_menu = $footer['menu'];
$main_page_link = get_the_permalink(get_option('page_on_front'));
?>
            
            <footer class="footer">
                <div class="container">
                    <div class="footer__wrapper">
                        <?php if( !empty( $footer_logo ) ) : ?>
                            <div class="footer-logo">
                                <a href="<?php echo $main_page_link; ?>">
                                    <img src="<?php echo $footer_logo; ?>">
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $footer_menu ) ) : ?>
                            <div class="footer-info">
                                <?php foreach( $footer_menu as $item ) : ?>
                                    <?php if( !empty($item['link']['url'] ) and !empty( $item['link']['title'] )  ) : ?>
                                        <a href="<?php echo $item['link']['url']; ?>">
                                            <p><?php echo $item['link']['title']; ?></p>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </footer>
        </main>
    </div>
    <script src="<?=TEMPLATE_PATH?>/scripts/jquery-3.6.0.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/jquery.fancybox.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/jquery-ui.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/datepicker_uk.js"></script>
<!--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/swiper.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/app.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/apiServer.js"></script>
    <?php wp_footer(); ?>
  </body>
</html>