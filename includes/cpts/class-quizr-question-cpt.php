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
                'show_in_menu' => true
            )
        );

    }

    public function add_meta_boxes(){

        add_meta_box(
            'quizr-question-set',
            __( 'Question Set', 'quizr' ),
            function( $post ){

                ?>
                    <p>This is a meta box</p>
                <?php

            },
            static::CPT_NAME,
            'side',
            'default'


        );

    }

}