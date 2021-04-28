<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Quizr_Question_Set_Cpt {

    const CPT_NAME = 'quizr_question_set';

    public function register_custom_post_type(){

        register_post_type( static::CPT_NAME, array(
            'labels' => array(
                'name' => __( 'Quizr Question Sets', 'quizr' ),
                'singular' => __( 'Quizr Question Set', 'quizr' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'thumbnail' )
        ) );

    }

}