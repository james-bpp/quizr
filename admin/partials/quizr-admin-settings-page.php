<div class="wrap">
    <h1>Quizr Settings</h1>
    <hr />
    <form method="post" action="options.php">
        <?php settings_fields( 'quizr_options_group' ); ?>
        <?php do_settings_sections( 'quizr_options_group' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row">Max Answers Per Question</th>
                <td></td>            
            </tr>
            <tr>
                <th scope="row">Show Questions Menu Item</th>
                <td></td>            
            </tr>        
        </table>
    </form>
</div>
