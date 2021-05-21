<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Quizr_Shortcodes_Api {

    private $quizr_answers_table;

    public function __construct( Quizr_Answers_Table $quizr_answers_table){
        $this->quizr_answers_table = $quizr_answers_table;
    }

    public function render_quizr_question_set_html( $atts, $content = null ){

        $a = shortcode_atts(
            array( 'id' => -1 ), $atts
        );

        $qs_id = $a['id'];

        $question_set = get_post( (int) $qs_id );

        $questions = get_posts(
            array(
                'post_type' => 'quizr_question',
                'numberposts' => -1,
                'meta_key' => 'quizr_question_set_id',
                'meta_value' => (int) $qs_id
            )
        );

        foreach( $questions as $question ){
            $question->answers = $this->quizr_answers_table->get( $question->ID );
        }

        ob_start();

        require_once QUIZR_PUBLIC_PATH . '/partials/quizr-public-shortcodes.php';

        return ob_get_clean();
    }

    public function register_shortcodes(){
        add_shortcode( 'quizr_question_set', array( $this, 'render_quizr_question_set_html' ) );
    }

}