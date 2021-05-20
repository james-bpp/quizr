<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Quizr_Settings_Api {

    public function register_settings(){
        register_setting(
            'quizr_options_group',
            'quizr_max_answers_per_question',
            array( 'type' => 'string', 'sanitize_callback' => 'santize_text_field' )
        );

        register_setting(
            'quizr_options_group',
            'quizr_show_cpt_question_in_menu',
            array( 'type' => 'string', 'sanitize_callback' => 'santize_text_field' )
        );
    }

    public function register_options_page(){

    }

    public function render_options_page(){

    }

    public function add_plugin_page_settings_link( $links ){

    }



}