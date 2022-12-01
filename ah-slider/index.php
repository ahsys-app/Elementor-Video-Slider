<?php
/*
Plugin Name: AH Video Slider
Plugin URI: devAspect.com
description: Video slider with text
Version: 1.0
Author: abdullah Mosa
Author URI: ahsys.app@gmail.com
License:
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\SliderWidget;
use Elementor\Plugin;

add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet', 99999);

function prefix_add_my_stylesheet() {
    //CSS
    wp_register_style( 'ah-swiper', plugins_url('assets/swiper/swiper-bundle.css', __FILE__) );
    wp_register_style( 'ah-style', plugins_url('assets/css/style.css', __FILE__) );
    wp_enqueue_style( 'ah-swiper');
    wp_enqueue_style( 'ah-style');
    //JS
    wp_enqueue_script('ah-script', plugins_url('assets/swiper/swiper-bundle.min.js', __FILE__) , null, wp_get_theme()->get( 'Version' ), true);
}

function ah_elementor_init(){
    Plugin::instance()->elements_manager->add_category('ah-category', ['title' => 'AH Video Slider', 'icon' => 'font'], 1);
}
add_action('elementor/init', 'ah_elementor_init');

class My_Elementor_Widgets
{

    protected static $instance = null;

    public static function get_instance(){
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct(){
        require_once('slider-widget.php');
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }

    public function register_widgets(){
        Plugin::instance()->widgets_manager->register_widget_type(new SliderWidget());
    }

}
function my_elementor_init(){
    My_Elementor_Widgets::get_instance();
}
add_action('init', 'my_elementor_init');
