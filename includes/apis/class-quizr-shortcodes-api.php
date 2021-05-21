<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Quizr_Shortcodes_Api {

    public function render_quizr_question_set_html( $atts, $content = null ){

        $a = shortcode_atts(
            array( 'id' => -1 ), $atts
        );

        print_r( $a );

        return '<p>This is a shortcode</p>';
    }

    public function register_shortcodes(){
        add_shortcode( 'quizr_question_set', array( $this, 'render_quizr_question_set_html' ) );
    }

}