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
<?php if( (int) $meta_value > 0 ) { ?>
    <hr />
    <a href="<?php echo admin_url('post-new.php?post_type=quizr_question') . "&question_set_id=$meta_value"; ?>" >
        Add New
    </a>
<?php } ?>
