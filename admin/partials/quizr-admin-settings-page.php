<div class="wrap">
    <h1>Quizr Settings</h1>
    <hr />
    <form method="post" action="options.php">
        <?php settings_fields( 'quizr_options_group' ); ?>
        <?php do_settings_sections( 'quizr_options_group' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row">Max Answers Per Question</th>
                <td>
                    <input
                        type="text"
                        id="quizr_max_answers_per_question"
                        name="quizr_max_answers_per_question"
                        value="<?php echo esc_attr( get_option( 'quizr_max_answers_per_question', 6) ); ?>"
                     />
                </td>            
            </tr>
            <tr>
                <th scope="row">Show Questions Menu Item</th>
                <td>
                    <input
                        type="checkbox"
                        id="quizr_show_cpt_question_in_menu"
                        name="quizr_show_cpt_question_in_menu"
                        value="1"
                        <?php checked( 1, get_option( 'quizr_show_cpt_question_in_menu', 1) ); ?>
                     />
                </td>            
            </tr>        
        </table>
        <?php submit_button(); ?>
    </form>
</div>
