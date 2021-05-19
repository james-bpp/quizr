<?php

if ( ! defined('ABSPATH') ) exit;

class Quizr_Question_Cpt {


    const CPT_NAME = 'quizr_question';

    private $mv;
    private $quizr_answers_table;

    public function __construct( Quizr_Answers_Table $quizr_answers_table){
        $this->mv = -1;
        $this->quizr_answers_table = $quizr_answers_table;
    }

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

        add_meta_box(
            'quizr-answers',
            __( 'Answers', 'quizr' ),
            array( $this, 'render_answers_metabox'),
            static::CPT_NAME,
            'advanced',
            'default'
        );
    }

    public function render_question_set_meta_box( $post ){

        global $pagenow;

        $question_sets = get_posts( 
            array(
                'post_type' => 'quizr_question_set'
            )
        );

        if( $pagenow === 'post-new.php')
        {
            $meta_value = $this->mv;
        }
        else 
        {
            $meta_value = get_post_meta( $post->ID, 'quizr_question_set_id', true);
        }      

        wp_nonce_field( 'quizr_question_set_id_nonce', 'quizr_question_set_id_nonce_' . $post->ID);

        require_once QUIZR_ADMIN_PATH . '/partials/quizr-admin-cpt-question-qsmb.php';
    }

    public function render_answers_metabox( $post ){
        
        $post_id = $post->ID;
        $answers = $this->quizr_answers_table->get( $post_id );

        $quizr_max_answers_per_question = get_option( 'quizr_max_answers_per_question', 6);

        wp_nonce_field( 'quizr_question_answer_nonce', 'quizr_question_answer_nonce_' . $post_id );
      
        require_once QUIZR_ADMIN_PATH . '/partials/quizr-admin-cpt-question-amb.php';

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

        if( isset( $post_data['quizr_question_answer_nonce_' . $id]) && 
            wp_verify_nonce( $post_data['quizr_question_answer_nonce_' . $id ], 'quizr_question_answer_nonce' )){               

            if( array_key_exists( 'quizr_question_answer', $post_data ) && is_array( $post_data['quizr_question_answer'])){

                $where = array( 'quizr_question_id' => $id );
                $where_format = array( '%d' );
                $this->quizr_answers_table->delete( $where, $where_format );

                foreach( $post_data['quizr_question_answer'] as $index => $answer){

                    $is_correct = array_key_exists( 'quizr_answer_correct', $post_data )
                        ? $post_data['quizr_answer_correct']
                        : -1;

                    if( strlen( $answer['description']) > 0 ){
                        $values_to_be_inserted = array(
                            'quizr_question_id' => $id,
                            'description' => $answer['description'],
                            'is_correct' => (int) $index === (int) $is_correct
                                            ? '1'
                                            : '0'
                        );

                        $this->quizr_answers_table->insert( $values_to_be_inserted );
                    }

                }

                
            }
        
        }

    
    }

    public function load_query_params(){

        if( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'quizr_question' ){
            if( isset( $_GET['question_set_id'] ) ) $this->mv = (int) $_GET['question_set_id'];
        }
    }

}