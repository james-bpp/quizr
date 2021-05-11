<?php

if( ! defined('ABSPATH')) exit;

class Quizr_Migrate {

    public function up(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'quizr_answers';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            quizr_question_id INT NOT NULL,
            description tinytext NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        );";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $sql );

    }

}