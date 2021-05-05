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

        $meta_value = get_post_meta( $post->ID, 'quizr_question_set_id', true);

        wp_nonce_field( 'quizr_question_set_id_nonce', 'quizr_question_set_id_nonce_' . $post->ID);

         ?>
        <div class="quizr-select-group-flex">
            <select id="quizr_question_set_id" name="quizr_question_set_id" class="widefat">
               <option value=""></option>
               <?php foreach( $question_sets as $qs){ ?>
                    <option 
                        value="<?php echo esc_html( $qs->ID); ?>" 
                        <?php echo (int) $qs->ID === (int) $meta_value ? 'selected="selected"' : ''; ?>
                    >
                    <?php echo esc_html( $qs->post_title); ?></option>
               <?php } ?>
            </select>
            <a href="<?php echo get_edit_post_link( $meta_value ); ?>" 
                class="button button-secondary">View</a>
        </div>

        <?php
    }

    public function save_custom_meta_data( $id ){

        global $post;

        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
            return $id;
        }

        if( ! current_user_can( 'edit_post', $id ) ){
            return $id;
        }

        if( ! is_object( $post ) ) return;

        if( $post->post_type !== static::CPT_NAME ) return;

        $post_data = sanitize_post( $_POST );

        if( isset( $post_data['quizr_question_set_id_nonce_'. $id]) && wp_verify_nonce( $post_data['quizr_question_set_id_nonce_' . $id], 'quizr_question_set_id_nonce') ){
            if( array_key_exists( 'quizr_question_set_id', $post_data) ){
                update_post_meta( $id, 'quizr_question_set_id', $post_data['quizr_question_set_id']);
            }
        }
    
    }

}