<?php

if ( ! defined('ABSPATH') ) exit;

class Quizr_Question_Cpt {


    const CPT_NAME = 'quizr_question';

    public function register_custom_post_type(){

        register_post_type( static::CPT_NAME, 
            array(
                'labels' => array(
                    'name' => __( 'Questions', 'quizr' ),
                    'singular_name' => __( 'Question', 'quizr' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );

    }

}