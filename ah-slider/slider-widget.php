<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use WP_Query;

class SliderWidget extends Widget_Base {

    public function get_name() {
        return 'slider-widget';
    }

    public function get_title() {
        return 'Video Slider Widget';
    }

    public function get_icon() {
        return 'eicon-photo-library';
    }

    public function get_keywords() {
        return ['ah', 'video', 'slider'];
    }

    public function get_categories() {
        return [ 'ah-category' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'blur_slides',
            [
                'label' => __( 'Slides', 'elementor' ),
            ]
        );

        $this->add_control( 'ah-slides', [
            'label' => __( 'Add your slides', 'my-listing' ),
            'type' => Controls_Manager::REPEATER,
            'fields' =>
                [
                    [
                        'name' => 'slide-img',
                        'label' => __( 'Image', 'ah-theme' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'options' => [],
                    ],
                    [
                        'name'        => 'title',
                        'label'       => __( 'Title', 'ah-theme' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => '',
                        'label_block' => true,
                    ],
                    [
                        'name'        => 'description',
                        'label'       => __( 'Description', 'ah-theme' ),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => '',
                        'label_block' => true,
                    ],
                    [
                        'name'        => 'url',
                        'label'       => __( 'Video URL', 'ah-theme' ),
                        'type'        => Controls_Manager::URL,
                        'default'   => [
                            'url'   => ''
                        ],
                        'label_block' => true,
                    ],
                ],
            'default' => [],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if( !empty($settings['ah-slides']) ): ?>
        <!-- Swiper -->
        <div class="widgetTagControl swiper mySwiper cu-slider-sw videoswiper">
            <div class="swiper-wrapper">
                <?php foreach ( $settings['ah-slides'] as $k => $slide ): ?>
                <div class="swiper-slide">
                    <div class="video-side-cu">
                        <a class="popup-video" href="<?=$slide['url']['url']?>">
                            <img class="main-slider-img-cu" src="<?=$slide['slide-img']['url']?>" alt="">
                            <img class="play-icon-cu" height="85" src="<?=plugins_url('assets/images/play-button.png', __FILE__)?>" alt="<?=$slide['title']?>">
                        </a>
                    </div>
                    <div class="text-side-cu">
                        <h3 class="slider-header-cu avgu"><?=$slide['title']?></h3>
                        <p class="glamode"><?=$slide['description']?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        </div>
        <?php endif; ?>

        <script>
            jQuery(document).ready(function($) {
                new Swiper(".mySwiper", {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
                $('.videoswiper a.popup-video').each(function(index, element) {
                    let href = $(element).attr('href');
                    $(element).magnificPopup({
                        items: {src: href},
                        type: 'iframe'
                    });
                });
            });
        </script>

        <?php
    }

    protected function _content_template() {

    }
}
