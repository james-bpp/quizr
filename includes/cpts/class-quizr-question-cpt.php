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
            array( $this, 'render_question_set_meta_box'),
            static::CPT_NAME,
            'side',
            'default'
        );
    }

    public function render_question_set_meta_box( $post ){

        $question_sets = get_posts( 
            array(
                'post_type' => 'quizr_question_set'
            )
        );

      //  print_r( $question_sets );

         ?>

            <select id="quizr_question_set_id" name="quizr_question_set_id" class="widefat">
               <option value=""></option>
               <?php foreach( $question_sets as $qs){ ?>
                    <option value="<?php echo esc_html( $qs->ID); ?>" ><?php echo esc_html( $qs->post_title); ?></option>
               <?php } ?>
            </select>

        <?php
    }

    public function save_custom_meta_data( $id ){
        echo '<pre>';
        print_r( $_POST );
        echo '</pre>';

        $post_data = sanitize_post( $_POST );
        
        if( array_key_exists( 'quizr_question_set_id', $post_data) ){
            update_post_meta( $id, 'quizr_question_set_id', $post_data['quizr_question_set_id']);
        }
        die();
    }

}